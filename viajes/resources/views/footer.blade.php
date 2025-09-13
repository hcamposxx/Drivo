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
        })        
    </script>
</body>
</html>