<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->get();
        return view('pages.employees.index', compact('employees'));
    }



    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:employees,email',
        'phone' => 'required',
        'designation' => 'required'
    ]);

    $employee = Employee::create($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Employee added successfully',
        'employee' => $employee
    ]);
}


    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

   public function update(Request $request, Employee $employee)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:employees,email,' . $employee->id,
        'phone' => 'required',
        'designation' => 'required',
    ]);

    $employee->update($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Employee updated successfully',
        'employee' => $employee
    ]);
}


    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(['success' => true]);
    }
}
