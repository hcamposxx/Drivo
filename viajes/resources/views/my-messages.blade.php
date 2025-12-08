@include('header')

<div class="form-background">
    <div class="form-overlay">
        <div class="container content has-text-centered">

            <h1 class="title my-3" style="color: white; font-weight: 600;">Mis Mensajes</h1>

            <div id="messagesContainer" class="columns is-multiline">
                <!-- Los mensajes se cargarán aquí con JavaScript -->
            </div>

        </div>
    </div>
</div>

@include('footer-content')
@include('footer')

<!-- Botón flotante para volver arriba -->
<button id="btn-scroll-top" class="button is-rounded" title="Volver arriba">
  <i class="fa fa-arrow-up"></i>
</button>

<style>
/* Fondo y overlay */
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

/* Tarjetas de mensajes */
.message-card {
    background-color: rgba(255,255,255,0.15);
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.3);
    padding: 20px;
    margin-bottom: 20px;
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 2px solid rgba(255, 215, 0, 0.3);
}

.trip-info {
    color: #ffd700;
    font-size: 1.1rem;
    font-weight: bold;
}

.message-date {
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.9rem;
}

.message-content {
    background-color: rgba(0, 0, 0, 0.3);
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
}

.message-label {
    color: #ffd700;
    font-weight: bold;
    margin-bottom: 5px;
}

.message-text {
    color: white;
    line-height: 1.6;
}

.response-section {
    background-color: rgba(255, 0, 234, 0.1);
    border-left: 4px solid #ff00eaff;
    padding: 15px;
    border-radius: 8px;
    margin-top: 15px;
}

.response-label {
    color: #ff00eaff;
    font-weight: bold;
    margin-bottom: 5px;
}

.no-response {
    color: rgba(255, 255, 255, 0.5);
    font-style: italic;
    text-align: center;
    padding: 20px;
}

.loading {
    text-align: center;
    padding: 50px;
    color: white;
}

#btn-scroll-top {
  position: fixed;
  bottom: 40px;
  right: 30px;
  display: none;
  z-index: 999;
  background-color: #f1ce04ff;
  color: white;
  border: none;
  box-shadow: 0 0 10px rgba(255, 215, 0, 0.4);
  transition: transform 0.2s, background-color 0.3s;
}

#btn-scroll-top:hover {
  background-color: #ff00eaff;
  transform: scale(1.1);
}
</style>

<script>
// Cargar mensajes al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    loadMyMessages();
});

function loadMyMessages() {
    const container = document.getElementById('messagesContainer');
    container.innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin fa-3x"></i><p>Cargando mensajes...</p></div>';

    $.ajax({
        url: "{{ route('getMyMessages') }}",
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.error) {
                container.innerHTML = '<div class="column is-full"><div class="notification is-danger">Error al cargar mensajes</div></div>';
                return;
            }

            if (response.messages.length === 0) {
                container.innerHTML = `
                    <div class="column is-full">
                        <div class="notification is-warning">
                            <p>No tienes mensajes enviados</p>
                            <p>Cuando envíes mensajes a conductores, aparecerán aquí</p>
                        </div>
                    </div>
                `;
                return;
            }

            let html = '';
            response.messages.forEach(function(msg) {
                const hasResponse = msg.response ? true : false;
                const responseReadBadge = hasResponse && !msg.response_read ? '<span class="tag is-success is-light is-small">Nueva respuesta</span>' : '';
                
                html += `
                    <div class="column is-full">
                        <div class="message-card">
                            <div class="message-header">
                                <div class="trip-info">
                                    <i class="fas fa-route"></i>
                                    ${msg.trip.departure_city.name} → ${msg.trip.arrival_city.name}
                                </div>
                                <div class="message-date">
                                    ${formatDate(msg.created_at)}
                                    ${responseReadBadge}
                                </div>
                            </div>

                            <div class="message-content">
                                <div class="message-label">
                                    <i class="fas fa-user"></i> Conductor: ${msg.trip.driver.name}
                                </div>
                                <div class="message-label" style="margin-top: 10px;">
                                    <i class="fas fa-envelope"></i> Tu mensaje:
                                </div>
                                <div class="message-text">
                                    ${msg.message}
                                </div>
                            </div>

                            ${hasResponse ? `
                                <div class="response-section">
                                    <div class="response-label">
                                        <i class="fas fa-reply"></i> Respuesta del conductor:
                                        <span style="float: right; font-size: 0.85rem; font-weight: normal; color: rgba(255,255,255,0.6);">
                                            ${formatDate(msg.response_date)}
                                        </span>
                                    </div>
                                    <div class="message-text">
                                        ${msg.response}
                                    </div>
                                </div>
                            ` : `
                                <div class="no-response">
                                    <i class="fas fa-clock"></i> Esperando respuesta del conductor
                                </div>
                            `}
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
        },
        error: function(err) {
            console.error("Error:", err);
            container.innerHTML = '<div class="column is-full"><div class="notification is-danger">Error al cargar los mensajes</div></div>';
        }
    });
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const day = String(date.getDate()).padStart(2, '0');
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const year = date.getFullYear();
    const hours = String(date.getHours()).padStart(2, '0');
    const minutes = String(date.getMinutes()).padStart(2, '0');
    return `${day}/${month}/${year} ${hours}:${minutes}`;
}

// Botón scroll top
window.addEventListener("scroll", function() {
    const btn = document.getElementById("btn-scroll-top");
    if (window.scrollY > 300) {
        btn.style.display = "flex";
    } else {
        btn.style.display = "none";
    }
});

document.getElementById("btn-scroll-top").addEventListener("click", function() {
    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
});
</script>