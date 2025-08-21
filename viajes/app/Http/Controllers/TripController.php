<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    public function searchTrip(Request $request)
    {
        if($request->input('origen') && $request->input('destino') && $request->input('fecha') && $request->input('asientos')){
            $origen = City::where('id', $request->input('origen'))->first();
            $destino = City::where('id', $request->input('destino'))->first();
            
            if($origen && $destino){
                return redirect("/search/{$origen->id}/{$destino->id}/{$request->input('fecha')}/{$request->input('asientos')}/{$request->input('sort')}/{$request->input('verified')}");
            }else
            {
                return redirect()->intended('/')->withErrors("Debe indicar origen y destino");
            }

        }
    
    }

    public function search($from,$to,$date,$seats,$sort="departure_time",$verified=null){

        $trips = Trip::with(['departureCity','arrivalCity','driver'])
        ->select(['trips.*', DB::raw('(SELECT SUM(seats)FROM reservations WHERE trip_id = trips.id)AS occupied_seats')])
        ->whereHas('departureCity', function($query){
            $query->where('active',1);
        })

        ->whereHas('arrivalCity', function($query){
            $query->where('active',1);
        })

        ->whereHas('driver', function($query)use($verified){
            $query->where('active',1);

            if($verified == 1){
                $query->where('verified',1);
                $query->where('dni_front',"!=","");
                $query->where('dni_back',"!=","");
                
            }
        })
        ->where('departure_city_id',$from)
        ->where('arrival_city_id',$to)
        ->where('available_seats',">=",$seats)
        ->where('departure_date',$date)
        ->where('active',1)
        ->orderBy($sort,"asc")
        ->get();

        $cityFrom = City::find($from);
        $cityTo = City::find($to);

        if($cityFrom && $cityTo){
            $from = $cityFrom->name;
            $to = $cityTo->name;

            return view('results-trip')->with(compact('from','to','seats','date','trips','sort','verified'));
        }else{
            return redirect()->withErrors("No hay viajes disponibles para estas condiciones");
            
        }
    }
}
