<?php

namespace App\Http\Controllers;


use App\Models\Project;
use App\Models\Simlist;
use App\Models\User;
use Illuminate\Http\Request;

class SimlistController extends Controller
{

    public function index()
    {
$projects = Project::all();
        $simlists = Simlist::with('worker')->get();

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


    public function update(Request $request, $id)
    {
    $validated=    $request->validate([

            'sim_info' => 'required|string|max:255',
            'number' => 'required|string|max:255',
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
