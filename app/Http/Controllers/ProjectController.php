<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Objectype;
use App\Models\Objectypes;
use App\Models\Price;
use App\Models\Project;
use App\Models\Seorole;
use App\Models\Simlist;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Validation\Rule;
use Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // Заготовка запроса
        $query = Project::with('wMarz');

        // Поиск по brand_name, если есть что искать
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('brand_name', 'like', "%{$search}%");
        }

        // Сколько записей показывать на странице
        $perPage = $request->input('per_page', 10);

        // Получаем данные с пагинацией
        $projects = $query->paginate($perPage);

        // Проверяем, AJAX это или нет
        if ($request->ajax()) {
            // Возвращаем только часть разметки (кусок таблицы + пагинация)
            // Для этого удобно вынести таблицу в отдельный blade-файл `_table.blade.php`
            // и вернуть готовый HTML. Ниже пример.
            $html = view('projects._table', compact('projects'))->render();

            // Возвращаем в формате JSON
            return response()->json(['html' => $html]);
        }

        // Если это НЕ AJAX, то грузим всю страницу (projects.index)
        return view('projects.index', compact('projects'));
    }

    public function export($id)
    {
        $project = Project::findOrFail($id);

        // Проверка на наличие даты начала договора
        if (!$project->paymanagir_start) {
            return redirect()->back()->withErrors(['error' => 'Для этого проекта не установлена дата начала договора']);
        }

        // Путь к шаблону
        $templatePath = public_path('paypamagir1.docx');

        // Копирование шаблона, чтобы не изменять оригинальный файл
        $tempPath = storage_path('app/public/' . $project->firm_name . '_temp.docx');
        copy($templatePath, $tempPath);

        // Открываем .docx файл как ZIP архив
        $zip = new \ZipArchive;
        if ($zip->open($tempPath) === true) {
            // Читаем содержимое документа
            $xml = $zip->getFromName('word/document.xml');

            // Заменяем текст в XML
            $xml = str_replace('Սեզամ-Գազ', $project->firm_name, $xml);
            $xml = str_replace('06403723', $project->hvhh, $xml);
            $xml = str_replace('1-3001',$project->paymanagir_id_marz, $xml);
            // Сохраняем измененный XML обратно в архив
            $zip->addFromString('word/document.xml', $xml);
            $zip->close();
        }

        // Путь к выходному файлу DOCX
        $outputDocxPath = storage_path('app/public/' . $project->firm_name . '_paymanagir.docx');

        // Переименовываем временный файл в окончательный DOCX
        rename($tempPath, $outputDocxPath);

        // Путь к выходному файлу PDF
        $outputPdfPath = public_path($project->firm_name . '_paymanagir.pdf');

        // Конвертация DOCX в PDF с помощью LibreOffice
        $command = 'libreoffice --headless --convert-to pdf ' . escapeshellarg($outputDocxPath) . ' --outdir ' . escapeshellarg(public_path());
        exec($command);

        // Отправка PDF файла пользователю
        return response()->download($outputPdfPath)->deleteFileAfterSend(true);
    }


    public function create(Request $request)
    {
        $simlists = Simlist::all();
        $states = State::all();
        $prices = Price::all();
        $types = DB::table('object_types')->get();
        $names = State::select('name')->distinct()->get();
$seoroles = Seorole::all();
$workers = User::all();
$hardwares = Hardware::all();
        $mode = $request->query('mode','phy');
        return view('projects.create', compact('simlists', 'hardwares','states' ,'workers','seoroles', 'prices','names','types','mode'));
    }
    public function getDistricts($name)
    {
        // Находим все строки в таблице states, где name совпадает с тем, что передали
        $states = State::where('name', $name)->get();
        // Превращаем в удобный для фронта массив: [ stateId => districtName ]
        $response = [];
        foreach ($states as $st) {
            // Ключ = ID записи, Значение = district (текст)
            $response[$st->id] = $st->district;
        }
        // Возвращаем JSON.
        return response()->json($response);
    }
    public function getDistrictss($namess)
    {
        // Находим все строки в таблице states, где name совпадает с тем, что передали
        $statess = State::where('name', $namess)->get();
        // Превращаем в удобный для фронта массив: [ stateId => districtName ]
        $response = [];
        foreach ($statess as $st) {
            // Ключ = ID записи, Значение = district (текст)
            $response[$st->id] = $st->district;
        }
        // Возвращаем JSON.
        return response()->json($response);
    }
    public function search(Request $request)
    {
        $number = $request->query('number');

        if (!$number) {
            return response()->json([]);
        }

        $results = Simlist::where('number', 'LIKE', "%$number%")->get();

        return response()->json($results);
    }
    public function getNextIdentId()
    {
        // Получаем все существующие ident_id как целые числа
        $existingIds = Project::whereNotNull('ident_id')
            ->pluck('ident_id')
            ->map(function($id) {
                return intval($id);
            })
            ->sort()
            ->values();

        $nextId = 1;

        foreach ($existingIds as $id) {
            if ($id === $nextId) {
                $nextId++;
            } elseif ($id > $nextId) {
                break;
            }
        }

        // Проверяем, не превышает ли идентификатор 9999
        if($nextId > 9999){
            return response()->json(['error' => 'Достигнуто максимальное количество идентификаторов.'], 400);
        }

        // Форматируем идентификатор как 4-значный с ведущими нулями
        $formattedId = str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return response()->json(['ident_id' => $formattedId]);
    }
    public function storeAll(Request $request)
    {
        // Здесь мы принимаем ВСЕ поля формы,
        // в том числе и для физ. лица, и для юр. лица, и тех. раздел, и админ-тех...
        // В зависимости от того, что реально было заполнено,
        // поля могут быть пусты.
        try {
        $validated = $request->validate([
            // Общие поля, встречаются и у физ., и у юр.
            'type_id'       => 'nullable|integer',
            'brand_name'    => 'nullable|string',
            'firm_bank'     => 'nullable|string',
            'firm_bank_hh'  => 'nullable|string',
            'firm_email'    => 'nullable|string',

            // Физ. лицо
            'ceo_name'      => 'nullable|string',
            'andznagir'     => 'nullable|string',
            'soc'           => 'nullable|string',
            'id_card'       => 'nullable|string',
            'ceo_phone'     => 'nullable|string',

            // Юр. лицо
            'firm_name'     => 'nullable|string',  // (пример)
            'hvhh'          => 'nullable|string',
            'fin_contact'   => 'nullable|string',

            // Адреса
            'i_marz_id'     => 'nullable|integer',
            'i_address'     => 'nullable|string',
            'w_marz_id'     => 'nullable|integer',
            'w_address'     => 'nullable|string',
            'x_gps'     => 'nullable|string',
            // Техническая секция
            'identification' => 'required|in:manual,auto',
            'ident_id' => 'required|digits:4|unique:projects,ident_id',
'paymanagir_start' => 'nullable|date',


            // ... дальше любые поля ...
            'last_name'     => 'nullable|string', // пример
            // и т. д...

            // Админ-техническая
            'dismiss_date'  => 'nullable|date', // если у вас есть поле-дата
            'sim_ids'         => 'array',     // ожидаем массив
            'sim_ids.*'       => 'integer',
            'patasxanatus'    => 'nullable|array',
            'patasxanatus.*'  => 'nullable|string|max:255',
            'numbers'         => 'nullable|array',
            'numbers.*'       => 'nullable|string|max:255',

        ]);

        // Сохраняем в таблицу projects (предполагая, что
        // соответствующие поля/колонки есть).
        // 2) Создаём новый Project (примерно)
        // Создаём новый проект
        $project = Project::create($validated);

        // Привязываем выбранные SIM-карты к проекту
        if (!empty($validated['sim_ids'])) {
            Simlist::whereIn('id', $validated['sim_ids'])
                ->update(['project_id' => $project->id]);
        }



            // Обработка Патасханату
            if (!empty($validated['patasxanatus']) && !empty($validated['numbers'])) {
                // Убедимся, что оба массива имеют одинаковую длину
                $countNames = count($validated['patasxanatus']);
                $countNumbers = count($validated['numbers']);
                $count = min($countNames, $countNumbers);

                for ($i = 0; $i < $count; $i++) {
                    $name = trim($validated['patasxanatus'][$i]);
                    $number = trim($validated['numbers'][$i]);

                    // Проверяем, что хотя бы одно из полей заполнено
                    if (!empty($name) || !empty($number)) {
                        $project->patasxanatus()->create([
                            'name'   => $name,
                            'number' => $number,
                        ]);
                    }
                }
            }

            // Редирект с сообщением об успехе
            return redirect()->route('projects.create')
                ->with('success', 'Проект создан, выбранные SIM-карты и Պատասխանատու сохранены.');
        } catch (\Exception $e) {
            // Логирование ошибки
            \Log::error('Ошибка при создании проекта: ' . $e->getMessage());

            // Редирект с ошибкой
            return redirect()->back()
                ->with('error', 'Произошла ошибка при создании проекта. Пожалуйста, попробуйте снова.');
        }
    }
    public function searchSimlists(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([]);
        }

        // Поиск SIM-карт по номеру, начинающемуся с введённой строки
        // Так как number не уникален, возвращаем id и number
        $simlists = Simlist::where('number', 'like', "{$query}%")
            ->whereNull('project_id') // Ищем только свободные SIM-карты
            ->limit(20)
            ->get(['id', 'number']);

        return response()->json([
            'simlists' => $simlists
        ]);
    }
    public function main_store_phy(Request $request){
        $validated =   $request->validate([
            'firm_type' => 'nullable|boolean',
            'ceo_name' => 'nullable|string',
            'andznagir' => 'nullable|string',
            'soc' => 'nullable|string',
            'type_id' => 'nullable|integer',
            'id_card' => 'nullable|string',
            'ceo_phone'=>'nullable|string',
            'firm_email' => 'nullable|string',
            'firm_bank' => 'nullable|string',
            'brand_name' => 'nullable|string',
            'firm_bank_hh' => 'nullable|string',
            'w_marz_id' => 'nullable|integer',
            'i_address' => 'nullable|string',
            'i_marz_id' => 'nullable|integer',
            'w_address' => 'nullable|string',
        ]);

        Project::create($validated);



        return redirect()->route('projects.index')->with('success','projects created successfully.');

    }
    public function main_store_jur(Request $request){
        $validated =   $request->validate([
            'firm_type' => 'nullable|boolean',
            'ceo_name' => 'nullable|string',
            'hvhh' => 'nullable|string',
            'ceo_phone'=>'nullable|string',
            'firm_email' => 'nullable|string',
            'firm_bank' => 'nullable|string',
            'type_id' => 'nullable|integer',
            'brand_name' => 'nullable|string',
            'firm_bank_hh' => 'nullable|string',
            'fin_contact' => 'nullable|string',
            'w_marz_id' => 'nullable|integer',
            'i_address' => 'nullable|string',
            'i_marz_id' => 'nullable|integer',
            'w_address' => 'nullable|string',
        ]);

        Project::create($validated);



        return redirect()->route('projects.index')->with('success','projects created successfully.');

    }
    public function store(Request $request)
    {
        $phyJur = $request->input('phy_jur'); // "0" -> физ, "1" -> юр

        if ($phyJur === '0') {
            // Валидируем как физ
            $validated = $request->validate([
                'ceo_name' => 'required|string',
                // и т.д. (поля для физического)
            ]);
        } else {
            // Валидируем как юр
            $validated = $request->validate([
                'firm_name' => 'required|string',
                'role'      => 'required|integer', // например
                // ...
            ]);
        }

        // Сохраняем
        Project::create($validated);

        return redirect()->back();
    }

//    public function store(Request $request)
//    {
//
//        $validatedData = $request->validate([
//            'brand_name' => 'required|string|max:255|unique:projects,brand_name',
//            'firm_type' => 'required|boolean', // 0 = юридическое, 1 = физическое лицо
//            'hvhh' => 'nullable|string|max:255',
//            'firm_name' => 'nullable|string',
//            'i_marz_id' => 'nullable|string',
//            'i_address' => 'nullable|string',
//            'w_marz_id' => 'nullable|string',
//            'w_address' => 'nullable|string',
//            'ceo_name' => 'nullable|string|',
//            'ceo_phone' => 'nullable|numeric|unique:projects,ceo_phone',
//            'firm_email' => 'nullable|string|email',
//            'firm_bank' => 'nullable|string',
//            'firm_bank_hh' => 'nullable|string',
//            'price_id' => 'nullable|string',
//            'paymanagir_time' => 'nullable|date',
//            'paymanagir_start' => 'nullable|date',
//            'signed' => 'boolean',
//            'status' => 'boolean',
//            'x_gps' => 'nullable|string|max:255',
//            'y_gps' => 'nullable|string|max:255',
//            'nkar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//            'their_hardware' => 'nullable|string|max:255',
//            'patasxanatu' => 'nullable|string|max:255',
//            'patasxanatu_phone' => 'nullable|numeric',
//            'patasxanatu_date' => 'nullable|date',
//            'building_type' => 'nullable|string|max:255',
//            'paymanagir_received' => 'boolean',
//            'paymanagir_end' => 'nullable|date',
//
//        ]);
//        $userId = Auth::id();
// $validatedData['user_id'] =  $userId;
//        if ($request->firm_type === '0') {
//            $validatedData['firm_type'] = 0;
//            $validatedData['hvhh'] = $request->hvhh;
//            $validatedData['i_address'] = $request->i_address;
//        } else {
//            $validatedData['firm_type'] = 1;
//            $validatedData['hvhh'] = null;
//            $validatedData['i_address'] = null;
//        }
//
//        if ($request->hasFile('nkar')) {
//            $imageName = time() . '.' . $request->nkar->extension();
//            $request->nkar->storeAs('public/images', $imageName);
//            $validatedData['nkar'] = $imageName;
//        }
//
////        $validatedData['simlist_1'] = $request->simlist_1;
////        $validatedData['simlist_2'] = $request->simlist_2;
//
//        try {
//            $project = Project::create(array_merge($validatedData, ['status' => 0]));
//
//            if ($request->has('send_to_api')) { // Проверяем, установлен ли чекбокс
//                $newProjectId = $project->id;
//
//                $url = "http://178.219.56.252:1000/api.html?login=Admin&pwd=&action=addObject";
//                $url .= "&Name=" . urlencode($request->brand_name);
//                $url .= "&Contract=" . urlencode($request->ceo_name);
//                $url .= "&MobilePhone1=+" . urlencode($request->ceo_phone);
//                $url .= "&Address=" . urlencode($request->i_address ?? $request->w_address);
////                $url .= "&SIMCardPhone1=" . urlencode(optional($project->simlist1)->sim_number);
////                $url .= "&SIMCardPhone2=" . urlencode(optional($project->simlist2)->sim_number);
//
//                $client = new Client();
//                $response = $client->get($url);
//                $responseBody = (string)$response->getBody();
//
//                if (trim($responseBody) == 'OK') {
//                    $project->status = 1;
//                    $project->save();
//                }
//            }
//
//            return redirect()->route('projects.index')->with('success', 'Project created successfully.');
//        }
//        catch (\Exception $e) {
//            Log::error('Error creating project: ' . $e->getMessage());
//            return redirect()->back()->withErrors(['error' => 'There was an error creating the project. ' . $e->getMessage()]);
//        }
//    }
    public function generatePaymanagirIdMarz(Request $request, Project $project)
    {

        if ($project->paymanagir_start == null) {
            return redirect()->back()->withErrors(['error' => 'Paymanagir start not found ']);
        } else{
            try {
                // Получить w_marz_id проекта
                $wMarzId = $project->w_marz_id;


                // Проверить, существует ли state
                $state = State::find($wMarzId);

                if (!$state ) {

                    return redirect()->back()->withErrors(['error' => 'State not found for w_marz_id']);
                }

                // Базовый ID из таблицы states
                $basePaymanagirId = $state->paymanagir_id;

                // Получить все paymanagir_id_marz для этого w_marz_id
                $existingIds = Project::where('w_marz_id', $wMarzId)
                    ->whereNotNull('paymanagir_id_marz')
                    ->orderBy('paymanagir_id_marz')
                    ->pluck('paymanagir_id_marz')
                    ->toArray();

                // Если нет существующих ID
                if (empty($existingIds)) {
                    $newPaymanagirIdMarz = $basePaymanagirId * 1000;
                } else {
                    // Ищем минимальное недостающее значение
                    $newPaymanagirIdMarz = null;
                    for ($i = 0; $i < 1000; $i++) {
                        $candidateId = $basePaymanagirId * 1000 + $i;
                        if (!in_array($candidateId, $existingIds)) {
                            $newPaymanagirIdMarz = $candidateId;
                            break;
                        }
                    }

                    if ($newPaymanagirIdMarz === null) {
                        return redirect()->back()->withErrors(['error' => 'No available paymanagir_id_marz for this state']);
                    }
                }

                // Сохранение нового ID в поле paymanagir_id_marz
                $project->paymanagir_id_marz = $newPaymanagirIdMarz;
                $project->save();

                return redirect()->back()->with('success', "Paymanagir ID Marz {$newPaymanagirIdMarz} успешно сгенерирован.");
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Ошибка при генерации ID: ' . $e->getMessage()]);
            }
        }
    }


    public function edit($id)
    {
        $user = Auth::user();
        $project = Project::findOrFail($id);
$states = State::all();
$prices = Price::all();
        if ($user->role_id == 2 && $project->active == 1) {
            return redirect()->route('projects.index')->with('error', 'You do not have permission to edit this project.');
        }

        return view('projects.edit', compact('project' ,'states' , 'prices'));
    }




    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'brand_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('projects')->ignore($project->id),
            ],
            'firm_bank' => 'nullable|string|max:255',
            'firm_bank_hh' => 'nullable|string|max:255',
            'ceo_name' => 'nullable|string|max:255',
            'ceo_phone' => [
                'nullable',
                'numeric',
                Rule::unique('projects')->ignore($project->id),
            ],
            'firm_type' => 'required|boolean', // 0 = юридическое, 1 = физическое лицо
            'hvhh' => 'nullable|string|max:255',
            'firm_name' => 'nullable|string',
            'i_marz_id' => 'nullable|string|max:255',
            'i_address' => 'nullable|string|max:255',
            'w_marz_id' => 'nullable|string|max:255',
            'w_address' => 'nullable|string|max:255',
            'firm_email' => 'nullable|string|email|max:255',
            'price_id' => 'nullable|string|max:255',
            'paymanagir_time' => 'nullable|date',
            'paymanagir_start' => 'nullable|date',
            'signed' => 'boolean',
            'status' => 'boolean',
            'x_gps' => 'nullable|string|max:255',
            'y_gps' => 'nullable|string|max:255',
            'nkar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'their_hardware' => 'nullable|string|max:255',
            'patasxanatu' => 'nullable|string|max:255',
            'patasxanatu_phone' => 'nullable|numeric',
            'patasxanatu_date' => 'nullable|date',
            'building_type' => 'nullable|string|max:255',
            'paymanagir_received' => 'boolean',
            'paymanagir_end' => 'nullable|date',
            'status_edit' => 'boolean',
        ]);
        $userId = Auth::id();
        $validatedData['user_id'] =  $userId;
        $projectData = $request->except(['_token', '_method', 'nkar']);

        if ($request->hasFile('nkar')) {

            if ($project->nkar && Storage::exists('public/images/' . $project->nkar)) {
                Storage::delete('public/images/' . $project->nkar);
            }
            $imageName = time() . '.' . $request->nkar->extension();
            $request->nkar->storeAs('public/images', $imageName);
            $projectData['nkar'] = $imageName;
        }

        try {
            $project->update($projectData);


            $contractNew = $request->ceo_name . '_' . $project->id;
            $url = "http://178.219.56.252:1000/api.html?login=Admin&pwd=&action=updateObject";
            $url .= "&Name=" . urlencode($request->brand_name);
            $url .= "&Contract=" . urlencode($request->ceo_name);
            $url .= "&MobilePhone1=+" . urlencode($request->ceo_phone);
            $url .= "&Address=" . urlencode($request->i_address);
            $url .= "&SIMCardPhone=+" . urlencode($request->patasxanatu_phone);

            $client = new Client();
            $response = $client->get($url);
            $responseBody = (string)$response->getBody();

            if (trim($responseBody) == 'OK') {
                $project->status_edit = 1;
                $message = 'Project updated successfully and server responded with OK.';
            } else {
                $project->status_edit = 0;
                $message = 'Project updated successfully but server did not respond with OK.';
            }
        } catch (\Exception $e) {
            Log::error('Error updating project: ' . $e->getMessage());
            $project->status_edit = 0;
        }

        $project->save();

        return redirect()->route('projects.index')->with('success', $message ?? 'There was an error updating the project.');
    }


    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully');
    }

    public function checkStatus($id)
    {
        $project = Project::findOrFail($id);
        $contractNew = $project->ceo_name . '_' . $project->id;

        try {
            $client = new Client();

            if ($project->status == 0) {
                // Если status == 0, выполняем AddObject
                $url = "http://178.219.56.252:1000/api.html?login=Admin&pwd=&action=addObject";
                $url .= "&Name=" . urlencode($project->firm_name);
                $url .= "&Contract=" . urlencode($project->ceo_name);
                $url .= "&MobilePhone1=+" . urlencode($project->ceo_phone);
                $url .= "&Address=" . urlencode($project->i_address);
                $url .= "&SIMCardPhone=+" . urlencode($project->patasxanatu_phone);
            } elseif ($project->status == 1 && $project->status_edit == 0) {
                // Если status == 1 и status_edit == 0, выполняем updateObject
                $url = "http://178.219.56.252:1000/api.html?login=Admin&pwd=&action=updateObject";
                $url .= "&Name=" . urlencode($project->firm_name);
                $url .= "&Contract=" . urlencode($project->ceo_name);
                $url .= "&MobilePhone1=+" . urlencode($project->ceo_phone);
                $url .= "&Address=" . urlencode($project->i_address);
                $url .= "&SIMCardPhone=+" . urlencode($project->patasxanatu_phone);
            } else {
                // Если status_edit == 1, то ничего не делать (или можно добавить другой сценарий)
                return redirect()->route('projects.index')->with('error', 'No action required.');
            }

            // Выполняем запрос
            $response = $client->get($url);
            $responseBody = (string)$response->getBody();

            if (trim($responseBody) == 'OK') {
                $project->status = 1;  // Если запрос успешен, устанавливаем status и status_edit в 1
                $project->status_edit = 1;
                $message = ' Status updated successfully.';
            } else {
                $project->status_edit = 0;  // Если запрос неуспешен, устанавливаем только status_edit в 0
                $message = 'Server did not respond with OK.';
            }

            $project->save();
            return redirect()->route('projects.index')->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Error checking status: ' . $e->getMessage());
            $project->status_edit = 0;  // Если возникло исключение, устанавливаем status_edit в 0
            $project->save();
            return redirect()->route('projects.index')->with('error', 'There was an error checking the status.');
        }
    }


    public function updateProjectItems(Request $request, $projectId)
    {
        $validated = $request->validate([
            'simlists' => 'nullable|array',
            'simlists.*' => 'exists:simlists,id',
            'hardwares' => 'nullable|array',
            'hardwares.*' => 'exists:hardwares,id',
        ]);

        // Сбрасываем связь для всех записей, связанных с этим projectId
        Simlist::where('project_id', $projectId)->update(['project_id' => null]);
        Hardware::where('project_id', $projectId)->update(['project_id' => null]);

        // Связываем только выбранные записи
        if (!empty($validated['simlists'])) {
            Simlist::whereIn('id', $validated['simlists'])->update(['project_id' => $projectId]);
        }

        if (!empty($validated['hardwares'])) {
            Hardware::whereIn('id', $validated['hardwares'])->update(['project_id' => $projectId]);
        }

        return redirect()->route('projects.index')->with('success', 'Items updated successfully.');
    }


    public function restoreinfo(Request $request, $projectId)
    {
        // Обновляем все simlists с данным project_id
        Simlist::where('project_id', $projectId)->update(['project_id' => null]);

        // Обновляем все hardwares с данным project_id
        Hardware::where('project_id', $projectId)->update(['project_id' => null]);

        // Редирект обратно с сообщением
        return redirect()->route('projects.index')->with('success', 'All items successfully restored to null.');
    }


    public function searchItems(Request $request)
    {
        $query = $request->input('query');

        $simlists = Simlist::where('number', 'like', "$query%")
            ->get(['id', 'number', 'project_id']);

        $hardwares = Hardware::where('serial', 'like', "$query%")
            ->get(['id', 'serial', 'project_id']);

        return response()->json([
            'simlists' => $simlists,
            'hardwares' => $hardwares,
        ]);
    }
    public function show($id)
    {
        $project = Project::with(['price', 'iMarz', 'wMarz'])->findOrFail($id);
        return view('projects.show', compact('project'));
    }
}
