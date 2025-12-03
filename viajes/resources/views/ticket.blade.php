<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket de viaje</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .box { border: 1px solid #ccc; padding: 10px; border-radius: 6px; }
    </style>
</head>
<body>
    <h2>Confirmación de Reserva - Drivo</h2>
    <div class="box">
        <p><strong>Pasajero:</strong> {{ $passenger->name }}</p>
        <p><strong>Origen:</strong> {{ $trip->departureCity->name }}</p>
        <p><strong>Destino:</strong> {{ $trip->arrivalCity->name }}</p>
        <p><strong>Fecha de salida:</strong> {{ $trip->departure_date }}</p>
        <p><strong>Hora:</strong> {{ $trip->departure_time }}</p>
        <p><strong>Asientos reservados:</strong> {{ $seats }}</p>
        <p><strong>Precio total:</strong> ${{ number_format($trip->price_per_seat * $seats, 0, ',', '.') }}</p>
    </div>
</body>
</html>
