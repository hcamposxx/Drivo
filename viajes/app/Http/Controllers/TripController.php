<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    public function searchTrip(Request $request)
    {
        if (!Auth::check()) {
        return redirect()->route('login')->withErrors('Debes iniciar sesión para buscar viajes.');
        }
        if($request->input('origen') && $request->input('destino') && $request->input('fecha') && $request->input('asientos')){
            if($request->has('form2')){

                $origen = City::where('name', $request->input('origen'))->first();
                $destino = City::where('name', $request->input('destino'))->first();

            }else{

                $origen = City::where('id', $request->input('origen'))->first();
                $destino = City::where('id', $request->input('destino'))->first();

            }
            
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

    public function store(Request $request){
        $trip = new Trip;
        $trip->departure_city_id = $request->input('departure_city_id');
        $trip->arrival_city_id = $request->input('arrival_city_id');
        $trip->available_seats = $request->input('available_seats');
        $trip->behind_available_seats = $request->input('behind_available_seats');
        $trip->car_plate = $request->input('car_plate');
        $trip->trip_duration = $request->input('trip_duration');
        $trip->driver_id = $request->input('driver_id');
        $trip->departure_date = $request->input('departure_date');
        $trip->departure_time = $request->input('departure_time');
        $trip->pickup_point = $request->input('pickup_point');
        $trip->dropoff_point = $request->input('dropoff_point');
        $trip->price_per_seat = str_replace(".", "", $request->input('price_per_seat'));
        $trip->smoking_allowed = $request->input('smoking_allowed');
        $trip->pets_allowed = $request->input('pets_allowed');
        $trip->car_brand = $request->input('car_brand');
        $trip->phone = $request->input('phone');
        $trip->automatic_reservation = $request->input('automatic_reservation');
        $trip->details = $request->input('details');
        $trip->car_color = $request->input('car_color');

        $trip->save();

        return response()->json([
            'message' => "Viaje creado correctamente",
            'icon' => 'success'
        ],201);


        
    }

    public function history(){
        $sessionUserId = Auth()->user()->id;

        $trips = Trip::with(['departureCity','arrivalCity','driver'])
            ->orWhere('driver_id', $sessionUserId)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $trips->map(function($trip){
            $trip->is_driver = true;
            return $trip;

        });
        
        $reservations = User::find($sessionUserId)->reservations;

        $tripIds = $reservations->pluck('trip_id')->unique()->toArray();

        $trips2 = Trip::with(['departureCity','arrivalCity','driver'])
            ->whereIn('id', $tripIds)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $trips2->map(function($trip){
            $trip->is_driver = false; //cuando es pasajero
            return $trip; 
        });
        
        $allTripIds = $trips->pluck('id')->concat($trips2->pluck('id'))->toArray(); //id de cuando es conductor y cuando es pasajero

        $reservationsForTrips = Reservation::whereIn('trip_id', $allTripIds)->get();

        $passengerCountPerTrip = $reservationsForTrips->groupBy('trip_id')->map->count();
        
        $trips->each(function($trip) use($passengerCountPerTrip){
            $trip->passenger_count = $passengerCountPerTrip->get($trip->id, 0);

        });

        $trips = $trips->concat($trips2)->sortByDesc('departure_date');

        $date = date('Y-m-d');

        return view('history', compact('trips','date'));
    }

    public function passengers($id){
        $sessionUserId = Auth()->user()->id;

        $trip = Trip::with(['departureCity','arrivalCity','driver'])
            ->orWhere('id', $id)
            ->get();
        
        $reservationsForTrips = Reservation::where('trip_id', $id)->with('passenger')->get();

        $passengerDataPerTrip = $reservationsForTrips->groupBy('trip_id')->map(function($reservations){
            return[
                'passenger_count' => $reservations->count(),
                'passengers' => $reservations->map(function($reservation){
                     return[

                        'passenger' => $reservation->passenger,
                        'seats' => $reservation->seats,
                        'comment' => $reservation->comment,
                        'confirmed' => $reservation->confirmed,
                        'phone' => $reservation->phone,
                        'reservationId' => $reservation->id

                    ];
                })
            ];
        });

        $trip->each(function($item)use($passengerDataPerTrip){
            $tripData = $passengerDataPerTrip->get($item->id,['passenger_count' => 0, 'passengers'=>[]]);
            $item->passenger_count = $tripData['passenger_count'];
            $item->passengers = $tripData['passengers'];
        });


        
        
        $date = $trip[0]->departure_date;
        $from = $trip[0]->departureCity->name;
        $to = $trip[0]->arrivalCity->name;

        return view('passengers', compact('trip','date','from','to'));

    }

    public function cancelTrip(Request $request){
        $idTrip = $request->input("id");
        Trip::where('id',$idTrip)
        ->update([
            'active' => 0
        ]);

        $reservations = Reservation::where('trip_id', $idTrip)->with('passenger')->get();

        $emails = $reservations->pluck('passenger.email')->toArray();

        Reservation::where('trip_id', $idTrip)->delete();
        return response()->json([
            'error' => false,
            'message' => "Viaje cancelado con éxito",
            'icon' => "success",
            
    ],200);
    }

//alerta de 5 minutos antes
    public function checkUpcomingTrips() {
    $userId = auth()->id();
    $now = now();
    $inFive = now()->addMinutes(5);

    $trips = Trip::where('user_id', $userId)
                ->orWhereHas('passengers', fn($q) => $q->where('user_id', $userId))
                ->whereBetween('start_time', [$now, $inFive])
                ->get(['id','start_time']);

   
    }

}
