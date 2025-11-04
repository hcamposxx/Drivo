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

<script>
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
</script>

@include('footer-content')
@include('footer')

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

#btn-scroll-top {
  position: fixed;
  bottom: 40px;
  right: 30px;
  display: none;
  z-index: 999;
  background-color: #f1ce04ff; /* Dorado */
  color: white; /* Color del ícono */
  border: none;
  box-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
  transition: transform 0.2s, background-color 0.3s;
}

#btn-scroll-top:hover {
  background-color: #ff00eaff; /* Dorado más intenso */
  transform: scale(1.1);
}
</style>

<!-- Botón flotante para volver arriba -->
<button id="btn-scroll-top" class="button is-rounded" title="Volver arriba">
  <i class="fa fa-arrow-up"></i>
</button>

<script>
  // Mostrar el botón cuando se baja un poco
  window.addEventListener("scroll", function() {
      const btn = document.getElementById("btn-scroll-top");
      if (window.scrollY > 300) {
          btn.style.display = "flex"; // aparece
      } else {
          btn.style.display = "none"; // desaparece
      }
  });

  // Al hacer clic, vuelve arriba con animación suave
  document.getElementById("btn-scroll-top").addEventListener("click", function() {
      window.scrollTo({
          top: 0,
          behavior: "smooth"
      });
  });

 

</script>