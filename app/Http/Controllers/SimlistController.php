<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\Simlist;
use App\Models\User;
use Illuminate\Http\Request;

class SimlistController extends Controller
{

    public function index(Request $request)
    {


        $query = simlist::query()->with('worker');


        // Поиск по имени, если параметр 'search' присутствует
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('number', 'like', "%{$search}%");
        }

        if ($request->boolean('filter_ident_null')) {
            $query->whereNull('ident_id');
        }


        // Определяем количество записей на странице, по умолчанию 10
        $perPage = $request->input('per_page', 10);

        // Получаем данные с пагинацией
        $simlists = $query->paginate($perPage);

        // Проверяем, AJAX запрос или нет
        if ($request->ajax()) {
            // Рендерим частичный вид таблицы
            $html = view('simlists._table', compact('simlists'))->render();

            // Возвращаем JSON ответ
            return response()->json(['html' => $html]);
        }





        return view('simlists.index', compact('simlists'));

    }



    public function create()
    {
        $projects = Project::all();
        return view('simlists.create', compact('projects'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sim_info' => 'required|string|max:255|unique:simlists',
            'number' => 'required|string|max:255|unique:simlists',
            'sim_id' => 'required|string|max:255',
            'price' => 'nullable|string|max:255',
            'mb' => 'nullable|string|max:255',
            'worker_id' => 'nullable',
//            'project_id' => 'exists:projects,id',


        ]);
        $validated['project_id'] = null;

        $userId = auth()->id();
        $validated['user_id'] = $userId;
        Simlist::create($validated);

        return redirect()->route('simlists.index')->with('success', 'Sim card added successfully.');
    }

    public function edit($id)
    {
        $workers = User::all();
        $simlist = Simlist::findOrFail($id);
 return view('simlists.edit',compact('simlist','workers'));
    }


    public function update(Request $request, $id )
    {

        $simlist = Simlist::findOrFail($id);

        $validated=    $request->validate([
            'sim_info' => 'required|string|max:255|unique:simlists,sim_info,'. $simlist->id,
            'number' => 'required|string|max:255|unique:simlists,number,'. $simlist->id,
            'sim_id' => 'required|string|max:255',
            'price' => 'nullable|string|max:255',
            'mb' => 'nullable|string|max:255',
            'worker_id' => 'nullable|integer'
        ]);

//        if($validated['sim_id'] == 1){
//
//            $validated['sim_id'] = 'Viva';
//        }
//
        $userId = auth()->id();
        $validated['user_id'] = $userId;
        $simlist = Simlist::findOrFail($id);
        $simlist->update($validated);

        return redirect()->route('simlists.index')
            ->with('success', 'Sim updated successfully.');
    }

    public function destroy($id)
    {
        $simlist = Simlist::findOrFail($id);
        $simlist->delete();

        return redirect()->route('simlists.index')
            ->with('success', 'Simlist deleted successfully.');
    }

}
