<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TripMessage;

class TripController extends Controller
{
    //el error de los viajes puede estar aqui revisar
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

        $trips = Trip::with(['departureCity','arrivalCity','driver','messages.user'])
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

        $trips2 = Trip::with(['departureCity','arrivalCity','driver','messages.user'])
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


    /**
 * Enviar mensaje a un conductor
 */
public function sendMessage(Request $request)
{
    try {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'message' => 'required|string|max:1000'
        ]);

        $trip = Trip::findOrFail($request->trip_id);
        
        if ($trip->user_id == auth()->id()) {
            return response()->json([
                'error' => true,
                'message' => 'No puedes enviarte mensajes a ti mismo'
            ]);
        }

        $message = TripMessage::create([
            'trip_id' => $request->trip_id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'is_read' => false
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Mensaje enviado correctamente',
            'data' => $message
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => 'Error al enviar el mensaje: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Obtener mensajes de un viaje
 */
public function getTripMessages($tripId)
{
    try {
        $trip = Trip::findOrFail($tripId);
        
        if ($trip->user_id != auth()->id()) {
            return response()->json([
                'error' => true,
                'message' => 'No tienes permiso para ver estos mensajes'
            ], 403);
        }

        $messages = TripMessage::with('user')
            ->forTrip($tripId)
            ->orderBy('created_at', 'desc')
            ->get();

        TripMessage::forTrip($tripId)
            ->unread()
            ->update(['is_read' => true]);

        return response()->json([
            'error' => false,
            'messages' => $messages
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => 'Error al obtener mensajes: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Contar mensajes no leídos
 */
public function getUnreadMessagesCount()
{
    $count = TripMessage::whereHas('trip', function($query) {
        $query->where('user_id', auth()->id());
    })
    ->unread()
    ->count();

    return response()->json([
        'error' => false,
        'count' => $count
    ]);
}

/**
 * Responder un mensaje (para conductores)
 */
public function replyMessage(Request $request)
{
    try {
        $request->validate([
            'message_id' => 'required|exists:trip_messages,id',
            'response' => 'required|string|max:1000'
        ]);

        $message = TripMessage::with('trip')->findOrFail($request->message_id);
        
        if ($message->trip->driver_id != auth()->id()) {
            return response()->json([
                'error' => true,
                'message' => 'No tienes permiso para responder este mensaje'
            ], 403);
        }

        $message->update([
            'response' => $request->response,
            'response_date' => now(),
            'response_read' => false
        ]);

        return response()->json([
            'error' => false,
            'message' => 'Respuesta enviada correctamente',
            'data' => $message
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => 'Error al enviar la respuesta: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Obtener mensajes del usuario (como pasajero)
 */
public function getMyMessages()
{
    try {
        $messages = TripMessage::with(['trip.departureCity', 'trip.arrivalCity', 'trip.driver'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        TripMessage::where('user_id', auth()->id())
            ->whereNotNull('response')
            ->where('response_read', false)
            ->update(['response_read' => true]);

        return response()->json([
            'error' => false,
            'messages' => $messages
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => true,
            'message' => 'Error al obtener mensajes: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Contar respuestas no leídas (para pasajeros)
 */
public function getUnreadResponsesCount()
{
    $count = TripMessage::where('user_id', auth()->id())
        ->whereNotNull('response')
        ->where('response_read', false)
        ->count();

    return response()->json([
        'error' => false,
        'count' => $count
    ]);
}

}
