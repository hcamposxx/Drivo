<div class="info-section container py-6">

  <!-- 🎯 Bloque principal: ¿Qué es Drivo? -->
  <section class="drivo-hero-box">
    <h1 class="title">🚘 Drivo: Tu ruta, compartida</h1>
    <p class="subtitle">Conecta con viajeros, ahorra dinero y cuida el planeta.</p>
    <ul class="features-list">
      <li>🌍 Conecta con personas y destinos cercanos</li>
      <li>💰 Ahorra compartiendo tus viajes</li>
      <li>🕒 Encuentra salidas en el momento justo</li>
      <li>🐾 Permite viajes con mascotas</li>
      <li>🗺️ Define tus rutas y paradas</li>
      <li>📱 Gestiona tus viajes desde cualquier dispositivo</li>
      <li>🌱 Reduce la contaminación y la congestión vial</li>
      <li>🚦 Planea con libertad, viaja con confianza</li>
    </ul>
  </section>

  <!-- 🟠 Bloques destacados con iconos y colores -->
  <div class="tiles is-ancestor mt-6">
    <div class="tile is-parent">
      <article class="tile is-child notification drivo-tile is-orange">
        <div class="content">
          <h2 class="title">💡 Planifica fácilmente</h2>
          <p>Selecciona origen, destino, fecha y número de asientos en segundos. Todo al alcance de tu mano.</p>
        </div>
      </article>
    </div>

    <div class="tile is-parent">
      <article class="tile is-child notification drivo-tile is-purple">
        <div class="content">
          <h2 class="title">💬 Conoce nuevos viajeros</h2>
          <p>Interactúa con otros usuarios y encuentra compañeros de viaje con intereses similares.</p>
        </div>
      </article>
    </div>

    <div class="tile is-parent">
      <article class="tile is-child notification drivo-tile is-teal">
        <div class="content">
          <h2 class="title">🗺️ Rutas personalizadas</h2>
          <p>Define tus trayectos, puntos de subida y bajada, y adapta el viaje a tu ritmo. La app se ajusta a tus necesidades.</p>
        </div>
      </article>
    </div>
  </div>

  <!-- 🟢 Sección con imágenes y explicación (oscura y translúcida) -->
  <section class="drivo-illustration mt-6 columns is-multiline dark-box">
    <div class="column is-half">
      <figure class="image is-4by3">
        <img src="{{ asset('img/users.jpg') }}" alt="Usuarios">
      </figure>
      <h3 class="title is-4 mt-2">👥 Comunidad activa</h3>
      <p>Miles de usuarios compartiendo sus trayectos, creando experiencias confiables y sociales.</p>
    </div>

    <div class="column is-half">
      <figure class="image is-4by3">
        <img src="{{ asset('img/comodidad.webp') }}" alt="Comodidad">
      </figure>
      <h3 class="title is-4 mt-2">🛋️ Comodidad y flexibilidad</h3>
      <p>Elige tu asiento, horarios y puntos de subida o bajada según tus necesidades. Viajar nunca fue tan cómodo y personalizado.</p>
    </div>

    <div class="column is-half mt-4">
      <figure class="image is-4by3">
        <img src="{{ asset('img/ahorro.jpg') }}" alt="Ahorro">
      </figure>
      <h3 class="title is-4 mt-2">💰 Ahorro inteligente</h3>
      <p>Comparte gastos de viaje, reduce gastos y contribuye al ahorro colectivo.</p>
    </div>

    <div class="column is-half mt-4"> 
      <figure class="image is-4by3"> 
        <img src="{{ asset('img/ecologia.jpg') }}" alt="Ecología"> 
      </figure> 
      <h3 class="title is-4 mt-2">🌱 Eco-friendly</h3> 
      <p>Menos autos en la calle significa menos contaminación y un planeta más limpio.</p> 
    </div>
  </section>

</div>

<style>
/* 🔹 Sección principal */
.drivo-hero-box {
  background: linear-gradient(135deg, #ffd700, #fd43a0);
  color: #fff;
  text-align: center;
  border-radius: 16px;
  padding: 3rem 2rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.25);
}

.drivo-hero-box .title {
  font-size: 2.2rem;
  font-weight: 800;
  margin-bottom: 1rem;
}

.drivo-hero-box .subtitle {
  font-size: 1.3rem;
  margin-bottom: 2rem;
}

.features-list {
  font-size: 1.1rem;
  font-weight: 600;
  line-height: 2;
}

/* 🔸 Tiles destacados */
.drivo-tile {
  border-radius: 12px;
  color: #fff;
  text-align: center;
  padding: 2rem 1rem;
  font-weight: 600;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.drivo-tile:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 20px rgba(0,0,0,0.25);
}

.drivo-tile.is-orange { background: #ff8c42; }
.drivo-tile.is-purple { background: #9b59b6; }
.drivo-tile.is-teal { background: #1abc9c; }

/* 🔹 Sección ilustraciones oscura y translúcida */
.drivo-illustration.dark-box {
  background: rgba(0, 0, 0, 0.7); /* fondo oscuro con transparencia */
  padding: 2rem;
  border-radius: 16px;
  color: #fff; /* texto blanco */
}

.drivo-illustration.dark-box .title,
.drivo-illustration.dark-box p {
  color: #fff;
}

.drivo-illustration.dark-box figure {
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0,0,0,0.5);
}
</style>
