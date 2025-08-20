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
</body>
</html>