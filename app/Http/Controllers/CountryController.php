<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    // Display DataTable
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Country::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editCountry btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                    $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="deleteCountry btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.countries');
    }

    // Store or Update Country
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $country_id = $request->country_id;

        $country = $country_id ? Country::find($country_id) : new Country();

        $country->name = $request->name;
        $country->latitude = $request->latitude;
        $country->longitude = $request->longitude;

        if($request->hasFile('image')){
            if($country->image && Storage::exists('public/'.$country->image)){
                Storage::delete('public/'.$country->image);
            }
            $path = $request->file('image')->store('countryimages', 'public');
            $country->image = $path;
        }

        $country->save();

        return response()->json([
            'success' => true,
            'message' => $country_id ? 'Country updated successfully' : 'Country created successfully'
        ]);
    }

    // Show country for edit
    public function edit($id)
    {
        $country = Country::find($id);
        return response()->json($country);
    }

    // Delete country
    public function destroy($id)
    {
        $country = Country::find($id);
        if($country->image && Storage::exists('public/'.$country->image)){
            Storage::delete('public/'.$country->image);
        }
        $country->delete();

        return response()->json(['success'=>'Country deleted successfully.']);
    }
}
