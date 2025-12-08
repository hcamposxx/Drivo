<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Importar DomPDF

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        try {
            $passenger = User::find($request->get('passenger_id'));

            if(!$passenger){
                return response()->json(["error"=>true,'message'=>'Su sesión ha caducado, intente nuevamente']);
            }

            $trip = Trip::with(['departureCity','arrivalCity','driver'])
                        ->find($request->get('trip_id'));

            if(!$trip || $trip->active != 1){
                return response()->json(["error"=>true,'message'=>'El viaje ya no esta disponible']);
            }

            $occupiedSeats = Reservation::where('trip_id',$trip->id)->sum('seats');

            if(($trip->available_seats - $occupiedSeats) == 0){
                return response()->json(["error"=>true,'message'=>'Ya no hay asientos disponibles en este viaje']);
            }

            if(($trip->available_seats - $occupiedSeats) < $request->get('seats')){
                return response()->json(["error"=>true,'message'=>'Ahora solo quedan '.($trip->available_seats - $occupiedSeats).' asientos disponibles']);
            }

            // Crear reserva
            $reservation = Reservation::create([
                'trip_id'=> $trip->id,
                'passenger_id'=> $passenger->id,
                'seats'=> $request->get('seats'),
                'phone'=> $request->get('phone'),
                'comment'=> $request->get('comment'),
                'confirmed'=> $trip->automatic_reservation ? 1 : 0
            ]);

            return response()->json([
                "error" => false,
                "message" => $trip->automatic_reservation ? 
                    'Reserva confirmada con '.$request->get('seats').' asientos' : 
                    'Debe esperar la confirmación del conductor',
                "reservation_id" => $reservation->id
            ]);

        } catch(Exception $ex) {
            return response()->json(["error"=>true,'message'=>'Intente nuevamente']);
        }
    }

    /**
     * Generar PDF de la reserva
     */
     public function generatePdf($id)
    {
        $reservation = Reservation::with(['trip.departureCity','trip.arrivalCity','passenger'])->findOrFail($id);
        $trip = $reservation->trip;
        $seats = $reservation->seats;
        
        // Obtener datos del pasajero
        $phone = $reservation->phone;
        $passengerName = optional($reservation->passenger)->name;
        $email = optional($reservation->passenger)->email;
        
        // Pasar TODAS las variables necesarias a la vista
        $pdf = Pdf::loadView('pdf', [
            'reservation' => $reservation,
            'trip' => $trip,
            'seats' => $seats,
            'phone' => $phone,
            'passengerName' => $passengerName,
            'email' => $email
        ]);

        return $pdf->download('reserva_'.$reservation->id.'.pdf');
    }

    /**
     * Método alternativo para PDF (también corregido)
     */
    public function pdf($tripId, $userId)
    {
        $trip = Trip::with(['departureCity','arrivalCity'])->findOrFail($tripId);
        $reservation = Reservation::with('passenger')
            ->where('trip_id', $tripId)
            ->where('passenger_id', $userId)
            ->firstOrFail();
        
        $seats = $reservation->seats;
        $phone = $reservation->phone;
        $passengerName = optional($reservation->passenger)->name;
        $email = optional($reservation->passenger)->email;
        
        // Pasar TODAS las variables
        $pdf = Pdf::loadView('pdf', [
            'reservation' => $reservation,
            'trip' => $trip,
            'seats' => $seats,
            'phone' => $phone,
            'passengerName' => $passengerName,
            'email' => $email
        ]);
        
        return $pdf->download('reserva_'.$tripId.'.pdf');
    }
}
