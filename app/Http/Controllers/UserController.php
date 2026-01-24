<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    // Display DataTable
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with('department', 'roleName')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('department_name', fn($row) => $row->department->name ?? 'No Department')
                ->addColumn('role_name', fn($row) => $row->roleName->Role ?? 'No Role')
                ->addColumn('photo', fn($row) => $row->photo ?? '')
                ->addColumn('status', fn($row) => $row->status)
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editUser btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="deleteUser btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $departments = Department::all();
        $roles = UserRole::all();
        return view('pages.users', compact('departments','roles'));
    }
     public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function show($id)
{
    $user = \App\Models\User::findOrFail($id);
    return view('users.show', compact('user'));
}
public function import(Request $request)
{
    $request->validate(['file' => 'required|mimes:xlsx,xls,csv']);

    Excel::import(new UsersImport, $request->file('file'));

    return back()->with('success', 'Users imported successfully.');
}
    // Show user for edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:user_roles,id',
            'status' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->department_id = $request->department_id;
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);

        if($request->hasFile('photo')){
            $user->photo = $request->file('photo')->store('user_photos','public');
        }

        $user->save();

        return response()->json(['success'=>true, 'message'=>'User created successfully']);
    }

    // Update existing user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'role_id' => 'required|exists:user_roles,id',
            'status' => 'required|boolean',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'nullable|string|min:6',
        ]);

        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->department_id = $request->department_id;
        $user->role_id = $request->role_id;
        $user->status = $request->status;

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        if($request->hasFile('photo')){
            if($user->photo && Storage::disk('public')->exists($user->photo)){
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('user_photos','public');
        }

        $user->save();

        return response()->json(['success'=>true, 'message'=>'User updated successfully']);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->photo && Storage::disk('public')->exists($user->photo)){
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return response()->json(['success'=>'User deleted successfully.']);
    }
}
