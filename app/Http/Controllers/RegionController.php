<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class RegionController extends Controller
{
    // Display DataTable
 public function index(Request $request)
{
    if($request->ajax()){
        $data = Region::with('state.country')->latest()->get(); // eager load state & country
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('state_name', function($row){ 
                return $row->state->name ?? ''; 
            })
            ->addColumn('country_name', function($row){ 
                return $row->state->country->name ?? ''; 
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editRegion btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="deleteRegion btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    $countries = Country::all();
    $states = State::all();
    return view('pages.regions', compact('states','countries'));
}


    // Store or Update Region
    public function store(Request $request)
    {
        $request->validate([
            'state_id' => 'required|exists:states,id',
            'name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $region_id = $request->region_id;
        $region = $region_id ? Region::find($region_id) : new Region();

        $region->state_id = $request->state_id;
        $region->name = $request->name;
        $region->latitude = $request->latitude;
        $region->longitude = $request->longitude;

        if($request->hasFile('image')){
            if($region->image && Storage::exists('public/'.$region->image)){
                Storage::delete('public/'.$region->image);
            }
            $path = $request->file('image')->store('regionimages', 'public');
            $region->image = $path;
        }

        $region->save();

        return response()->json([
            'success' => true,
            'message' => $region_id ? 'Region updated successfully' : 'Region created successfully'
        ]);
    }

    // Show region for edit
    public function edit($id)
    {
        $region = Region::find($id);
        return response()->json([
            'id' => $region->id,
            'state_id' => $region->state_id,
            'name' => $region->name,
            'latitude' => $region->latitude,
            'longitude' => $region->longitude,
            'image' => $region->image,
        ]);
    }

    // Delete region
    public function destroy($id)
    {
        $region = Region::find($id);
        if($region->image && Storage::exists('public/'.$region->image)){
            Storage::delete('public/'.$region->image);
        }
        $region->delete();

        return response()->json(['success'=>'Region deleted successfully.']);
    }

    public function getRegions($state_id)
{
    $regions = Region::where('state_id', $state_id)->get();
    return response()->json($regions);
}

}
