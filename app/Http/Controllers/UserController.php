<?php

namespace App\Http\Controllers;

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

        $users = User::latest()->paginate(5);

        return view('users.index',compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
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
        $user->is_admin = $request->has('is_admin') ? $validated['is_admin'] : null;
        $user->havayrole = $request->has('havayrole') ? $validated['havayrole'] : null;
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
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'female' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|integer',
            'is_admin' => 'required|boolean'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->female = $request->female;
        $user->number = $request->number;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->is_admin = $request->is_admin;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
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
