/*=============================================
        VARIABLE LOCAL STORAGE
=============================================*/

    if(localStorage.getItem("capturarRango") != null){

        $("#daterange-btn span").html(localStorage.getItem("capturarRango"));


    }else{

        $("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de fecha')

    }

/*=========================================
        CARGAR TABLA CLIENTES
=========================================*/

    var table = $(".tablaBuscarClientes").DataTable({

        "ajax":"ajax/tablaBuscarCliente.ajax.php",
        "autoWidth": true,
        "columnDefs": [
            {
            "targets": -1,
            "data": null,
            "defaultContent": '<button class="btn btn-success waves-effect waves-ligh btnSeleccionarCliente"><i class="icofont icofont-check"></i></button>'
            }
         ],
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


    //CARGAMOS LOS IDS EN LOS BOTONES DE ACCION

    $('.tablaBuscarClientes tbody').on( 'click', 'button', function () {
    
        if (window.matchMedia("(min-width:992px)").matches){

            var data = table.row( $(this).parents('tr') ).data();
            
             
        } else {

            var data = table.row( $(this).parents('tbody tr ul li') ).data();
            
   
        }

        $(this).attr("idCliente", data[8]);
        $(this).attr("NombreCliente", data[1]);
        $(this).attr("ApellidoCliente", data[2]);
                        
    } );

/*=========================================
        SELECCIONAR CLIENTE
=========================================*/
   
    $('.tablaBuscarClientes tbody').on("click", "button.btnSeleccionarCliente", function(){


        var idCliente = $(this).attr("idCliente");
        
            var datos = new FormData();
            datos.append("idCliente" ,idCliente);

            $.ajax({

                url: "ajax/clientes.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                                       
                    $("#clienteVenta").val(respuesta["Nombre"]+' '+respuesta["Apellido"]);
                    $("#idClienteVenta").val(respuesta["ClienteID"]);

                    $("#modalBuscarCliente .close").click()

                }
            });
        })

/*=========================================
        CARGAR TABLA PRODUCTOS
=========================================*/

    var table2 = $(".tablaProductosVenta").DataTable({

        "ajax":"ajax/tablaProductosVenta.ajax.php",
        "columnDefs": [
            {"className": "text-center", "targets": "_all"},
            
            {

            "targets": -1,
            "data": null,
            "defaultContent": '<div class="text-center"><div class="btn-group"><button class="btn btn-primary waves-effect waves-ligh agregarProducto recuperarBoton"><i class="icofont icofont-plus"></i> Agregar</button></div></div>'
            
            },

            {
                "targets": [ 4 ],
                "visible": false,
                "searchable": false
            },

            {

            "targets": -5,
            "data": null,
            "defaultContent": '<div class="text-center"><img class="img-thumbnail img-60 imgTablaProdVenta" width="40px"></div>'
            
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

    $('.tablaProductosVenta tbody').on( 'click', 'button.agregarProducto', function () {
    
        if (window.matchMedia("(min-width:992px)").matches){

            var data2 = table2.row( $(this).parents('tr') ).data();
                         
        } else {

            var data2 = table2.row( $(this).parents('tbody tr ul li') ).data();
               
        }

        $(this).attr("idProducto", data2[5]);
                               
    });


    //CARGAMOS LAS IMAGENES

    function cargarImagenes(){

        var imgTabla = $('.imgTablaProdVenta');

        for(var i = 0; i < imgTabla.length; i ++){

            var data2 = table2.row( $(imgTabla[i]).parents("tr")).data();
            
            $(imgTabla[i]).attr("src", data2[1])

        }

    }   

    //CARGAMOS LAS IMAGENES CUANDO ENTRAMOS A LA PAGINA POR PRIMERA VEZ

    setTimeout(function(){

        cargarImagenes();
               
    },300) 

    //CARGAMOS LAS IMAGENES CUANDO INTERACTUAMOS CON EL PAGINADOR

    $('.dataTables_paginate').click(function(){

        cargarImagenes();
       
    })

    //CARGAMOS LAS IMAGENES CUANDO INTERACTUAMOS CON EL BUSCADOR

    $("input[aria-controls='DataTables_Table_1']").focus(function(){

        $(document).keyup(function(event){

            event.preventDefault();

            cargarImagenes();

        })

    })

    //CARGAMOS LAS IMAGENES CUANDO INTERACTUAMOS CON EL FILTRO DE CANTIDAD


    $("select[name='DataTables_Table_1_length']").change(function(){

        cargarImagenes();
   
    })

    //CARGAMOS LAS IMAGENES CUANDO INTERACTUAMOS CON LOS FILTROS DE ORDENAR

    $(".sorting").click(function(){

        cargarImagenes();
   
    })

    $(".sorting_asc").click(function(){

        cargarImagenes();
  
    })

/*=========================================
        AGREGAR PRODUCTOS A LA VENTA
=========================================*/
    
    $('.tablaProductosVenta tbody').on("click", "button.agregarProducto", function(){

        var idProducto = $(this).attr("idProducto");
        
        $(this).removeClass("btn-primary agregarProducto");
        $(this).addClass("btn-default");
        
        var datos = new FormData();
        datos.append("idEditarProducto", idProducto);  

        $.ajax({

                url: "ajax/productos.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                                                            
                    var descripcion = respuesta["Nombre"];
                    var precio = respuesta["PrecioVenta"]; 
                    var tipo = respuesta["Tipo"];
                                        
                    if (respuesta["Stock"]!=null) {

                        var Stock = respuesta["Stock"];
                        var nuevoStock = Number(Stock-1);

                    } else {

                        var nuevoStock = "no";
                        var Stock = "no";

                    }
                

                    $(".nuevoProducto").append(

                        '<div class="row">'+
                            '<div class="col-sm-7">'+
                                '<div class="material-group">'+
                                    '<div class="material-addone">'+
                                        '<button  type="button" class="btn btn-danger btn-mini waves-effect waves-light p-1 quitarProducto" idProducto="'+idProducto+'"><i class="icofont icofont-close m-0"></i></button>'+
                                    '</div>'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="text" class="form-control nuevaDescripcionProducto" name="descProdVenta" id="descProdVenta" idProducto="'+idProducto+'" value="'+descripcion+'" nombreProducto="'+descripcion+'" readonly required>'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Descripción</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2 ingresoCantidad">'+
                                '<div class="material-group">'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="number" class="form-control form-control-right cantidadVenta" name="cantidadVenta" min="1" value="1" stock="'+Stock+'" nuevoStock="'+nuevoStock+'">'+
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
                                        '<input type="text" min="1" class="form-control form-control-right precioProducto" name="precioProducto" precioReal="'+precio+'" readonly value="'+precio+'" />'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Precio</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                         '</div>'

                        );

                    //SUMAMOS EL TOTAL CON ESTA FUNCION                  
                    sumarTotalPrecios();

                    //CALCULAMOS EL RECARGO O DESCUENTO
                    descuentoRegargo();

                    //LISTAMOS LOS PRODUCTOS PARA CREAR LA VENTA
                    listarProductos();

                    //DAR FORMATO A PRECIOS DE LOS PRODUCTOS
                    $(".precioProducto").number(true, 2);
                    
                }
            });
        
    });

/*=========================================
        QUITAR PRODUCTOS DE LA VENTA
=========================================*/

    $('#formNuevaVenta').on("click", "button.quitarProducto", function(){

        $(this).parent().parent().parent().parent().remove();

        var idProducto = $(this).attr("idProducto");

        $("button.recuperarBoton[idProducto='"+idProducto+"']").removeClass('btn-default');

        $("button.recuperarBoton[idProducto='"+idProducto+"']").addClass('btn-primary agregarProducto');

            if ($(".nuevoProducto").children().length == 0 ) {

                $("#totalVenta").val(0);
                $("#totalVentaFinal").val(0);
                $("#totalVenta").attr("total", 0);
                $("#desRegargoVenta").val(0);
                $("#montoRecargo").val(0);
                $("#montoDescuento").val(0);

            } else {

                //SUMAMOS EL TOTAL CON ESTA FUNCION                  
                sumarTotalPrecios();

                //CALCULAMOS EL RECARGO O DESCUENTO
                descuentoRegargo();

                //LISTAMOS LOS PRODUCTOS PARA CREAR LA VENTA
                listarProductos();

            }
        
    });

/*=========================================
        AGREGAR PRODUCTO DESDE EL BOTON
=========================================*/

    $(".btnAgregarProducto").click(function(){

        var datos = new FormData();
        datos.append("traerProductos", "ok");

        $.ajax({

                url: "ajax/productos.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                                                           
                    $(".nuevoProducto").append(
                        
                        '<div class="row">'+
                            '<div class="col-sm-6">'+
                                '<div class="material-group">'+
                                    '<div class="material-addone">'+
                                        '<button type="button" class="btn btn-mini btn-danger p-1 quitarProducto" idProducto ><i class="icofont icofont-close"></i></button>'+
                                    '</div>'+
                                    '<div class="form-group form-default form-static-label p-t-5">'+
                                        '<select class="form-control nuevaDescripcionProducto" idProducto name="nuevaDescripcionProducto" id="nuevaDescripcionProducto" required>'+
                                            '<option value="">Seleccione el producto</option>'+
                                        '</select>'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Descripción</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2 ingresoCantidad">'+
                                '<div class="material-group">'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="number" class="form-control form-control-right cantidadVenta" name="cantidadVenta" min="1" value="1" >'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Cantidad</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-4 ingresoPrecio">'+
                                '<div class="material-group">'+
                                    '<div class="material-addone">'+
                                        '<i class="icofont icofont-cur-dollar"></i>'+
                                    '</div>'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="text" class="form-control form-control-right precioProducto" precioReal name="precioProducto" readonly />'+
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

                        $(".nuevaDescripcionProducto").append(

                            '<option idProducto="'+item.ProductoID+'" value="'+item.ProductoID+'">'+item.Nombre+'</option>'

                        )

                    }

                    //SUMAMOS EL TOTAL CON ESTA FUNCION                  
                    sumarTotalPrecios();

                    //CALCULAMOS EL RECARGO O DESCUENTO
                    descuentoRegargo();

                    
                    //DAR FORMATO A PRECIOS DE LOS PRODUCTOS
                    $(".precioProducto").number(true, 2);
                            
                   
                }
        });

    })

/*=========================================
        SELECCIONAR PRODUCTO
=========================================*/

    $('#formNuevaVenta').on("change", "select.nuevaDescripcionProducto", function(){

        var idProducto = $(this).val();
        var precioProducto = $(this).parent().parent().parent().parent().children(".ingresoPrecio").children().children().children(".precioProducto");
        var nuevaDescripcionProducto = $(this).parent().parent().parent().parent().children().children().children().children(".nuevaDescripcionProducto");
        var nuevacantidadVenta = $(this).parent().parent().parent().parent().children().children().children().children(".cantidadVenta");
                                       
        var datos = new FormData();
        datos.append("idEditarProducto", idProducto);

        $.ajax({

                url: "ajax/productos.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){

                    if (respuesta["Stock"]!=null) {

                        var Stock = respuesta["Stock"];
                        var nuevoStock = Number(Stock-1);

                    } else {

                        var nuevoStock = "no";
                        var Stock = "no";

                    }
                    
                    $(precioProducto).val(respuesta["PrecioVenta"]);
                    $(precioProducto).attr("precioReal", respuesta["PrecioVenta"]);
                    $(precioProducto).val(respuesta["PrecioVenta"]);
                    $(nuevaDescripcionProducto).attr("idProducto", respuesta["ProductoID"]);
                    $(nuevaDescripcionProducto).attr("nombreProducto", respuesta["Nombre"]);

                    $(nuevacantidadVenta).attr("stock", Stock);
                    $(nuevacantidadVenta).attr("nuevoStock", nuevoStock);

                    //SUMAMOS EL TOTAL CON ESTA FUNCION                  
                    sumarTotalPrecios();

                    //CALCULAMOS EL RECARGO O DESCUENTO
                    descuentoRegargo();

                    //LISTAMOS LOS PRODUCTOS PARA CREAR LA VENTA
                    listarProductos();
                                               
                   
                }
        });       
        

    });

/*=========================================
        MODIFICAR CANTIDAD
=========================================*/

    $('#formNuevaVenta').on("change", "input.cantidadVenta", function(){

        var precioProducto = $(this).parent().parent().parent().parent().children(".ingresoPrecio").children().children().children(".precioProducto");
        
        var precioPro = precioProducto.attr("precioReal")
        
               
        var precioFinal = $(this).val() * precioProducto.attr("precioReal");
       
        precioProducto.val(precioFinal);

        var stockNull = $(this).attr("stock");
                
        if (stockNull != "no") {

            var nuevoStock = Number($(this).attr("stock")) - $(this).val();

            $(this).attr("nuevoStock", nuevoStock);

            if(Number($(this).val()) > Number($(this).attr("stock"))){

                $(this).val(1);

                $(this).attr("nuevoStock", nuevoStock);

                precioProducto.val(precioPro);

                swal({
                  title: "La cantidad supera el Stock",
                  text: "¡Sólo hay "+$(this).attr("stock")+" unidades!",
                  type: "error",
                  confirmButtonText: "¡Cerrar!"
                });

            }

        } else {

            
        }

        //SUMAMOS EL TOTAL CON ESTA FUNCION                  
        sumarTotalPrecios();
        
        //CALCULAMOS EL RECARGO O DESCUENTO
        descuentoRegargo();

        //LISTAMOS LOS PRODUCTOS PARA CREAR LA VENTA
        listarProductos();

     
    });

/*=========================================
        SUMAR LOS PRECIOS
=========================================*/

    function sumarTotalPrecios(){

        var precioItem = $(".precioProducto");
        var arraySumaPrecio = [];

        for (var i = 0; i < precioItem.length; i++) {
            
            arraySumaPrecio.push(Number($(precioItem[i]).val()));
            

        }

        function sumarArrayPrecios(total, numero){

            return total + numero;

        }

        var sumaTotalPrecio = arraySumaPrecio.reduce(sumarArrayPrecios); 
        
        $("#totalVenta").val(sumaTotalPrecio);

        $("#totalVentaFinal").val(sumaTotalPrecio);

        $("#totalVenta").attr("total", sumaTotalPrecio);

    }

/*=========================================
        DESCUENTO O RECARGO
=========================================*/

    function descuentoRegargo(){

        var monto = $("#desRegargoVenta").val();
        
        var precioTotal = $("#totalVenta").attr("total");
               
       // var precioMonto =Number(precioTotal * monto/100);
        
        var totalConMonto = Number(precioTotal) + Number(monto);
        
        if (monto.length > 0) {

            var signo = Math.sign(monto);
        
            if (signo == 1) {

                $("#montoRecargo").val(monto);
                $("#montoDescuento").val(0);
           
            } else {

                $("#montoDescuento").val(monto);
                $("#montoRecargo").val(0);

            }
        
        } else if(monto == "") {

            
                $("#montoRecargo").val(0);
                $("#montoDescuento").val(0);
            
        }

        $("#precioNetoVenta").val(precioTotal);
        
        $("#totalVenta").val(totalConMonto);

        $("#totalVentaFinal").val(totalConMonto);

    }

/*=========================================
    CUANDO CAMBIA EL DESCUENTO O RECARGO
=========================================*/

    $("#desRegargoVenta").change(function(){

        descuentoRegargo();

    });

/*=========================================
        DAR FORMATO AL PRECIO FINAL
=========================================*/
    
    $("#totalVenta").number(true, 2);
   // $("#desRegargoVenta").number(true, 2);

/*=========================================
        SELECCIONAR METODO DE PAGO
=========================================*/

    $("#fPagoVenta").change(function(){

        //var metodo = $(this).val();

        var metodo = $('#fPagoVenta option:selected').html();
        
        if (metodo == "Efectivo") {

           
           $(this).parent().parent().parent().removeClass("col-sm-6");
           $(this).parent().parent().parent().addClass("col-sm-4");
           $(this).parent().parent().parent().parent().children(".cajasMetodoPago").removeClass("col-sm-6");
           $(this).parent().parent().parent().parent().children(".cajasMetodoPago").addClass("col-sm-8");


           $(this).parent().parent().parent().parent().children(".cajasMetodoPago").html(

            '<div class="row">'+
               '<div class="col-sm-6">'+
                    '<div class="material-group">'+
                        '<div class="material-addone">'+
                            '<i class="icofont icofont-cur-dollar"></i>'+
                        '</div>'+
                        '<div class="form-group form-default form-static-label">'+
                            '<input type="text" class="form-control form-control-right PagaEfectivo" placeholder="00000" required>'+
                            '<span class="form-bar"></span>'+
                            '<label class="float-label text-dark">Recibió</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
                '<div class="col-sm-6 capturarCambioEfectivo">'+
                    '<div class="material-group">'+
                        '<div class="material-addone">'+
                            '<i class="icofont icofont-cur-dollar"></i>'+
                        '</div>'+
                        '<div class="form-group form-default form-static-label">'+
                            '<input type="text" class="form-control form-control-right cambioEfectivo" placeholder="00000" readonly required>'+
                            '<span class="form-bar"></span>'+
                            '<label class="float-label text-dark">Cambio</label>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>'
            );
           
           //AGREGAR FORMATO A LOS PRECIOS

           $(".PagaEfectivo").number(true, 2);
           $(".cambioEfectivo").number(true, 2);

        } else {

            $(this).parent().parent().parent().removeClass("col-sm-4");
            $(this).parent().parent().parent().addClass("col-sm-6");

            $(this).parent().parent().parent().parent().children(".cajasMetodoPago").removeClass("col-sm-8");
            $(this).parent().parent().parent().parent().children(".cajasMetodoPago").addClass("col-sm-6");

            $(this).parent().parent().parent().parent().children(".cajasMetodoPago").html(

                '<div class="row">'+
                    '<div class="col-sm-12">'+
                        '<div class="material-group">'+
                            '<div class="material-addone">'+
                                '<i class="icofont icofont-lock"></i>'+
                            '</div>'+
                            '<div class="form-group form-primary form-static-label">'+
                                '<input type="text" class="form-control form-control-right"name="codTransVenta" id="codTransVenta>'+
                                '<span class="form-bar"></span>'+
                                '<label class="float-label">Cod de transacción</label>'+
                            '</div>'+
                        '</div>'+
                     '</div>'+
                '</div>'
            )
        }

    });

/*=========================================
        CAMBIO EN EFECTIVO
=========================================*/

    $('#formNuevaVenta').on("change", "input.PagaEfectivo", function(){

        var efectivo = $(this).val();
        
        var cambio = Number(efectivo) - Number($("#totalVenta").val());
        
        var nuevoCambioEfectivo = $(this).parent().parent().parent().parent().parent().children().children('.capturarCambioEfectivo').children().children().children('.cambioEfectivo');
        
        nuevoCambioEfectivo.val(cambio);

    });

/*=========================================
        LISTAR TODOS LOS PRODUCTOS
=========================================*/

    function listarProductos(){

        var listaProductos = [];

        var descripcion = $(".nuevaDescripcionProducto");
                
        var cantidad = $(".cantidadVenta"); 
        
        var precio = $(".precioProducto");

        for (var i = 0; i < descripcion.length; i++) {
            
            listaProductos.push({"idProducto":$(descripcion[i]).attr("idProducto"),
                                 "nombreProducto":$(descripcion[i]).attr("nombreProducto"),
                                 "cantidadProducto":$(cantidad[i]).val(),
                                 "stock":$(cantidad[i]).attr("nuevoStock"),
                                 "precioProducto":$(precio[i]).attr("precioReal"),
                                 "total":$(precio[i]).val() });

        }

        $("#listadoProductos").val(JSON.stringify(listaProductos));
        
    }

/*=========================================
        EDITAR VENTA
=========================================*/

    $(".tablas").on("click", ".btnEditarVenta", function(){

        var idVenta = $(this).attr("idVenta");

        window.location= "index.php?ruta=editar-venta&idVenta="+idVenta;

    })

/*=========================================
        DETALLE VENTA
=========================================*/

    $(".tablas").on("click", ".btnDetalleVenta", function(){

        var idVenta = $(this).attr("idVenta");
        var idCliente = $(this).attr("idCliente");
        var idUsuarioCancela = $(this).attr("idUsuarioCancela");
                        
        var datos = new FormData();
        datos.append("detalleVenta" ,idVenta);

        $.ajax({

            url: "ajax/ventas.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                                
                recarTemp = parseInt(respuesta["MontoRecargo"]);
                descaTemp = parseInt(respuesta["MontoDescuento"]);               
               
                if (recarTemp!=0) {

                    $("#tituloDesRecDetalleVenta").html('Recargo : <span> $'+respuesta["MontoRecargo"]+'</span>');
                                    
                } else if(descaTemp!=0){

                    $("#tituloDesRecDetalleVenta").html('Descuento : <span> $'+respuesta["MontoDescuento"]+'</span>');

                } else {

                    
                }

                if (respuesta["Estado"]!="R") {

                    $("#tituloMotivoDetalleVenta").html("Motivo :");
                    $("#motivoDetalleVenta").html(respuesta["MotivoCancela"]);
                }
                                
                $("#facturaDetalleVenta").html(respuesta["NroFactura"]);
                $("#totalVentaDetalle").html('$'+respuesta["Total"]);
                $("#vendedorVentaDetalle").html(respuesta["Nombre"]+' '+respuesta["Apellido"]);
                $("#fechaDetalleVenta").html(respuesta["fechaFormateada"]);
                $(".tituloDetalleVenta").html('Detalle de venta N° '+respuesta["NroFactura"]);
        
            }
        
        });

        var datos = new FormData();
        datos.append("productosVenta" ,idVenta);

        $.ajax({

            url: "ajax/ventas.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                                
                respuesta.forEach(function(respuesta, index) {
                  
                   $(".listadoProductosDetalle").append(

                        '<span class="text-dark">'+respuesta.Cantidad+' '+respuesta.Nombre+' $'+(respuesta.PrecioUnitario)*(respuesta.Cantidad)+'</span><br>'
                    
                    );
                });
            }
        });

        var datos = new FormData();
        datos.append("idCliente" ,idCliente);

        $.ajax({

            url: "ajax/clientes.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                
                $("#nombreClienteDetalle").html(respuesta["Nombre"]+' '+respuesta["Apellido"]);
                $("#direccionClienteDetalle").html(respuesta["Calle"]+' '+respuesta["Nro"]+'-'+respuesta["Barrio"]+'-'+respuesta["Localidad"]);
                $("#telefonoClienteDetalle").html('('+respuesta["Prefijo"]+')- '+respuesta["NroTelefono"]);
                
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
                    $("#estadoVentaDetalle").html('<span class="label label-danger">'+estado+'</span>');
                    $("#tituloUsuarioAnulaDetalleVenta").html("Usuario anula :");
                    $("#usuarioAnulaDetalleVenta").html(respuesta["nombrePersona"]+' '+respuesta["Apellido"]);
                    
                                       
                }

            });
        
        } else {

            estado = "Registrada";
            $("#estadoVentaDetalle").html('<span class="label label-success">'+estado+'</span>');
            $("#tituloMotivoDetalleVenta").html("");
            $("#motivoDetalleVenta").html("");
            $("#tituloUsuarioAnulaDetalleVenta").html("");
            $("#usuarioAnulaDetalleVenta").html("");

        }
        

    })

/*==========================================
        FORMATEAR MODAL DETALLE VENTA
==========================================*/

    $("#modalDetalleDeVenta").on('show.bs.modal', function () {

        $(".listadoProductosDetalle").empty();
            
    });

/*=========================================
        ELIMINAR VENTA
=========================================*/

    //corregir la clase para poder utilizar
    $(".tablsas").on("click", ".btnEliminarVenta", function(){

        var idVenta = $(this).attr("idVenta");
        var factura = $(this).attr("factura");

        swal({
        title: "¡Atencion!",
        text: "¿Esta seguro de eliminar la venta "+factura+"?",
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
                datos.append("eliminarVenta", idVenta);
                
                $.ajax({
                    url:"ajax/ventas.ajax.php",
                    method:"POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        if(respuesta==0){

                            swal({
                                title:"Venta eliminada!",
                                text:"¡La venta se eliminó correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="ventas";

                                    }

                                });

                        }else{

                            swal({
                                title:"Error!",
                                text:"¡No se pudo eliminar la venta!",
                                type:"error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="ventas";

                                    }

                                });

                        }

                    }

                });

            }, 1000);

        });



    })

/*==========================================
        ANULAR VENTA
==========================================*/

    $(".tablas").on("click", ".btnEliminarVenta", function(){

        var idVenta = $(this).attr("idVenta");
        var numVenta = $(this).attr("factura");

        $(".ventaTituloAnular").html("Anular venta N°"+numVenta);
        $("#idVentaA").val(idVenta);
        
        
    });

/*==========================================
        VALIDAR ANULAR VENTA
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

            $("#formAnularFactura").validate({

                errorClass: "text-danger error",
                validClass: "state-primary",
                errorElement: "span",

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
    });

/*=========================================
        AUTOCOMPLETAR LOCALIDAD         
=========================================*/

    function aLocalidad(accion){

        var modo = accion;

        if (modo == 'Nuevo') {

            var cambio = "#localidadCliente";
            
        } else {

            var cambio = "#eLocalidadCliente";
            
        }
         
        var datos = new FormData();
        datos.append("TablaL", "Localidad");
        $.ajax({
            url:"ajax/clientes.ajax.php",
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

/*=========================================
        AUTOCOMPLETAR BARRIO            
=========================================*/

    function aBarrio(accion){

        var tipo = accion;

        if (tipo == "Nuevo") {

            var mostrar = '#barrioCliente';
            
        } else {

            var mostrar = '#eBarrioCliente';
            
        }

        var datos = new FormData();
        datos.append("TablaB", "Barrio");
        $.ajax({
            url:"ajax/clientes.ajax.php",
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

/*==========================================
        VALIDAR CREAR CLIENTE
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

            $("#formRegistroCliente").validate({

                errorClass: "messages text-danger",
                validClass: "state-success",
                errorElement: "p",

                rules: {
                    nombreCliente: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 20,
                        minlength: 3
                    },
                    apellidoCliente: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 30
                    },
                    calleCliente: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                        maxlength: 25,
                        minlength: 3
                    },
                    numCalleCliente: {
                        required: true,
                        number: true,
                        maxlength: 4,
                        minlength: 1
                    },
                    pisoCliente: {
                        required: false,
                        number: true,
                        maxlength: 2,
                        minlength: 1
                    },
                    deptoCliente: {
                        required: false,
                        pattern: /^[a-zA-Z0-9]+$/,
                        maxlength: 2,
                        minlength: 1
                    },
                    localidadCliente: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                        maxlength: 40,
                        minlength: 3,
                    },
                    barrioCliente: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                        maxlength: 20,
                        minlength: 3,
                    },
                    codAreaTelefono: {
                        required: true,
                        pattern: /^[0-9]+$/,
                        maxlength: 5,
                        minlength: 3
                    },
                    numeroTeléfono: {
                        required: true,
                        pattern: /^[0-9]+$/,
                        maxlength: 10,
                        minlength: 3
                    },
                },

                messages: {
                    nombreCliente: {
                        required: 'Ingrese un nombre',
                        minlength: 'Minimo 3 caracteres'
                    },
                    apellidoCliente: {
                        required: 'Ingrese Apellido',
                        minlength: 'Minimo 3 caracteres'
                    },
                    calleCliente: {
                        required: 'Ingrese nombre de calle',
                        minlength:'Mínimo 3 caracteres'
                    },
                    numCalleCliente: {
                        required: 'Ingrese número de calle',
                        number: 'Sólo se permiten números',
                        minlength:'Mínimo 1 número'
                    },
                    pisoCliente: {
                        number: 'Sólo se permiten números',
                        maxlength: 'máximo 2 caracteres',
                        minlength: 'mínimo 1 caracter'
                    },
                    deptoCliente: {
                        maxlength: 'máximo 2 caracteres',
                        minlength: 'mínimo 1 caracter'
                    },
                    localidadCliente: {
                        required: 'Ingrese la localidad',
                        minlength: 'Mínimo 3 caracteres'
                    },
                    barrioCliente: {
                        required: 'Ingrese el barrio',
                        minlength: 'Mínimo 3 caracteres'
                    },
                    codAreaTelefono: {
                        required: 'Ingresar',
                        minlength: 'Mínimo 3 caracteres'
                    },
                    numeroTeléfono: {
                        required: 'Ingresar',
                        minlength: 'Mínimo 3 caracteres'
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
        IMPRIMIR FACTURA
==========================================*/

    $(".tablas").on("click", ".btnImprimirFactura", function(){

        var idVenta = $(this).attr("idVenta");

        $("#idVentaC").val(idVenta);
        
    })

/*==========================================
        RANGO DE FECHAS
==========================================*/
   
    $('#daterange-btn').daterangepicker(
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
        
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        var fechaInicial = start.format('YYYY-MM-DD');
        
        var fechaFinal = end.format('YYYY-MM-DD');
        
        var capturarRango = $("#daterange-btn span").html();
               
        localStorage.setItem("capturarRango", capturarRango);

        window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

      }

    )

/*==========================================
        CANCELAR RANGO DE FECHAS
==========================================*/

    $(".daterangepicker.opensright .range_inputs .cancelBtn").on("click", function(){

        localStorage.removeItem("capturarRango");
        localStorage.clear();
        window.location = "ventas";
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

            window.location = "index.php?ruta=ventas&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;

        }

    })