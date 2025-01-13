<?php
namespace App\Http\Controllers;

use App\Models\Seorole;
use Illuminate\Http\Request;

class SeoroleController extends Controller
{
    // 1) Возвращает HTML-таблицу (для модального окна списка)
    public function list()
    {
        $seoroles = Seorole::all();
        return view('seoroles._table', compact('seoroles'));
    }

    // 2) Возвращает форму создания
    public function create()
    {
        return view('seoroles._create_form');
    }

    // 3) Обработка создания
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Seorole::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Seorole created successfully',
            'data'    => $role
        ]);
    }

    // 4) Возвращает форму редактирования
    public function edit($id)
    {
        $seorole = Seorole::findOrFail($id);
        return view('seoroles._edit_form', compact('seorole'));
    }

    // 5) Обновление
    public function update(Request $request, $id)
    {
        $seorole = Seorole::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $seorole->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Seorole updated successfully',
            'data'    => $seorole
        ]);
    }

    // 6) Удаление
    public function destroy($id)
    {
        $seorole = Seorole::findOrFail($id);
        $seorole->delete();

        return response()->json([
            'success' => true,
            'message' => 'Seorole deleted successfully',
        ]);
    }
}
