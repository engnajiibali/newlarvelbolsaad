<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Region;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DistrictController extends Controller
{
    // Display DataTable
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = District::with('region.state.country')->latest()->get(); // eager load Region → State → Country
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('region_name', function($row){ 
                    return $row->region->name ?? ''; 
                })
                ->addColumn('state_name', function($row){ 
                    return $row->region->state->name ?? ''; 
                })
                ->addColumn('country_name', function($row){ 
                    return $row->region->state->country->name ?? ''; 
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editDistrict btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="deleteDistrict btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $countries = Country::all();
        $states = State::all();
        $regions = Region::all();
        return view('pages.districts', compact('countries','states','regions'));
    }

    // Store or Update District
    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:regions,id',
            'name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $district_id = $request->district_id;
        $district = $district_id ? District::find($district_id) : new District();

        $district->region_id = $request->region_id;
        $district->name = $request->name;
        $district->latitude = $request->latitude;
        $district->longitude = $request->longitude;

        // Handle image
        if($request->hasFile('image')){
            if($district->image && Storage::exists('public/'.$district->image)){
                Storage::delete('public/'.$district->image);
            }
            $path = $request->file('image')->store('districtimages', 'public');
            $district->image = $path;
        }

        $district->save();

        return response()->json([
            'success' => true,
            'message' => $district_id ? 'District updated successfully' : 'District created successfully'
        ]);
    }

    // Show district for edit
    public function edit($id)
    {
        $district = District::find($id);
        return response()->json([
            'id' => $district->id,
            'region_id' => $district->region_id,
            'state_id' => $district->region->state_id ?? null,
            'country_id' => $district->region->state->country_id ?? null,
            'name' => $district->name,
            'latitude' => $district->latitude,
            'longitude' => $district->longitude,
            'image' => $district->image,
        ]);
    }

    // Delete district
    public function destroy($id)
    {
        $district = District::find($id);
        if($district->image && Storage::exists('public/'.$district->image)){
            Storage::delete('public/'.$district->image);
        }
        $district->delete();

        return response()->json(['success'=>'District deleted successfully.']);
    }

    // Get districts by region (for cascading dropdown)
    public function getDistricts($region_id)
    {
        $districts = District::where('region_id', $region_id)->get();
        return response()->json($districts);
    }
}
