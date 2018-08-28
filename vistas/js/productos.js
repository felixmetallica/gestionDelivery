/*==========================================
        ASIGNAR CODIGO A PRODUCTO
==========================================*/

    $("#rubroProducto").change(function(){

        var idRubro = $(this).val();
                
        var datos = new FormData();
        datos.append("idRubro", idRubro);

        $.ajax({
            url: "ajax/productos.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType:false,
            processData: false,
            dataType: "json",
            success:function(respuesta){
                               
                if (!respuesta) {

                    var nuevoCodigo = idRubro+"01";

                    $("#codigoProducto").val(nuevoCodigo);
                
                } else {

                    var nuevoCodigo = Number(respuesta["Codigo"]) + 1;
                
                    $("#codigoProducto").val(nuevoCodigo);


                } 

            }
        })

    })

/*==========================================
        SUBIR FOTO PRODUCTO
==========================================*/

    $(".nuevaImagen").change(function(){

        var imagen = this.files[0];
        var nombreImagen = this.files[0]["name"];
        var rutaDefault = 'vistas/img/productos/default/anonymous.png';

        $(".foto").val(nombreImagen);

        /*==========================================
            VALIDAR EL FORMATO DE IMAGEN PNG O JPG
        ==========================================*/

        if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png" ) {

            $(".nuevaImagen").val("");
            $(".foto").val("");
            $(".previsualizar").attr("src", rutaDefault);

                swal({
                    title: "Error!!",
                    text: "¡Solo se adminten archivos JPG o PNG!",
                    type: "error",
                    confirmButtonText: "Cerrar"
                });

        } else if (imagen["size"] > 2000000){

            $(".nuevaImagen").val("");
            $(".foto").val("");
            $(".previsualizar").attr("src", rutaDefault);

                swal({
                    title: "Error!!",
                    text: "¡El tamaño de la imagen no puede superar los 2 MB!",
                    type: "error",
                    confirmButtonText: "Cerrar"
                });

            } else {

               var datosImagen = new FileReader;
               datosImagen.readAsDataURL(imagen);

               $(datosImagen).on("load", function(event){

                    var rutaImagen = event.target.result;
                    $(".previsualizar").attr("src", rutaImagen);

               })

            }
                
        })  

    $("#modalEditarProducto").on('hidden.bs.modal', function () {

        var rutaDefault = 'vistas/img/productos/default/anonymous.png';
        $(".nuevaImagen").val("");
        $(".foto").val("");
        $(".previsualizar").attr("src", rutaDefault);


    });

/*=========================================
        EDITAR PRODUCTO
=========================================*/

    $('.eprecioCompra').hide();
    $('.estockMinimo').hide();

    $('.tablas tbody').on("click", "button.btnEditarProducto", function(){

        var idProducto = $(this).attr("idProducto");
        var codActual = $(this).attr("codActual");        
        var datos = new FormData();
        
        datos.append("idEditarProducto" ,idProducto);

        $.ajax({

            url: "ajax/productos.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                console.log("respuesta", respuesta);
                
                if (respuesta["Tipo"] == "Entero") {

                     tipo = "Entero";
                
                } else {

                    tipo = "Compuesto";
                }

                if (respuesta["RestaStock"] == "S") {

                    var afecta = "Si";

                } else {

                    var afecta = "No";

                }

                var precioComp = parseInt(respuesta["PrecioCompra"]);
                
                if (precioComp != 0) {

                    $('.eprecioCompra').show();
                    $('.estockMinimo').show();

                } else {

                    if (respuesta["StockMinimo"] !=0) {

                        $('.estockMinimo').show();
                        $('.eprecioCompra').hide();

                    } else {

                        $('.estockMinimo').hide();
                        $('.eprecioCompra').hide();

                    }

                }
                
                $("#enombreProducto").val(respuesta["Nombre"]);
                $("#eprecioProducto").val(respuesta["PrecioVenta"]);
                $("#erubroProducto").val(respuesta["Rubro"]);
                $("#nombreProductoModal").html("Editar "+respuesta["Nombre"]);
                $("#idProductoE").val(respuesta["ProductoID"]);
                $("#ecodigoProducto").val(respuesta["Codigo"]);
                $("#valorA").val(respuesta["Codigo"]);
                $("#ValorR").val(respuesta["RubroID"]);
                $("#eTipoProducto").html(respuesta["Tipo"]);
                $("#eTipoProducto").val(tipo);

                $("#eafectaStockProducto").html(afecta);
                $("#eafectaStockProducto").val(respuesta["RestaStock"]);

                $("#ePrecioProductoCompra").val(respuesta["PrecioCompra"]);
                $("#eStockMinimoCompra").val(respuesta["StockMinimo"]);

                $(".foto").attr("placeholder", respuesta["Imagen"]);


                if (respuesta["Imagen"] !="") {

                    $("#imagenActual").val(respuesta["Imagen"]);

                    $(".previsualizar").attr("src", respuesta["Imagen"]);

                }

            }

        });



    })
    
/*=========================================
        ACTIVAR/DESACTIVAR PRODUCTO              
=========================================*/

    $('.tablas tbody').on("click", "button.btnActivarProducto", function(){

        var idProducto = $(this).attr("idProducto");
        var valorActivar = $(this).attr("estado");
        var nombreProducto = $(this).attr("nombreproducto");
                
        if (valorActivar=="S") {

            var estado = "desactivar";
            var cambio = "N";
            var estadoActual = "desactivado";
            var cambioActual = "desactivó";

        } else {

            var estado = "activar";
            var cambio = "S";
            var estadoActual = "activado";
            var cambioActual = "activó";

        }


        swal({
            title: "¡Atención!",
            text: "¿Desea "+estado+" el producto "+nombreProducto+"?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(){

            var datos = new FormData();
            datos.append("activarProducto", idProducto);
            datos.append("estadoProducto", cambio);

                $.ajax({
                    url:"ajax/productos.ajax.php",
                    type:"POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        if(respuesta ="ok"){

                            swal({
                                title:"Producto "+estadoActual+"!",
                                text:"¡El producto "+nombreProducto+" se "+cambioActual+" correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="productos";

                                    }

                                });

                        } else {

                            swal({
                                title:"Error!",
                                text:"¡El cambio no efectuó correctamente!",
                                type:"error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="productos";

                                    }

                                });
                        }

                    }

                });

        });


    })
    
/*=========================================
        ELIMINAR PRODUCTO
=========================================*/

     $('.tablas tbody').on("click", "button.btnEliminarProducto", function(){

        var idProductoEliminar = $(this).attr("idProducto");
        var nombreProducto = $(this).attr("nombreproducto");
        var Imagen = $(this).attr("Imagen");
        var Codigo = $(this).attr("Codigo");
       

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el producto "+nombreProducto+"?",
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
            datos.append("eliminarProducto", idProductoEliminar);
            datos.append("eliminarImagen", Imagen);
            datos.append("eliminarCodigo", Codigo);

            $.ajax({
                url:"ajax/productos.ajax.php",
                method:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta==0){

                        swal({
                        title:"Producto eliminado!",
                        text:"¡El producto se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="productos";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar el producto!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="productos";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });

     })

/*==========================================
        VALIDAR CREAR PRODUCTO
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

        $("#formAgregarProducto").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                nombreProducto: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9.\'\"\s]+$/,
                    maxlength: 40,
                    minlength: 3
                },
                precioProducto: {
                    required: true,
                    pattern: /^[0-9.]+$/,
                    maxlength: 4,
                    minlength: 2
                },
                rubroProducto: {
                    required: true,
                },
                tipoProducto: {
                    required: true,
                },
                afectaStockProducto: {
                    required: true,
                },
                precioProductoCompra: {
                    required: true,
                    pattern: /^[0-9.]+$/,
                    maxlength: 10,
                    minlength: 2
                },
                stockMinimoCompra: {
                    required: true,
                    pattern: /^[0-9.]+$/,
                    maxlength: 10,
                    minlength: 2
                },
            },
            messages: {
                nombreProducto: {
                    required: 'Ingrese el nombre del producto',
                    minlength: 'Minimo 3 caracteres'
                },
                precioProducto: {
                    required: 'Ingrese precio',
                    minlength: 'Minimo 2 caracteres'
                },
                rubroProducto: {
                    required: "Seleccione una opción",
                },
                tipoProducto: {
                    required: "Seleccione una opción",
                },
                afectaStockProducto: {
                    required: "Seleccione una opción",
                },
                precioProductoCompra: {
                    required: 'Ingrese precio',
                    minlength: 'Minimo 2 caracteres'
                },
                stockMinimoCompra: {
                    required: 'Ingrese cantidad mínima',
                    minlength: 'Minimo 2 caracteres'
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

/*==========================================
        VALIDAR EDITAR PRODUCTO
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

        $("#formEditarProducto").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                enombreProducto: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9.\'\"\s]+$/,
                    maxlength: 30,
                    minlength: 3
                },
                eprecioProducto: {
                    required: true,
                    pattern: /^[0-9.]+$/,
                    maxlength: 20,
                    minlength: 2
                },
                
            },
            messages: {
                enombreProducto: {
                    required: 'Ingrese el nombre del producto',
                    minlength: 'Minimo 3 caracteres'
                },
                eprecioProducto: {
                    required: 'Ingrese precio',
                    minlength: 'Minimo 2 caracteres'
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

/*==========================================
        FORMATEAR MODAL
==========================================*/

    $('#modalAgregarProducto').on('hidden.bs.modal', function (e) {
       
        document.getElementById("formAgregarProducto").reset();
        
        var validator = $( "#formAgregarProducto" ).validate();
        
            validator.resetForm();
        
        var rutaDefault = 'vistas/img/productos/default/anonymous.png';
            
            $(".nuevaImagen").val("");
            $(".foto").val("");
            $(".previsualizar").attr("src", rutaDefault);
            $('.precioCompra').hide();
            $('.stockMinimo').hide();


    });

/*==========================================
        MOSTRAR CAMPO PRECIO COMPRA
==========================================*/
    
    $('.precioCompra').hide();
    $('.stockMinimo').hide();

    $('#formAgregarProducto').on("change", "select.tipoProducto", function(){

        var tipo = $(this).val();
        
        if (tipo == "Entero") {

            $('.precioCompra').show();
            $('.stockMinimo').show();

        }else{

            $('.precioCompra').hide();
            $('.stockMinimo').show();

        }
                        
    });

    $('#formEditarProducto').on("change", "select.eTipoProductosel", function(){

        var tipo = $(this).val();
                
        if (tipo == "Entero") {

            $('.eprecioCompra').show();
            $('.estockMinimo').show();

        }else{

            $('.eprecioCompra').hide();
            $('.estockMinimo').show();
            $('#ePrecioProductoCompra').val('');

        }
                        
    });

/*==========================================
        MOSTRAR CAMPO STOCK MINIMO
==========================================*/
    
    $('#formAgregarProducto').on("change", "select.controlStock", function(){

        var tipoProducto = $("#tipoProducto").val();
        
        var afecta = $(this).val();
        
        if (tipoProducto == "Entero" ) {

            $('.precioCompra').show();
            $('.stockMinimo').show();

        } else {

            if (afecta == "S") {

                $('.precioCompra').hide();
                $('.stockMinimo').show();

            } else {

                $('.precioCompra').hide();
                $('.stockMinimo').hide();


            }

        }
                        
    });


    $('#formEditarProducto').on("change", "select.eControlStock", function(){

        var tipoProducto = $(".eTipoProductosel").val();
                
        var afecta = $(this).val();
        
        if (tipoProducto == "Entero" ) {

            $('.eprecioCompra').show();
            $('.estockMinimo').show();

        } else {

            if (afecta == "S") {

                $('.eprecioCompra').hide();
                $('.estockMinimo').show();

            } else {

                $('.eprecioCompra').hide();
                $('.estockMinimo').hide();
                $("#eStockMinimoCompra").val('');

            }

        }
                        
    });

    