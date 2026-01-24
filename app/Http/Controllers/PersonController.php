<?php

namespace App\Http\Controllers;

use App\Models\persons;
use App\Models\Army;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PersonController extends Controller
{
// public function __construct()
// {
// $this->middleware('permission:show')->only('show');
// $this->middleware('permission:create')->only('create', 'store');
// $this->middleware('permission:edit')->only('edit', 'update');
// $this->middleware('permission:delete')->only('destroy');
// }

/**
* Display a listing of the resource.
*/
public function index()
{
$pageTitle = "Askarta";
$subTitle = "Liiska Askarta ";
$persons = Army::paginate(10);

$AllPersons = Army::count();
$ActivePersons = Army::where('status', '=', "true")->count();
$inActivePersons = Army::where('status', '=', "false")->count();
$NewJoiners = Army::whereBetween('date_added', [
Carbon::now()->startOfWeek(),
Carbon::now()->endOfWeek()
])->count();

$enteries = Army::count();
return view('pages.persons.index', compact('enteries','persons', 'AllPersons', 'ActivePersons', 'inActivePersons', 'NewJoiners', 'pageTitle', 'subTitle'));
}
public function searchPerson(Request $request)
{
$query = Army::query();

// Name search
if ($request->filled('name')) {
$name = strtoupper($request->name);
$query->where('first_name', 'like', "%$name%");
}

// Email filter (partial match)
if ($request->filled('email')) {
$query->where('email', 'LIKE', '%' . $request->email . '%');
}

// Phone filter (partial match)
if ($request->filled('phone')) {
$query->where('phone', 'LIKE', '%' . $request->phone . '%');
}

// Status filter
if ($request->filled('status')) {
$query->where('status', $request->status);
}

$persons = $query->paginate(10)->appends($request->except('page'));


$pageTitle = "Askarta";
$subTitle = "Search Results";

$AllPersons = Army::count();
$ActivePersons = Army::where('status', 'true')->count();
$inActivePersons = Army::where('status', 'false')->count();
$NewJoiners = Army::whereBetween('date_added', [
Carbon::now()->startOfWeek(),
Carbon::now()->endOfWeek()
])->count();
$enteries = $persons->total(); // only filtered results count

return view('pages.persons.index', compact(
'enteries',
'persons',
'AllPersons',
'ActivePersons',
'inActivePersons',
'NewJoiners',
'pageTitle',
'subTitle'
));
}

public function getpersons()
{

$pageTitle = "Employee";
$subTitle = "Employee List";
$persons = persons::paginate(12);
$AllPersons = persons::count();
$ActivePersons = persons::where('status', '=', "Active")->count();
$inActivePersons = persons::where('status', '=', "Inactive")->count();
$NewJoiners = persons::whereBetween('created_at', [
Carbon::now()->startOfWeek(),
Carbon::now()->endOfWeek()
])->count();
$enteries = persons::count();
return view('pages.persons.grid', compact('enteries','persons', 'AllPersons', 'ActivePersons', 'inActivePersons', 'NewJoiners', 'pageTitle', 'subTitle'));
}

/**
* Show the form for creating a new resource.
*/
public function create()
{
$pageTitle = "Add Employee";
return view('pages.persons.add', compact('pageTitle'));
}

/**
* Store a newly created resource in storage.
*/
public function store(Request $request)
{
$validated = $request->validate([
'fullName' => 'required|string|max:255',
'email'    => 'nullable|email',
'phone'    => 'nullable|string|max:20',
'gender'   => 'required',
]);

// Handle profile image upload
if ($request->hasFile('personImd')) {
$fileName = time() . '_img_' . $request->personImd->getClientOriginalName();
$request->personImd->move(public_path('upload/personImg'), $fileName);
} else {
$fileName = 'userimg.png'; // Default image
}

// Create new person
$person = new persons();
$person->FullName   = $request->fullName;
$person->Email      = $request->email;
$person->Phone      = $request->phone;
$person->Gender     = $request->gender;
$person->image      = $fileName;
$person->createdby  = session()->get('userId');

if ($person->save()) {
return redirect('persons')->with('success', 'Person successfully registered.');
} else {
return back()->with('fail', 'Something went wrong.');
}
}


/**
* Display the specified resource.
*/
public function show(string $id)
{
$person = Army::findOrFail($id);
$pageTitle = "User Details";
return view('pages.persons.show', compact('person', 'pageTitle'));
}

/**
* Show the form for editing the specified resource.
*/
public function edit(string $id)
{
$person = persons::findOrFail($id);
$pageTitle = "Edit User";
return view('pages.persons.edit', compact('person', 'pageTitle'));
}

/**
* Update the specified resource in storage.
*/
public function update(Request $request, $id)
{
$validated = $request->validate([
'fullName' => 'required|string|max:255',
'email'    => 'nullable|email',
'phone'    => 'nullable|string|max:20',
'gender'   => 'required',
]);

$person = persons::findOrFail($id);

// Handle profile image update if uploaded
if ($request->hasFile('personImd')) {
$fileName = time() . '_img_' . $request->personImd->getClientOriginalName();
$request->personImd->move(public_path('upload/personImg'), $fileName);
$person->image = $fileName;
}

// Update fields
$person->FullName = $request->fullName;
$person->Email    = $request->email;
$person->Phone    = $request->phone;
$person->Gender   = $request->gender;

if ($person->save()) {
return redirect('persons')->with('success', 'Person successfully updated.');
} else {
return back()->with('fail', 'Update failed.');
}
}

/**
* Remove the specified resource from storage.
*/
public function destroy(string $id)
{
$person = persons::findOrFail($id);
$person->delete();

return back()->with('success', 'User deleted successfully.');
}
}
