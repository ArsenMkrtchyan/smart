<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Object_type;

use App\Models\Price;
use App\Models\Project;
use App\Models\Seorole;
use App\Models\Simlist;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
use Spatie\Backup\Tasks\Backup\BackupJobFactory;



use Symfony\Component\HttpFoundation\StreamedResponse;
class ProjectController extends Controller
{

    public function index(Request $request)
    {

        $query = Project::with('wMarz','object_type')->orderBy('ident_id','DESC');


        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('firm_name', 'like', "%{$search}%")->orWhere('ident_id', 'like', "%{$search}%");
        }
        if ($request->filled('object_check')) {
            $check = $request->input('object_check');
            $query->where('object_check', $check);
        }

        // Кол-во найденных (после всех фильтров, но до пагинации)
        $totalCount = $query->count();


        $perPage = $request->input('per_page', 10);
        $projects = $query->paginate($perPage);


        if ($request->ajax()) {

            $html = view('projects._table', compact('projects'))->render();


            return response()-> json([
                'html' => $html,
                'count' => $totalCount,

            ]);
        }


        return view('projects.index', compact('projects','totalCount'));
    }

    public function dbBackup()
    {
        try {
            Artisan::call('backup:run', ['--only-db' => true]);
            // Предположим, что пакет создаёт ZIP где-то в storage/app/laravel-backup/.
            $disk = config('backup.destination.disks')[0] ?? 'local';
            // Или если у вас отдельный настроенный диск.

            // Ищем последний файл
            // (Можете воспользоваться классом Spatie\Backup\BackupDestination\BackupDestination
            //  и его методами lastBackupFile() и т.д.)

            // Но упрощённо:
            $files = \Storage::disk($disk)->files('laravel');
            // Возвращаются массив путей внутри laravel-backup
            // Сортируем по времени ...
            usort($files, function ($a, $b) use ($disk) {
                return \Storage::disk($disk)->lastModified($b) <=>
                    \Storage::disk($disk)->lastModified($a);
            });
            // $files[0] — самый свежий
            $latest = $files[0] ?? null;
            if (!$latest) {
                throw new \Exception("No backup file found");
            }

            // Скачиваем
            $fullPath = storage_path("app/{$latest}");
            return response()->download($fullPath);

        } catch (Exception $e) {
            return redirect()->back()->with('error','Backup failed: '.$e->getMessage());
        }
    }
    public function makeinvoice(Request $request)
    {
        // Запускаем php artisan backup:run
        // Можно добавить --only-db=true, если хотите только бэкап БД
        Artisan::call('invoices:generate');

        // После успеха — просто редирект на список
        return redirect()->route('projects.invoices')
            ->with('success', 'Backup completed!');
    }
    public function showInvoices()
    {
        // 1) Найти все файлы в папке "public" (или можно "public/invoices"?)
        //    Если нужно именно "storage/app/public", то с точки зрения Laravel это "disk('public')" без дополнительной папки
        //    или же указываем 'disk('public')->files('invoices')' если у нас папка invoices.
        //    Но предположим, что файлы лежат прямо в public.
        $allFiles = \Storage::disk('public')->files();
        // например, $allFiles = ['invoices_001.pdf', 'invoices_test.docx', 'avatar.png', ... ]

        // 2) Отфильтровать те, что начинаются на "invoices_"
        $invoices = array_filter($allFiles, function ($file) {
            return \Str::startsWith($file, 'invoices_');
        });

        // 3) Передать список файлов во view
        return view('invoices', compact('invoices'));
    }
    public function deleteInvoice(Request $request)
    {
        // Получаем имя файла из формы
        $filename = $request->input('filename');

        // Проверяем, что оно не пустое
        if (!$filename) {
            return redirect()->route('projects.invoices')
                ->with('error', 'No filename specified!');
        }

        // Удаляем файл
        // Предполагается, что лежит на диске 'public' (storage/app/public)
        $disk = 'public';
        if (!\Storage::disk($disk)->exists($filename)) {
            return redirect()->route('projects.invoices')
                ->with('error', 'File not found or already deleted!');
        }

        \Storage::disk($disk)->delete($filename);

        return redirect()->route('projects.invoices')
            ->with('success', 'Файл «' . $filename . '» удалён успешно!');
    }

    public function downloadInvoice(Request $request)
    {
        $filename = $request->query('filename');
        // Примерно /invoices/download?filename=invoices_001.pdf

        // Можно дополнительно проверить startsWith('invoices_'),
        // чтобы не дать скачать посторонние файлы
        if (! $filename || ! \Str::startsWith($filename, 'invoices_')) {
            abort(404, 'Файл не найден или не подходит под invoices_*');
        }

        // Проверить, что файл реально существует
        if (! \Storage::disk('public')->exists($filename)) {
            abort(404, 'Файл не найден на диске.');
        }

        // Отдать файл на скачивание
        return \Storage::disk('public')->download($filename);
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
            'object_check'    => 'nullable|string',

            // Физ. лицо
            'ceo_name'      => 'nullable|string',
            'andznagir'     => 'nullable|string',
            'soc'           => 'nullable|string',
            'id_card'       => 'nullable|string',
            'ceo_phone'     => 'nullable|string',
            'ceorole_id'     => 'nullable|integer',
            // Юр. лицо
            'firm_name'     => 'nullable|string',  // (пример)
            'hvhh'          => 'nullable|string',
            'fin_contact'   => 'nullable|string',
            'price_id' => 'nullable',
            // Адреса
            'i_marz_id'     => 'nullable|integer',
            'i_address'     => 'nullable|string',
            'w_marz_id'     => 'nullable|integer',
            'w_address'     => 'nullable|string',
            'x_gps'     => 'nullable|string',
            // Техническая секция
            'identification' => 'required|in:manual,auto',
            'ident_id' => 'nullable|digits:4|unique:projects,ident_id',
'paymanagir_start' => 'nullable|date',
            'paymanagir_received' => 'nullable',

        'worker_id' => 'nullable|integer',
            // Админ-техническая
            'dismiss_date'  => 'nullable|date', // если у вас есть поле-дата
            'sim_ids'         => 'array',     // ожидаем массив
            'sim_ids.*'       => 'integer',
            'hardware_ids'         => 'array',     // ожидаем массив
            'hardware_ids.*'       => 'integer',
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
                ->update(['project_id' => $project->id ,'ident_id' => $project->ident_id] );
        }
            if (!empty($validated['hardware_ids'])) {
                Hardware::whereIn('id', $validated['hardware_ids'])
                    ->update(['project_id' => $project->id , 'ident_id' => $project->ident_id]);
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
            return redirect()->route('projects.edit' , $project->id)
                ->with('success', 'Проект создан, выбранные SIM-карты/hard и Պատասխանատու сохранены.');
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

    public function searchHardwares(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([]);
        }

        // Поиск оборудования по серийному номеру, начинающемуся с введённой строки
        $hardwares = Hardware::where('serial', 'like', "{$query}%")
            ->whereNull('project_id') // Ищем только свободное оборудование, если применимо
            ->limit(20)
            ->get(['id', 'serial', 'name']);

        return response()->json([
            'hardwares' => $hardwares
        ]);
    }


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
        $project = Project::with(['simlists', 'patasxanatus'])->findOrFail($id);

        // Определяем текущий раздел (main, technical, adminTechnical)
        // Можно передать через запрос или определить по данным проекта
        $currentSection = 'main'; // По умолчанию

        // Получаем необходимые данные для формы
        $simlists = Simlist::all();
        $states = State::all();
        $prices = Price::all();
        $types = DB::table('object_types')->get();
        $names = State::select('name')->distinct()->get();
        $seoroles = Seorole::all();
        $workers = User::all();
        $hardwares = Hardware::all();

        return view('projects.edit', compact(
            'project',
            'currentSection',
            'simlists',
            'states',
            'prices',
            'types',
            'names',
            'seoroles',
            'workers',
            'hardwares'
        ));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $request->validate([
            // Ваши правила валидации
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
            'ceorole_id'     => 'nullable|string',

            // Юр. лицо
            'firm_name'     => 'nullable|string',
            'hvhh'          => 'nullable|string',
            'fin_contact'   => 'nullable|string',

            // Адреса
            'i_marz_id'     => 'nullable|integer',
            'i_address'     => 'nullable|string',
            'w_marz_id'     => 'nullable|integer',
            'w_address'     => 'nullable|string',
            'x_gps'         => 'nullable|string',

            // Техническая секция
            'identification' => 'nullable|in:manual,auto',
            'ident_id' => 'nullable|digits:4|unique:projects,ident_id,'.$project->id,
            'paymanagir_received' => 'nullable',
            // Админ-техническая секция
            'paymanagir_start' => 'nullable|date',
            'paymanagir_end' => 'nullable|date',
            'end_dimum' => 'nullable|date',
            'tech_check' => 'nullable|string',
            'object_check' => 'nullable|string',
            'price_id' => 'nullable',
            'status_edit' => 'nullable|boolean',
            'worker_id' => 'nullable|integer',
            // Связанные SIM-карты и Pатասxanatu
            'sim_ids'         => 'array',
            'sim_ids.*'       => 'integer',
            'patasxanatus'    => 'nullable|array',
            'patasxanatus.*'  => 'nullable|string|max:255',
            'numbers'         => 'nullable|array',
            'numbers.*'       => 'nullable|string|max:255',
            'hardware_ids' => 'nullable|array',
            'hardware_ids.*' => 'integer|exists:hardwares,id',
        ]);

        // Обновление данных проекта
        $project->update($validated);

        // Обновляем связанные SIM-карты
        Simlist::where('project_id', $project->id)->update(['project_id' => null]);
        if (!empty($validated['sim_ids'])) {
            Simlist::whereIn('id', $validated['sim_ids'])->update(['project_id' => $project->id ,'ident_id'=>$project->ident_id ]);
        }

        Hardware::where('project_id', $project->id)->update(['project_id' => null]);
        if (!empty($validated['hardware_ids'])) {
            Hardware::whereIn('id', $validated['hardware_ids'])->update(['project_id' => $project->id ,'ident_id'=>$project->ident_id ]);
        }

        // Обработка Pатասxanatu
        $project->patasxanatus()->delete();
        if (!empty($validated['patasxanatus']) && !empty($validated['numbers'])) {
            foreach ($validated['patasxanatus'] as $key => $name) {
                if (!empty($name) || !empty($validated['numbers'][$key])) {
                    $project->patasxanatus()->create([
                        'name' => $name,
                        'number' => $validated['numbers'][$key],
                    ]);
                }
            }
        }

        return redirect()->route('projects.edit', $project->id)
            ->with('success', 'Проект успешно обновлен.');
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
