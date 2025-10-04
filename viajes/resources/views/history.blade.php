@include('header')
<div class="container py-6">
    
<div class="card px-2 my-5">
    <h1 class="my-2 columns is-mobile is-centered">Historial de viajes</h1>
</hr>
</div>
<div class="card px-2 my-5 columns">
@php
    $totalTrips= count($trips);
@endphp 
          
                <article class="message column {{ ($totalTrips == 0)?'is-warning':'is-success' }}">
                    <div class="message-header">
                        <p>Mis {{ $totalTrips }} últimos viajes</p>                    
                    </div>                    
                    <span class="message-body columns is-mobile is-centered">
                        @if ($totalTrips== 0)
                        <div class="content">
                        <h2>Aún no hay viajes</h2>
                        <p>Publica tu primer viaje o busca un asiento</p>
                        </div>
                        @else
                        <div class="content">
                            @foreach ($trips as $info)
                                <div class="card my-2">
                                    <!-- Tarjetas para cada viaje -->
                                    <div class="card-content">
                                        <div class="media">
                                        <div class="media-left">
                                            <figure class="image is-48x48">
                                            <img
                                                src="{{ optional($info->driver)->photo ? $info->driver->photo : asset('img/auto.png')}}"
                                                alt="Placeholder image"
                                            />
                                            </figure>
                                        </div>
                                        <!-- credenciales y rating -->
                                        <div class="media-content columns">
                                            <div class="column">
                                                <p class="title is-4">{{ $info->driver->name }}</p>
                                                <span>Viajé como: {{ $info-> is_driver ? 'Conductor': 'Pasajero' }}</span>
                                                    <p class="subtitle is-6">
                                                        <span class="icon has-text-warning">
                                                            <i class="fas fa-car"></i>
                                                        </span>
                                                        Marca: {{ $info->car_brand }} | Color: {{ $info->car_color }} | Patente: {{ $info->car_plate }}                                                       
                                                    </p>
                                            </div>
                                            <div class="column">
                                                <p class="subtitle is-6">
                                                    <span class="icon has-text-success">
                                                        <i class="fas fa-location"></i>
                                                    </span>  
                                                    {{ $info->departureCity->name }} -> 
                                                    <span class="icon has-text-success">
                                                        <i class="fas fa-location"></i>
                                                    </span>
                                                    {{ $info->arrivalCity->name }}
                                                </p>
                                                <p class="subtitle is-6">
                                                    <span class="icon has-text-success">
                                                        <i class="fas fa-clock"></i>
                                                    </span>  
                                                    {{ substr($info->departure_time,0,5) }} ->
                                                    <!-- calcular duracion de viaje -->
                                                    @php
                                                        $horaOriginal = new DateTime($info->departure_time);
                                                        $duracion = new DateInterval("PT".intval(substr($info->trip_duration,0,2))."H".intval(substr($info->trip_duration,3,2))."M");
                                                        $horaLlegada = $horaOriginal->add($duracion);
                                                    @endphp 
                                                   
                                                    {{ substr($horaLlegada->format('H:i:s').PHP_EOL,0,5) }}
                                                    ({{ intval(substr($info->trip_duration,0,2))."h ".intval(substr($info->trip_duration,3,2))."m" }})
                                                </p>
                                                <!-- precio del viaje -->
                                                <p style="font-size:16pt">
                                                    <span class="icon has-text-success">
                                                        <i class="fas fa-dollar"></i>
                                                    </span>  
                                                    ${{ number_format($info->price_per_seat,0,',','.') }} CLP P/p                 
                                                </p>
                                                <!-- disponibilidad de asientos -->
                                                <p class="subtitle is-6">
                                                    <div class="py-2 card px-2">
                                                        <div class="icon-text">
                                                            <span style="color:{{ $info->active == 0 ? 'red':(date($info->departure_date) < $date ? 'gray':'' )}}">{{ $info->active == 0 ? 'Viaje cancelado': (date($info->departure_date) >= $date && $info->departure_time > date('H:i:s') ? '':'Viaje finalizado' ) }}</span>                                                           
                                                        </div>
                                                    </div>
                                                </p>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="content">
                                            <p style="color:gray">Aquí encontrarás mas información detallada del viaje y datos que te ayudarán a tomar el que mejor se adapte a tus necesidades</p>
                                            <p>
                                                <strong>Comentarios del conductor: </strong>{{ $info->details }}
                                                
                                            </p>
                                        </div>                                        
                                            <footer class="card-footer">
                                                @if(($info->available_seats - $info->occupied_seats) > 0) 
                                                <button onclick="showDetails('{{ $info->id }}','{{ $info->departure_date }}',' {{ substr($info->departure_time,0,5) }} -> {{ substr($horaLlegada->format('H:i:s').PHP_EOL,0,5) }} ({{ intval(substr($info->trip_duration,0,2)).'h '.intval(substr($info->trip_duration,3,2)).'m' }})','{{ $info->available_seats - $info->occupied_seats }}','{{ $info->occupied_seats? $info->occupied_seats:0}}','{{ $info->pets_allowed?'SI':'NO' }}','{{ $info->smoking_allowed?'SI':'NO' }}','{{ $info->pickup_point }}','{{ $info->dropoff_point }}','{{ $info->details }}','{{ optional($info->driver)->photo ? $info->driver->photo : asset('img/auto.png')}}')" data-micromodal-trigger="modal-details" style="border-radius: 50px" class="js-modal-trigger button is-success is-fullwidth is-medium modal-button">Detalles del viaje</button>
                                                @else
                                                <button disabled style="border-radius: 50px" class="js-modal-trigger button is-light is-fullwidth is-medium modal-button">No hay asientos disponibles</button>
                                                @endif
                                                @if (auth()->user()->id == $info->driver->id)
                                                <button onclick="window.location.href='/history/{{ $info->id }}'" style="border-radius: 50px" class="js-modal-trigger button is-warning is-fullwidth is-medium modal-button">{{ $info->passenger_count}} pasajeros - ver</button>
                                                @endif
                                                
                                            </footer>
                                    </div>
                                </div>
                                @include('trip-details')
                            @endforeach
                        </div>
                        @endif
                    </span>
                </article>
                
</div>


@include('footer')