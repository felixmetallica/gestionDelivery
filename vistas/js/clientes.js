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

/*=========================================
            EDITAR CLIENTE                   
=========================================*/

    $('.tablas tbody').on("click", "button.btnEditarCliente", function(){

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
                

                $("#idCliente").val(respuesta["ClienteID"]);
                $("#idPersona").val(respuesta["PersonaID"]);
                $("#eNombreCliente").val(respuesta["Nombre"]);
                $("#eApellidoCliente").val(respuesta["Apellido"]);
                $("#eCalleCliente").val(respuesta["Calle"]);
                $("#eNumCalleCliente").val(respuesta["Nro"]);
                $("#ePisoCliente").val(respuesta["Piso"]);
                $("#eDeptoCliente").val(respuesta["Dpto"]);
                $("#eLocalidadCliente").val(respuesta["Localidad"]);
                $("#eIdLocalidadExistente").val(respuesta["LocalidadID"]);
                $("#eBarrioCliente").val(respuesta["Barrio"]);
                $("#eIdBarrioExistente").val(respuesta["BarrioID"]);
                $("#eCodAreaCliente").val(respuesta["Prefijo"]);
                $("#eNumeroTelefonoCliente").val(respuesta["NroTelefono"]);
                $("#eComentarioCliente").val(respuesta["Comentario"]);

            }
        });

    })

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

                errorClass: "text-danger error",
                validClass: "state-primary",
                errorElement: "span",

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
            VALIDAR EDITAR CLIENTE
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

            $("#formEditarCliente").validate({

                errorClass: "messages text-danger",
                validClass: "state-success",
                errorElement: "p",

                rules: {
                    eNombreCliente: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 20,
                        minlength: 3
                    },
                    eApellidoCliente: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 30
                    },
                    eCalleCliente: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                        maxlength: 25,
                        minlength: 3
                    },
                    eNumCalleCliente: {
                        required: true,
                        number: true,
                        maxlength: 4,
                        minlength: 1
                    },
                    ePisoCliente: {
                        required: false,
                        number: true,
                        maxlength: 2,
                        minlength: 1
                    },
                    eDeptoCliente: {
                        required: false,
                        pattern: /^[a-zA-Z0-9]+$/,
                        maxlength: 2,
                        minlength: 1
                    },
                    eLocalidadCliente: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                        maxlength: 40,
                        minlength: 3
                    },
                    eBarrioCliente: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                        maxlength: 40,
                        minlength: 3
                    },
                    eCodAreaCliente: {
                        required: true,
                        pattern: /^[0-9]+$/,
                        maxlength: 5,
                        minlength: 3
                    },
                    eNumeroTelefonoCliente: {
                        required: true,
                        pattern: /^[0-9]+$/,
                        maxlength: 10,
                        minlength: 3
                    },
                },

                messages: {
                    eNombreCliente: {
                        required: 'Ingrese un nombre',
                        minlength: 'Minimo 3 caracteres'
                    },
                    eApellidoCliente: {
                        required: 'Ingrese Apellido',
                        minlength: 'Minimo 3 caracteres'
                    },
                    eCalleCliente: {
                        required: 'Ingrese nombre de calle',
                        minlength:'Mínimo 3 caracteres'
                    },
                    eNumCalleCliente: {
                        required: 'Ingrese número de calle',
                        number: 'Sólo se permiten números',
                        minlength:'Mínimo 1 número'
                    },
                    ePisoCliente: {
                        number: 'Sólo se permiten números',
                        maxlength: 'máximo 2 caracteres',
                        minlength: 'mínimo 1 caracter'
                    },
                    eDeptoCliente: {
                        maxlength: 'máximo 2 caracteres',
                        minlength: 'mínimo 1 caracter'
                    },
                    eLocalidadCliente: {
                        required: 'Ingrese la localidad',
                        minlength: 'Mínimo 3 caracteres'
                    },
                    eBarrioCliente: {
                        required: 'Ingrese el barrio',
                        minlength: 'Mínimo 3 caracteres'
                    },
                    eCodAreaCliente: {
                        required: 'Ingresar',
                        minlength: 'Mínimo 3 caracteres'
                    },
                    eNumeroTelefonoCliente: {
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

/*=========================================
            ACTIVAR/DESACTIVAR CLIENTE              
=========================================*/

    $('.tablas tbody').on("click", "button.btnActivarCliente", function(){

        var idCliente = $(this).attr("idCliente");
        var valorActivar = $(this).attr("valor");
        var nombreCliente = $(this).attr("nombre");
        var apellidoCliente = $(this).attr("apellido");


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
            text: "¿Desea "+estado+" el cliente "+nombreCliente+" "+apellidoCliente+"?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(){

            var datos = new FormData();
            datos.append("activarCliente", idCliente);
            datos.append("estadoCliente", cambio);

                $.ajax({
                    url:"ajax/clientes.ajax.php",
                    type:"POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        if(respuesta ="ok"){

                            swal({
                                title:"Cliente "+estadoActual+"!",
                                text:"¡El cliente "+nombreCliente+" se "+cambioActual+" correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="clientes";

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

                                        window.location="clientes";

                                    }

                                });
                        }

                    }

                });

        });

    });

/*=========================================
            ELIMINAR CLIENTE            
=========================================*/
    $('.tablas tbody').on("click", "button.btnEliminarCliente", function(){

        var idCliente = $(this).attr("idCliente");
        var nombreCliente = $(this).attr("NombreCliente");
        var apellidoCliente = $(this).attr("ApellidoCliente");


        swal({
        title: "¡Atencion!",
        text: "¿Desea eliminar el cliente "+nombreCliente+" "+apellidoCliente+"?",
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
                datos.append("eliminarCliente", idCliente);
                
                $.ajax({
                    url:"ajax/clientes.ajax.php",
                    method:"POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        if(respuesta==0){

                            swal({
                                title:"Cliente eliminado!",
                                text:"¡El cliente se eliminó correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="clientes";

                                    }

                                });

                        }else{

                            swal({
                                title:"Error!",
                                text:"¡No se pudo eliminar el cliente!",
                                type:"error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="clientes";

                                    }

                                });

                        }

                    }

                });

            }, 1000);

        });

    })

/*=========================================
            DETALLES DE CLIENTE
=========================================*/

    $('.tablas tbody').on("click", "button.btnDetalleCliente", function(){

        $("#listadoClientes").hide(300);
        $('#detallesCliente').show(300);

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
                console.log("respuesta", respuesta);

                if (respuesta["Sexo"]=="M") {

                    var sexo = "Masculino";

                } else {

                    var  sexo = "Femenino";
                }

                if (respuesta["Activo"]=="S") {

                    var estado = "Activo";

                } else {

                    var  estado = "Desactivado";
                }

                if (respuesta["Piso"]!="") {

                    var piso = respuesta["Piso"];

                } else {

                  var piso = "-";

                }

                if (respuesta["Dpto"]!="") {

                    var Dpto = respuesta["Dpto"];

                } else {

                    var Dpto = "-";

                }

                if (respuesta["UltimaCompra"] == "00/00/0000 00:00 AM") {

                    var ultimoPedido = "-";
                
                } else {

                    var ultimoPedido = respuesta["UltimaCompra"];

                }

                $("#detalleNombreApellido").html(respuesta["Nombre"]+" "+respuesta["Apellido"]);
                $("#tituloDetalleCliente").html("Información de "+respuesta["Nombre"]+" "+respuesta["Apellido"]);
                $("#detalleTelefonoClienteP").html('<i class="icofont icofont-telephone"></i>('+respuesta["Prefijo"]+') - '+respuesta["NroTelefono"]);
                $("#detalleNombreCliente").html(respuesta["Nombre"]);
                $("#detalleCalleCliente").html(respuesta["Calle"]);
                $("#detallePisoCliente").html(piso);
                $("#detalleLocalidadCliente").html(respuesta["Localidad"]);
                $("#detalleTelefonoCliente").html("("+respuesta["Prefijo"]+") -"+respuesta["NroTelefono"]);
                $("#detalleUltimoPedido").html(ultimoPedido);

                $("#detalleApellidoCliente").html(respuesta["Apellido"]);
                $("#detalleNumCalleCliente").html(respuesta["Nro"]);
                $("#detalleDepartamentoCliente").html(Dpto);
                $("#detalleBarrioCliente").html(respuesta["Barrio"]);
                $("#detalleEstadoCliente").html(estado);
                $("#detalleComentarioCliente").html(respuesta["Comentario"]);
                $("#detalleFechaAltaCliente").html(respuesta["FechaAlta"]);
                $("#detallePedidoCliente").html(respuesta["Compras"]);

            }

        });
    
    });

    function volveraListas(){

      //  $("#listadoClientes").show(500);
      //  $('#detallesCliente').hide(500);

        window.location="clientes";
    }