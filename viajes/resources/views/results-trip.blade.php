@include('header')
@include('hero')

<div class="container py-6">

    <!-- Formulario de búsqueda -->
    <div class="card px-2 py-2 columns is-mobile is-centered translucent-card">
        <form method="post" action="{{ route('searchTrip') }}" class="field is-grouped">
            @csrf
            <input type="hidden" name="verified" value="-1">
            <input type="hidden" name="sort" value="departure_time">

            <!-- Origen -->
            <div class="control">
                <span class="icon"><i class="fas fa-location"></i></span>
                <select required style="width: 200px" name="origen" id="origen">
                    <option value="{{ $from }}" selected>{{ $from }}</option>
                </select>
            </div>

            <!-- Destino -->
            <div class="control">
                <span class="icon"><i class="fas fa-location"></i></span>
                <select required style="width: 200px" name="destino" id="destino">
                    <option value="{{ $to }}" selected>{{ $to }}</option>
                </select>
            </div>

            <!-- Fecha -->
            <div class="control" title="Fecha de salida">
                <input required class="input is-success" type="date" name="fecha" id="fecha" min="{{ date('Y-m-d') }}" value="{{ $date ?? date('Y-m-d') }}">
            </div>

            <!-- Número de asientos -->
            <div class="field" title="Número de asientos">
                <p class="control has-icons-left">
                    <span class="icon"><i class="fas fa-chair"></i></span>
                    <input required class="input is-success" type="number" name="asientos" id="asientos" min="1" max="4" value="{{ $seats ?? 1 }}">
                </p>
            </div>

            <!-- Botón Buscar -->
            <div class="field mx-2">
                <button class="button btn-buscar">Buscar</button>
            </div>
        </form>
    </div>

    <!-- Resultados de viajes -->
    <div class="card px-2 my-5 columns translucent-card">
        @php
            $totalTrips = count($trips);
        @endphp

        <article class="message column {{ ($totalTrips == 0) ? 'is-warning' : 'is-success' }}">
            <div class="message-header">
                <p>{{ $from }} -> {{ $to }} | {{ $totalTrips }} viajes disponibles | Salida: {{ ($date == date('Y-m-d') ? 'Hoy' : '') }} {{ $date }}</p>
            </div>
            <span class="message-body columns is-mobile is-centered">
                @if ($totalTrips == 0)
                    <div class="content">
                        <div class="columns">
                            <div class="py-2 card px-2 translucent-card">
                                <div class="icon-text">
                                    <span class="icon has-text-success"><i class="fas fa-chair"></i></span>
                                    <span> Disponibles </span>
                                    <span class="icon has-text-danger"><i class="fas fa-chair"></i></span>
                                    <span> Ocupados </span>
                                </div>
                            </div>
                        </div>
                        <h2>Aún no hay viajes con asientos libres para esta fecha</h2>
                        <p>{{ $from }} -> {{ $to }}</p>
                        <p>Intente cambiar las fechas</p>
                    </div>
                @else
                    <div class="content">
                        @foreach ($trips as $info)
                            <div class="card my-2 translucent-card" @if($info->available_seats == $info->occupied_seats) style="background-color:#fff4d6" @endif>
                                <div class="card-content">
                                    <div class="media">
                                        <div class="media-left">
                                            <figure class="image is-48x48">
                                                <img src="{{ auth()->user()->photo ? asset(auth()->user()->photo) : asset('img/auto.png') }}" alt="Foto conductor"/>
                                            </figure>
                                        </div>
                                        <div class="media-content columns">
                                            <div class="column">
                                                <p class="title is-4">{{ $info->driver->name }}</p>
                                            </div>
                                            <div class="column">
                                                <p class="subtitle is-6">
                                                    <span class="icon has-text-success"><i class="fas fa-location"></i></span>  
                                                    {{ $from }} -> 
                                                    <span class="icon has-text-success"><i class="fas fa-location"></i></span>
                                                    {{ $to }}
                                                </p>
                                                <p class="subtitle is-6">
                                                    <span class="icon has-text-success"><i class="fas fa-clock"></i></span>  
                                                    {{ substr($info->departure_time,0,5) }} ->
                                                    @php
                                                        $horaOriginal = new DateTime($info->departure_time);
                                                        $duracion = new DateInterval("PT".intval(substr($info->trip_duration,0,2))."H".intval(substr($info->trip_duration,3,2))."M");
                                                        $horaLlegada = $horaOriginal->add($duracion);
                                                    @endphp 
                                                    {{ substr($horaLlegada->format('H:i:s'),0,5) }}
                                                    ({{ intval(substr($info->trip_duration,0,2))."h ".intval(substr($info->trip_duration,3,2))."m" }})
                                                </p>
                                                <p style="font-size:16pt">
                                                    <span class="icon has-text-success"><i class="fas fa-dollar"></i></span>  
                                                    ${{ number_format($info->price_per_seat,0,',','.') }} CLP P/p                 
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="content" style="color:gray;">
                                        <p>Aquí encontrarás más información detallada del viaje y datos que te ayudarán a tomar el que mejor se adapte a tus necesidades</p>
                                        <p><strong>Comentarios del conductor: </strong>{{ $info->details }}</p>
                                    </div>

                                    <footer class="card-footer">
                                        @if(($info->available_seats - $info->occupied_seats) > 0) 
                                            <!-- Botón Detalles y Reserva -->
                                            <button 
                                                onclick="showDetails('{{ $info->id }}','{{ $info->departure_date }}',' {{ substr($info->departure_time,0,5) }} -> {{ substr($horaLlegada->format('H:i:s'),0,5) }} ({{ intval(substr($info->trip_duration,0,2)).'h '.intval(substr($info->trip_duration,3,2)).'m' }})','{{ $info->available_seats - $info->occupied_seats }}','{{ $info->occupied_seats? $info->occupied_seats:0}}','{{ $info->pets_allowed?'SI':'NO' }}','{{ $info->smoking_allowed?'SI':'NO' }}','{{ $info->pickup_point }}','{{ $info->dropoff_point }}','{{ $info->details }}','{{ optional($info->driver)->photo ? $info->driver->photo : asset('img/auto.png')}}')" 
                                                data-micromodal-trigger="modal-details" 
                                                class="js-modal-trigger button is-success is-fullwidth is-medium modal-button card-footer-item" 
                                                style="border-radius:50px;">
                                                Detalles y Reserva
                                            </button>

                                            <!-- NUEVO: Botón Enviar Mensaje -->
                                            @if(auth()->check() && auth()->id() != $info->driver_id)
                                                <button 
                                                    onclick="openMessageModal(
                                                        {{ $info->id }}, 
                                                        '{{ $info->driver->name }}', 
                                                        '{{ $from }}', 
                                                        '{{ $to }}'
                                                    )" 
                                                    class="button is-info is-fullwidth is-medium modal-button card-footer-item" 
                                                    style="border-radius:50px;">
                                                    <span class="icon">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                    <span>Mensaje</span>
                                                </button>
                                            @endif
                                        @else
                                            <button disabled class="js-modal-trigger button is-light is-fullwidth is-medium modal-button" style="border-radius:50px;">
                                                No hay asientos disponibles
                                            </button>
                                        @endif
                                    </footer>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </span>
        </article>
    </div>

</div> <!-- Cierra container único -->

<!-- Modal de Mensajes -->
<div id="messageModal" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Enviar mensaje al conductor</p>
      <button class="delete" aria-label="close" onclick="closeMessageModal()"></button>
    </header>
    <section class="modal-card-body">
      <div class="field">
        <label class="label">Conductor</label>
        <div class="control">
          <input class="input" type="text" id="driverName" readonly>
        </div>
      </div>
      <div class="field">
        <label class="label">Ruta</label>
        <div class="control">
          <input class="input" type="text" id="tripRoute" readonly>
        </div>
      </div>
      <div class="field">
        <label class="label">Mensaje</label>
        <div class="control">
          <textarea class="textarea" id="messageText" placeholder="Escribe tu mensaje aquí..." rows="5"></textarea>
        </div>
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success" onclick="sendMessage()">Enviar mensaje</button>
      <button class="button" onclick="closeMessageModal()">Cancelar</button>
    </footer>
  </div>
</div>

@include('trip-details')
@include('footer-content')
@include('footer')

<!-- Botón flotante -->
<button id="btn-scroll-top" class="button is-rounded" title="Volver arriba">
  <i class="fa fa-arrow-up"></i>
</button>

<style>
/* Cards translúcidas */
.translucent-card {
    background-color: rgba(0,0,0,0.65);
    color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
}

/* Inputs estilizados */
.input {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    color: #000;
}
.input:focus {
    border-color: #ffd700;
    box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.4);
}

/* Botones */
.button.is-success {
    background: linear-gradient(90deg, #FFD700, #FF43A0);
    border: none;
    font-weight: bold;
    color: #000;
}
.button.is-success:hover {
    filter: brightness(1.1);
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

/* Iconos dorados */
.translucent-card .icon i.fas {
    color: #FFD700;
}

/* Estilos del Modal de Mensajes */
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

/* Estilo para botones en el footer */
.card-footer {
    display: flex;
    gap: 10px;
    padding: 10px;
}

.card-footer-item {
    flex: 1;
}
</style>

<script>
window.addEventListener("scroll", function() {
    const btn = document.getElementById("btn-scroll-top");
    btn.style.display = (window.scrollY > 300) ? "flex" : "none";
});
document.getElementById("btn-scroll-top").addEventListener("click", function() {
    window.scrollTo({ top: 0, behavior: "smooth" });
});

// Funciones del Modal de Mensajes
let currentTripId = null;

function openMessageModal(tripId, driverName, fromCity, toCity) {
  currentTripId = tripId;
  document.getElementById('driverName').value = driverName;
  document.getElementById('tripRoute').value = fromCity + ' → ' + toCity;
  document.getElementById('messageText').value = '';
  document.getElementById('messageModal').classList.add('is-active');
}

function closeMessageModal() {
  document.getElementById('messageModal').classList.remove('is-active');
  currentTripId = null;
}

function sendMessage() {
  const message = document.getElementById('messageText').value.trim();
  
  if (!message) {
    Swal.fire({
      icon: 'warning',
      title: 'Mensaje vacío',
      text: 'Por favor escribe un mensaje',
      timer: 2000
    });
    return;
  }

  let token = $('meta[name="csrf-token"]').attr('content');
  
  $.ajax({
    url: "{{ route('sendMessage') }}",
    type: "POST",
    dataType: "json",
    data: {
      '_token': token,
      'trip_id': currentTripId,
      'message': message
    },
    success: function(response) {
      if (response.error) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: response.message,
          timer: 3000
        });
      } else {
        Swal.fire({
          icon: 'success',
          title: '¡Mensaje enviado!',
          text: response.message,
          timer: 2500
        }).then(() => {
          closeMessageModal();
        });
      }
    },
    error: function(err) {
      console.error("Error:", err);
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'No se pudo enviar el mensaje',
        timer: 3000
      });
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  const modalBg = document.querySelector('#messageModal .modal-background');
  if (modalBg) {
    modalBg.addEventListener('click', closeMessageModal);
  }
});
</script>
</document_content>