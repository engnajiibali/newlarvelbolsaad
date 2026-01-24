<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Department;
use App\Models\Keydin;
use Illuminate\Http\Request;

class ShaxdaHubkaController extends Controller
{
    public function index(Request $request)
    {
  
        // 1. Fetch All Items
       $items = Item::whereNull('FinishDate')
             ->where('WaaxId', '2')
             ->get(['ItemId', 'ItemName']);


        // 2. Fetch All Fadhiyada
     $allFadhiyada = Department::get(['id', 'name']);

        // Selected Filter
        $selectedFadhi = $request->get('fadhi');

        $fadhiyada = $selectedFadhi
            ? $allFadhiyada->where('id', $selectedFadhi)
            : $allFadhiyada;

        // 3. Counts grouped
        $counts = Keydin::selectRaw('FadhiId, keydin_itemID as ItemId, COUNT(*) as ItemCount')
            ->groupBy('FadhiId', 'keydin_itemID')
            ->get();

        // Mapping counts
        $itemCounts = [];
        foreach ($counts as $row) {
            $itemCounts[$row->FadhiId][$row->ItemId] = $row->ItemCount;
        }

        return view('pages.hubka.shaxda', compact('items', 'allFadhiyada', 'fadhiyada', 'selectedFadhi', 'itemCounts'));
    }
}
