@include('header')
<!-- Franja con texto en movimiento -->
<div class="scroll-banner">
  <div class="scroll-text">
    🚗 Conecta con personas y destinos | 💰 Ahorra compartiendo tus viajes | 🌍 Reduce la contaminación | 🕒 Encuentra salidas en el momento justo | 🐾 Permite viajes con mascotas | 🚘 Drivo: tu ruta, compartida | 🌄 Descubre nuevas rutas y paisajes | 👥 Conoce viajeros con tus mismos destinos | 🔒 Viaja seguro y verificado | 🌱 Menos autos, más planeta | ⛽ Ahorra combustible y gastos | 📱 Gestiona tus viajes desde cualquier lugar | 🧳 Crea tu historial de viajes favoritos | 🗓️ Planea con libertad, viaja con confianza | 🚦 Drivo, donde cada viaje cuenta.
  </div>
</div>


@include('hero')
<div class="container">
    @include('search-trip')
    @include('info')
</div>

<!-- Botón flotante para volver arriba -->
<button id="btn-scroll-top" class="button is-rounded" title="Volver arriba">
  <i class="fa fa-arrow-up"></i>
</button>

@include('components.ticket-button')

<script>
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


@include('footer-content')
@include('footer')

<style>
/* Franja del banner */
.scroll-banner {
  background: linear-gradient(90deg, #ffd700, #fd43a0ff); /* Dorado a fucsia */
  overflow: hidden;
  white-space: nowrap;
  padding: 10px 0;
}

/* Texto en movimiento */
.scroll-text {
  display: inline-block;
  animation: scroll-left 45s linear infinite;
  font-size: 1.1rem;
  color: #000000ff; /* 👈 Cambia aquí el color del texto */
  font-weight: 500;
}

/* Animación del desplazamiento */
@keyframes scroll-left {
  0% {
    transform: translateX(0%);
  }
  100% {
    transform: translateX(-100%);
  }
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


