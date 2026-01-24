<?php

namespace App\Http\Controllers;

use App\Models\Army;
use Illuminate\Http\Request;

class ArmyApiController extends Controller
{
    // Fetch all
    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Army::limit(20)->get()
        ]);
    }

    // Fetch single record
    public function show($id)
    {
        $army = Army::find($id);

        if (!$army) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $army
        ]);
    }

    // Create new
 



  
}
