@include('header')

<div class="form-background">
    <div class="form-overlay">
        <div class="container content">

            <h1 class="title has-text-white has-text-centered my-4" style="font-weight: 600;">
                🆘 Centro de Ayuda – Drivo
            </h1>

            <div class="columns is-multiline">

                <!-- ¿Qué es Drivo? -->
                <div class="column is-full">
                    <div class="card term-card">
                        <div class="card-content">
                            <p class="subtitle has-text-white">
                                <span class="icon term-icon"><i class="fas fa-car-side"></i></span>
                                <strong>🚘 ¿Qué es Drivo?</strong>
                            </p>
                            <p class="has-text-white">
                                Drivo es una plataforma que conecta a conductores y pasajeros que desean compartir viajes urbanos o interurbanos. Su objetivo es ofrecer una forma más económica, flexible y sustentable de trasladarse, aprovechando los asientos disponibles en autos particulares.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ¿Cómo funciona? -->
                <div class="column is-full">
                    <div class="card term-card">
                        <div class="card-content">
                            <p class="subtitle has-text-white">
                                <span class="icon term-icon"><i class="fas fa-route"></i></span>
                                <strong>🧭 ¿Cómo funciona?</strong>
                            </p>
                            <p class="has-text-white">
                                Los conductores publican un viaje indicando origen, destino, fecha, hora y cantidad de asientos disponibles.<br><br>
                                Los pasajeros buscan viajes compatibles y reservan los asientos que necesiten.<br><br>
                                Una vez confirmada la reserva, ambas partes pueden comunicarse y realizar el viaje según lo acordado.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ¿Cómo se realiza una reserva? -->
                <div class="column is-full">
                    <div class="card term-card">
                        <div class="card-content">
                            <p class="subtitle has-text-white">
                                <span class="icon term-icon"><i class="fas fa-credit-card"></i></span>
                                <strong>💳 ¿Cómo se realiza una reserva?</strong>
                            </p>
                            <p class="has-text-white">
                                Ingresa a la sección <strong>Buscar viajes</strong>.<br>
                                Selecciona el viaje que te interese y haz clic en <strong>Enviar solicitud</strong>.<br>
                                Indica cuántos asientos necesitas, tu número de contacto y un comentario opcional.<br><br>
                                Si el conductor tiene activada la confirmación automática, tu reserva quedará confirmada al instante; de lo contrario, deberás esperar su aprobación.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ¿Quién puede publicar un viaje? -->
                <div class="column is-full">
                    <div class="card term-card">
                        <div class="card-content">
                            <p class="subtitle has-text-white">
                                <span class="icon term-icon"><i class="fas fa-id-card"></i></span>
                                <strong>🪪 ¿Quién puede publicar un viaje?</strong>
                            </p>
                            <p class="has-text-white">
                                Solo los usuarios registrados pueden publicar viajes. El conductor debe contar con:<br><br>
                                • Licencia de conducir vigente.<br>
                                • Vehículo con SOAP y revisión técnica al día.<br>
                                • Compromiso de cumplir con las condiciones del viaje publicadas en la app.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ¿Se permiten mascotas o fumar durante el viaje? -->
                <div class="column is-full">
                    <div class="card term-card">
                        <div class="card-content">
                            <p class="subtitle has-text-white">
                                <span class="icon term-icon"><i class="fas fa-paw"></i></span>
                                <strong>🐾 ¿Se permiten mascotas o fumar durante el viaje?</strong>
                            </p>
                            <p class="has-text-white">
                                Depende del conductor. En cada publicación verás si se permiten mascotas o fumar dentro del vehículo.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ¿Cómo cancelo una reserva o viaje? -->
                <div class="column is-full">
                    <div class="card term-card">
                        <div class="card-content">
                            <p class="subtitle has-text-white">
                                <span class="icon term-icon"><i class="fas fa-times-circle"></i></span>
                                <strong>❌ ¿Cómo cancelo una reserva o viaje?</strong>
                            </p>
                            <p class="has-text-white">
                                Si eres pasajero, puedes cancelar tu reserva desde la sección <strong>Mis reservas</strong>.<br>
                                Si eres conductor, puedes cancelar el viaje desde tu perfil de <strong>Viajes publicados</strong>.<br><br>
                                Se recomienda cancelar con anticipación para mantener una buena reputación en la comunidad.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Seguridad y confianza -->
                <div class="column is-full">
                    <div class="card term-card">
                        <div class="card-content">
                            <p class="subtitle has-text-white">
                                <span class="icon term-icon"><i class="fas fa-lock"></i></span>
                                <strong>🔒 Seguridad y confianza</strong>
                            </p>
                            <p class="has-text-white">
                                Verifica siempre el perfil y calificaciones del conductor o pasajero antes de viajar.<br>
                                Asegúrate de comunicarte solo a través de la plataforma.<br>
                                No compartas datos personales sensibles fuera de la aplicación.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ¿Necesitas más ayuda? -->
                <div class="column is-full">
                    <div class="card term-card">
                        <div class="card-content">
                            <p class="subtitle has-text-white">
                                <span class="icon term-icon"><i class="fas fa-envelope"></i></span>
                                <strong>📧 ¿Necesitas más ayuda?</strong>
                            </p>
                            <p class="has-text-white">
                                Si tienes dudas o problemas con tu cuenta, escríbenos a:<br>
                                <strong>soporte@drivo.cl</strong><br><br>
                                Nuestro equipo te responderá lo antes posible. 🚀
                            </p>
                        </div>
                    </div>
                </div>

            </div>

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
    background-color: rgba(0,0,0,0.75);
    border-radius: 15px;
    padding: 2rem;
    width: 90%;
    max-width: 1000px;
    margin: 0 auto;
    box-shadow: 0 0 25px rgba(0,0,0,0.5);
}

.term-card {
    background-color: rgba(255,255,255,0.1);
    border-radius: 12px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.3);
    padding: 1rem;
}

.term-card .subtitle {
    display: flex;
    align-items: center;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.term-icon {
    color: #FFD700; /* dorado */
    margin-right: 10px;
    font-size: 1.3rem;
}
.has-text-white {
    color: white !important;
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