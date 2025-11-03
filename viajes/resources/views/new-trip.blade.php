@include('header')

<div class="form-background">
  <div class="form-overlay">
    <div class="container content has-text-centered">

      <h1 class="my-3" style="color: white; font-weight: 600;">
        Publicar nuevo viaje
      </h1>

      <section class="my-2 columns is-mobile is-centered">
        <form method="POST" action="">
          @csrf

          {{-- Campos principales --}}
          <div class="field">
            <div class="control has-icons-left">
              <select required class="input" name="origen" id="origen" style="background-color: rgba(255,255,255,0.15); color: #fff;">
              </select>
              <span class="icon is-small is-left"><i class="fas fa-map-marker-alt"></i></span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left">
              <input required class="input" type="text" name="recogida" id="recogida" placeholder="Lugar de recogida">
              <span class="icon is-small is-left"><i class="fas fa-location"></i></span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left">
              <select required class="input" name="destino" id="destino" style="background-color: rgba(255,255,255,0.15); color: #fff;">
              </select>
              <span class="icon is-small is-left"><i class="fas fa-map-marker-alt"></i></span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left">
              <input required class="input" type="text" name="llegada" id="llegada" placeholder="Lugar de llegada">
              <span class="icon is-small is-left"><i class="fas fa-flag-checkered"></i></span>
            </div>
          </div>

          {{-- Asientos, fecha y hora --}}
          <div class="field">
            <div class="control has-icons-left">
              <input required class="input" type="number" name="asientos" id="asientos" min="1" max="4" value="3" placeholder="Número de asientos">
              <span class="icon is-small is-left"><i class="fas fa-chair"></i></span>
            </div>
          </div>

          <div class="field">
            <label class="has-text-white">Fecha de salida</label>
            <input required class="input" type="date" name="fecha" id="fecha" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}">
          </div>

          <div class="field">
            <label class="has-text-white">Hora de salida</label>
            <input required class="input" type="time" name="hora" id="hora">
          </div>

          {{-- Opciones adicionales --}}
          <div class="field has-text-left has-text-white">
            <label>Dejar asiento libre por comodidad</label>
            <select required class="input" name="libre" id="libre">
              <option value="1">Sí</option>
              <option value="0">No</option>
            </select>
          </div>

          <div class="field has-text-left has-text-white">
            <label>Permite mascotas</label>
            <select required class="input" name="mascota" id="mascota">
              <option value="1">Sí</option>
              <option selected value="0">No</option>
            </select>
          </div>

          <div class="field has-text-left has-text-white">
            <label>Permite fumar</label>
            <select required class="input" name="fumar" id="fumar">
              <option value="1">Sí</option>
              <option selected value="0">No</option>
            </select>
          </div>

          <div class="field has-text-left has-text-white">
            <label>Reserva automática</label>
            <select required class="input" name="automatica" id="automatica">
              <option value="1">Sí</option>
              <option value="0">No</option>
            </select>
          </div>

          <hr>

          {{-- Información del vehículo --}}
          <div class="field">
            <div class="control has-icons-left">
              <input required class="input" type="number" min="100" name="precio" id="precio" placeholder="Precio por asiento (ej: 3000)">
              <span class="icon is-small is-left"><i class="fas fa-dollar-sign"></i></span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left">
              <input required class="input" type="text" name="celular" id="celular" placeholder="Celular">
              <span class="icon is-small is-left"><i class="fas fa-phone"></i></span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left">
              <input required class="input" type="text" name="placa" id="placa" placeholder="Patente">
              <span class="icon is-small is-left"><i class="fas fa-car"></i></span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left">
              <input required class="input" type="text" name="marca" id="marca" placeholder="Marca">
              <span class="icon is-small is-left"><i class="fas fa-car"></i></span>
            </div>
          </div>

          <div class="field">
            <div class="control has-icons-left">
              <input required class="input" type="text" name="color" id="color" placeholder="Color">
              <span class="icon is-small is-left"><i class="fas fa-palette"></i></span>
            </div>
          </div>

          <div class="field">
            <label class="has-text-white">Duración estimada</label>
            <input required class="input" type="time" name="duracion" id="duracion">
          </div>

          <div class="field">
            <textarea class="input" name="detalles" id="detalles" placeholder="Detalles adicionales para los pasajeros" rows="3"></textarea>
          </div>

          {{-- Botón de envío --}}
          <div class="field">
            <button type="button"
              onclick="saveTrip()"
              class="button is-fullwidth"
              style="background: linear-gradient(90deg, #FFD700, #FF69B4);
                     border: none;
                     color: black;
                     font-weight: bold;
                     transition: 0.3s;
                     box-shadow: 0 2px 6px rgba(0,0,0,0.3);">
              Publicar viaje
            </button>
          </div>

          {{-- Declaración legal --}}
          <div class="field mt-4">
            <label class="checkbox"
              style="display:block; background:#fff8fb; border:1px solid #ff66a3; border-radius:10px; padding:12px 16px; font-size:0.95rem; line-height:1.5; color:#333;">
              <input type="checkbox" name="declaracion" id="declaracion" required>
              Declaro que este viaje no tiene fines de lucro y que cumplo con los requisitos legales vigentes para transportar pasajeros ocasionalmente. 
              <br>
              - Tengo licencia válida. <br>
              - SOAP vigente. <br>
              - Acepto los            
                 <a style="color: #007BFF; text-decoration: underline;" href="{{ route('reglas') }}" target="_blank">Términos y Condiciones</a>
              </a> de la app.
            </label>
          </div>
        </form>
      </section>

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
  background-color: rgba(0, 0, 0, 0.7);
  border-radius: 15px;
  padding: 2rem;
  width: 90%;
  max-width: 800px;
  margin: 0 auto;
  box-shadow: 0 0 20px rgba(0,0,0,0.4);
}

.input {
  background-color: rgba(255,255,255,0.15) !important;
  border: 1px solid rgba(255,255,255,0.4);
  color: white;
}

.input::placeholder {
  color: rgba(255,255,255,0.7);
}

.icon i {
  color: white !important;
}
select option {
  color: #000 !important;
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