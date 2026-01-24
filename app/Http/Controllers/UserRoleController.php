<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Models\User;
class UserRoleController extends Controller
{
//                 public function __construct()
// {
//     $this->middleware('permission:show')->only('show');
//     $this->middleware('permission:create')->only('create');
//     $this->middleware('permission:edit')->only('edit');
//     $this->middleware('permission:delete')->only('destroy');
// }
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index()
{
$pageTitle ="User Management";
$subTitle ="Manage User Information";
$userRole = UserRole::paginate(10);
return view('pages.userRole.index',compact('userRole','pageTitle','subTitle'));
}

/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
    $pageTitle ="User Role Management";
     $subTitle ="Add New User Role";
$menus = Menu::all();
$submenus = SubMenu::with('menu')->get();

// return [$menus, $submenus];


return view('pages.userRole.add',compact('menus','submenus','pageTitle','subTitle'));


}

/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(Request $request)
{
    $request->validate([
        'Role' => 'required|string',
        'menu' => 'required',
        'Description' => 'nullable|string',
    ], [
        'Role.unique' => 'This Role is already registered.',
    ]);

$existingRole = UserRole::where('Role', $request->Role)->first();

if ($existingRole) {
    return back()->with('fail', 'This Role already exists.');
}

// Proceed with saving the role
$role = new UserRole();
$role->role_menu = $request->menu;
$role->Role = $request->Role;
$role->Read_permision = $request->Read ?? 0;  // Set to 0 if null
$role->Write_permision = $request->Write ?? 0; // Set to 0 if null
$role->Edit_permision = $request->Edit ?? 0;   // Set to 0 if null
$role->Delete_permision = $request->Delete ?? 0; // Set to 0 if null
$role->description = $request->Description;

if ($role->save()) {
    return redirect('userRole')->with('success', 'Role successfully registered.');
} else {
    return back()->with('fail', 'Something went wrong.');
}

}

/**
* Display the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function show($id)
{
//
}

/**
* Show the form for editing the specified resource.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function edit($id)
{
$menus = Menu::all();
$submenus = SubMenu::with('menu')->get();
$role = UserRole::findOrfail($id);
// return [$menus, $submenus];
    $pageTitle ="User Management";
     $subTitle ="Edit User Role";

return view('pages.userRole.edit',compact('menus','submenus','role','pageTitle','subTitle'));
}

/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
$request->validate([
'Role' => 'required|string',
'menu' => 'required'
],
[  
'Role.unique' => 'This Role is already registered'
]);

$role = UserRole::where('Role', $request->Role)->first();

if ($role && $role->id != $id) {
    // A different role with the same name already exists
    return back()->with('fail', 'This role already exists. Please choose a different name.');
} else {
        // The role found matches the current ID (likely during an update operation)
        // You might want to handle this case based on your application's logic

$role =UserRole::findOrfail($id);
$role->role_menu = $request->menu;
$role->Role = $request->Role;
$role->Read_permision = $request->Read ?? 0;  // Set to 0 if null
$role->Write_permision = $request->Write ?? 0; // Set to 0 if null
$role->Edit_permision = $request->Edit ?? 0;   // Set to 0 if null
$role->Delete_permision = $request->Delete ?? 0; // Set to 0 if null
$role->description = $request->Description;
$res= $role->save();
if ($res) {
return redirect('userRole')->with('success', 'Role successsfully Registed');
}
else{
return back()->with('fail', 'Somthing Wrong');
}
    }




}

/**
* Remove the specified resource from storage.
*
* @param  int  $id
* @return \Illuminate\Http\Response
*/
public function destroy($id)
{
$CheckUsers = User::where('role_id', '=',$id)->first();
if ($CheckUsers) {
return back() ->with('fail', 'This Role Already Assigned With User');
exit();
}
$role = UserRole::findOrfail($id);
if ($role->isDefault=="Yes") {
return back()->with('fail', 'This is Default USer You Can not Delete');
}

$res= $role->delete();
if ($res) {
return back() ->with('success', 'USer successsfully Deleted');
}
else{
return back()->with('fail', 'Somthing Wrong');
}
}
}
