<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Reserva - Drivo</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            background: #ffffff;
            max-width: 800px;
            margin: 40px auto;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
        }

        .logo {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .logo span {
            color: #3498db;
        }

        .subtitle {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .title-container {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .main-title {
            display: inline-block;
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 28px;
            padding-bottom: 10px;
            border-bottom: 2px solid #3498db;
        }
        
        .status-container {
            margin-top: 5px;
            text-align: center;
        }
        
        .status-badge {
            display: inline-block;
            background-color: #27ae60;
            color: white;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .section {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #f9fbfd;
            border-radius: 10px;
            border-left: 4px solid #3498db;
        }

        .section h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #2c3e50;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }

        .info-item {
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px dotted #e0e0e0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: 600;
            color: #2c3e50;
            display: inline-block;
            min-width: 180px;
        }

        .value {
            color: #34495e;
        }

        .price-box {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin: 25px 0;
        }

        .price-label {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .price-value {
            font-size: 32px;
            font-weight: 700;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #7f8c8d;
            border-top: 1px solid #eee;
            padding-top: 25px;
            line-height: 1.6;
        }

        .footer-logo {
            font-weight: 700;
            color: #2c3e50;
            font-size: 18px;
        }

        .no-data {
            color: #e74c3c;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">DR<span>IVO</span></div>
            <div class="subtitle">Transporte confiable y seguro</div>
        </div>

        <!-- TÍTULO CON TAG CENTRADO DEBAJO -->
        <div class="title-container">
            <div class="main-title">Confirmación de Reserva</div>
            <div class="status-container">
                <span class="status-badge">{{ $reservation->confirmed ? 'Confirmada' : 'Pendiente' }}</span>
            </div>
        </div>

        <div class="section">
            <h2>Detalles de la Reserva</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Fecha de Reserva:</span>
                    <span class="value">{{ \Carbon\Carbon::parse($reservation->created_at)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Asientos Reservados:</span>
                    <span class="value">{{ $seats }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Información del Viaje</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Origen:</span>
                    <span class="value">{{ $trip->departureCity->name }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Destino:</span>
                    <span class="value">{{ $trip->arrivalCity->name }}</span>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Datos del Pasajero</h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Nombre:</span>
                    <span class="value">
                        @if(!empty($passengerName))
                            {{ $passengerName }}
                        @else
                            <span class="no-data">No disponible</span>
                        @endif
                    </span>
                </div>
                
                <div class="info-item">
                    <span class="label">Teléfono:</span>
                    <span class="value">
                        @if(!empty($phone))
                            {{ $phone }}
                        @else
                            <span class="no-data">No proporcionado</span>
                        @endif
                    </span>
                </div>
                
                <div class="info-item">
                    <span class="label">Correo Electrónico:</span>
                    <span class="value">
                        @if(!empty($email))
                            {{ $email }}
                        @else
                            <span class="no-data">No disponible</span>
                        @endif
                    </span>
                </div>
                
                @if(!empty($reservation->comment))
                <div class="info-item">
                    <span class="label">Comentarios:</span>
                    <span class="value">{{ $reservation->comment }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="price-box">
            <div class="price-label">VALOR TOTAL A PAGAR</div>
            <div class="price-value">${{ number_format($trip->price_per_seat * $seats, 0, ',', '.') }}</div>
            <div style="font-size: 12px; margin-top: 10px; opacity: 0.9;">
                ({{ $seats }} asiento{{ $seats > 1 ? 's' : '' }} × ${{ number_format($trip->price_per_seat, 0, ',', '.') }} cada uno)
            </div>
        </div>

        <div class="footer">
            <div class="footer-logo">DRIVO</div>
            <div>Gracias por confiar en nuestro servicio de transporte.</div>
            <div style="font-size: 12px; color: #7f8c8d; margin-top: 5px;">
                Para consultas: contacto@drivo.com | Tel: +1 234 567 890
            </div>
            <div style="margin-top: 15px; font-style: italic;">
                ¡Te deseamos un excelente viaje!
            </div>
            <div style="font-size: 11px; margin-top: 20px; color: #95a5a6;">
                Documento generado automáticamente el {{ date('d/m/Y H:i') }}
            </div>
        </div>
    </div>
</body>
</html>