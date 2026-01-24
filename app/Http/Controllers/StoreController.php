<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Department;
use Yajra\DataTables\Facades\DataTables;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Store::with('department')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department_name', function($row){
                    return $row->department->name ?? '';
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editStore btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="deleteStore btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $departments = Department::all();
        return view('pages.stores', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:100',
            'location' => 'required|string|max:150',
            'status' => 'required|boolean',
        ]);

        $store_id = $request->store_id;
        $store = $store_id ? Store::find($store_id) : new Store();

        $store->department_id = $request->department_id;
        $store->name = $request->name;
        $store->location = $request->location;
        $store->status = $request->status;
        $store->save();

        return response()->json([
            'success' => true,
            'message' => $store_id ? 'Store updated successfully' : 'Store created successfully'
        ]);
    }

    public function edit($id)
    {
        $store = Store::find($id);
        return response()->json($store);
    }

    public function destroy($id)
    {
        Store::find($id)->delete();
        return response()->json(['success'=>'Store deleted successfully.']);
    }
}
