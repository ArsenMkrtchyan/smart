<?php
namespace App\Http\Controllers;

use App\Models\Object_type;
use Illuminate\Http\Request;

class ObjectTypeController extends Controller
{
    // 1) Возвращает HTML-таблицу (для модального окна списка)
    public function list()
    {
        $objectTypes = Object_type::all();
        // Вернём фрагмент Blade-шаблона, который содержит <table> ...
        return view('object_types._table', compact('objectTypes'));
    }

    // 2) Возвращает форму создания (Create)
    public function create()
    {
        return view('object_types._create_form');
    }

    // 3) Обработка создания
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $obj = Object_type::create($validated);

        // Если нужно вернуть что-то для AJAX:
        return response()->json([
            'success' => true,
            'message' => 'Тип успешно создан',
            'data' => $obj
        ]);
    }

    // 4) Возвращает форму редактирования (Edit)
    public function edit($id)
    {
        $objectType = Object_type::findOrFail($id);
        return view('object_types._edit_form', compact('objectType'));
    }

    // 5) Обновление
    public function update(Request $request, $id)
    {
        $objectType = Object_type::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $objectType->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Тип обновлён',
            'data' => $objectType
        ]);
    }

    // 6) Удаление
    public function destroy($id)
    {
        $objectType = Object_type::findOrFail($id);
        $objectType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Тип удалён'
        ]);
    }
}
