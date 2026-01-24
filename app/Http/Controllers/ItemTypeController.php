<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemType;
use Yajra\DataTables\Facades\DataTables;

class ItemTypeController extends Controller
{
    // index
  public function index(Request $request)
{
    if ($request->ajax()) {
        $data = ItemType::with('departments')->latest('ItemTypeId')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('departments', function($row){ 
                return $row->departments->name ?? ''; 
            })
            ->addColumn('action', function($row){
                $btn  = '<a href="javascript:void(0)" data-id="'.$row->ItemTypeId.'" class="editItemType btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                $btn .= '<a href="javascript:void(0)" data-id="'.$row->ItemTypeId.'" class="deleteItemType btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('pages.itemtypes');
}


    // store
    public function store(Request $request)
    {
        $request->validate([
            'ItemTypeName' => 'required|string|max:100',
            'WaaxId'       => 'required|integer',
        ]);

        $id = $request->itemtype_id;

        $itemtype = ItemType::updateOrCreate(
            ['ItemTypeId' => $id],
            [
                'ItemTypeName' => $request->ItemTypeName,
                'WaaxId' => $request->WaaxId,
                'UserId' => auth()->id() ?? 1,
                'itemtypeCreateDate' => now(),
                'itemtypeUpdateDate' => now(),
                'FinishDate' => $request->FinishDate
            ]
        );

        return response()->json(['success' => true, 'message' => $id ? 'ItemType updated!' : 'ItemType created!']);
    }

    // edit
    public function edit($id)
    {
        $itemtype = ItemType::find($id);
        return response()->json($itemtype);
    }

    // destroy
    public function destroy($id)
    {
        ItemType::find($id)->delete();
        return response()->json(['success' => 'ItemType deleted successfully.']);
    }
}
