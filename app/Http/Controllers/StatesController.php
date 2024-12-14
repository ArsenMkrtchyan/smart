<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = State::all();

        return view('states.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('states.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'paymanagir_id' => 'required|string|max:255',
        ]);

        State::create($validated);

        return redirect()->route('states.index')->with('success', 'State added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $state = State::findOrFail($id);
        return view('states.edit',compact('state'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'name' => 'required|string|max:255',

            'paymanagir_id' => 'required|string|max:255',
        ]);

        $state = State::findOrFail($id);
        $state->update($request->all());

        return redirect()->route('state.index')
            ->with('success', 'State updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $state = State::findOrFail($id);
        $state->delete();

        return redirect()->route('states.index')
            ->with('success', 'State deleted successfully.');
    }
}
