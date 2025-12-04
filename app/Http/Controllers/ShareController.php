<?php

namespace App\Http\Controllers;

use App\Models\Shareable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function displayShares(){
        // Logic to display shareable diagrams
    }

    public function storeShareAccess(Request $request){
        $shareInformation = $request->validate([
            'diagram_id' => 'required|integer',
            'user_id' => 'required|integer',
            'created_by' => 'required|integer',
        ]);

        $shareInformation['created_date'] = Carbon::now();
        $shareInformation['is_active'] = true;

        $Sharediagram = Shareable::create($shareInformation);

        return response()->json($Sharediagram, 201);
    }
}
