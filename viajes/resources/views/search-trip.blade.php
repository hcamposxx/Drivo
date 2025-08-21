<div class="card px-2 py-2 columns is-mobile is-centered">
    <form method="post" action="{{ route('searchTrip') }}" class="field is-grouped">
        @csrf
        <input type="hidden" name="verified" value="-1">
        <input type="hidden" name="sort" value="departure_time">
        <div class="control">

            <span class="icon"><i class="fas fa-location"></i></span>
            <select required style="width: 200px" name="origen" id="origen">

            </select>

        </div>
        
        <div class="control">

            <span class="icon"><i class="fas fa-location"></i></span>
            <select required style="width: 200px" name="destino" id="destino">

            </select>

        </div>

        <div class="control" title="Fecha de salida">


            <input required class="input is-success" type="date" name="fecha" id="fecha"  min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">

        </div>
        
        <div class="field" title="Número de asientos">

            <p class="control has-icons-left">

                
                <span class="icon"><i class="fas fa-chair"></i></span>
                <input required class="input is-success" type="number" name="asientos" id="asientos"  min="1" max="4" value="1">

            </p>

        </div>

        <div class="field mx-2" title="Número de asientos">

            <button class="button is-success">Buscar</button>

        </div>
        
        
    </form>
</div>