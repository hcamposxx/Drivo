@include('header')


<div class="container content">
    <h1 class="my-2 columns is-mobile is-centered">Publicar nuevo viaje</h1>
</hr>



    <section class="my-2 columns is-mobile is-centered">
        <form method="POST" action="">
            @csrf
            <div class="field">                
                <div class="control has-icons-left">
                     <select required style="width: 200px" name="origen" id="origen">

                    </select>
                </div>
            </div>

            <div class="field">                
                <div class="control has-icons-left">
                     <input required class="input is-success" type="text" name="recogida" id="recogida" placeholder="Lugar de recogida" value="">
                     <span class="icon is-small is-left">
                        <i class="fas fa-location"></i>
                    </span>
                </div>
            </div>

            <div class="field">                
                <div class="control has-icons-left">
                     <select required style="width: 200px" name="destino" id="destino">

                    </select>
                </div>
            </div>

            <div class="field">                
                <div class="control has-icons-left">
                     <input required class="input is-success" type="text" name="llegada" id="llegada" placeholder="Lugar de llegada" value="">
                     <span class="icon is-small is-left">
                        <i class="fas fa-location"></i>
                    </span>
                </div>
            </div>
            <div class="field">                
                <div class="control has-icons-left">
                     <input title="Cuantos asientos ofreces?" required class="input is-success" type="number" name="asientos" id="asientos" min="1" max="4" value="3">
                     <span class="icon is-small is-left">
                        <i class="fas fa-chair"></i>
                    </span>
                </div>
            </div>
            <div class="field">
                    <div class="control">
                        Fecha de salida:
                        <input required class="input is-success" type="date" name="fecha" id="fecha" min="{{ date('Y-m-d') }}"
                            value="{{ date('Y-m-d') }}">
                    </div>
            </div>
            <div class="field">
                    <div class="control">
                        Hora salida:
                        <input required class="input is-success" type="time" name="hora" id="hora" >
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        Deseas dejar un asiento libre por comodidad?:
                        <select class="select" required style="width: 200px" name="libre" id="libre">
                            <option value="1">Si</option>
                            <option value="0">No</option>

                        </select>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        Se permite viajar con mascota?:
                        <select class="select" required style="width: 200px" name="mascota" id="mascota">
                            <option value="1">Si</option>
                            <option selected value="0">No</option>

                        </select>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        Se permite fumar?:
                        <select class="select" required style="width: 200px" name="fumar" id="fumar">
                            <option value="1">Si</option>
                            <option selected value="0">No</option>

                        </select>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        {{-- Para no tener que confirmar cada pasajero de forma manual --}}
                        Activar reserva automatica?: 
                        <select class="select" required style="width: 200px" name="automatica" id="automatica">
                            <option value="1">Si</option>
                            <option value="0">No</option>

                        </select>
                    </div>
                </div>
                <hr/>
                <div class="field">                
                <div class="control has-icons-left">
                     <input required class="input is-success" type="number" min="100" name="precio" id="precio" placeholder="Precio por asiento ej: 3.000" value="">
                     <span class="icon is-small is-left">
                        <i class="fas fa-dollar"></i>
                    </span>
                </div>
            </div>
            <div class="field">                
                <div class="control has-icons-left">
                     <input required class="input is-success" type="text" name="celular" id="celular" placeholder="Celular" value="">
                     <span class="icon is-small is-left">
                        <i class="fas fa-phone"></i>
                    </span>
                </div>
            </div>
            <div class="field">                
                <div class="control has-icons-left">
                     <input required class="input is-success" type="text" name="placa" id="placa" placeholder="Patente" value="">
                     <span class="icon is-small is-left">
                        <i class="fas fa-car"></i>
                    </span>
                </div>
            </div>
            <div class="field">                
                <div class="control has-icons-left">
                     <input required class="input is-success" type="text" name="marca" id="marca" placeholder="Marca" value="">
                     <span class="icon is-small is-left">
                        <i class="fas fa-car"></i>
                    </span>
                </div>
            </div>
            <div class="field">                
                <div class="control has-icons-left">
                     <input required class="input is-success" type="text" name="color" id="color" placeholder="Color" value="">
                     <span class="icon is-small is-left">
                        <i class="fas fa-car"></i>
                    </span>
                </div>
            </div>
            <div class="field">                
                <div class="control">
                    Duración
                     <input required class="input is-success" type="time" name="duracion" id="duracion" placeholder="Duración del viaje" value="">
                </div>
            </div>
            <div class="field">                
                <div class="control">
 
                     <textarea class="input is-success" name="detalles" id="detalles" placeholder="Algo que deban saber los pasajeros" rows="4"></textarea>
                </div>
            </div>
            <div class="field">                
                <div class="control has-icons-left">
                    <button type="button" onclick="saveTrip()" class="button is-success is-fullwidth">
                        Publicar viaje
                    </button>
                </div>
            </div>
            
        </form>
    </section>
</hr>
</div>

@include('footer')