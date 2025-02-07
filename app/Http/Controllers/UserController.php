<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_fin()
    {

        return view('home');
    }
    public function index()
    {

        $users = User::all();

        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $roles = Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'female' => 'required|string|max:255',
            'firm_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'balance' => 'nullable|numeric',
            'number' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'role_id' => 'required|exists:roles,id',
            'is_admin' => 'nullable|boolean',
            'havayrole' => 'nullable|boolean',
            'password' => 'required|string|min:8',
        ]);

        $user = new User();
        $user->fill($validated);
        $user->password = Hash::make($validated['password']);
        $user->is_admin = $request->has('is_admin') ? $validated['is_admin'] : 0;
        $user->havayrole = $request->has('havayrole') ? $validated['havayrole'] : 0;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // Проверка прав доступа
        $currentUser = auth()->user();
        if ($currentUser->role_id !== 4 || !$currentUser->is_admin) {
            abort(403, 'Access denied');
        }

        // Получение всех ролей
        $roles = \App\Models\Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'female' => 'required|string|max:255',
            'firm_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'balance' => 'nullable|numeric',
            'number' => 'nullable|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'is_admin' => 'nullable|boolean',
            'havayrole' => 'nullable|boolean',
            'password' => 'nullable|string|min:8', // пароль теперь может быть null
        ]);

        // Заполнение данных пользователя
        $user->fill($validated);

        // Если поле password заполнено, обновить его
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Обработка полей is_admin и havayrole
        $user->is_admin = $request->has('is_admin') ? $request->is_admin : 0;
        $user->havayrole = $request->has('havayrole') ? $request->havayrole : 0;

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }
}
