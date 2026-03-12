        <script type="text/javascript">

        function contCamas(){
            var _tot = 0;
            for(var c = 1; c < 11; c++){
                var _val = (($('#num_camas_'+c).val()=='')?0:$('#num_camas_'+c).val());
                _tot += parseInt(_val,10);   
            }
            $('#total_camas').attr('value',_tot);
        }

        function contCuartos(){
            var tot = 0;
            for(var c = 1; c < 11; c++){
                var _val = (($('#num_cuartos_' + c).val()=='')?0:$('#num_cuartos_' + c).val());
                tot += parseInt(_val,10);   
            }
            $('#total_cuartos').attr('value',tot);
        }

        function contOcupa(){
            var tot = 0;
            for(var c = 1; c < 11; c++){
                var _val = (($('#ocupacion_maxima_' + c).val()=='')?0:$('#ocupacion_maxima_' + c).val());
                tot += parseInt(_val,10);   
            }
            $('#total_ocupacion').attr('value',tot);
        }

        </script>
