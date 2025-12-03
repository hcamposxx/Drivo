<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reserva</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }

        .container {
            background: #ffffff;
            max-width: 700px;
            margin: 30px auto;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.15);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h2 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #555;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .section p {
            font-size: 15px;
            margin: 4px 0;
        }

        .important {
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Confirmación de Reserva</h1>

        <div class="section">
            <h2>Datos de la reserva</h2>
            <p><span class="important">ID de reserva:</span> {{ $reservation->id }}</p>
            <p><span class="important">Fecha de reserva:</span> {{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y H:i') }}</p>
            <p><span class="important">Asientos solicitados:</span> {{ $seats }}</p>
            <p><span class="important">Valor total:</span> ${{ number_format($trip->price_per_seat * $seats, 0, ',', '.') }}</p>
        </div>

        <div class="section">
            <h2>Datos del viaje</h2>
            <p><span class="important">Origen:</span> {{ $trip->departureCity->name }}</p>
            <p><span class="important">Destino:</span> {{ $trip->arrivalCity->name }}</p>
            <!--<p><span class="important">Lugar de recogida:</span> {{ $reservation->pickup_location ?? 'No indicado' }}</p>
            <p><span class="important">Lugar de llegada:</span> {{ $reservation->dropoff_location ?? 'No indicado' }}</p>-->
        </div>

        <div class="section">
            <h2>Datos del pasajero</h2>
            <p><span class="important">Teléfono:</span> {{ $phone }}</p>
            <p><span class="important">Comentario:</span> {{ $reservation->comment ?? 'Ninguno' }}</p>
        </div>

        <div class="footer">
            Gracias por usar nuestro servicio. <br>
            ¡Te deseamos un buen viaje!
        </div>
    </div>
</body>
</html>
