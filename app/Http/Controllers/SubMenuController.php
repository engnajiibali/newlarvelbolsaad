<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubMenu;
use App\Models\Menu;
use Yajra\DataTables\Facades\DataTables;

class SubMenuController extends Controller
{
    // Display DataTable
 public function index(Request $request)
{
    if ($request->ajax()) {
        $data = SubMenu::with('menu')->latest()->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('menu_name', function($row){
                return $row->menu->menu_name ?? '';
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="editSubMenu btn btn-primary btn-sm"><i class="fa fa-edit"></i></a> ';
                $btn .= '<a href="javascript:void(0)" data-id="'.$row->id.'" class="deleteSubMenu btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    $menus = Menu::all(); // ➝ tani waa waxa ka maqan
   
    return view('pages.sub_menus', compact('menus'));
}


    // Store or Update SubMenu
    public function store(Request $request)
    {
        $request->validate([
            'name_sub_menu' => 'required|string|max:100',
            'menu_id' => 'required|exists:menus,id',
            'sub_menu_order' => 'nullable|integer',
            'hak_akses' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'content_before' => 'nullable|string',
            'content_after' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'title' => 'nullable|string|max:255',
            'target' => 'nullable|in:_self,_blank',
        ]);

        $submenu = SubMenu::updateOrCreate(
            ['id' => $request->sub_menu_id],
            $request->all()
        );

        return response()->json([
            'success' => true,
            'message' => $request->sub_menu_id ? 'SubMenu updated successfully' : 'SubMenu created successfully'
        ]);
    }

    // Show submenu for edit
    public function edit($id)
    {
        $submenu = SubMenu::findOrFail($id);
        return response()->json($submenu);
    }

    // Delete submenu
    public function destroy($id)
    {
        $submenu = SubMenu::findOrFail($id);
        $submenu->delete();

        return response()->json(['success'=>'SubMenu deleted successfully.']);
    }
}
