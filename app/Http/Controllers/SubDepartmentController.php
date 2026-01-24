<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubDepartment;
use App\Models\Department;
use Yajra\DataTables\Facades\DataTables;

class SubDepartmentController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = SubDepartment::with('department')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department_name', function($row){
                    return $row->department->name ?? '';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editSubDepartment btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="deleteSubDepartment btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $departments = Department::all();
        return view('pages.sub_departments', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50',
            'status' => 'required|boolean',
        ]);

        $subdepartment_id = $request->sub_department_id;

        $subdepartment = $subdepartment_id ? SubDepartment::find($subdepartment_id) : new SubDepartment();

        $subdepartment->department_id = $request->department_id;
        $subdepartment->name = $request->name;
        $subdepartment->code = $request->code;
        $subdepartment->status = $request->status;
        $subdepartment->save();

        return response()->json([
            'success' => true,
            'message' => $subdepartment_id ? 'SubDepartment updated successfully' : 'SubDepartment created successfully'
        ]);
    }

    public function edit($id)
    {
        $subdepartment = SubDepartment::find($id);
        return response()->json($subdepartment);
    }

    public function destroy($id)
    {
        SubDepartment::find($id)->delete();
        return response()->json(['success'=>'SubDepartment deleted successfully.']);
    }
}
