/*=========================================
        CALCULAR RETENCIONES
=========================================*/

    function calcularRetenciones(){

        //CALCULAR NUEVAMENTE LAS RETENCIONES

        var sueldoSuma=0;
                
        $(".sumarSueldo").each(function(){
            sueldoSuma+=parseFloat($(this).html()) || 0;
        });

        var datos = new FormData();
        datos.append("traerRetenciones" ,"ok");

            $.ajax({

                url: "ajax/payment.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                                                                                
                    respuesta.forEach(funcionForEach);

                    function funcionForEach(item, index){

                        var concepto = item.Descripcion;
                        var res = concepto.substring(0, 3);
                        var unidades = item.Unidades;
                                              
                        var nuevaRetenc = $('.retencion'+res).attr("nuevareten");

                        var unidadesRetenActual = $('.retencion'+res).attr("unidadesReten");

                        if (nuevaRetenc == "S") {

                            var valor = (sueldoSuma*unidadesRetenActual)/100;

                        } else {

                            var valor = (sueldoSuma*unidades)/100;

                        }

                        $('.retencion'+res).html(valor.toFixed(2));

                        $('.retencion'+res).attr("valorConcepto",valor.toFixed(2));
                                               
                    }
          
                }

            });


            //SUMAMOS EL TOTAL DE LAS RETENCIONES
            
            setTimeout(function(){

                sumarRetenciones();
                       
            },300);

            //SUMAMOS EL TOTAL DE LOS HABERES REMUNERATIVOS
            sumarRemunerativos();

            //CALCULAMOS EL NETO
            
            setTimeout(function(){

                sumarNeto();
                       
            },320);
            

           

    }

/*=========================================
        SUMAR RETENCIONES
=========================================*/

    function sumarRetenciones(){

        var retencionSuma=0;
        
        $(".sumarRetencion").each(function(){
                
            retencionSuma+=parseFloat($(this).html()) || 0;

        });                   
        
        $('.Retenciones').html(retencionSuma.toFixed(2));

        $('#totalRetencion').val(retencionSuma.toFixed(2));        
        
        

    }

/*=========================================
        SUMAR REMUNERATIVOS
=========================================*/

    function sumarRemunerativos(){

        var sueldoSuma=0;
                
        $(".sumarSueldo").each(function(){
            
            sueldoSuma+=parseFloat($(this).html()) || 0;
        
        });

        $('.HaberesRemunerativos').html(sueldoSuma.toFixed(2));

        $('#totalHaberesCdesc').val(sueldoSuma.toFixed(2));

        


    }

/*=========================================
        SUMAR NO REMUNERATIVOS
=========================================*/

    function sumarNoRemunerativos(){

        var noRemunerativos=0;
                        
        $(".sumarNoRemunerativos").each(function(){
            
            noRemunerativos+=parseFloat($(this).html()) || 0;
        
        });

        if (noRemunerativos==0) {

            $('.HaberesNoRemunerativos').html('');

        } else {

            $('.HaberesNoRemunerativos').html(noRemunerativos.toFixed(2));

        }

        

        $('#totalHaberesSdesc').val(noRemunerativos.toFixed(2));

        


    }

/*=========================================
        SUMAR NETO
=========================================*/

    function sumarNeto(){

        //sumo remunerativos
        var totalRemu=0;
                
        $(".sumarSueldo").each(function(){
            
            totalRemu+=parseFloat($(this).html()) || 0;
        
        });

        //sumo no remunerativos

        var totalNoRemu=0;
                        
        $(".sumarNoRemunerativos").each(function(){
            
            totalNoRemu+=parseFloat($(this).html()) || 0;
        
        });

        //sumo retenciones

        var totalRetencion=0;
        
        $(".sumarRetencion").each(function(){
                
            totalRetencion+=parseFloat($(this).html()) || 0;

        });   
        
        var netoTotal = (totalRemu + totalNoRemu) - totalRetencion;
                
        $('#valorNeto').html('$'+ netoTotal.toFixed(2));

        $('#totalNetoBoleta').val(netoTotal);


    }

/*=========================================
        LISTAR TODOS LOS CONCEPTOS
=========================================*/

    function listarConceptos(){

        var listaConceptos = [];
      
        var descripcion = $(".nuevaDescripcionConcepto");
                       
        var unidades = $(".unidades"); 

        var total = $(".valorConcepto");
               
        for (var i = 0; i < descripcion.length; i++) {
            
            listaConceptos.push({"ConceptoID":$(descripcion[i]).attr("idConcepto"),
                                 "Descripcion":$(descripcion[i]).attr("descripcionConcepto"),
                                 "Tipo":$(descripcion[i]).attr("tipoConcepto"),
                                 "Fijo":$(descripcion[i]).attr("fijoConcepto"),
                                 "Unidades":$(unidades[i]).attr("unidadesConcepto"),
                                 "Total":$(total[i]).attr("valorConcepto") });

        }

        $("#listadoConceptos").val(JSON.stringify(listaConceptos));
        
    } 

/*=========================================
        CALCULAR TOTALES EDICION
=========================================*/

    function calcularTotalesEdicion(){

        console.log("estoy aqui");

        //calculamos los nuevos montos de las retenciones
            setTimeout(function(){

                sumarRemunerativos();

                sumarNoRemunerativos();
                       
            },500); 

            setTimeout(function(){

                calcularRetenciones();
                
                listarConceptos();

            },500);


    }

