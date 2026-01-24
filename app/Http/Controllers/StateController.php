<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class StateController extends Controller
{
    // Display DataTable
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = State::with('country')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('country_name', function($row){ 
                    return $row->country->name ?? ''; 
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editState btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="deleteState btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $countries = Country::all();
        return view('pages.states', compact('countries'));
    }

    // Store or Update State
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $state_id = $request->state_id;
        $state = $state_id ? State::find($state_id) : new State();

        $state->country_id = $request->country_id;
        $state->name = $request->name;
        $state->latitude = $request->latitude;
        $state->longitude = $request->longitude;

        if($request->hasFile('image')){
            if($state->image && Storage::exists('public/'.$state->image)){
                Storage::delete('public/'.$state->image);
            }
            $path = $request->file('image')->store('stateimages', 'public');
            $state->image = $path;
        }

        $state->save();

        return response()->json([
            'success' => true,
            'message' => $state_id ? 'State updated successfully' : 'State created successfully'
        ]);
    }

    // Show state for edit
    public function edit($id)
    {
        $state = State::find($id);
        return response()->json([
            'id' => $state->id,
            'country_id' => $state->country_id,
            'name' => $state->name,
            'latitude' => $state->latitude,
            'longitude' => $state->longitude,
            'image' => $state->image,
        ]);
    }

    // Delete state
    public function destroy($id)
    {
        $state = State::find($id);
        if($state->image && Storage::exists('public/'.$state->image)){
            Storage::delete('public/'.$state->image);
        }
        $state->delete();

        return response()->json(['success'=>'State deleted successfully.']);
    }

    public function getStates($country_id)
{
    $states = State::where('country_id', $country_id)->get();
    return response()->json($states);
}
}
