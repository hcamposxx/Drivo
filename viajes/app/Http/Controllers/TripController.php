<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function searchTrip(Request $request)
    {
        if($request->input('origen') && $request->input('destino') && $request->input('fecha') && $request->input('asientos')){
            $origen = City::where('name', $request->input('origen'))->first();
            $destino = City::where('name', $request->input('destino'))->first();
            
        }
    
    }
}
