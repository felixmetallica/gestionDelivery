/*=========================================
        VARIABLE LOCAL STORAGE
=========================================*/

    if(localStorage.getItem("capturarRango3") != null){

        $("#daterange-btn3 span").html(localStorage.getItem("capturarRango3"));


    }else{

        $("#daterange-btn3 span").html('<i class="fa fa-calendar"></i> Rango de fecha')

    }

/*=========================================
        CARGAR TABLA PROVEEDORES
=========================================*/

    var table = $(".tablaBuscarProveedores").DataTable({

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

        }

    });

/*=========================================
        SELECCIONAR PROVEEDOR
=========================================*/

    $('.tablaBuscarProveedores tbody').on("click", "button.btnSeleccionarProveedor", function(){

        var idProveedor = $(this).attr("idProveedor");

            var datos = new FormData();
            datos.append("traigoProveedor" ,idProveedor);

            $.ajax({

                url: "ajax/proveedores.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    $("#proveedorCompra").val(respuesta["RazonSocial"]);
                    $("#idProveedorCompra").val(respuesta["ProveedorID"]);
                    $("#modalBuscarProveedor .close").click()

                }
            });
        })

/*=========================================
        CARGAR TABLA INSUMOS/PRODUCTOS
=========================================*/

    var table2 = $(".tablaInsumosCompra").DataTable({

        "ajax":"ajax/tablaInsumosCompra.ajax.php",

        "columnDefs": [

            {

              "targets": 0,
              "className": "text-center",
              "width": "5%"

            },

            {

              "targets": 1,
              "className": "text-center",
              "width": "10%"

            },

            {

              "targets": 2,
              "className": "p-l-20"

            },

            {

              "targets": 3,
              "className": "text-center"

            },

            {

            "targets": -1,
            "data": null,
            "defaultContent": '<div class="btn-group"><button class="btn btn-primary waves-effect waves-ligh agregarInsumo recuperarBoton"><i class="icofont icofont-plus"></i> Agregar</button></div>'

            }

         ],

         "language": {

            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Registros del _START_ al _END_ de _TOTAL_",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered":   "",
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

        }

    });


    //CARGAMOS LOS IDS EN LOS BOTONES DE ACCION

    $('.tablaInsumosCompra tbody').on( 'click', 'button.agregarInsumo', function () {

        if (window.matchMedia("(min-width:992px)").matches){

            var data2 = table2.row( $(this).parents('tr') ).data();

        } else {

            var data2 = table2.row( $(this).parents('tbody tr ul li') ).data();

        }

        var temp = data2[3].split(".");
        var idInProd = temp[0];
        var tipoProdInsum = temp[1];

        $(this).attr("tipo", tipoProdInsum);
        $(this).attr("idInProd", idInProd);

    });

/*=========================================
        AGREGAR INSUMOS/PRODUCTOS A LA COMPRA
=========================================*/

    $('.tablaInsumosCompra tbody').on("click", "button.agregarInsumo", function(){

        var idInProd = $(this).attr("idInProd");
        var tipo = $(this).attr("tipo");

        $(this).removeClass("btn-primary agregarInsumo");
        $(this).addClass("btn-default");

        var datos = new FormData();
        datos.append("idInProd", idInProd);
        datos.append("tipo", tipo);

        $.ajax({

                url: "ajax/compras.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    var descripcion = respuesta["Nombre"];
                    var precio = respuesta["PrecioCompra"];

                    $(".nuevoInsumo").append(

                        '<div class="row">'+
                            '<div class="col-sm-7">'+
                                '<div class="material-group">'+
                                    '<div class="material-addone">'+
                                        '<button type="button" class="btn btn-danger btn-mini waves-effect waves-light p-1 quitarInsumo" idInProd="'+idInProd+'"><i class="icofont icofont-close m-0"></i></button>'+
                                    '</div>'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="text" class="form-control md-static nuevaDescripcionInsumo" name="descInsumoCompra" id="descInsumoCompra" idInProd="'+idInProd+'" value="'+descripcion+'" nombreInsumoProd="'+descripcion+'" tipoInsumoProd="'+tipo+'" readonly required>'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Descripción</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2 ingresoCantidad">'+
                                '<div class="material-group">'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="number" step="any" class="form-control form-control-right cantidadCompra" name="cantidadCompra" min="1" value="1">'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Cantidad</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-3 ingresoPrecio">'+
                                '<div class="material-group">'+
                                    '<div class="material-addone">'+
                                        '<i class="icofont icofont-cur-dollar"></i>'+
                                    '</div>'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="text" min="1" class="form-control precioInsumo form-control-right" name="precioInsumo" precioReal="'+precio+'" readonly value="'+precio+'" />'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Precio</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                         '</div>'

                        );

                    //SUMAMOS EL TOTAL CON ESTA FUNCION
                    sumarTotalPrecios();

                    //CALCULAMOS IMPUESTO
                    impuesto();

                    //LISTAMOS LOS INSUMOS PARA CREAR LA COMPRA
                    listarInsumos();

                    //DAR FORMATO A PRECIOS DE LOS INSUMOS
                    $(".precioInsumo").number(true, 2);

                }
            });

    });

/*=========================================
        QUITAR INSUMOS/PRODUCTOS DE LA COMPRA
=========================================*/

    $('#formNuevaCompra').on("click", "button.quitarInsumo", function(){

        $(this).parent().parent().parent().parent().remove();

        var idInProd = $(this).attr("idInProd");

        $("button.recuperarBoton[idInProd='"+idInProd+"']").removeClass('btn-default');

        $("button.recuperarBoton[idInProd='"+idInProd+"']").addClass('btn-primary agregarInsumo');

            if ($(".nuevoInsumo").children().length == 0 ) {

                $("#totalCompra").val(0);
                $("#totalCompraFinal").val(0);
                $("#totalCompra").attr("total", 0);
                $("#desRegargoCompra").val(0);
                $("#montoRecargo").val(0);
                $("#montoDescuento").val(0);
                $("#listadoInsumos").val(0);

            } else {

                //SUMAMOS EL TOTAL CON ESTA FUNCION
                sumarTotalPrecios();

                //CALCULAMOS EL IMPUESTO
                impuesto();

                //LISTAMOS LOS INSUMOS PARA CREAR LA COMPRA
                listarInsumos();

            }

    });

/*=========================================
        AGREGAR INSUMOS/PRODUCTOS DESDE EL BOTON
=========================================*/

    $(".btnAgregarInsumo").click(function(){

        var datos = new FormData();
        datos.append("traerInsumosPord", "ok");

        $.ajax({

                url: "ajax/compras.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    $(".nuevoInsumo").append(

                        '<div class="row">'+
                            '<div class="col-sm-7">'+
                                '<div class="material-group">'+
                                    '<div class="material-addone">'+
                                        '<button type="button" class="btn btn-mini btn-danger p-1 quitarInsumo" idInProd><i class="icofont icofont-close"></i></button>'+
                                    '</div>'+
                                    '<div class="form-group form-default form-static-label p-t-5">'+
                                        '<select class="form-control nuevaDescripcionInsumo" idInProd name="nuevaDescripcionInsumo" id="nuevaDescripcionInsumo" required>'+
                                            '<option value="">Seleccione el insumo</option>'+
                                        '</select>'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Descripción</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2 ingresoCantidad">'+
                                '<div class="material-group">'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="number" step="any" class="form-control form-control-right cantidadCompra" name="cantidadCompra" min="1" value="1">'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Cantidad</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-3 ingresoPrecio">'+
                                '<div class="material-group">'+
                                    '<div class="material-addone">'+
                                        '<i class="icofont icofont-cur-dollar"></i>'+
                                    '</div>'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="text" class="form-control form-control-right precioInsumo" precioReal name="precioInsumo" readonly />'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Precio</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'
                    );

                    //AGREGAR LOS PRODUCTOS AL SELECT

                    respuesta.forEach(funcionForEach);

                    function funcionForEach(item, index){

                        $(".nuevaDescripcionInsumo").append(

                            '<option idInProd="'+item.Id+'" tipoProdInsum="'+item.Tipo+'" value="'+item.Id+'.'+item.Tipo+'">'+item.Nombre+'</option>'

                        )

                    }

                    //SUMAMOS EL TOTAL CON ESTA FUNCION
                    sumarTotalPrecios();

                    //CALCULAMOS EL IMPUESTO
                    impuesto();


                    //DAR FORMATO A PRECIOS DE LOS PRODUCTOS
                    $(".precioInsumo").number(true, 2);


                }
        });

    })

/*=========================================
        SELECCIONAR INSUMO/PRODUCTO
=========================================*/

    $('#formNuevaCompra').on("change", "select.nuevaDescripcionInsumo", function(){

        var IdTipo = $(this).val();
        var temp = IdTipo.split(".");
        var idInProd = temp[0];
        var tipoProdInsum = temp[1];

        var precioInsumo = $(this).parent().parent().parent().parent().children(".ingresoPrecio").children().children().children(".precioInsumo");
        var nuevaDescripcionInsumo = $(this).parent().parent().parent().parent().children().children().children().children(".nuevaDescripcionInsumo");

        var datos = new FormData();
        datos.append("idInProd", idInProd);
        datos.append("tipo", tipoProdInsum);

        $.ajax({

                url: "ajax/compras.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    $(precioInsumo).val(respuesta["PrecioCompra"]);
                    $(precioInsumo).attr("precioReal", respuesta["PrecioCompra"]);
                    $(nuevaDescripcionInsumo).attr("idInProd", respuesta["InsumosID"]);
                    $(nuevaDescripcionInsumo).attr("nombreInsumoProd", respuesta["Nombre"]);
                    $(nuevaDescripcionInsumo).attr("tipoInsumoProd", tipoProdInsum);

                    //SUMAMOS EL TOTAL CON ESTA FUNCION
                    sumarTotalPrecios();

                    //CALCULAMOS EL IMPUESTO
                    impuesto();

                    //LISTAMOS LOS PRODUCTOS PARA CREAR LA COMPRA
                    listarInsumos();


                }
        });


    });

/*=========================================
        MODIFICAR CANTIDAD
=========================================*/

    $('#formNuevaCompra').on("change", "input.cantidadCompra", function(){

        var precioInsumo = $(this).parent().parent().parent().parent().children(".ingresoPrecio").children().children().children(".precioInsumo");

        var precioFinal = $(this).val() * precioInsumo.attr("precioReal");

        precioInsumo.val(precioFinal);

        //DAR FORMATO A PRECIOS DE LOS INSUMOS
        $(".precioInsumo").number(true, 2);

        //SUMAMOS EL TOTAL CON ESTA FUNCION
        sumarTotalPrecios();

        //CALCULAMOS EL IMPUESTO
        impuesto();

        //LISTAMOS LOS PRODUCTOS PARA CREAR LA COMPRA
        listarInsumos();


    });

/*=========================================
        SUMAR LOS PRECIOS
=========================================*/

    function sumarTotalPrecios(){

        var precioItem = $(".precioInsumo");
        var arraySumaPrecio = [];

        for (var i = 0; i < precioItem.length; i++) {

            arraySumaPrecio.push(Number($(precioItem[i]).val()));


        }

        function sumarArrayPrecios(total, numero){

            return total + numero;

        }

        var sumaTotalPrecio = arraySumaPrecio.reduce(sumarArrayPrecios);

        $("#totalCompra").val(sumaTotalPrecio);

        $("#totalCompraFinal").val(sumaTotalPrecio);

        $("#totalCompra").attr("total", sumaTotalPrecio);

    }

/*=========================================
        IMPUESTO
=========================================*/

    function impuesto(){

        var impuesto = $("#nuevoImpuestoCompra").val();
        var precioTotal = $("#totalCompra").attr("total");
        var precioImpuesto = Number(precioTotal * impuesto/100);
        var totalConImpuesto = Number(precioImpuesto) + Number(precioTotal);

            $("#totalCompra").val(totalConImpuesto);

            $("#totalCompraFinal").val(totalConImpuesto);

            $("#nuevoPrecioImpuesto").val(precioImpuesto);

            $("#precioNetoCompra").val(precioTotal);


    }

/*=========================================
        CUANDO CAMBIA IMPUESTO
=========================================*/

    $("#nuevoImpuestoCompra").change(function(){

        impuesto();

    });

/*=========================================
        DAR FORMATO AL PRECIO FINAL
=========================================*/

    $("#totalCompra").number(true, 2);

/*=========================================
        LISTAR TODOS LOS INSUMOS
=========================================*/

    function listarInsumos(){

        var listaInsumos = [];
        console.log("listaInsumos", listaInsumos);

        var descripcion = $(".nuevaDescripcionInsumo");

        var cantidad = $(".cantidadCompra");

        var precio = $(".precioInsumo");

        for (var i = 0; i < descripcion.length; i++) {

            listaInsumos.push({"idInProd":$(descripcion[i]).attr("idInProd"),
                                 "nombre":$(descripcion[i]).attr("nombreInsumoProd"),
                                 "tipo":$(descripcion[i]).attr("tipoInsumoProd"),
                                 "cantidad":$(cantidad[i]).val(),
                                 "precio":$(precio[i]).attr("precioReal"),
                                 "total":$(precio[i]).val() });

        }

        $("#listadoInsumos").val(JSON.stringify(listaInsumos));

    }

/*=========================================
        EDITAR COMPRA
=========================================*/

    $(".tablas").on("click", ".btnEditarCompra", function(){

        var idCompra = $(this).attr("idCompra");

        window.location= "index.php?ruta=editar-compra&idCompra="+idCompra;

    })

/*=========================================
        DETALLE COMPRA
=========================================*/

    $(".tablas").on("click", ".btnDetalleCompra", function(){

        var idCompra = $(this).attr("idCompra");
        var idProveedor = $(this).attr("idProveedor");
        var idUsuarioCancela = $(this).attr("idUsuarioCancela");

        var datos = new FormData();
        datos.append("detalleCompra" ,idCompra);

        $.ajax({

            url: "ajax/compras.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                var porcentajeImpuesto = respuesta["Impuesto"] * 100 / respuesta["Neto"];
                var redondeo = Math.round(porcentajeImpuesto);


                if (respuesta["Estado"]!="R") {

                    $("#tituloMotivoDetalleVenta").html("Motivo :");
                    $("#motivoDetalleVenta").html(respuesta["MotivoAnula"]);
                }

                $("#ordenDetalleCompra").html(respuesta["NroCompra"]);
                $("#fechaDetalleCompra").html(respuesta["fechaFormateada"]);
                $(".tituloDetalleCompra").html('Detalle de compra N° '+respuesta["NroCompra"]);
                $("#usuarioCompraDetalle").html(respuesta["Nombre"]+' '+respuesta["Apellido"]);
                $("#totalCompraDetalle").html('$'+$.number(respuesta["Total"], 2 ));
                $("#impuestoDetalleCompra").html('Impuesto (%'+redondeo+'): $'+ $.number(respuesta["Impuesto"],2));


            }

        });

        var datos = new FormData();
        datos.append("productosCompra" ,idCompra);

        $.ajax({

            url: "ajax/compras.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){


                respuesta.forEach(function(respuesta, index) {

                   $(".listadoProductosDetalle").append(

                        '<span class="text-dark">'+respuesta.Cantidad+' '+respuesta.Medida+' '+respuesta.Nombre+' $'+$.number((respuesta.PrecioUnitario)*(respuesta.Cantidad),2)+'</span><br>'

                    );
                });
            }
        });

        var datos = new FormData();
        datos.append("traigoProveedor" ,idProveedor);

        $.ajax({

            url: "ajax/proveedores.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                $("#nombreProveedorCompraDetalle").html(respuesta["RazonSocial"]);
                $("#telefonoProveedorDetalle").html('('+respuesta["Prefijo"]+')- '+respuesta["NroTelefono"]);
                $("#mailProveedorDetalle").html(respuesta["Email"]);

            }

        });

        var datosDom = new FormData();
        datosDom.append("traigoDomicilio" ,idProveedor);
        $.ajax({

            url: "ajax/proveedores.ajax.php",
            method: "POST",
            data: datosDom,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                $("#direccionProveedorDetalle").html(respuesta["Calle"]+' '+respuesta["Nro"]+'-'+respuesta["Barrio"]+'-'+respuesta["Localidad"]);


            }

        });

        if (idUsuarioCancela != "") {

            var datos = new FormData();
            datos.append("idUsuario" ,idUsuarioCancela);

            $.ajax({

                url: "ajax/usuarios.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    estado = "Anulada";
                    $("#estadoCompraDetalle").html('<span class="label label-danger">'+estado+'</span>');
                    $("#tituloUsuarioAnulaDetalleVenta").html("Usuario anula :");
                    $("#usuarioAnulaDetalleVenta").html(respuesta["nombrePersona"]+' '+respuesta["Apellido"]);


                }

            });

        } else {

            estado = "Registrada";
            $("#estadoCompraDetalle").html('<span class="label label-success">'+estado+'</span>');
            $("#tituloMotivoDetalleVenta").html("");
            $("#motivoDetalleVenta").html("");
            $("#tituloUsuarioAnulaDetalleVenta").html("");
            $("#usuarioAnulaDetalleVenta").html("");

        }


    })

/*==========================================
        FORMATEAR MODAL DETALLE COMPRA
==========================================*/

    $("#modalDetalleDeCompra").on('show.bs.modal', function () {

        $(".listadoProductosDetalle").empty();

    });

/*========================================
        ANULAR COMPRA
==========================================*/

    $(".tablas").on("click", ".btnAnularCompra", function(){

        var idCompra = $(this).attr("idCompra");
        var numCompra = $(this).attr("orden");

        $(".ventaTituloAnular").html("Anular compra N°"+numCompra);
        $("#idCompraA").val(idCompra);


    });

/*==========================================
        VALIDAR ANULAR COMPRA
==========================================*/

    $(function(){

            $.validator.addMethod("pattern", function(value, element, param) {

                if (this.optional(element)) {

                    return true;

                }

                if (typeof param === 'string') {

                    param = new RegExp('^(?:' + param + ')$');

                }

                    return param.test(value);

            }, "Formato Invalido.");

            $("#formAnularCompra").validate({

                errorClass: "messages text-danger",
                validClass: "state-success",
                errorElement: "p",

                rules: {
                    motivoAnula: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 100,
                        minlength: 3
                    },
                },

                messages: {
                    motivoAnula: {
                        required: 'Debe ingresar un motivo',
                        minlength: 'Minimo 3 caracteres'
                    },

                    onkeyup : false

                },

                highlight: function(element){

                    $(element).closest('.md-input-wrapper').addClass('md-input-danger');

                },

                unhighlight: function(element){

                    $(element).closest('.md-input-wrapper').removeClass('md-input-danger');

                },

                errorPlacement: function(error, element) {

                    if (element.is(":radio") || element.is(":checkbox")) {

                        element.closest('.option-group').after(error);

                    } else {

                        error.insertAfter(element.parent());

                    }

                }

            });
    });

/*==========================================
        IMPRIMIR ORDEN
==========================================*/

    $(".tablas").on("click", ".btnImprimirOrden", function(){

        var idCompra = $(this).attr("idCompra");

        swal({
            title:"¡Atencion!",
            text:"¿Desea generar la orden de compra?",
            type:"warning",
            confirmButtonText: "Generar",
            cancelButtonText: "Cancelar",
            showCancelButton: true,
            closeOnConfirm: true
        },
            function(isConfirm){
                if(isConfirm){
                   window.open("extensiones/tcpdf/pdf/orden.php?compra="+idCompra, "_blank");
                   window.location="compras";

                } else {

                    window.location="compras";
                }
        });

    })

/*==========================================
        RANGO DE FECHAS
==========================================*/

    $('#daterange-btn3').daterangepicker(
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

        $('#daterange-btn3 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        var fechaInicial = start.format('YYYY-MM-DD');

        var fechaFinal = end.format('YYYY-MM-DD');

        var capturarRango = $("#daterange-btn3 span").html();

        localStorage.setItem("capturarRango3", capturarRango);

        window.location = "index.php?ruta=compras&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

      }

    )

/*==========================================
        CANCELAR RANGO DE FECHAS
==========================================*/

    $(".daterangepicker.opensright .range_inputs .cancelBtn").on("click", function(){

        localStorage.removeItem("capturarRango3");
        localStorage.clear();
        window.location = "compras";
    })

/*==========================================
        CAPTURAR HOY
==========================================*/

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

            localStorage.setItem("capturarRango3", "Hoy");

            window.location = "index.php?ruta=compras&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

        }

    })

/*==========================================
        AGREGAR PROVEEDOR
===========================================*/

    'use strict';
    $(document).ready(function() {

        jQuery.validator.addMethod("pattern", function(value, element, param) {

            if (this.optional(element)) {

                return true;

            }

            if (typeof param === 'string') {

                param = new RegExp('^(?:' + param + ')$');

            }

                return param.test(value);

        }, "Formato Invalido.");

        var form = $("#registrarProveedor").show();

            form.steps({
                headerTag: "h3",
                bodyTag: "fieldset",
                transitionEffect: "slideLeft",
                labels: {
                    cancel: "Cancelar",
                    current: "current step:",
                    pagination: "Paginación",
                    finish: "Finalizar",
                    next: "Siguiente",
                    previous: "Anterior",
                    loading: "Cargando ..."
                },
                onStepChanging: function (event, currentIndex, newIndex){

                    if (currentIndex < newIndex){

                        form.find(".body:eq(" + newIndex + ") label.error").remove();
                        form.find(".body:eq(" + newIndex + ") .error").removeClass("error");

                    }
                        form.validate().settings.ignore = ":disabled,:hidden";
                        return form.valid();

                },
                onFinishing: function (event, currentIndex){

                        form.validate().settings.ignore = ":disabled";
                        return form.valid();

                },
                onFinished: function (event, currentIndex){

                    // ENVIO DE FORMULARIO
                    var datos = new FormData ($('#registrarProveedor')[0]);

                    $.ajax({
                        url: 'ajax/proveedores.ajax.php',
                        type: 'post',
                        dataType: 'json',
                        cache: true,
                        processData: false,
                        contentType: false,
                        data: datos,
                        timeout: 8000,
                        success: function(respuesta){

                            $('#modalAgregarProveedor').modal().hide();

                            if(respuesta == "ok"){

                                swal({
                                    title:"Registro Exitoso!",
                                    text:"¡El proveedor se registró correctamente!",
                                    type:"success",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                },
                                function(isConfirm){
                                    if(isConfirm){
                                        window.location="crear-compra";
                                    }
                                });

                            } else {

                                swal({
                                    title:"Error!",
                                    text:"¡ocurrió un error, revise los datos!"+respuesta,
                                    type:"error",
                                    confirmButtonText: "Cerrar",
                                    closeOnConfirm: false
                                },
                                function(isConfirm){
                                    if(isConfirm){
                                        window.location="crear-compra";
                                    }
                                });
                            }
                        }
                    });
                }
                    // REALIZAMOS LA VALIDACION DE LOS CAMPOS
                    }).validate({

                        errorClass: "messages text-danger",
                        validClass: "state-success",
                        errorElement: "p",

                        rules: {

                            razonProveedor: {
                                required: true,
                                pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                                maxlength: 70,
                                minlength: 3
                            },
                            emailProveedor: {
                                required: true,
                                email: true,
                                remote: {
                                    url: 'ajax/empleados.ajax.php',
                                    type: 'post',
                                    data: {
                                        mail: function(){
                                            return $('#emailProveedor').val();
                                        }
                                    }
                                }
                            },
                            cuitProveedor: {
                                required: true,
                                maxlength: 13,
                                minlength:13,
                                remote: {
                                    url: 'ajax/proveedores.ajax.php',
                                    type: 'post',
                                    data: {
                                        cuit: function(){
                                            return $('#cuitProveedor').val();
                                        }
                                    }
                                }
                            },
                            ivaProveedor: {
                                required: true,
                            },
                            rubroProveedor: {
                                required: true,
                            },
                            codAreaTelefonoProveedor: {
                                required: true,
                                number:true,
                                maxlength: 5,
                                minlength: 3
                            },
                            numeroTeléfonoProveedor: {
                                required: true,
                                number:true,
                                maxlength: 8,
                                minlength: 2
                            },
                            calleProveedor: {
                                required: true,
                                pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                                maxlength: 25,
                                minlength: 3
                            },
                            numCalleProveedor: {
                                required: true,
                                number:true,
                                maxlength: 4,
                                minlength: 1
                            },
                            pisoProveedor: {
                                number:true,
                                maxlength: 2
                            },
                            deptoProveedor: {
                                pattern: /^[a-zA-Z0-9\'\"\s]+$/,
                                maxlength: 2
                            },
                            localidadProveedor: {
                                required: true,
                                pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                                maxlength: 40,
                                minlength: 3,
                            },
                            barrioProveedor: {
                                required: true,
                                pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                                maxlength: 20,
                                minlength: 3,
                            },
                            codPostalProveedor: {
                                required: false,
                                number:true,
                                maxlength: 4,
                                minlength: 3
                            },
                            nombreRefProveedor: {
                                required: false,
                                pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                                maxlength: 30
                            },
                            apellidoRefProveedor: {
                                required: false,
                                pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                                maxlength: 30
                            },
                            emailRefProveedor: {
                                required: false,
                                email: true,
                                remote: {
                                    url: 'ajax/empleados.ajax.php',
                                    type: 'post',
                                    data: {
                                        mail: function(){
                                            return $('#emailRefProveedor').val();
                                        }
                                    }
                                }
                            },
                            codArRefProveedor: {
                                required: false,
                                number:true,
                                maxlength: 5,
                                minlength: 3
                            },
                            numTelRefProveedor: {
                                required: false,
                                number:true,
                                maxlength: 9,
                                minlength: 2
                            },

                        },

                        messages: {

                            razonProveedor: {
                                required: 'Ingrese la razón social',
                                minlength: 'Minimo 3 caracteres'
                            },
                            emailProveedor: {
                                required: 'Ingrese una dirección de email',
                                email: 'Ingrese una dirección de email valida',
                                remote: 'El email ya se encuentra registrado'
                            },
                            cuitProveedor: {
                                required: 'Ingrese el CUIT',
                                minlength: 'Debe ingresar todos los dígitos',
                                remote: 'El CUIT ya esta registrado'
                            },
                            ivaProveedor: {
                                required: 'Seleccione una opción',
                            },
                            rubroProveedor: {
                                required: 'Seleccione una opción',
                            },
                            codAreaTelefonoProveedor: {
                                required: 'Ingrese código de aŕea',
                                minlength: 'Mínimo 3 caracteres',
                                number: 'Ingrese solo números'
                            },
                            numeroTeléfonoProveedor: {
                                required: 'Ingrese número de teléfono',
                                minlength: 'Mínimo 3 caracteres',
                                number: 'Ingrese solo números'
                            },
                            calleProveedor: {
                                required: 'Ingrese nombre de calle',
                                minlength:'Mínimo 3 caracteres'
                            },
                            numCalleProveedor: {
                                required: 'Ingrese número de calle',
                                minlength:'Mínimo 1 número',
                                number: 'Solo se permiten números'
                            },
                            pisoProveedor: {
                                number: 'Solo se permiten números',
                                maxlength: 'Ingrese solo dos dígitos'
                            },
                            deptoProveedor: {
                               maxlength: 'Ingrese solo dos dígitos'
                            },
                            localidadProveedor: {
                                required: 'Ingrese la localidad',
                                minlength: 'Mínimo 3 caracteres'
                            },
                            barrioProveedor: {
                                required: 'Ingrese el barrio',
                                minlength: 'Mínimo 3 caracteres'
                            },
                            codPostalProveedor: {
                                number: 'Solo se permiten números'
                            },
                            nombreRefProveedor: {
                                minlength: 'Minimo 3 caracteres'
                            },
                            apellidoRefProveedor: {
                                minlength: 'Minimo 3 caracteres'
                            },
                            emailRefProveedor: {
                                email: 'Ingrese una dirección de email valida',
                                remote: 'El email ya se encuentra registrado'
                            },
                            codArRefProveedor: {
                                minlength: 'Mínimo 3 caracteres',
                                number: 'Ingrese solo números'
                            },
                            numTelRefProveedor: {
                                minlength: 'Mínimo 3 caracteres',
                                number: 'Ingrese solo números'
                            },


                            onkeyup : false,

                        },

                        highlight: function(element){

                            $(element).closest('.form-group').addClass('form-danger');
                            $(element).closest('.form-group').removeClass('form-primary');

                        },

                        unhighlight: function(element){

                            $(element).closest('.form-group').addClass('form-primary');
                            $(element).closest('.form-group').removeClass('form-danger');

                        },

                        errorPlacement: function(error, element) {

                            if (element.is(":radio") || element.is(":checkbox")) {

                                element.closest('.option-group').after(error);

                            } else {

                                error.insertAfter(element.parent().children('.float-label'));

                        }

                    }

                    });

    }); // fin de document ready

/*==========================================
        AUTOCOMPLETAR LOCALIDAD
==========================================*/

    function aLocalidad(accion){

        var modo = accion;

        if (modo == 'Nuevo') {

            var cambio = "#localidadProveedor";

        } else {

            var cambio = "#elocalidadProveedor";

        }

        var datos = new FormData();
        datos.append("TablaL", "Localidad");
        $.ajax({
            url:"ajax/proveedores.ajax.php",
            method:"POST",
            dataType:'json',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(respuesta){

                var sLocalidad = respuesta;
                $( function() {
                    $(""+cambio+"").autocomplete({
                        source: sLocalidad,
                        minChars: 1,

                    });
                });
            }
        });

    }

/*==========================================
        AUTOCOMPLETAR BARRIO
===========================================*/

    function aBarrio(accion){

        var tipo = accion;

        if (tipo == "Nuevo") {

            var mostrar = '#barrioProveedor';

        } else {

            var mostrar = '#ebarrioProveedor';

        }

        var datos = new FormData();
        datos.append("TablaB", "Barrio");
        $.ajax({
            url:"ajax/proveedores.ajax.php",
            method:"POST",
            dataType:'json',
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success:function(respuesta){

                var sBarrios = respuesta;
                $( function() {
                    $( ""+mostrar+"" ).autocomplete({
                        source: sBarrios,
                        minChars: 1,

                    });
                } );
            }
        });
    }
