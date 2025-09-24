<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $passenger = User::find($request->get('passenger_id'));

            if($passenger){
                $idTrip = $request->get('trip_id');
                $trip = Trip::with(['departureCity','arrivalCity','driver'])
                ->find($idTrip);

                if($trip && $trip->active == 1){
                    $occupiedSeats = Reservation::where('trip_id',$idTrip)->sum('seats');

                    if(($trip->available_seats - $occupiedSeats) == 0){
                        return response()->json(["error"=>true,'message'=>'Ya no hay asientos disponibles en este viaje']);
                    }elseif (($trip->available_seats - $occupiedSeats) >= $request->get('seats')){
                        Reservation::create([
                            'trip_id'=> $request->get('trip_id'),
                            'passenger_id'=> $request->get('passenger_id'),
                            'seats'=> $request->get('seats'),
                            'phone'=> $request->get('phone'),
                            'comment'=> $request->get('comment'),
                            'confirmed'=> $trip->automatic_reservation ? 1:0

                        ]);
                        return response()->json(["error"=>false,'message'=> $trip->automatic_reservation ? 'Reserva confirmada con '.$request->get('seats').' asientos':'Debe esperar la confirmación del conductor']);

                    }else{
                        return response()->json(["error"=>false,'message'=>'Ahora solo quedan '.$trip->available_seats - $occupiedSeats.' asientos disponibles']);
                    }
                }else{
                    return response()->json(["error"=>true,'message'=>'El viaje ya no esta disponible']);
                    }
            }else{
                    return response()->json(["error"=>true,'message'=>'Su sesión ha caducado, intente nuevamente']);
                    }

        }catch(Exception $ex){
            return response()->json(["error"=>true,'message'=>'Intente nuevamente']);
                    
        } 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
