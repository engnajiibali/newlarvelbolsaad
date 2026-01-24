<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shaqsiyaadka;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class ShaqsiyaadkaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Shaqsiyaadka::latest('ShaqsiyaadkaId')->get();
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('SawirkaShaqsiga', function ($row) {
                    if ($row->SawirkaShaqsiga) {
                        return '<img src="'.asset($row->SawirkaShaqsiga).'" width="45" height="45" class="rounded-circle shadow-sm" style="object-fit: cover; border: 2px solid #eee;">';
                    }
                    return '<span class="badge bg-light text-dark border">No Image</span>';
                })
                ->addColumn('KaarkaShaqsiga', function ($row) {
                    if ($row->KaarkaShaqsiga) {
                        return '<a href="'.asset($row->KaarkaShaqsiga).'" target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="fa fa-eye"></i> View Card
                                </a>';
                    }
                    return '<span class="text-muted small">No File</span>';
                })
                ->addColumn('action', function ($row) {
                    // ROLE CHECK: Only Role ID 1 (Admin) can Edit or Delete
                    if (auth()->user()->role_id == 1) {
                        $btn = '<div class="btn-group" role="group">
                                    <a href="javascript:void(0)" data-id="'.$row->ShaqsiyaadkaId.'" class="editShaqsiyaad btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" data-id="'.$row->ShaqsiyaadkaId.'" class="deleteShaqsiyaad btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>';
                        return $btn;
                    }
                    
                    // Non-admins see a restricted view
                    return '<span class="badge bg-secondary opacity-75"><i class="fa fa-lock me-1"></i> View Only</span>';
                })
                ->rawColumns(['SawirkaShaqsiga', 'KaarkaShaqsiga', 'action'])
                ->make(true);
        }

        return view('pages.shaqsiyaadka');
    }

    /**
     * Store or Update a resource.
     */
    public function store(Request $request)
    {
        // SECURITY: Server-side check to block non-admins
        // if (auth()->user()->role_id != 1) {
        //     return response()->json(['message' => 'Ficilkan laguma oggola (Unauthorized)'], 403);
        // }

        $request->validate([
            'magacaShaqsiga' => 'required|string|max:100',
            'Jagada'         => 'nullable|string|max:100',
            'TalefanLambarka' => 'nullable|string|max:20',
            'Addresska'      => 'nullable|string|max:255',
            'Description'    => 'nullable|string',
            'SawirkaShaqsiga' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'KaarkaShaqsiga'  => 'nullable|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $id = $request->ShaqsiyaadkaId;
        
        // Find existing record or create new
        $shaqsi = $id ? Shaqsiyaadka::findOrFail($id) : new Shaqsiyaadka();

        $shaqsi->magacaShaqsiga = $request->magacaShaqsiga;
        $shaqsi->Jagada = $request->Jagada;
        $shaqsi->TalefanLambarka = $request->TalefanLambarka;
        $shaqsi->Addresska = $request->Addresska;
        $shaqsi->Description = $request->Description;
        
        if (!$id) {
            $shaqsi->CreateDate = now();
        }

        // Handle Image Upload
        if ($request->hasFile('SawirkaShaqsiga')) {
            // Delete old file if updating
            if ($id && $shaqsi->SawirkaShaqsiga && File::exists(public_path($shaqsi->SawirkaShaqsiga))) {
                File::delete(public_path($shaqsi->SawirkaShaqsiga));
            }

            $image = $request->file('SawirkaShaqsiga');
            $filename = time().'_photo.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/shaqsiyaad/sawir'), $filename);
            $shaqsi->SawirkaShaqsiga = 'uploads/shaqsiyaad/sawir/'.$filename;
        }

        // Handle Card/PDF Upload
        if ($request->hasFile('KaarkaShaqsiga')) {
            // Delete old file if updating
            if ($id && $shaqsi->KaarkaShaqsiga && File::exists(public_path($shaqsi->KaarkaShaqsiga))) {
                File::delete(public_path($shaqsi->KaarkaShaqsiga));
            }

            $file = $request->file('KaarkaShaqsiga');
            $cardname = time().'_card.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/shaqsiyaad/kaarka'), $cardname);
            $shaqsi->KaarkaShaqsiga = 'uploads/shaqsiyaad/kaarka/'.$cardname;
        }

        $shaqsi->save();

        return response()->json([
            'success' => true,
            'message' => $id ? 'Xogta waa la cusubaysiiyey' : 'Shaqsi cusub waa la diiwaangeliyey'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $shaqsi = Shaqsiyaadka::findOrFail($id);
        return response()->json($shaqsi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // SECURITY: Server-side check to block non-admins
        if (auth()->user()->role_id != 1) {
            return response()->json(['message' => 'Ficilkan laguma oggola (Unauthorized)'], 403);
        }

        $shaqsi = Shaqsiyaadka::findOrFail($id);

        // Delete associated files from storage
        if ($shaqsi->SawirkaShaqsiga && File::exists(public_path($shaqsi->SawirkaShaqsiga))) {
            File::delete(public_path($shaqsi->SawirkaShaqsiga));
        }
        
        if ($shaqsi->KaarkaShaqsiga && File::exists(public_path($shaqsi->KaarkaShaqsiga))) {
            File::delete(public_path($shaqsi->KaarkaShaqsiga));
        }

        $shaqsi->delete();

        return response()->json(['success' => 'Xogta waa la tirtiray.']);
    }
}