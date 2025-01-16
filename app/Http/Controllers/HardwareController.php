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
        $query = Hardware::query()->with('worker');

        // Поиск по имени, если параметр 'search' присутствует
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('serial', 'like', "%{$search}%");
        }

        if ($request->boolean('filter_ident_null')) {
            $query->whereNull('ident_id');
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
        // Получение всех пользователей (работников)
        $workers = \App\Models\User::all();

        return view('hardwares.create', compact('workers'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'serial' => 'required|string|max:255',

            'worker_id' => 'required|exists:users,id',
        ]);

        \App\Models\Hardware::create([
            'name' => $validated['name'],
            'serial' => $validated['serial'],
            'ident_id' => null,

            'user_id' => auth()->id(), // Автоматически устанавливаем ID текущего пользователя
            'worker_id' => $validated['worker_id'],
            'project_id' => null, // Устанавливаем project_id в null
        ]);

        return redirect()->route('hardwares.index')->with('success', 'Оборудование успешно добавлено!');
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
        $hardware = \App\Models\Hardware::findOrFail($id);
        $workers = \App\Models\User::all(); // Получение списка всех пользователей

        return view('hardwares.edit', compact('hardware', 'workers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hardware = \App\Models\Hardware::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'serial' => 'required|string|max:255|unique:hardwares',
            'worker_id' => 'required|exists:users,id',
        ]);

        // Обновление данных оборудования
        $hardware->update([
            'name' => $validated['name'],
            'serial' => $validated['serial'],


            'worker_id' => $validated['worker_id'],

        ]);

        return redirect()->route('hardwares.index')->with('success', 'Оборудование успешно обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hardware $hardware)
    {
        //
    }
}
