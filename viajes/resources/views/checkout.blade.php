@include('header')

<div class="container checkout-container">
    <div class="checkout-box">

        {{-- Logo Webpay centrado --}}
        <div class="logo-container">
            <img src="/img/logo_webpay.png" alt="Webpay" class="webpay-logo">
        </div>

        {{-- Título --}}
        <h1 class="title has-text-centered mt-4">Confirmar Reserva</h1>
        <p class="has-text-centered">Revisa los datos antes de confirmar.</p>

        <hr class="my-4">

        {{-- Información del viaje --}}
        <div class="trip-info">
            <p><strong>Origen:</strong> {{ $trip->departureCity->name }}</p>
            <p><strong>Destino:</strong> {{ $trip->arrivalCity->name }}</p>
            <p><strong>Asientos solicitados:</strong> {{ $seats }}</p>
            <p><strong>Valor asiento(s):</strong> ${{ number_format($trip->price_per_seat, 0, ',', '.') }}</p>
        </div>

        <hr class="my-4">

        {{-- Campo para número de tarjeta --}}
        <div class="field">
            <label class="label">Número de Tarjeta</label>
            <div class="control has-icons-left">
                <input class="input card-input" type="text" placeholder="0000 0000 0000 0000">
                <span class="icon is-small is-left">
                    <i class="fas fa-credit-card"></i>
                </span>
            </div>
        </div>

        {{-- Formulario oculto para enviar datos --}}
        <form id="confirmForm">
            @csrf
            <input type="hidden" name="trip_id" value="{{ $trip->id }}">
            <input type="hidden" name="passenger_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="seats" value="{{ $seats }}">
            <input type="hidden" name="phone" value="{{ $phone }}">
            <input type="hidden" name="comment" value="{{ $comment }}">
        </form>

        {{-- Botón de confirmación --}}
        <button class="button is-success is-fullwidth confirm-btn" onclick="confirmReservation()">
            Confirmar
        </button>

    </div>
</div>

@include('footer-content')
@include('footer')

{{-- Estilos --}}
<style>
.checkout-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
}

.checkout-box {
    background: #ffffff;
    padding: 2.5rem;
    border-radius: 18px;
    max-width: 420px;
    width: 100%;
    color: #000;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.4);
    position: relative;
}

.logo-container {
    width: 100%;
    margin-bottom: 20px;
    text-align: center;
}

.webpay-logo {
    width: 140px;
    max-width: 100%;
    height: auto;
}

.trip-info p {
    font-size: 1.1rem;
}

.card-input {
    background: #fafafa;
    border: 1px solid #ccc;
}

.confirm-btn {
    background: linear-gradient(90deg, #FFD700, #FF43A0);
    border: none;
    font-weight: bold;
    color: #000;
    padding: 12px;
    border-radius: 10px;
}

.confirm-btn:hover {
    opacity: 0.9;
}
</style>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmReservation() {
    let form = document.getElementById("confirmForm");
    let formData = new FormData(form);

    fetch("/api/ajax/reservations", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {

        if (data.error) {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data.message || "No se pudo procesar la reserva.",
                confirmButtonColor: "#d33"
            });
            return;
        }

        // Confirmación exitosa
        Swal.fire({
            icon: "success",
            title: "¡Reserva confirmada!",
            text: data.message || "Tu reserva ha sido procesada correctamente.",
            confirmButtonColor: "#28a745"
        }).then(() => {
            // Abrir y descargar automáticamente el PDF
            let tripId = form.querySelector('input[name="trip_id"]').value;
            let passengerId = form.querySelector('input[name="passenger_id"]').value;

            // Abrir PDF en nueva pestaña para descargar
            window.open(`/reservation-pdf/${tripId}/${passengerId}`, '_blank');

            // Redirigir a historial de reservas después de un corto delay
            setTimeout(() => {
                window.location.href = "/history";
            }, 500);
        });

    })
    .catch(() => {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ocurrió un error procesando la reserva.",
            confirmButtonColor: "#d33"
        });
    });
}
</script>
