<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    // Display DataTable
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Department::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editDepartment btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="deleteDepartment btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.departments');
    }

    // Store or Update Department
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:50',
            'status' => 'required|boolean',
        ]);

        $department_id = $request->department_id;
        $department = $department_id ? Department::find($department_id) : new Department();

        $department->name = $request->name;
        $department->code = $request->code;
        $department->status = $request->status;
        $department->save();

        return response()->json([
            'success' => true,
            'message' => $department_id ? 'Department updated successfully' : 'Department created successfully'
        ]);
    }

    // Show department for edit
    public function edit($id)
    {
        $department = Department::find($id);
        return response()->json($department);
    }

    // Delete department
    public function destroy($id)
    {
        Department::find($id)->delete();
        return response()->json(['success'=>'Department deleted successfully.']);
    }
}
