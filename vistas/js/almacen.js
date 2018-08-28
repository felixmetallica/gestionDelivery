/*=============================================
        VARIABLE LOCAL STORAGE
=============================================*/

    if(localStorage.getItem("capturarRango") != null){

        $("#daterange-btn4 span").html(localStorage.getItem("capturarRango"));

    }else{

        $("#daterange-btn4 span").html('<i class="fa fa-calendar"></i> Rango de fecha')

    }

/*=========================================
        SELECCIONAR INSUMO/PRODUCTO
=========================================*/

    $('#formMovimiento').on("change", "select.insumoProdMovimiento", function(){

        var Codigo = $(this).val();
                        
        var datos = new FormData();
        datos.append("Codigo", Codigo);
        
        $.ajax({

                url: "ajax/almacen.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                    
                    $("#idProdInsMovimiento").val(respuesta["Id"]);
                    $("#tipoProdInsMovimiento").val(respuesta["Tipo"]);
                    $("#nombreProdInsMovimiento").val(respuesta["Nombre"]);

                }
        
        });       
 
    });

/*=========================================
            EDITAR MOVIMIENTO                   
=========================================*/

     $('.tablas tbody').on("click", "button.btnEditarMovimiento", function(){

        var idMovimiento = $(this).attr("idMovimiento");
        
        var datos = new FormData();
        datos.append("idMovimiento" ,idMovimiento);

        $.ajax({

            url: "ajax/almacen.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                if (respuesta["InsumosID"] != null) {

                    var idProdIns = respuesta["InsumosID"];
                    var tipo = "Insumo";
                    var Actual = '[{"id":"'+idProdIns+'","nombre":"'+respuesta["Nombre"]+'","tipo":"'+tipo+'","cantidad":"'+respuesta["Cantidad"]+'","tipoMov":"'+respuesta["Tipo"]+'"}]';
                    
                   

                } else {

                    var idProdIns = respuesta["ProductoID"];
                    var tipo = "Producto";
                    var Actual = '[{"id":"'+idProdIns+'","nombre":"'+respuesta["Nombre"]+'","tipo":"'+tipo+'","cantidad":"'+respuesta["Cantidad"]+'","tipoMov":"'+respuesta["Tipo"]+'"}]';
                    
                                        
                }

                if (respuesta["Tipo"] == "I") {

                    var tipoMomiviento = "Ingreso";

                } else {

                    var tipoMomiviento = "Egreso";

                }

                $("#idMovimiento").val(respuesta["AlmacenID"]);
                $("#einsumoProdMovimiento").html(respuesta["Nombre"]);
                $("#eidProdInsMovimiento").val(idProdIns);
                $("#enombreProdInsMovimiento").val(respuesta["Nombre"]);
                $("#etipoProdInsMovimiento").val(tipo);
                $("#efechaMovimiento").val(respuesta["Fecha"]);
                $("#etipoMovimiento").val(respuesta["Tipo"]);
                $("#etipoMovimiento").html(tipoMomiviento);
                $("#ecantidadMovimiento").val(respuesta["Cantidad"]);
                $("#edescripcionMovimiento").val(respuesta["Descripcion"]);
                $("#valoresActuales").val(Actual);
            }
        
        });

    })

    $('#formEditarMovimiento').on("change", "select.einsumoProdMovimiento", function(){

        var Codigo = $(this).val();
        console.log("Codigo", Codigo);
                        
        var datos = new FormData();
        datos.append("Codigo", Codigo);
        
        $.ajax({

                url: "ajax/almacen.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                    
                    $("#eidProdInsMovimiento").val(respuesta["Id"]);
                    $("#etipoProdInsMovimiento").val(respuesta["Tipo"]);
                    $("#enombreProdInsMovimiento").val(respuesta["Nombre"]);

                }
        
        });       
 
    });

/*=========================================
        ELIMINAR MOVIMIENTO                   
=========================================*/

    $('.tablas tbody').on("click", "button.btnEliminarMovimiento", function(){

        var idMovimiento = $(this).attr("idMovimiento");
        var tipoMovimiento = $(this).attr("tipoMov");
        var idInsProd = $(this).attr("idInsProd");
        var tipoInsProd = $(this).attr("tipoInsProd");
        var Cantidad = $(this).attr("cantidad");

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el movimiento?",
            type: "warning",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function(){

            setTimeout(function(){

                var datos = new FormData();
                    datos.append("eliminarMovimiento" ,idMovimiento);
                    datos.append("tipoMovimiento" ,tipoMovimiento);
                    datos.append("idInsProd" ,idInsProd);
                    datos.append("tipoInsProd" ,tipoInsProd);
                    datos.append("Cantidad" ,Cantidad);
                
                $.ajax({
                    url:"ajax/almacen.ajax.php",
                    method:"POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){
                        
                        if(respuesta=="ok"){

                            swal({
                                title:"Movimiento eliminado!",
                                text:"¡Los datos se eliminaron correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="almacen";

                                    }

                                });

                        }else{

                            swal({
                                title:"Error!",
                                text:"¡No se pudo eliminar el movimiento!",
                                type:"error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="almacen";

                                    }

                                });

                        }

                    }

                });

            }, 1000);

        });

    })

/*==========================================
        RANGO DE FECHAS
==========================================*/
   
    $('#daterange-btn4').daterangepicker(
      {
        ranges   : {
          'Hoy'       : [moment(), moment()],
          'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 días' : [moment().subtract(6, 'days'), moment()],
          'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
          'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
          'Último mes'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment()
      },
      
      function (start, end) {
        
        $('#daterange-btn4 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        var fechaInicial = start.format('YYYY-MM-DD');
        
        var fechaFinal = end.format('YYYY-MM-DD');
        
        var capturarRango = $("#daterange-btn4 span").html();
               
        localStorage.setItem("capturarRango", capturarRango);

        window.location = "index.php?ruta=almacen&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

      }

    )

/*==========================================
        CANCELAR RANGO DE FECHAS
==========================================*/

    $(".daterangepicker.opensright .range_inputs .cancelBtn").on("click", function(){

        localStorage.removeItem("capturarRango");
        localStorage.clear();
        window.location = "almacen";
    })

/*==========================================
        CAPTURAR HOY
===========================================*/

    $(".daterangepicker.opensright .ranges li").on("click", function(){

        var textoHoy = $(this).attr("data-range-key");

        if(textoHoy == "Hoy"){

            var d = new Date();
            var dia = d.getDate();
            var mes = d.getMonth()+1;
            var año = d.getFullYear();

            if(dia < 10){

                var fechaInicial = año+"-0"+mes+"-0"+dia;

                var fechaFinal = año+"-0"+mes+"-0"+dia;

            }else if(mes < 10){

                var fechaInicial = año+"-0"+mes+"-"+dia;

                var fechaFinal = año+"-0"+mes+"-"+dia;


            }else if(mes < 10 && dia < 10){

                var fechaInicial = año+"-0"+mes+"-0"+dia;

                var fechaFinal = año+"-0"+mes+"-0"+dia;

            }else{

                var fechaInicial = año+"-"+mes+"-"+dia;

                var fechaFinal = año+"-"+mes+"-"+dia;

            }

            localStorage.setItem("capturarRango", "Hoy");

            window.location = "index.php?ruta=almacen&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

        }

    })