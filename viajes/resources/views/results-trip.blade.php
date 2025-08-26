@include('header')
<div class="container py-6">
    
<div class="card px-2 my-5">
    <form method="post" action="{{ route('searchTrip') }}" class="field is-grouped">
        @csrf
        <input type="hidden" name="verified" value="-1">
        <input type="hidden" name="sort" value="departure_time">
        <div class="control">

            <span class="icon"><i class="fas fa-location"></i></span>
            <select style="width: 200px" name="origen" id="origen">

            </select>

        </div>
        
        <div class="control">

            <span class="icon"><i class="fas fa-location"></i></span>
            <select style="width: 200px" name="destino" id="destino">

            </select>

        </div>

        <div class="control" title="Fecha de salida">


            <input class="input is-success" type="date" name="fecha" id="fecha"  min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">

        </div>
        
        <div class="field" title="Número de asientos">

            <p class="control has-icons-left">

                
                <span class="icon"><i class="fas fa-chair"></i></span>
                <input class="input is-success" type="number" name="asientos" id="asientos"  min="1" max="4" value="1">

            </p>

        </div>

        <div class="control mx-2" title="Número de asientos">

            <button class="button is-success">Buscar</button>

        </div>
        
        
    </form>
</div>
<div class="card px-2 my-5 columns">
@php
    $totalTrips= count($trips);
@endphp 
          
                <article class="message column {{ ($totalTrips == 0)?'is-warning':'is-success' }}">
                    <div class="message-header">
                        <p>{{ $from }} -> {{ $to }} | {{ $totalTrips }} viajes disponibles | Salida: {{ ($date==date('Y-m-d')?'Hoy':'') }} {{ $date }}</p>                    
                    </div>                    
                    <span class="message-body columns is-mobile is-centered">
                        @if ($totalTrips== 0)
                        <div class="content">
                            <div class="columns">
                                <div class="py-2 card px-2">
                                    <div class="icon-text">
                                        <span class="icon has-text-success">
                                            <i class="fas fa-chair"></i>
                                        </span>
                                        <span> Disponibles </span>
        
                                        <span class="icon has-text-danger">
                                            <i class="fas fa-chair"></i>
                                        </span>
                                        <span> Ocupadas </span>

                                        <span class="icon has-text-info">
                                            <i class="fas fa-chair"></i>
                                        </span>
                                        <span> Libres por comodidad</span>
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
                                <div class="card my-2">
                                    <!-- Tarjetas para cada viaje -->
                                    <div class="card-content">
                                        <div class="media">
                                        <div class="media-left">
                                            <figure class="image is-48x48">
                                            <img
                                                src="https://bulma.io/assets/images/placeholders/96x96.png"
                                                alt="Placeholder image"
                                            />
                                            </figure>
                                        </div>
                                        <!-- credenciales y rating -->
                                        <div class="media-content columns">
                                            <div class="column">
                                                <p class="title is-4">{{ $info->driver->name }}</p>
                                                <span>Calificación: </span>
                                                    <p class="subtitle is-6">
                                                        <span class="icon has-text-warning">
                                                            <i class="fas fa-star"></i>
                                                        </span>
                                                        {{ $info->driver->rating }}                                                       
                                                    </p>
                                            </div>
                                            <div class="column">
                                                <p class="subtitle is-6">
                                                    <span class="icon has-text-success">
                                                        <i class="fas fa-location"></i>
                                                    </span>  
                                                    {{ $from }} -> 
                                                    <span class="icon has-text-success">
                                                        <i class="fas fa-location"></i>
                                                    </span>
                                                    {{ $to }}
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
                                                            
                                                            @for ($inicio=0; $inicio < $info->available_seats - $info->occupied_seats; $inicio++)
                                                            <span class="icon has-text-success" title="Disponible">
                                                                <i class="fas fa-chair"></i>
                                                            </span>
                                                            @endfor

                                                            @for ($inicio=0; $inicio < $info->behind_available_seats; $inicio++)
                                                            <span class="icon has-text-info" title="Libre por comodidad">
                                                                <i class="fas fa-chair"></i>
                                                            </span>
                                                            @endfor
                                                            
                                                             @for ($inicio=0; $inicio < $info->occupied_seats; $inicio++)
                                                            <span class="icon has-text-danger" title="Ocupada">
                                                                <i class="fas fa-chair"></i>
                                                            </span>
                                                            @endfor
                                                            {{ ($info->available_seats - $info->occupied_seats) }} Disponibles
                                                            
                                                            
                                                        </div>
                                                    </div>
                                                </p>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="content">
                                            <p style="color:gray">Aquí encontrarás mas información detallada del viaje y datos que te ayudarán a tomar el que mejor se adapte a tus necesidades</p>
                                            <p>
                                                <strong>Aclaraciones del conductor: </strong>{{ $info->details }}
                                                
                                            </p>
                                        </div>                                        
                                            <footer class="card-footer">
                                                <button style="border-radius: 50px" class="button is-success is-fullwidth is-medium">Detalles del viaje</button>
                                            </footer>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </span>
                </article>
                
</div>                          
@include('footer')