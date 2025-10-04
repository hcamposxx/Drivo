<script>

    $(document).ready(function(){

        $('#origen').select2({
            placeholder:"Origen",
            allowClear:true,
            ajax:{
                url:function(params){
                     $('#destino').val(null).trigger('change');
                    return "{{ route('city.index') }}";
                },
                dataType:'json',
                method:'GET',
                success:function(res){

                },
                error:function(res){

                }
            },
            language:{
                searching:function(){
                    return 'Cargando...';
                },
                noResults:function(){
                    return 'Sin resultados';
                }
            }
        });

        $('#destino').select2({
            placeholder:"Destino",
            allowClear:true,
            ajax:{
                url:function(params){
                    let ori =  $('#origen').val();
                    if(ori){
                        return `/api/ajax/getDestinations/${ori}`;
                    }
                },
                dataType:'json',
                method:'GET',
                success:function(res){

                },
                error:function(res){

                }
            },
            language:{
                searching:function(){
                    return 'Cargando...';
                },
                noResults:function(){
                    return 'Sin resultados';
                }
            }
        })

    });

</script>
@if ($errors->any())
<script>
    Swal.fire({
        position:'center-center',
        title: '{{ $errors->first() }}',
        icon: 'error',
        showConfirmButton: true,
        timer: 4500
    })
</script>

@endif

@if (session('mensaje'))
<script>
    Swal.fire({
        position:'center-center',
        title: "{{ session('mensaje')}}",
        icon: 'success',
        showConfirmButton: true,
        timer: 2500
    })
</script>

@endif
    <script src="https://cdn.jsdelivr.net/npm/micromodal/dist/micromodal.min.js"></script>
    <script>
        //inicializar micromodal
        document.addEventListener('DOMContentLoaded',function(){
            MicroModal.init();
        });
        
        function showDetails(id_trip, fecha, hora, disponibles, ocupados, mascotas, fumar, salida, llegada, detalle, foto){
            $('#modal_id_trip').val(id_trip);
            $('#txt_date').text(fecha);
            $('#txt_time').text(hora);
            $('#txt_availables').text(disponibles);
            $('#modal_seats').attr('max',disponibles);
            $('#txt_occupied').text(ocupados);
            $('#txt_pets').text(mascotas);
            $('#txt_smoking').text(fumar);
            $('#txt_pickup').text(salida);
            $('#txt_dropoff').text(llegada);
            $('#txt_details').text(detalle);
            $('#img_driver').attr('src',foto);
        }

        function sendReservation() {
            let token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url:`{{ route('save-reservation') }}`,
                type:'POST',
                dataType:'json',
                data:{
                    '_token': token,
                    'trip_id':$('#modal_id_trip').val(),
                    'phone':$('#modal_phone').val(),
                    'comment':$('#modal_comment').val(),
                    'seats':$('#modal_seats').val(),
                    'trip_id':$('#modal_id_trip').val(),
                    'passenger_id':'{{ optional(Auth::user())->id }}',
                },
                 success:function(res){
                    if(res.error){
                        Swal.fire({
                            position:'center-center',
                            title: res.message,
                            icon: 'error',
                            showConfirmButton: true,
                            timer: 3500
                            });
                    }else{
                        Swal.fire({
                            position:'center-center',
                            title: res.message,
                            icon: 'success',
                            showConfirmButton: true,
                            timer: 3500
                            }).then((result)=>{
                                if(result.isConfirmed || result.dismiss == Swal.DismissReason.timer){
                                    location.reload();
                                }
                            });
                    }
                },
                error:function(err){
                    Swal.fire({
                            position:'center-center',
                            title: "Upps",
                            icon: 'error',
                            showConfirmButton: true,
                            timer: 3500
                            });
                            console.log(err);

                }
            })

        }

        function saveTrip() {
            let token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url:`{{ route('save-trip') }}`,
                type:'POST',
                dataType:'json',
                data:{
                    '_token': token,
                    'departure_city_id':$('#origen').val(),
                    'arrival_city_id':$('#destino').val(),
                    'available_seats':$('#asientos').val(),
                    'behind_available_seats':$('#libre').val(),
                    'car_plate':$('#placa').val(),
                    'car_color':$('#color').val(),
                    'car_brand':$('#marca').val(),
                    'driver_id':'{{ optional(Auth::user())->id }}',
                    'departure_date':$('#fecha').val(),
                    'departure_time':$('#hora').val(),
                    'pickup_point':$('#recogida').val(),
                    'dropoff_point':$('#llegada').val(),
                    'price_per_seat':$('#precio').val(),
                    'smoking_allowed':$('#fumar').val(),
                    'pets_allowed':$('#mascota').val(),
                    'phone':$('#celular').val(),
                    'details':$('#detalles').val(),
                    'automatic_reservation':$('#automatica').val(),
                    'trip_duration':$('#duracion').val(),
                },
                 success:function(res){
                    console.log(res)
                    if(res.error){
                        Swal.fire({
                            position:'center-center',
                            title: res.message,
                            icon: 'error',
                            showConfirmButton: true,
                            timer: 3500
                            });
                    }else{
                        Swal.fire({
                            position:'center-center',
                            title: res.message,
                            icon: 'success',
                            showConfirmButton: true,
                            timer: 3500
                            }).then((result)=>{
                                if(result.isConfirmed || result.dismiss == Swal.DismissReason.timer){
                                    location.href = `/search/${$('#origen').val()}/${$('#destino').val()}/${$('#fecha').val()}/1/departure_time/-1`
                                }
                            });
                    }
                },
                error:function(err){
                    Swal.fire({
                            position:'center-center',
                            title: "Upps",
                            icon: 'error',
                            showConfirmButton: true,
                            timer: 3500
                            });
                            console.log(err);

                }
            })

        }


        


    </script>
</body>
</html>