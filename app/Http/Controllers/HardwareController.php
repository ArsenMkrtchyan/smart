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
    public function index()
    {
        $hardwares = Hardware::all();

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
