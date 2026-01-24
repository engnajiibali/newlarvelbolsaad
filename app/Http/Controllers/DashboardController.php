<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keydin;
use App\Models\Department;
use App\Models\Askari;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Dashboard counts ---
        $Keydin = Keydin::count();
        $fadhiyada = Department::count();
        $Askari = Askari::count();
        $totalItems = Item::count();
 $shaqsiyadka = Keydin::where('keydin_Xalada', 2)->count();
        // --- Items for Keydin chart ---
        $itemList = Item::whereNull('FinishDate')
          ->where('WaaxId', '2')
        ->get(['ItemId', 'ItemName']);

          $ownershipData = Keydin::selectRaw('keydin_Xalada, COUNT(*) as total')
            ->groupBy('keydin_Xalada')
            ->pluck('total', 'keydin_Xalada');

             $carStatusData = Keydin::selectRaw('Xalada, COUNT(*) as total')
            ->groupBy('Xalada')
            ->pluck('total', 'Xalada');

        // Count each item in tbl_keydin
        $rawKeydinItems = DB::table('tbl_keydin')
            ->select('keydin_itemID', DB::raw('COUNT(*) as count'))
            ->groupBy('keydin_itemID')
            ->get();
            
   $xaladaCounts = Keydin::select('Xalada')
        ->selectRaw('COUNT(*) as total')
        ->groupBy('Xalada')
        ->pluck('total', 'Xalada'); // ['XaladaValue' => count, ...]
        // Merge item names with counts
        $KeydinItems = $itemList->map(function ($item) use ($rawKeydinItems) {
            $count = $rawKeydinItems->firstWhere('keydin_itemID', $item->ItemId)->count ?? 0;
            return (object)[
                'ItemName' => $item->ItemName,
                'Count' => $count
            ];
        });
      $xaladaLabels = [
        1 => 'L baxshay',
        2 => 'La keydiyay',
        3 => 'Lumay',
        4 => 'La burbutiyay',
        5 => 'Baafin',
        6 => 'Lqabtay',
    ];

        // --- Return view with all data ---
        return view('pages.starter', compact(
            'Keydin',
            'fadhiyada',
            'Askari',
            'totalItems',
            'KeydinItems',
            'xaladaCounts',
            'xaladaLabels',
            'ownershipData',
            'carStatusData',
            'shaqsiyadka'
        ));
    }
}
