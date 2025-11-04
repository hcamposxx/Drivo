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

</style>


