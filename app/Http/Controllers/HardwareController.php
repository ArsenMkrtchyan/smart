<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\Project;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Инициализируем строителя запросов
        $query = Hardware::query();

        // Поиск по имени, если параметр 'search' присутствует
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Определяем количество записей на странице, по умолчанию 10
        $perPage = $request->input('per_page', 10);

        // Получаем данные с пагинацией
        $hardwares = $query->paginate($perPage);

        // Проверяем, AJAX запрос или нет
        if ($request->ajax()) {
            // Рендерим частичный вид таблицы
            $html = view('hardwares._table', compact('hardwares'))->render();

            // Возвращаем JSON ответ
            return response()->json(['html' => $html]);
        }

        // Возвращаем основной вид с данными
        return view('hardwares.index', compact('hardwares'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        return view('hardwares.create' , compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'serial' => 'required|string|max:255',
            'project_id' => 'exists:projects,id',
        ]);
        $userId = auth()->id();
        $validated['user_id'] = $userId;
        Hardware::create($validated);

        return redirect()->route('hardwares.index')->with('success', 'Hardware added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Hardware $hardware)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hardware = Hardware::findOrFail($id);
        return view('hardwares.edit',compact('hardware'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $request->validate([

        'name' => 'required|string|max:255',
        'serial' => 'required|string|max:255',
    ]);

        $simlist = Hardware::findOrFail($id);
        $simlist->update($request->all());

        return redirect()->route('hardwares.index')
            ->with('success', 'Hardware updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hardware $hardware)
    {
        //
    }
}
