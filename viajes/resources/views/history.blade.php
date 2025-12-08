@php
use Carbon\Carbon;
@endphp

@include('header')

<div class="form-background">
    <div class="form-overlay">
        <div class="container content has-text-centered">

            <h1 class="title my-3" style="color: white; font-weight: 600;">Historial de viajes</h1>

            @php $totalTrips = count($trips); @endphp

            @if($totalTrips == 0)
                <div class="notification is-warning">
                    <p>Aún no hay viajes</p>
                    <p>Publica tu primer viaje o busca un asiento</p>
                </div>
            @else
                <div class="columns is-multiline">
                    @foreach($trips as $info)
                        @php
                            $horaInicio = Carbon::parse($info->departure_date.' '.$info->departure_time);
                            $horaActual = Carbon::now();
                            $horasDiferencia = $horaInicio->diffInHours($horaActual);
                            $fechaViaje = Carbon::parse($info->departure_date.' '.$info->departure_time);
                            $viajeFinalizado = $fechaViaje->lessThan($horaActual);
                        @endphp

                        <div class="column is-full">
                            <div class="card trip-card my-3">
                                <div class="card-content">

                                    <div class="media">
                                        <div class="media-left">
                                            <figure class="image is-48x48">
                                                <img src="{{ optional($info->driver)->photo ? $info->driver->photo : asset('img/auto.png') }}" alt="Driver photo">
                                            </figure>
                                        </div>
                                        <div class="media-content columns">
                                            <div class="column">
                                                <p class="title is-4 has-text-white">{{ $info->driver->name }}</p>
                                                <p class="subtitle is-6 has-text-white">
                                                    Rol: {{ $info->is_driver ? 'Conductor' : 'Pasajero' }}
                                                </p>
                                                <p class="subtitle is-6 has-text-white">
                                                    <span class="icon">
                                                        <i class="fas fa-car"></i>
                                                    </span>
                                                    {{ $info->car_brand }} | {{ $info->car_color }} | {{ $info->car_plate }}
                                                </p>
                                            </div>
                                            <div class="column">
                                                <p class="subtitle is-6 has-text-white">
                                                    <span class="icon">
                                                        <i class="fas fa-location"></i>
                                                    </span>
                                                    {{ $info->departureCity->name }} → {{ $info->arrivalCity->name }}
                                                </p>
                                                <p class="subtitle is-6 has-text-white">
                                                    <span class="icon">
                                                        <i class="fas fa-calendar"></i>
                                                    </span>
                                                    {{ $fechaViaje->format('d/m/Y') }}                 
                                                </p>
                                                <p class="subtitle is-6 has-text-white">
                                                    <span class="icon">
                                                        <i class="fas fa-clock"></i>
                                                    </span>
                                                    {{ substr($info->departure_time,0,5) }} →
                                                    @php
                                                        $horaOriginal = new DateTime($info->departure_time);
                                                        $duracion = new DateInterval("PT".intval(substr($info->trip_duration,0,2))."H".intval(substr($info->trip_duration,3,2))."M");
                                                        $horaLlegada = $horaOriginal->add($duracion);
                                                    @endphp
                                                    {{ substr($horaLlegada->format('H:i:s'),0,5) }} 
                                                    ({{ intval(substr($info->trip_duration,0,2))."h ".intval(substr($info->trip_duration,3,2))."m" }})
                                                </p>
                                                <p class="subtitle is-6 has-text-white">
                                                    <span class="icon">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </span>
                                                    ${{ number_format($info->price_per_seat,0,',','.') }} CLP P/p
                                                </p>

                                                <!-- Estado del viaje con badge -->
                                                <p class="subtitle is-6">
                                                    @if($info->active == 0)
                                                        <span class="status-badge canceled">Viaje cancelado</span>
                                                    @elseif($viajeFinalizado)
                                                        <span class="status-badge finished">Viaje finalizado</span>
                                                    @endif
                                                </p>

                                                <!-- Botón de cancelar viaje -->
                                                @if ($info->is_driver && $info->active && $fechaViaje->greaterThan($horaActual))
                                                    <button onclick="cancelTrip({{ $info->id }}, '{{ $info->departureCity->name }}', '{{ $info->arrivalCity->name }}')" class="button is-danger is-fullwidth is-medium mt-2">
                                                        Cancelar viaje (Faltan {{ $horaActual->diffInHours($fechaViaje) }} horas)
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Comentarios -->
                                    <div class="content mt-3">
                                        <strong class="has-text-white">Comentarios del conductor: </strong>
                                        <span class="has-text-white">{{ $info->details }}</span>
                                    </div>

                                    <!-- Mensajes de pasajeros -->
                                    @if($info->is_driver && isset($info->messages) && $info->messages->count() > 0)
                                        <div class="content mt-4">
                                            <strong class="has-text-white">
                                                <span class="icon">
                                                    <i class="fas fa-envelope"></i>
                                                </span>
                                                Mensajes de pasajeros ({{ $info->messages->count() }})
                                            </strong>
                                            
                                            <div class="messages-container mt-3">
                                                @foreach($info->messages as $message)
                                                    <div class="message-card mb-3">
                                                        <div class="message-header">
                                                            <div class="message-user">
                                                                <figure class="image is-24x24" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                                                                    <img src="{{ $message->user->photo ?? asset('img/auto.png') }}" 
                                                                         alt="User photo" 
                                                                         style="border-radius: 50%;">
                                                                </figure>
                                                                <strong>{{ $message->user->name }}</strong>
                                                            </div>
                                                            <span class="message-date">
                                                                {{ \Carbon\Carbon::parse($message->created_at)->format('d/m/Y H:i') }}
                                                            </span>
                                                        </div>
                                                        
                                                        <!-- Mensaje original -->
                                                        <div class="message-body">
                                                            <strong style="color: #ffd700;">Mensaje:</strong><br>
                                                            {{ $message->message }}
                                                        </div>
                                                        
                                                        @if(!$message->is_read)
                                                            <span class="tag is-warning is-light is-small mt-2">Nuevo</span>
                                                        @endif

                                                        <!-- Respuesta del conductor -->
                                                        @if($message->response)
                                                            <div class="response-box mt-3">
                                                                <strong style="color: #ff00eaff;">Tu respuesta:</strong>
                                                                <span class="response-date">
                                                                    {{ \Carbon\Carbon::parse($message->response_date)->format('d/m/Y H:i') }}
                                                                </span>
                                                                <div class="response-text">
                                                                    {{ $message->response }}
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Botón para responder -->
                                                            <button 
                                                                class="button is-small is-info mt-3" 
                                                                onclick="openReplyModal({{ $message->id }}, '{{ $message->user->name }}', '{{ addslashes($message->message) }}')"
                                                                style="border-radius: 20px;">
                                                                <span class="icon">
                                                                    <i class="fas fa-reply"></i>
                                                                </span>
                                                                <span>Responder</span>
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <footer class="card-footer">
                                        @if(auth()->user()->id == $info->driver->id)
                                            <button onclick="window.location.href='/history/{{ $info->id }}'" class="button is-warning is-fullwidth is-medium card-footer-item mt-2">
                                                {{ $info->passenger_count }} pasajeros - ver
                                            </button>
                                        @endif
                                    </footer>

                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Modal de Respuesta -->
<div id="replyModal" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Responder mensaje</p>
      <button class="delete" aria-label="close" onclick="closeReplyModal()"></button>
    </header>
    <section class="modal-card-body">
      <div class="field">
        <label class="label">Pasajero</label>
        <div class="control">
          <input class="input" type="text" id="passengerName" readonly>
        </div>
      </div>
      <div class="field">
        <label class="label">Mensaje recibido</label>
        <div class="control">
          <textarea class="textarea" id="originalMessage" readonly rows="3"></textarea>
        </div>
      </div>
      <div class="field">
        <label class="label">Tu respuesta</label>
        <div class="control">
          <textarea class="textarea" id="responseText" placeholder="Escribe tu respuesta aquí..." rows="4"></textarea>
        </div>
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success" onclick="sendReply()">Enviar respuesta</button>
      <button class="button" onclick="closeReplyModal()">Cancelar</button>
    </footer>
  </div>
</div>

@include('footer-content')
@include('footer')

<!-- Botón flotante para volver arriba -->
<button id="btn-scroll-top" class="button is-rounded" title="Volver arriba">
  <i class="fa fa-arrow-up"></i>
</button>

<style>
/* Fondo y overlay */
.form-background {
    position: relative;
    background: url('/img/fondo.jpg') center/cover no-repeat;
    min-height: 100vh;
    padding: 50px 0;
}

.form-overlay {
    background-color: rgba(0,0,0,0.7);
    border-radius: 15px;
    padding: 2rem;
    width: 90%;
    max-width: 1000px;
    margin: 0 auto;
    box-shadow: 0 0 20px rgba(0,0,0,0.4);
}

/* Tarjetas de viaje */
.trip-card {
    background-color: rgba(255,255,255,0.15);
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

.trip-card .card-footer-item {
    margin: 5px 0;
}

/* Texto blanco */
.has-text-white {
    color: white !important;
}

/* Iconos dorados */
.icon i {
    color: #FFD700 !important;
}

/* Badges para estado del viaje */
.status-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 8px;
    font-size: 0.9em;
    font-weight: bold;
}

.status-badge.canceled {
    background-color: black;
    color: red;
}

.status-badge.finished {
    background-color: black;
    color: white;
}

/* Botones con borde redondeado y margen */
.button {
    border-radius: 50px;
    margin-top: 5px;
}

/* Botón flotante */
#btn-scroll-top {
  position: fixed;
  bottom: 40px;
  right: 30px;
  display: none;
  z-index: 999;
  background-color: #f1ce04ff;
  color: white;
  border: none;
  box-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
  transition: transform 0.2s, background-color 0.3s;
}

#btn-scroll-top:hover {
  background-color: #ff00eaff;
  transform: scale(1.1);
}

/* Contenedor de mensajes */
.messages-container {
    max-height: 400px;
    overflow-y: auto;
    padding: 10px;
    background-color: rgba(0, 0, 0, 0.3);
    border-radius: 8px;
}

.message-card {
    background-color: rgba(255, 255, 255, 0.1);
    border-left: 4px solid #ffd700;
    border-radius: 8px;
    padding: 12px;
    transition: transform 0.2s;
}

.message-card:hover {
    transform: translateX(5px);
    background-color: rgba(255, 255, 255, 0.15);
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    padding-bottom: 8px;
    border-bottom: 1px solid rgba(255, 215, 0, 0.3);
}

.message-user {
    color: #ffd700;
    font-size: 0.95rem;
}

.message-date {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.85rem;
}

.message-body {
    color: white;
    line-height: 1.5;
    font-size: 0.95rem;
}

.messages-container::-webkit-scrollbar {
    width: 8px;
}

.messages-container::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.2);
    border-radius: 10px;
}

.messages-container::-webkit-scrollbar-thumb {
    background: #ffd700;
    border-radius: 10px;
}

.messages-container::-webkit-scrollbar-thumb:hover {
    background: #ff00eaff;
}

/* Estilos para respuestas */
.response-box {
    background-color: rgba(255, 0, 234, 0.1);
    border-left: 4px solid #ff00eaff;
    padding: 10px;
    border-radius: 8px;
}

.response-date {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.85rem;
    float: right;
}

.response-text {
    color: white;
    margin-top: 8px;
    line-height: 1.5;
}

/* Modal styles */
.modal-card {
    max-width: 500px;
}

.modal-card-head {
    background-color: #ffd700;
}

.modal-card-title {
    color: #000;
    font-weight: 600;
}

.modal-card-foot {
    justify-content: flex-end;
}
</style>

<script>
// Función para cancelar viaje
function cancelTrip(id, from, to){
    Swal.fire({
        title: "Confirmar",
        text: "Quieres cancelar el viaje "+from+" > "+to+"?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, cancelar viaje"
    }).then((result)=>{
        if(result.isConfirmed){
            let token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: "{{ route('cancelTrip') }}",
                type: "POST",
                dataType: "json",
                data:{
                    '_token':token,
                    'id':id,
                },
                success: function (respuesta) {
                    if(respuesta.error){
                        Swal.fire({
                            position:'center-center',
                            title: respuesta.message,
                            icon: 'error',
                            showConfirmButton: true,
                            timer: 3500
                        });
                    }else{
                        Swal.fire({
                            position:'center-center',
                            title: respuesta.message,
                            icon: 'success',
                            showConfirmButton: true,
                            timer: 3500
                        }).then((result)=>{
                            if(result.isConfirmed || result.dismiss == Swal.DismissReason.timer){
                                location.reload();
                            }
                        });
                    }
                },
                error: function (err) {
                    console.error("error", err);
                }
            });
        }
    })
}

// Funciones del modal de respuesta
let currentMessageId = null;

function openReplyModal(messageId, userName, originalMsg) {
  currentMessageId = messageId;
  document.getElementById('passengerName').value = userName;
  document.getElementById('originalMessage').value = originalMsg;
  document.getElementById('responseText').value = '';
  document.getElementById('replyModal').classList.add('is-active');
}

function closeReplyModal() {
  document.getElementById('replyModal').classList.remove('is-active');
  currentMessageId = null;
}

function sendReply() {
  const response = document.getElementById('responseText').value.trim();
  
  if (!response) {
    Swal.fire({
      icon: 'warning',
      title: 'Respuesta vacía',
      text: 'Por favor escribe una respuesta',
      timer: 2000
    });
    return;
  }

  let token = $('meta[name="csrf-token"]').attr('content');
  
  $.ajax({
    url: "{{ route('replyMessage') }}",
    type: "POST",
    dataType: "json",
    data: {
      '_token': token,
      'message_id': currentMessageId,
      'response': response
    },
    success: function(resp) {
      if (resp.error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: resp.message,
          timer: 3000
        });
      } else {
        Swal.fire({
          icon: 'success',
          title: '¡Respuesta enviada!',
          text: resp.message,
          timer: 2500
        }).then(() => {
          closeReplyModal();
          location.reload();
        });
      }
    },
    error: function(err) {
      console.error("Error:", err);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudo enviar la respuesta',
        timer: 3000
      });
    }
  });
}

// Botón scroll top
window.addEventListener("scroll", function() {
    const btn = document.getElementById("btn-scroll-top");
    if (window.scrollY > 300) {
        btn.style.display = "flex";
    } else {
        btn.style.display = "none";
    }
});

document.getElementById("btn-scroll-top").addEventListener("click", function() {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});

// Cerrar modal al hacer clic en el fondo
document.addEventListener('DOMContentLoaded', function() {
  const modalBg = document.querySelector('#replyModal .modal-background');
  if (modalBg) {
    modalBg.addEventListener('click', closeReplyModal);
  }
});
</script>