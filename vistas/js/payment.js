/*=========================================
        CARGAR TABLA LIQUIDACION GRUPAL
=========================================*/

    var table = $(".tablaLiquidacionGrupal").DataTable({

        "ajax":"ajax/tablaLiquidacionesGrupales.ajax.php",
        "autoWidth": true,
        "columnDefs": [
            {
                'targets': 0,
                'checkboxes': {
                   'selectRow': true
                },

            }
         ],
         'select': {
         'style': 'multi'
         },
         'order': [[1, 'asc']],
         "language": {

            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },

    });

/*=========================================
        EDITAR CONCEPTO
=========================================*/

    $('.tablas tbody').on("click", "button.btnEditarConcepto", function(){

        var idConcepto = $(this).attr("idConcepto");

        var datos = new FormData();
        datos.append("idConcepto" ,idConcepto);

        $.ajax({

            url: "ajax/payment.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){


                if (respuesta["Porcentaje"] == "S") {

                    var porcentaje = "Si";

                } else {

                    var porcentaje = "No";

                }

                if (respuesta["Fijo"] == "S") {

                    var fijo = "Si";

                } else {

                    var fijo = "No";

                }

                switch(respuesta["Tipo"]) {

                    case "1":

                        var tipo = "Remunerativo";

                        break;

                    case "2":

                        var tipo = "No remunerativo";

                        break;

                    case "3":

                        var tipo = "Retención";

                        break;

                }


                $("#nombreIsumoModal").html("Editar concepto "+respuesta["Descripcion"]);
                $("#idConceptoE").val(respuesta["ConceptoID"]);
                $("#descConceptoE").val(respuesta["Descripcion"]);

                $("#porcentajeConceptoE").html(porcentaje);
                $("#porcentajeConceptoE").val(respuesta["Porcentaje"]);

                $("#tipoConceptoE").html(tipo);
                $("#tipoConceptoE").val(respuesta["Tipo"]);

                $("#fijoConceptoE").html(fijo);
                $("#fijoConceptoE").val(respuesta["Fijo"]);

                $("#codConceptoE").val(respuesta["Codigo"]);

                $("#eunidadesConcepto").val(respuesta["Unidades"]);


            }

        });

    })

/*=========================================
        ELIMINAR CONCEPTO
=========================================*/

    $(".tablas").on("click", ".btnEliminarConcepto", function(){

        var idConcepto = $(this).attr("idConcepto");
        var nombre = $(this).attr("nombre");

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el concepto "+nombre+"?",
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
            datos.append("eliminarConcepto", idConcepto);

            $.ajax({
                url:"ajax/payment.ajax.php",
                method:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta=="ok"){

                        swal({
                        title:"Concepto eliminado!",
                        text:"¡El concepto se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="conceptos";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar el concepto!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="conceptos";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });


    })

/*=========================================
        HABILITAR BOTONES
=========================================*/
    $('#fornNuevaBoleta').on("change", "select.empleadoBoleta", function(){

        $('#tipoLiquidacionBoleta').removeAttr("disabled");

    });

    $('#fornNuevaBoleta').on("change", "select.tipoLiquidacionBoleta", function(){

        $( ".btnComenzarLiquidacion" ).removeClass("btn-disabled disabled");

    });

/*=========================================
        COMENZAR LIQUIDACION
=========================================*/

    $('#fornNuevaBoleta').on("click", "button.btnComenzarLiquidacion", function(){

        var idEmpleado = $('select[name=empleadoBoleta]').val();
        var tipo = $('select[name=tipoLiquidacionBoleta]').val();
        var tipoBoleta = $('#tipoLiquidacionBoleta option:selected').attr("tipo");
        var idBoleta = $("#idBoletaLiquidacion").val();

        switch(tipoBoleta) {
            case "Mensual":
                window.location = "index.php?ruta=crear-boleta&idEmpleado="+idEmpleado+"&tipoLiquidacion="+tipo;
                break;
            case "Parcial":
                swal({
                      title: "Liquidacion parcial",
                      text: "Ingrese la cantidad de días",
                      type: "input",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      confirmButtonText: "Aceptar",
                      cancelButtonText: "Cancelar",
                      inputPlaceholder: "Ingrese cantidad de días"
                    },
                    function(inputValue){
                      if (inputValue === false) return false;

                      if (inputValue === "") {

                        swal.showInputError("Debe ingresar una cantidad!");

                        return false

                      }

                        window.location = "index.php?ruta=crear-boleta&idEmpleado="+idEmpleado+"&tipoLiquidacion="+tipo+"&cantidad="+inputValue;


                    });
                break;
            case "Vacaciones":
                swal({
                      title: "Vacaciones",
                      text: "Ingrese la cantidad de días",
                      type: "input",
                      showCancelButton: true,
                      closeOnConfirm: false,
                      confirmButtonText: "Aceptar",
                      cancelButtonText: "Cancelar",
                      inputPlaceholder: "Ingrese cantidad de días"
                    },
                    function(inputValue){
                      if (inputValue === false) return false;

                      if (inputValue === "") {

                        swal.showInputError("Debe ingresar una cantidad!");

                        return false

                      }

                        window.location = "index.php?ruta=crear-boleta&idEmpleado="+idEmpleado+"&tipoLiquidacion="+tipo+"&dias="+inputValue;


                    });
                break;
            case "Aguinaldo":
                window.location = "index.php?ruta=crear-boleta&idEmpleado="+idEmpleado+"&tipoLiquidacion="+tipo;
                break;

        }


    });

/*=========================================
        AGREGAR CONCEPTO A LIQUIDACION
=========================================*/

    $(".btnAgregarConceptoBoleta").click(function(){

        var idConcepto = $('select[name=conceptoAgregar]').val();
        var sueldoBase = $('.SueldoBasico').attr("sueldo");
        var valorInicialVaca = $('.valorVaca').attr('valorVaca');
        var valorAntiguedad = $('.Anti').attr("valorAntiguedad");

        if (valorAntiguedad == undefined) {

            var baseCalculo = Number(sueldoBase);

        } else {

            var baseCalculo = Number(sueldoBase) + Number(valorAntiguedad);

        }

        var sueldoSuma=0;

        $(".sumarSueldo").each(function(){
            sueldoSuma+=parseFloat($(this).html()) || 0;
        });

        var exitenRemu=0;

        $(".nuevaDescripcionConcepto ").each(function(){

            var conceptosEnTabla = $(this).html();

            if (conceptosEnTabla=="Vacaciones") {

                $('.claseVacaMonto').html('');

            }

        });

        //AGREGAR NUEVO CONCEPTO A LA LIQUIDACION

        var datos = new FormData();
        datos.append("idConcepto" ,idConcepto);

            $.ajax({

                url: "ajax/payment.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    switch(respuesta["Tipo"]) {

                        case "1":

                            //HABERES REMUNERATIVOS
                            switch(respuesta["Descripcion"]) {

                                case "Presentismo":

                                    if (respuesta["Porcentaje"] =="N") {

                                        var cantidad = $('#unidadesConcepto').val();
                                        var unidades = 1;
                                        var valorConcepto = Number(cantidad);

                                    } else {

                                        var unidades = $('#unidadesConcepto').val();
                                        var valorConcepto = (sueldoBase*unidades)/100;

                                    }


                                break;

                                case "Feriados":

                                    if (respuesta["Porcentaje"] =="N") {

                                        var cantidad = $('#unidadesConcepto').val();
                                        var unidades = 1;
                                        var valorConcepto = Number(cantidad);

                                    } else {

                                        var cantidad = $('#unidadesConcepto').val();
                                        var unidades = cantidad;
                                        var valorConcepto = Number(baseCalculo/25) * Number(unidades);

                                    }

                                break;

                                case "Inasistencias":

                                    if (respuesta["Porcentaje"] =="N") {

                                        var cantidad = $('#unidadesConcepto').val();
                                        var unidades = 1;
                                        var valorConcepto = Number(-cantidad);

                                    } else {

                                        var cantidad = $('#unidadesConcepto').val();
                                        var unidades = cantidad;
                                        var valorConcepto = Number(-sueldoBase/30) * unidades;

                                    }

                                break;

                                case "Horas Extra":

                                    if (respuesta["Porcentaje"] =="N") {

                                        var cantidad = $('#unidadesConcepto').val();
                                        var unidades = 1;
                                        var valorConcepto = Number(cantidad);

                                    } else {

                                        var cantidad = $('#unidadesConcepto').val();
                                        var unidades = cantidad;
                                        var valorHora = baseCalculo/180;
                                        var valorConcepto = (Number(valorHora)*2)*cantidad;

                                    }

                                break;

                                default:

                                    if (respuesta["Porcentaje"] =="N") {

                                        var cantidad = $('#unidadesConcepto').val();
                                        var unidades = 1;
                                        var valorConcepto = Number(cantidad);


                                    } else {

                                        var cantidad = $('#unidadesConcepto').val();
                                        var unidades = cantidad;
                                        var valorConcepto = Number(sueldoBase/25) * unidades;


                                    }

                            }

                            $("#agregarConcepto" ).closest( "tr" ).after('<tr>'+
                                                                                '<th scope="row"><div class="material-addone"><button type="button" class="btn btn-mini btn-danger p-1 quitarConcepto" idConcepto="'+respuesta["ConceptoID"]+'"><i class="icofont icofont-close"></i></button> '+respuesta["Codigo"]+' </div></th>'+
                                                                                '<td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'+respuesta["ConceptoID"]+'" descripcionConcepto="'+respuesta["Descripcion"]+'" tipoConcepto="'+respuesta["Tipo"]+'" fijoConcepto="'+respuesta["Fijo"]+'">'+respuesta["Descripcion"]+'</span></td>'+
                                                                                '<td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'+unidades+'">'+unidades+'.00</span></td>'+
                                                                                '<td class="text-center"><span id="sumarSueldo" class="sumarSueldo valorConcepto" valorConcepto="'+valorConcepto.toFixed(2)+'">'+valorConcepto.toFixed(2)+'</spam></td>'+
                                                                                '<td class="text-center"></span></td>'+
                                                                                '<td class="text-center"></td>'+
                                                                            '</tr>');

                        break;
                        //-----------------------------FIN HABERES REMUNERATIVOS---------------------------------------------------------------------------------------------
                        case "2":

                            //HABERES NO REMUNERATIVOS
                            if (respuesta["Porcentaje"] =="N") {

                                var cantidad = $('#unidadesConcepto').val();
                                var unidades = 1;
                                var valorConcepto = Number(cantidad);

                            } else {

                                var cantidad = $('#unidadesConcepto').val();
                                var unidades = cantidad;
                                var valorConcepto = (Number(sueldoBase) * Number(unidades))/100;

                            }

                            $("#agregarConcepto" ).closest( "tr" ).after('<tr>'+
                                                                            '<th scope="row"><div class="material-addone"><button type="button" class="btn btn-mini btn-danger p-1 quitarConcepto" idConcepto="'+respuesta["ConceptoID"]+'"><i class="icofont icofont-close"></i></button> '+respuesta["Codigo"]+' </div></th>'+
                                                                            '<td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'+respuesta["ConceptoID"]+'" descripcionConcepto="'+respuesta["Descripcion"]+'" tipoConcepto="'+respuesta["Tipo"]+'" fijoConcepto="'+respuesta["Fijo"]+'">'+respuesta["Descripcion"]+'</span></td>'+

                                                                            '<td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'+unidades+'">'+unidades+'.00</span></td>'+
                                                                            '<td></td>'+
                                                                            '<td class="text-center"><span id="sumarNoRemunerativos" class="sumarNoRemunerativos valorConcepto" valorConcepto="'+valorConcepto.toFixed(2)+'">'+valorConcepto.toFixed(2)+'</span></td>'+
                                                                            '<td></td>'+
                                                                        '</tr>');



                        break;
                        //-----------------------------FIN HABERES NO REMUNERATIVOS---------------------------------------------------------------------------------------------
                        case "3":

                            //RETENCIONES

                            var trimed = respuesta["Descripcion"].substring(0, 3);
                            var cantidad = $('#unidadesConcepto').val();
                            var unidades = cantidad;
                            var valorConcepto = (Number(sueldoSuma) * Number(unidades))/100;



                            $("#agregarConcepto" ).closest( "tr" ).after('<tr>'+
                                                                        '<th scope="row"><div class="material-addone"><button type="button" class="btn btn-mini btn-danger p-1 quitarConcepto" idConcepto="'+respuesta["ConceptoID"]+'"><i class="icofont icofont-close"></i></button> '+respuesta["Codigo"]+' </div></th>'+
                                                                        '<td><span id="nuevaDescripcionConcepto" class="nuevaDescripcionConcepto" idConcepto="'+respuesta["ConceptoID"]+'" descripcionConcepto="'+respuesta["Descripcion"]+'" tipoConcepto="'+respuesta["Tipo"]+'" fijoConcepto="'+respuesta["Fijo"]+'">'+respuesta["Descripcion"]+'</span></td>'+

                                                                        '<td class="text-center"><span id="unidades" class="unidades" unidadesConcepto="'+unidades+'">'+unidades+'.00</span></td>'+
                                                                        '<td></td>'+
                                                                        '<td></td>'+
                                                                        '<td class="text-center"><span id="sumarRetencion" class="sumarRetencion retencion'+trimed+' valorConcepto" valorConcepto="'+valorConcepto.toFixed(2)+'" nuevareten="S" unidadesReten="'+unidades+'">'+valorConcepto.toFixed(2)+'</spam></td>'+
                                                                    '</tr>');

                        break;
                        //-----------------------------FIN HABERES RETENCION---------------------------------------------------------------------------------------------
                        default:
                        //console.log('default');
                    }


                }//-----------------------------FIN RESPUESTA AJAX---------------------------------------------------------------------------------------------


            });


            //calculamos los nuevos montos de las retenciones
            setTimeout(function(){

                sumarRemunerativos();



            },7);

            setTimeout(function(){
                sumarNoRemunerativos();

                calcularRetenciones();

            },115);

            //COMPRUEBO SI HAY VACACIONES PARA LIBERAR EL BOTON


            $(".nuevaDescripcionConcepto").each(function(){

                vacas = $(this).html();

                if (vacas == "Vacaciones") {

                    $( ".btnCalcularVacaciones" ).removeClass("btn-disabled disabled");
                    $( ".btnCalcularVacaciones" ).attr("deactivado", 0);
                    $( ".btnConfirmarLiquidacion" ).addClass("btn-disabled disabled");
                    $( ".btnConfirmarLiquidacion" ).attr("type", "button");

                }

            });



        $("#modalAgregarConceptoBoleta .close").click();


    });

/*=========================================
        QUITAR CONCEPTO DE LIQUIDACION
=========================================*/

    $('#fornNuevaBoleta').on("click", "button.quitarConcepto", function(){

        $(this).parent().parent().parent().remove();

        var montoVacacionActual = $('.claseVacaMonto').attr("valorconcepto");

        if (montoVacacionActual != undefined) {

            var montoVacacionesOld = 0;

                $('.claseVacaMonto').html('');
                $('.claseVacaMonto').attr("valorconcepto",montoVacacionesOld.toFixed(2));

        }


        //calculamos los nuevos montos de las retenciones

            setTimeout(function(){

                calcularRetenciones();

                sumarRemunerativos();

                sumarNoRemunerativos();

            },7);

            setTimeout(function(){

               listarConceptos();

            },10);

            //COMPRUEBO SI HAY VACACIONES PARA LIBERAR EL BOTON

            $(".nuevaDescripcionConcepto").each(function(){

                vacas = $(this).html();

                if (vacas == "Vacaciones") {

                    $( ".btnCalcularVacaciones" ).removeClass("btn-disabled disabled");
                    $( ".btnCalcularVacaciones" ).attr("deactivado", 0);
                    $( ".btnConfirmarLiquidacion" ).addClass("btn-disabled disabled");
                    $( ".btnConfirmarLiquidacion" ).attr("type", "button");

                }

            });

    });

/*=========================================
        CALCULAR RETENCIONES
=========================================*/

    function calcularRetenciones(){

        //CALCULAR NUEVAMENTE LAS RETENCIONES

        var sueldoSuma=0;

        $(".sumarSueldo").each(function(){
            sueldoSuma+=parseFloat($(this).html()) || 0;
        });
            console.log("sueldoSuma", sueldoSuma);

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

                sumarRemunerativos();

            },100);

            setTimeout(function(){

                sumarRetenciones();

            },650);

            //SUMAMOS EL TOTAL DE LOS HABERES REMUNERATIVOS


            //CALCULAMOS EL NETO

            setTimeout(function(){

                sumarNeto();
                listarConceptos();

            },320);




    }

/*=========================================
        CALCULAR VACACIONES
=========================================*/

    $(".btnCalcularVacaciones").click(function(){

        var activo = $( ".btnCalcularVacaciones" ).attr("deactivado");
        var recalcula = $( ".btnCalcularVacaciones" ).attr("recalcula");

        if (activo == 0) {

            if (recalcula == 0) {

                var sumarRemunerativosV=0;

                $(".sumarSueldo").each(function(){

                    sumarRemunerativosV+=parseFloat($(this).html()) || 0;

                });

                var montoDiaVacaciones = sumarRemunerativosV/25;
                var diasVacaciones = $('.valorVaca').attr('valorVaca');

                var montoVacaciones = Number(montoDiaVacaciones) * Number(diasVacaciones);

                $('.claseVacaMonto').html(montoVacaciones.toFixed(2));
                $('.claseVacaMonto').attr("valorconcepto",montoVacaciones.toFixed(2));
                $( ".btnCalcularVacaciones" ).addClass("btn-disabled disabled");
                $( ".btnCalcularVacaciones" ).attr("deactivado", 1);
                $( ".btnCalcularVacaciones" ).attr("recalcula", 1);
                $( ".btnConfirmarLiquidacion" ).removeClass("btn-disabled disabled");
                $( ".btnConfirmarLiquidacion" ).attr("type", "submit");

                setTimeout(function(){

                    sumarRemunerativos();

                    sumarNoRemunerativos();

                    calcularRetenciones();

                },7);

                setTimeout(function(){

                    listarConceptos();

                },30);

            } else {

                var montoVacacionActual = $('.claseVacaMonto').attr("valorconcepto");

                var montoVacacionesOld = 0;

                $('.claseVacaMonto').html('');
                $('.claseVacaMonto').attr("valorconcepto",montoVacacionesOld.toFixed(2));

                var sumarRemunerativosV=0;

                $(".sumarSueldo").each(function(){

                    sumarRemunerativosV+=parseFloat($(this).html()) || 0;

                });

                $('.HaberesRemunerativos').html(sumarRemunerativosV.toFixed(2));
                $('#totalHaberesCdesc').val(sumarRemunerativosV.toFixed(2));

                calcularRetenciones();

                var montoDiaVacaciones = sumarRemunerativosV/25;
                var diasVacaciones = $('.valorVaca').attr('valorVaca');

                var montoVacaciones = Number(montoDiaVacaciones) * Number(diasVacaciones);

                $('.claseVacaMonto').html(montoVacaciones.toFixed(2));
                $('.claseVacaMonto').attr("valorconcepto",montoVacaciones.toFixed(2));
                $( ".btnCalcularVacaciones" ).addClass("btn-disabled disabled");
                $( ".btnCalcularVacaciones" ).attr("deactivado", 1);
                $( ".btnCalcularVacaciones" ).attr("recalcula", 1);
                $( ".btnConfirmarLiquidacion" ).removeClass("btn-disabled disabled");
                $( ".btnConfirmarLiquidacion" ).attr("type", "submit");

                //calculamos los nuevos montos de las retenciones
                setTimeout(function(){

                    sumarRemunerativos();

                    sumarNoRemunerativos();

                    calcularRetenciones();

                },7);

                setTimeout(function(){

                    listarConceptos();

                },30);

            }

        } //fin activo

    });

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
            console.log("noRemunerativos", noRemunerativos);

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
        SELECCIONAR CONCEPTOS
=========================================*/

    $('#modalAgregarConceptoBoleta').on('show.bs.modal', function (e) {

        $("#formAgregarConceptoBoleta")[0].reset();

        var tipoBoleta = $('#tipoLiquidacionBoleta option:selected').attr("tipo");

        var conceptos = [];

        $(".nuevaDescripcionConcepto").each(function(){

            conceptos.push({"Descripcion":$(this).html() });

        });

        var listadoConceptos = JSON.stringify(conceptos);

        var datos = new FormData();

        datos.append("traerConceptosLiquidar" ,listadoConceptos);
        datos.append("tipoBoleta" ,tipoBoleta);

        $.ajax({

            url: "ajax/payment.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                $('#conceptoAgregar option').remove();

                $("#conceptoAgregar").append('<option value="">Seleccione una opción</option>');

                $.each(respuesta,function(key, registro) {

                    $("#conceptoAgregar").append('<option value='+registro.ConceptoID+'>'+registro.Descripcion+'</option>');

                });

            }


        });



    });

/*=========================================
        EDITAR BOLETA
=========================================*/

    $(".tablas").on("click", ".btnEditarBoleta", function(){

        var idBoleta = $(this).attr("idBoleta");
        var idTipo = $(this).attr("tipoBoleta");
        var idEmpleado = $(this).attr("empleadoID");
        var tipo = $(this).attr("liquidacion");

        if (tipo !="Vacaciones") {

            window.location = "index.php?ruta=editar-boleta&idBoleta="+idBoleta+"&idEmpleado="+idEmpleado+"&tipoLiquidacion="+idTipo;

        } else {

            var datos = new FormData();

            datos.append("traigoConcepto" ,idBoleta);

            $.ajax({

                url: "ajax/payment.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    $.each(respuesta,function(key, registro) {

                        if (registro.Descripcion === "Vacaciones") {

                            var dias = Math.round(registro.Unidades);
                            window.location = "index.php?ruta=editar-boleta&idBoleta="+idBoleta+"&idEmpleado="+idEmpleado+"&tipoLiquidacion="+idTipo+"&dias="+dias;

                        }


                    });

                }


            });


        }


    });

/*=========================================
        ELIMINAR BOLETA
=========================================*/

    $(".tablas").on("click", ".btnEliminarBoleta", function(){

        var idBoleta = $(this).attr("idBoleta");
        var NombreEmpleado = $(this).attr("NombreBoleta");
        var ApellidoEmpleado = $(this).attr("ApellidoBoleta");

        var mes = $(this).attr("mes");
        var anio = $(this).attr("anio");
        var tipo = $(this).attr("tipo");

        swal({
            title: "¡Atencion!",
            text: "¿Eliminar liquidación "+tipo+" "+mes+" "+anio+" de "+NombreEmpleado+" "+ApellidoEmpleado+"?",
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
            datos.append("eliminarBoleta", idBoleta);

            $.ajax({
                url:"ajax/payment.ajax.php",
                method:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta==0){

                        swal({
                        title:"liquidación eliminada!",
                        text:"¡La liquidación se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="liquidaciones";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar la liquidacion!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="liquidaciones";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });






    })

/*=========================================
        DETALLE BOLETA
=========================================*/

    $(".tablas").on("click", ".btnDetalleBoleta", function(){

        var idBoleta = $(this).attr("idBoleta");

        //INFORMACION DE LA LIQUIDACION Y DEL EMPLEADO

        var datos = new FormData();
        datos.append("detalle" ,idBoleta);

        $.ajax({

            url: "ajax/payment.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                $(".tituloBoletaDetalle").html("Detalle liquidacion ("+ respuesta["Tipo"]+") "+ respuesta["Mes"]+"/"+respuesta["Anio"]+" de "+respuesta["Nombre"]+" "+respuesta["Apellido"]);
                $("#tipoBoletaDetalle").html(respuesta["Tipo"]);
                $("#empleadoBoletaDetalle").html(respuesta["Nombre"]+" "+respuesta["Apellido"]);
                $("#periodoBoletaDetalle").html(respuesta["Mes"]+"/"+respuesta["Anio"]);

                if (respuesta["Estado"] == "C") {

                    $("#estadoBoletaDetalle").html('<label class="label label-warning">Confeccionada</label>');

                } else {

                    $("#estadoBoletaDetalle").html('<label class="label label-success">Liquidada</label>');

                }

                $("#fechaConfeccionBoletaDetalle").html(respuesta["FechaConfeccion"]);
                $("#fechaLiquidacionBoletaDetalle").html(respuesta["FechaLiquidacion"]);
                $("#fechaPagoBoletaDetalle").html(respuesta["FechaPago"]);
                $("#totalRemunerativosBoletaDetalle").html(respuesta["TotalRemunerativos"]);

                if (respuesta["TotalNoRemunerativos"] == 0) {

                    $("#totalNoRemunerativosBoletaDetalle").html('');

                } else {

                    $("#totalNoRemunerativosBoletaDetalle").html(respuesta["TotalNoRemunerativos"]);

                }

                $("#totalRetencionesBoletaDetalle").html(respuesta["TotalRetenciones"]);
                $("#totalNetoBoletaDetalle").html('$'+respuesta["TotalNeto"]);

            }

        });

        $(".borrar").each(function(){

            $(this).closest('tr').remove();

        });

        //DETALLE DE LOS CONCEPTOS

        var datos = new FormData();
        datos.append("traigoConcepto" ,idBoleta);

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

                        switch(item.Tipo) {
                            case "1":
                                $("#ingresar" ).closest( "tr" ).before('<tr class="borrar">'+
                                                            '<th scope="row" class="text-center f-10">'+item.Codigo+'</th>'+
                                                            '<td class="text-left f-10">'+item.Descripcion+'</td>'+
                                                            '<td class="text-right f-10"">'+item.Unidades+'</td>'+
                                                            '<td class="text-right f-10"">'+item.Total+'</td>'+
                                                            '<td class="text-right f-10""></td>'+
                                                            '<td class="text-right f-10""></td>'+
                                                        '</tr>');
                                break;
                            case "2":
                                $("#ingresar" ).closest( "tr" ).before('<tr class="borrar">'+
                                                            '<th scope="row" class="text-center f-10">'+item.Codigo+'</th>'+
                                                            '<td class="text-left f-10">'+item.Descripcion+'</td>'+
                                                            '<td class="text-right f-10"">'+item.Unidades+'</td>'+
                                                            '<td class="text-right f-10""></td>'+
                                                            '<td class="text-right f-10"">'+item.Total+'</td>'+
                                                            '<td class="text-right f-10""></td>'+
                                                        '</tr>');
                                break;
                            case "3":
                                $("#ingresar" ).closest( "tr" ).before('<tr class="borrar">'+
                                                            '<th scope="row" class="text-center f-10">'+item.Codigo+'</th>'+
                                                            '<td class="text-left f-10">'+item.Descripcion+'</td>'+
                                                            '<td class="text-right f-10"">'+item.Unidades+'</td>'+
                                                            '<td class="text-right f-10""></td>'+
                                                            '<td class="text-right f-10""></td>'+
                                                            '<td class="text-right f-10"">'+item.Total+'</td>'+
                                                        '</tr>');
                                break;
                        }

                    }

                }

            });

    })

/*==========================================
        IMPRIMIR LIQUIDACION
==========================================*/

    $(".tablas").on("click", ".btnImprimirBoleta", function(){

        var idBoleta = $(this).attr("idBoleta");
        var estado = $(this).attr("estado");


        if (estado == "C") {

            swal({

                  title: "Realizar liquidación",
                  text: "Ingrese la fecha de pago",
                  type: "input",
                  inputType: 'date',
                  showCancelButton: true,
                  closeOnConfirm: false,
                  confirmButtonText: "Aceptar",
                  cancelButtonText: "Cancelar",
                  inputPlaceholder: "fecha de pago"
                },
                function(inputValue){

                  if (inputValue === false) return false;

                  if (inputValue === "") {

                    swal.showInputError("Debe ingresar una cantidad!");

                    return false

                  }
                    window.open("extensiones/tcpdf/pdf/liquidacion.php?liquidacion="+idBoleta+"&fechaPago="+inputValue, "_blank");

                    setTimeout(function(){
                      window.location="liquidaciones";
                    }, 10);

                });



        } else {

            swal({
                title:"¡Atencion!",
                text:"¿Desea imprimir la liquidación?",
                type:"warning",
                confirmButtonText: "Imprimir",
                cancelButtonText: "Cancelar",
                showCancelButton: true,
                closeOnConfirm: true
            },
                function(isConfirm){

                    if(isConfirm){

                       window.open("extensiones/tcpdf/pdf/liquidacion.php?liquidacion="+idBoleta, "_blank");
                       window.location="liquidaciones";

                    } else {

                        window.location="liquidaciones";

                    }
            });


        }

    })

/*=========================================
        IMPRIMIR LIQUIDACION GRUPAL
=========================================*/

    $(".btnLiquidarGrupal").on('click', function(e){

        var form = $("#formLiquidacionGrupal");
        var rowsel = table.column(0).checkboxes.selected();
        var lista = [];

        $.each(rowsel, function(index, rowId){

            $(form).append(

                        lista.push( rowId )
            )

        })

        var liquidaciones = jQuery.param(lista);

        var arrayValues = lista.join(',');

        swal({

          title: "Realizar liquidación",
          text: "Ingrese la fecha de pago",
          type: "input",
          inputType: 'date',
          showCancelButton: true,
          closeOnConfirm: false,
          confirmButtonText: "Aceptar",
          cancelButtonText: "Cancelar",
          inputPlaceholder: "fecha de pago"
        },
        function(inputValue){

          if (inputValue === false) return false;

          if (inputValue === "") {

            swal.showInputError("Debe ingresar una cantidad!");

            return false

          }
            window.open("extensiones/tcpdf/pdf/liquidacion-grupal.php?liquidaciones="+arrayValues+"&fechaPago="+inputValue, "_blank");

            setTimeout(function(){
              window.location="liquidaciones";
            }, 15);

        });

    })
