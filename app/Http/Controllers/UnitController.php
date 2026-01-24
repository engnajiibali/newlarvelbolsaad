<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use Yajra\DataTables\Facades\DataTables;

class UnitController extends Controller
{
    // ✅ Display DataTable
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Unit::latest('UnitId')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->UnitId.'" class="editUnit btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->UnitId.'" class="deleteUnit btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
               ->editColumn('Status', function($row){
    if ($row->Status == 0) {
        return '<span class="badge bg-success">Active</span>';
    } else {
        return '<span class="badge bg-danger">Inactive</span>';
    }
})
                ->rawColumns(['action','Status'])
                ->make(true);
        }

        return view('pages.unit.index'); // 👈 blade file
    }

    // ✅ Store or Update Unit
    public function store(Request $request)
    {
        $request->validate([
            'UnitName' => 'required|string|max:100',
            'Status'   => 'required|boolean',
            'UserId'   => 'nullable|integer',
            'FinishDate' => 'nullable|date',
        ]);

        $unit_id = $request->UnitId;

        // If updating existing unit
        if($unit_id){
            $unit = Unit::find($unit_id);
        } else {
            $unit = new Unit();
        }

        $unit->UnitName   = $request->UnitName;
        $unit->Status     = $request->Status;
        $unit->UserId     = $request->UserId;
        $unit->FinishDate = $request->FinishDate;

        $unit->save();

        return response()->json([
            'success' => true,
            'message' => $unit_id ? 'Unit updated successfully' : 'Unit created successfully'
        ]);
    }

    // ✅ Show unit for edit
    public function edit($id)
    {
        $unit = Unit::find($id);
        return response()->json($unit);
    }

    // ✅ Delete unit
    public function destroy($id)
    {
        $unit = Unit::find($id);
        $unit->delete();

        return response()->json(['success'=>'Unit deleted successfully.']);
    }
}
