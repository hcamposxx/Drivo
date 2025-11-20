<!-- Botón flotante para abrir el modal de tickets -->
@auth
<button id="btn-ticket" class="button is-rounded" title="Reportar un problema">
  <i class="fas fa-life-ring"></i>
</button>

<!-- Modal para crear ticket -->
<div id="ticketModal" class="modal">
  <div class="modal-background" onclick="closeTicketModal()"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">
        <span class="icon-text">
          <span class="icon"><i class="fas fa-headset"></i></span>
          <span>Reportar un Problema</span>
        </span>
      </p>
      <button class="delete" aria-label="close" onclick="closeTicketModal()"></button>
    </header>
    <section class="modal-card-body">
      <form id="ticketForm" method="POST" action="{{ route('tickets.store') }}">
        @csrf
        
        <!-- Asunto -->
        <div class="field">
          <label class="label">Asunto *</label>
          <div class="control has-icons-left">
            <input class="input" type="text" name="subject" placeholder="Ej: Problema con un viaje" required maxlength="255">
            <span class="icon is-small is-left">
              <i class="fas fa-tag"></i>
            </span>
          </div>
        </div>

        <!-- Descripción -->
        <div class="field">
          <label class="label">Descripción del problema *</label>
          <div class="control">
            <textarea class="textarea" name="description" placeholder="Describe detalladamente el problema que estás experimentando..." rows="5" required maxlength="2000"></textarea>
          </div>
          <p class="help">Máximo 2000 caracteres</p>
        </div>

        <!-- Prioridad -->
        <div class="field">
          <label class="label">Prioridad *</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select name="priority" required>
                <option value="baja">🟢 Baja - No es urgente</option>
                <option value="media" selected>🟡 Media - Necesito ayuda pronto</option>
                <option value="alta">🔴 Alta - Es urgente</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Información adicional -->
        <article class="message is-info is-small">
          <div class="message-body">
            <strong>💡 Tip:</strong> Incluye detalles como fecha, hora y capturas de pantalla si es posible. Te responderemos lo antes posible.
          </div>
        </article>

      </form>
    </section>
    <footer class="modal-card-foot">
      <button type="submit" form="ticketForm" class="button is-primary mr-2">
        <span class="icon"><i class="fas fa-paper-plane"></i></span>
        <span>Enviar Ticket</span>
      </button>
      <button class="button mr-2" onclick="closeTicketModal()">Cancelar</button>
      <a href="{{ route('tickets.index') }}" class="button is-ghost">
        <span class="icon"><i class="fas fa-history"></i></span>
        <span>Ver mis tickets</span>
      </a>
    </footer>
  </div>
</div>

<script>
  // Abrir modal
  document.getElementById('btn-ticket').addEventListener('click', function() {
    document.getElementById('ticketModal').classList.add('is-active');
  });

  // Cerrar modal
  function closeTicketModal() {
    document.getElementById('ticketModal').classList.remove('is-active');
    document.getElementById('ticketForm').reset();
  }

  // Cerrar con ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeTicketModal();
    }
  });
</script>

<style>
/* Botón flotante de soporte */
#btn-ticket {
  position: fixed;
  bottom: 100px; /* Arriba del botón de scroll */
  right: 30px;
  z-index: 998;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
  transition: transform 0.3s, box-shadow 0.3s;
  width: 56px;
  height: 56px;
  display: flex;
  align-items: center;
  justify-content: center;
}

#btn-ticket:hover {
  transform: scale(1.1) rotate(10deg);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
  background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}

#btn-ticket i {
  font-size: 1.5rem;
}

/* Animación de entrada */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

#btn-ticket {
  animation: fadeIn 0.5s ease-out;
}

/* Efecto pulsante */
@keyframes pulse {
  0%, 100% {
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
  }
  50% {
    box-shadow: 0 4px 25px rgba(102, 126, 234, 0.7);
  }
}

#btn-ticket {
  animation: pulse 2s infinite;
}
</style>
@endauth