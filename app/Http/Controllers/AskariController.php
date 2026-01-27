<?php

namespace App\Http\Controllers;

use App\Models\Askari;
use App\Models\Department;
use App\Models\AssignFadhi;
use Illuminate\Http\Request;

class AskariController extends Controller
{
    public function index()
    {

        $assignments = AssignFadhi::with(['askari', 'fadhi'])->paginate(10);
        return view('pages.askari.index', compact('assignments'));
        // $askar = Askari::with('Department')->paginate(10);
        // return view('pages.askari.index', compact('askar'));
    }
    
    public function create()
    {
       
        $Departments = Department::all();
        return view('pages.askari.create', compact('Departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'MagacaQofka' => 'required|string|max:255',
            'LamabrkaCiidanka' => 'required|unique:askarta',
            'DepartmentId' => 'required|exists:Departments,id',
            'AskariImage' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('AskariImage')) {
            $data['AskariImage'] = $request->file('AskariImage')->store('askari', 'public');
        }

        Askari::create($data);

        return redirect()->route('pages.askari.index')->with('success', 'Askari la abuurtay!');
    }

    public function edit($id)
    {
        $askari = Askari::findOrFail($id);
        $Departments = Department::all();
        return view('pages.askari.edit', compact('askari', 'Departments'));
    }

    public function update(Request $request, $id)
    {
        $askari = Askari::findOrFail($id);

        $request->validate([
            'MagacaQofka' => 'required|string|max:255',
            'LamabrkaCiidanka' => "required|unique:askarta,LamabrkaCiidanka,$id,AskariId",
            'DepartmentId' => 'required|exists:Departments,id',
            'AskariImage' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('AskariImage')) {
            $data['AskariImage'] = $request->file('AskariImage')->store('askari', 'public');
        }

        $askari->update($data);

        return redirect()->route('pages.askari.index')->with('success', 'Askari waa la cusbooneysiiyey!');
    }

    public function destroy($id)
    {
        $askari = Askari::findOrFail($id);
        $askari->delete();

        return redirect()->route('pages.askari.index')->with('success', 'Askari waa la tirtiray!');
    }

    public function show($id)
    {
        $askari = Askari::with('Department')->findOrFail($id);
        return view('pages.askari.show', compact('askari'));
    }
}
