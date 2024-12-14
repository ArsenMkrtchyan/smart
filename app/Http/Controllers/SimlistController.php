<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\Simlist;
use Illuminate\Http\Request;

class SimlistController extends Controller
{

    public function index()
    {
$projects = Project::all();
        $simlists = Simlist::all();

        return view('simlists.index', compact('simlists','projects'));

    }
    public function create()
    {
        $projects = Project::all();
        return view('simlists.create', compact('projects'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sim_info' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'sim_id' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'mb' => 'required|string|max:255',
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
        $simlist = Simlist::findOrFail($id);
 return view('simlists.edit',compact('simlist'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([

            'sim_info' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'sim_id' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'mb' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);
        $userId = auth()->id();
        $validated['user_id'] = $userId;
        $simlist = Simlist::findOrFail($id);
        $simlist->update($request->all());

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
