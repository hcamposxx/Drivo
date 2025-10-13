@include('header')
<div class="container py-6">
    
<div class="card px-2 my-5">
    <h1 class="my-2 columns is-mobile is-centered">Viaje {{ $from }} -> {{ $to }} Fecha: {{ $date }}</h1>
</hr>
</div>
<div class="card px-2 my-5 columns">
@php
    $totalTrips= count($trip[0]->passengers);
@endphp 
          
                <article class="message column {{ ($totalTrips == 0)?'is-warning':'is-success' }}">
                    <div class="message-header">
                        <p>{{ $totalTrips }} Pasajeros para este viaje</p>                    
                    </div>                    
                    <span class="message-body columns is-mobile is-centered">
                        @if ($totalTrips== 0)
                        <div class="content">
                        <h2>Aún no hay pasajeros</h2>
                        <p> </p>
                        </div>
                        @else
                        <div class="content">
                            @foreach ($trip as $item)
                            @foreach ($item->passengers as $info)
                                <div class="card my-2">
                                    <!-- Tarjetas para cada viaje -->
                                    <div class="card-content">
                                        <div class="media">
                                        <div class="media-left">
                                            <figure class="image is-48x48">
                                            <img
                                                src="{{$info['passenger']->photo ? $info['passenger']->photo : asset('img/auto.png')}}"
                                                alt="Placeholder image"
                                            />
                                            </figure>
                                        </div>
                                        <!-- credenciales y rating -->
                                        <div class="media-content columns">
                                            <div class="column">
                                                <p class="title is-4">{{ $info['passenger']->name }}</p>
                                                <span>Calificación: {{ $info['passenger']->rating }}</span>
                                                    <p class="subtitle is-6">
                                                        <span class="icon has-text-success">
                                                            <i class="fas fa-phone"></i>
                                                        </span>
                                                        {{ $info['phone'] }}                                                      
                                                    </p>
                                                    <p class="subtitle is-6">
                                                        <span class="icon has-text-success">
                                                            <i class="fas fa-chair"></i>
                                                        </span>
                                                        Asientos reservados: {{ $info['seats'] }}                                                      
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
                                                    
                                                    @if ((!empty($info['passenger']->dni_front) && !empty($info['passenger']->dni_back) && $info['passenger']->verified == 1))
                                                    <span class="icon has-text-success">
                                                        <i class="fas fa-check"></i>
                                                    </span>
                                                    
                                                    <strong style="color:#00AFF5">Verificado</strong>
                                                    @else
                                                    <span class="icon has-text-warning">
                                                        <i class="fas fa-warning"></i>
                                                    </span>
                                                    <strong class="has-text-warning">Por verificar</strong>
                                                    
                                                    @endif  
                                                </p>
                                                <p class="subtitle is-6">
                                                    <span class="icon has-text-success">
                                                        <i class="fas fa-comment"></i>
                                                    </span>
                                                    <strong>Comentarios del pasajero: </strong>{{ $info['comment'] }}  
                                                </p>
                                                <p class="subtitle is-6">
                                                    <span class="icon has-text-success">
                                                        <i class="fas fa-info"></i>
                                                    </span>
                                                    <strong>Reserva #: <span style="font-size: 9pt">{{ strtoupper(md5($info['reservationId'])) }} </span></strong> 
                                                </p>
                                            </div>
                                        </div>
                                        </div>
                                                                                 
                                            <footer class="card-footer">
                                                
                                            </footer>
                                    </div>
                                </div>
                            @endforeach
                            @endforeach
                        </div>
                        @endif
                    </span>
                </article>
                
</div>


@include('footer')