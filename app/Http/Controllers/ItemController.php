<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    /**
     * Display a listing of items.
     */
    public function index(Request $request)
    {
      
        if ($request->ajax()) {
            $data = Item::with(['unit','waax','user'])->latest('ItemId')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('unit', fn($row) => $row->unit->UnitName ?? '')
                ->addColumn('waax', fn($row) => $row->waax->WaaxName ?? '')
                ->addColumn('user', fn($row) => $row->user->UserName ?? '')
                ->editColumn('Status', function ($row) {
                    // 0 = Active, 1 = Inactive
                    $badgeClass = $row->Status == 0 ? 'bg-success' : 'bg-danger';
                    $statusText = $row->Status == 0 ? 'Active' : 'Inactive';
                    $textColor = $row->Status == 0 ? '' : 'color: #fff;'; // white text for inactive

                    return '<a href="javascript:void(0)" class="toggleStatus badge '.$badgeClass.'" data-id="'.$row->ItemId.'" style="cursor:pointer; '.$textColor.'">'.$statusText.'</a>';
                })
                ->addColumn('action', function($row){
                    return '
                        <a href="javascript:void(0)" data-id="'.$row->ItemId.'" class="editItem btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0)" data-id="'.$row->ItemId.'" class="deleteItem btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    ';
                })
                ->rawColumns(['Status','action'])
                ->make(true);
        }

        // Load dropdown data for modal
        $units = Unit::all();
        $waax = Department::all();
        $users = User::all();

        return view('pages.items.index', compact('units','waax','users'));
    }

    /**
     * Store or update an item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ItemName' => 'required|string|max:255',
            'UnitId' => 'required|integer',
            'ItemType' => 'required|string',
            'CabirkaKeedinta' => 'nullable|string',
            'CabirkaBixinta' => 'nullable|string',
            'WaaxId' => 'required|integer',
            'UserId' => 'required|integer',
            'Status' => 'required|boolean',
            'FinishDate' => 'nullable|date',
        ]);

        Item::updateOrCreate(
            ['ItemId' => $request->ItemId],
            $validated
        );

        return response()->json(['success' => 'Item saved successfully.']);
    }

    /**
     * Get a single item for edit.
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return response()->json($item);
    }

    /**
     * Delete an item.
     */
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json(['success' => 'Item deleted successfully.']);
    }

    /**
     * Toggle the status of an item (active/inactive).
     */
    public function toggleStatus($id)
    {
        $item = Item::findOrFail($id);
        $item->Status = $item->Status == 1 ? 0 : 1;
        $item->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully.',
            'new_status' => $item->Status
        ]);
    }
}
