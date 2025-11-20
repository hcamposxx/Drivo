@auth
<button id="btn-ticket" class="button is-rounded" title="Reportar un problema">
  <i class="fas fa-life-ring"></i>
</button>

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
      <!-- Mostrar errores de validación -->
      @if($errors->any())
      <div class="notification is-danger is-light">
        <button class="delete"></button>
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form id="ticketForm" method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="field">
          <label class="label">Asunto *</label>
          <div class="control has-icons-left">
            <input class="input" type="text" name="subject" value="{{ old('subject') }}" placeholder="Ej: Problema con un viaje" required maxlength="255">
            <span class="icon is-small is-left">
              <i class="fas fa-tag"></i>
            </span>
          </div>
        </div>

        <div class="field">
          <label class="label">Descripción del problema *</label>
          <div class="control">
            <textarea class="textarea" name="description" placeholder="Describe detalladamente el problema que estás experimentando..." rows="5" required maxlength="2000">{{ old('description') }}</textarea>
          </div>
          <p class="help">Máximo 2000 caracteres</p>
        </div>

        <div class="field">
          <label class="label">Imagen del problema *</label>
          <div class="file has-name is-fullwidth">
            <label class="file-label">
              <input class="file-input" type="file" name="image" id="imageInput" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" required onchange="updateFileName(this)">
              <span class="file-cta">
                <span class="file-icon">
                  <i class="fas fa-upload"></i>
                </span>
                <span class="file-label">
                  Seleccionar imagen...
                </span>
              </span>
              <span class="file-name" id="fileName">
                No se ha seleccionado ninguna imagen
              </span>
            </label>
          </div>
          <p class="help">Sube una captura de pantalla del problema (JPG, PNG, GIF, WEBP - Máx. 5MB)</p>
          
          <!-- Vista previa de la imagen -->
          <div id="imagePreview" class="mt-3" style="display: none;">
            <p class="has-text-weight-bold mb-2">Vista previa:</p>
            <figure class="image">
              <img id="previewImg" src="" alt="Vista previa" style="max-height: 200px; width: auto; border-radius: 8px; border: 2px solid #ddd;">
            </figure>
            <button type="button" class="button is-small is-danger mt-2" onclick="removeImage()">
              <span class="icon"><i class="fas fa-times"></i></span>
              <span>Quitar imagen</span>
            </button>
          </div>
        </div>

        <article class="message is-info is-small">
          <div class="message-body">
            <strong>💡 Tip:</strong> Una imagen clara del problema nos ayudará a resolverlo más rápido. Incluye detalles en la descripción.
          </div>
        </article>

      </form>
    </section>
    <footer class="modal-card-foot">
      <button type="submit" form="ticketForm" class="button is-primary">
        <span class="icon"><i class="fas fa-paper-plane"></i></span>
        <span>Enviar Ticket</span>
      </button>
      <button class="button" onclick="closeTicketModal()">Cancelar</button>
      <a href="{{ route('tickets.index') }}" class="button is-ghost">
        <span class="icon"><i class="fas fa-history"></i></span>
        <span>Ver mis tickets</span>
      </a>
    </footer>
  </div>
</div>

<style>
#btn-ticket {
  position: fixed;
  bottom: 100px;
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
  animation: fadeIn 0.5s ease-out, pulse 2s infinite;
}

#btn-ticket:hover {
  transform: scale(1.1) rotate(10deg);
  box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
  background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}

#btn-ticket i {
  font-size: 1.5rem;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes pulse {
  0%, 100% { box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); }
  50% { box-shadow: 0 4px 25px rgba(102, 126, 234, 0.7); }
}
</style>

<script>
document.getElementById('btn-ticket').addEventListener('click', function() {
  document.getElementById('ticketModal').classList.add('is-active');
});

function closeTicketModal() {
  document.getElementById('ticketModal').classList.remove('is-active');
  document.getElementById('ticketForm').reset();
  document.getElementById('fileName').textContent = 'No se ha seleccionado ninguna imagen';
  document.getElementById('imagePreview').style.display = 'none';
}

function updateFileName(input) {
  const fileName = input.files[0]?.name || 'No se ha seleccionado ninguna imagen';
  document.getElementById('fileName').textContent = fileName;
  
  // Mostrar vista previa
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('previewImg').src = e.target.result;
      document.getElementById('imagePreview').style.display = 'block';
    };
    reader.readAsDataURL(input.files[0]);
  }
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeTicketModal();
});
</script>
@endauth