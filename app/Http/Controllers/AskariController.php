<?php

namespace App\Http\Controllers;

use App\Models\Askari;
use App\Models\Department;
use App\Models\AssignFadhi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AskariController extends Controller
{
 public function index(Request $request)
{


$assignments = AssignFadhi::with(['askari', 'fadhi'])
    ->where('assignfadhi.Status', 0) // ✅ FIXED
    ->withCount([
        'assignhubs as qori_count' => function ($q) {
            $q->where('assignhub.Status', 0); // ✅ FIXED
        }
    ])
    ->when($request->darajada, function ($q) use ($request) {
        $q->whereHas('askari', function ($qq) use ($request) {
            $qq->where('Darajada', 'like', '%' . $request->darajada . '%');
        });
    })
    ->when($request->lambar_ciidan, function ($q) use ($request) {
        $q->whereHas('askari', function ($qq) use ($request) {
            $qq->where('LamabrkaCiidanka', 'like', '%' . $request->lambar_ciidan . '%');
        });
    })
    ->when($request->magaca, function ($q) use ($request) {
        $q->whereHas('askari', function ($qq) use ($request) {
            $qq->where('MagacaQofka', 'like', '%' . $request->magaca . '%');
        });
    })
    ->when($request->fadhi_id, function ($q) use ($request) {
        $q->where('assignfadhi.FadhiId', $request->fadhi_id);
    })
    ->orderBy('assignFadhiDate', 'desc')
    ->paginate(10)
    ->withQueryString();





    $fadhiyada = Department::all();

    return view('pages.askari.index', compact('assignments', 'fadhiyada'));
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

    public function searchAskari(Request $request)
{
    $search = $request->get('q');

    $data = Askari::where('MagacaQofka', 'LIKE', "%{$search}%")
        ->orWhere('LamabrkaCiidanka', 'LIKE', "%{$search}%")
        ->select(
            'AskariId as id',
            DB::raw("CONCAT(MagacaQofka, ' - ', LamabrkaCiidanka) as text")
        )
        ->limit(20)
        ->get();

    return response()->json($data);
}
}
