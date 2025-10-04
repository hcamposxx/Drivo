<div class="modal micromodal-slide" id="modal-details" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
      <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
        <header class="modal__header">
          <h2 class="modal__title" id="modal-1-title">
            {{ $from ?? " "}} -> {{ $to ?? " "}}
          </h2>
          <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
        </header>
        <main class="modal__content" id="modal-1-content">
          <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <tr>
              <td align="center" colspan="2">
                <img src="" id="img_driver" alt="">
              </td>
            </tr>
            <tr>
              <th>Fecha: </th>
              <td id="txt_date"></td>
            </tr>
            <tr>
              <th>Hora: </th>
              <td id="txt_time"></td>
            </tr>

            <tr>
              <th>Asientos Disponibles: </th>
              <td id="txt_availables"></td>
            </tr>
            <tr>
              <th>Asientos Ocupados: </th>
              <td id="txt_occupied"></td>
            </tr>
            <tr>
              <th>Se aceptan mascotas?: </th>
              <td id="txt_pets"></td>
            </tr>
            <tr>
              <th>Se permite fumar?: </th>
              <td id="txt_smoking"></td>
            </tr>
            <tr>
              <td colspan="2"><strong>Punto de Salida:</strong> <span id="txt_pickup"></span> </td>            
            </tr>
            <tr>
              <td colspan="2"><strong>Punto de Llegada:</strong> <span id="txt_dropoff"></span></td> 
            </tr>
            <tr>
              <th>Comentarios del conductor: </th>
              <td>
                <code id="txt_details"></code> 
              </td>
            </tr>
            @if ((date($info->departure_date) <= $date && $info->departure_time < date('H:i:s')  ))
            <tr>
              <th colspan="2">Separar Asientos: </th>
            </tr>
            <tr>
                    <th>Cuántos asientos necesitas?:</th>
                    <td>
                        <div class="field">
                            <div class="control has-icons-left">
                                <input required class="input" type="number" id="modal_seats" max=4 min=1  value="1">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-chair"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>
            <tr>
                    <th>Telefono de contacto:</th>
                    <td>
                        <div class="field">
                            <div class="control has-icons-left">
                                <input required class="input" type="number" id="modal_phone" value="{{ optional(Auth::user())->phone }}">
                                <span class="icon is-small is-left">
                                    <i class="fas fa-phone"></i>
                                </span>
                            </div>
                        </div>
                    </td>
                </tr>
            <tr>
              <td colspan="2">
                <div class="field">                
                <div class="control has-icons-left">
                    <textarea rows="3" required class="input" id="modal_comment" placeholder="Escribe algo que el conductor deba saber"></textarea>
                </div>
            </div>
              </td>
            </tr>
            @endif 
          </table>
          <p>
            <form action="">
              <input type="hidden" name="modal_id_trip" id="modal_id_trip" value="-1">
            </form>
          </p>
        </main>
        <footer class="modal__footer">
          <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Cerrar</button>
          @if ((date($info->departure_date) <= $date && $info->departure_time < date('H:i:s')  ))
          
          
          @auth
          <button onclick="sendReservation()" class="modal__btn modal__btn-primary">Enviar solicitud</button>
          @else
          <a href="{{ route('login') }}" class="modal__btn modal__btn-primary">Enviar solicitud</a>
          @endauth
          @endif
        </footer>
      </div>
    </div>
  </div>