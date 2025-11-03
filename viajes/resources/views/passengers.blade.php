@include('header')

<div class="form-background">
    <div class="form-overlay">
        <div class="container content has-text-centered">

            <h1 class="title my-3 has-text-white" style="font-weight: 600;">
                Viaje {{ $from }} -> {{ $to }} Fecha: {{ $date }}
            </h1>

            @php $totalTrips = count($trip[0]->passengers); @endphp

            @if ($totalTrips == 0)
                <div class="notification is-warning">
                    <p>Aún no hay pasajeros</p>
                </div>
            @else
                <div class="columns is-multiline">
                    @foreach ($trip as $item)
                        @foreach ($item->passengers as $info)
                            <div class="column is-full">
                                <div class="card trip-card my-3">
                                    <div class="card-content">

                                        <div class="media">
                                            <div class="media-left">
                                                <figure class="image is-48x48">
                                                    <img src="{{ $info['passenger']->photo ? $info['passenger']->photo : asset('img/auto.png') }}" alt="Passenger photo">
                                                </figure>
                                            </div>
                                            <div class="media-content columns">
                                                <div class="column">
                                                    <p class="title is-4 has-text-white">{{ $info['passenger']->name }}</p>

                                                    <!-- Teléfono con margen inferior -->
                                                    <p class="subtitle is-6 has-text-white phone-field">
                                                        <span class="icon">
                                                            <i class="fas fa-phone"></i>
                                                        </span>
                                                        {{ $info['phone'] }}
                                                    </p>

                                                    <p class="subtitle is-6 has-text-white">
                                                        <span class="icon">
                                                            <i class="fas fa-chair"></i>
                                                        </span>
                                                        Asientos reservados: {{ $info['seats'] }}
                                                    </p>
                                                </div>
                                                <div class="column">
                                                    <p class="subtitle is-6 has-text-white">
                                                        <span class="icon">
                                                            <i class="fas fa-location"></i>
                                                        </span>
                                                        {{ $from }} → 
                                                        <span class="icon">
                                                            <i class="fas fa-location"></i>
                                                        </span>
                                                        {{ $to }}
                                                    </p>
                                                    <p class="subtitle is-6 has-text-white">
                                                        @if (!empty($info['passenger']->dni_front) && !empty($info['passenger']->dni_back) && $info['passenger']->verified == 1)
                                                            <span class="icon">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                            <strong style="color:#00AFF5">Verificado</strong>
                                                        @else
                                                            <span class="icon">
                                                                <i class="fas fa-warning"></i>
                                                            </span>
                                                            <strong class="has-text-warning">Por verificar</strong>
                                                        @endif
                                                    </p>
                                                    <p class="subtitle is-6 has-text-white">
                                                        <span class="icon">
                                                            <i class="fas fa-comment"></i>
                                                        </span>
                                                        <strong class="has-text-white">Comentarios del pasajero: </strong>
                                                        <span class="has-text-white">{{ $info['comment'] }}</span>
                                                    </p>
                                                    <p class="subtitle is-6 has-text-white">
                                                        <span class="icon">
                                                            <i class="fas fa-info"></i>
                                                        </span>
                                                        <strong class="has-text-white">Reserva #: </strong>
                                                        <span style="font-size: 9pt; color: white;">{{ strtoupper(md5($info['reservationId'])) }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>

@include('footer-content')
@include('footer')

<style>
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

.trip-card {
    background-color: rgba(255,255,255,0.15);
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
}

.has-text-white {
    color: white !important;
}

/* Iconos dorados */
.icon i {
    color: #FFD700 !important;
}

/* Separación entre ícono de teléfono y número */
.phone-field .icon {
    margin-bottom: 5px;
}
</style>
