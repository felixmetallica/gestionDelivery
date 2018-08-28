'use strict';
$(document).ready(function() {

/*=======================================
            CREAR PROVEEDOR
=======================================*/

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
                                        window.location="proveedores";
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
                                        window.location="proveedores";
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

/*=======================================
            EDITAR PROVEEDOR
=======================================*/

    $("#modalEditarProveedor").on('hidden.bs.modal', function(e){

        window.location="proveedores";
    });

    $("#editarProveedor").steps({
        headerTag: "h3",
        bodyTag: "fieldset",
        transitionEffect: "slideLeft",
        startIndex: 0,
        labels: {
        cancel: "Cancelar",
        current: "current step:",
        pagination: "Paginación",
        finish: "Finalizar",
        next: "Siguiente",
        previous: "Anterior",
        loading: "Cargando ..."},
        onFinished: function (event, currentIndex){

            // ENVIO DE FORMULARIO

            var datos = new FormData ($('#editarProveedor')[0]);

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

                    $('#modalEditarProveedor').modal().hide();

                    if(respuesta =="ok"){

                        swal({
                            title:"Modificación Exitosa!",
                            text:"¡El proveedor se modificó correctamente!",
                            type:"success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="proveedores";
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

                                window.location="proveedores";

                            }

                        });
                    }
                }
            });
        }
    });




}); // fin de document ready

    function editoProveedor(id){

        var idProveedor = id;

        var idProvDomi = id;

        var idProvRef = id;


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

                $("#NombreProveedorEditar").html('Editar proveedor '+respuesta["RazonSocial"]);
                $("#erazonProveedor").val(respuesta["RazonSocial"]);
                $("#idProveedorEditar").val(respuesta["ProveedorID"]);
                $("#ecuitProveedor").val(respuesta["CUITT"]);
                $("#eemailProveedor").val(respuesta["Email"]);
                $("#eivaProveedor").val(respuesta["IVAID"]);
                $("#eivaProveedor").html(respuesta["IVA"]);
                $("#erubroProveedor").val(respuesta["RubroID"]);
                $("#erubroProveedor").html(respuesta["Rubro"]);
                $("#ecodAreaTelefonoProveedor").val(respuesta["Prefijo"]);
                $("#enumeroTeléfonoProveedor").val(respuesta["NroTelefono"]);
                $("#detalleRazon").html(respuesta["RazonSocial"]);
                $("#detalleIva").html(respuesta["TipoIVA"]);
                $("#detalleEmail").html(respuesta["Email"]);
                $("#detalleFechaAlta").html(respuesta["Alta"]);
                $("#detalleRubro").html(respuesta["Rubro"]);


            }

        });

        var datosDom = new FormData();
        datosDom.append("traigoDomicilio" ,idProvDomi);
        $.ajax({

            url: "ajax/proveedores.ajax.php",
            method: "POST",
            data: datosDom,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){


                $("#ecalleProveedor").val(respuesta["Calle"]);
                $("#enumCalleProveedor").val(respuesta["Nro"]);
                $("#episoProveedor").val(respuesta["Piso"]);
                $("#edeptoProveedor").val(respuesta["Dpto"]);
                $("#elocalidadProveedor").val(respuesta["Localidad"]);
                $("#ebarrioProveedor").val(respuesta["Barrio"]);
                $("#ecodPostalProveedor").val(respuesta["CP"]);


            }

        });

        var datosRef = new FormData();
        datosRef.append("traigoReferente" ,idProvRef);
        $.ajax({

            url: "ajax/proveedores.ajax.php",
            method: "POST",
            data: datosRef,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){


                $("#idPersona").val(respuesta["PersonaID"]);
                $("#enombreRefProveedor").val(respuesta["Nombre"]);
                $("#idPerRef").val(respuesta["PersonaID"]);
                $("#eapellidoRefProveedor").val(respuesta["Apellido"]);
                $("#eemailRefProveedor").val(respuesta["Email"]);
                $("#ecodArRefProveedor").val(respuesta["Prefijo"]);
                $("#enumTelRefProveedor").val(respuesta["NroTelefono"]);




            }

        });



    }


/*============================================
            AUTOCOMPLETAR LOCALIDAD
============================================*/

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

/*============================================
            AUTOCOMPLETAR BARRIO
============================================*/

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

/*============================================
            DETALLES DE PROVEEDOR
============================================*/

    function detalleProveeodr(id){

        $("#tablaProveedor").hide(300);
        $('#detalleProveedor').show(300);

        var idProveedor = id;
        var idProvDomi = id;
        var idProvRef = id;

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


                if (respuesta["Activo"]=="S") {

                    var estado = "Activo";

                } else {

                    var  estado = "Desactivado";
                }



                $("#detalleRazonP").html(respuesta["RazonSocial"]);
                $("#detalleTelefonoProveedorP").html('<i class="icofont icofont-telephone"></i>('+respuesta["Prefijo"]+') - '+respuesta["NroTelefono"]);
                $("#detalleEmailProveedorP").html('<i class="icofont icofont-email"></i>'+respuesta["Email"]);
                $("#detalleRazon").html(respuesta["RazonSocial"]);
                $("#detalleIva").html(respuesta["IVA"]);
                $("#detalleEmail").html(respuesta["Email"]);
                $("#detalleFechaAlta").html(respuesta["Alta"]);
                $("#detalleCuit").html(respuesta["CUITT"]);
                $("#detalleRubro").html(respuesta["Rubro"]);
                $("#detalleTelefono").html('('+respuesta["Prefijo"]+') - '+respuesta["NroTelefono"]);
                $("#detalleEstado").html(estado);

            }

        });

        var datosDom = new FormData();
        datosDom.append("traigoDomicilio" ,idProvDomi);
        $.ajax({

            url: "ajax/proveedores.ajax.php",
            method: "POST",
            data: datosDom,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                if (respuesta["Piso"]!="") {

                    var pisoD = respuesta["Piso"];

                } else {

                    var pisoD = "-";

                }

                if (respuesta["Dpto"]!="") {

                    var deptoD = respuesta["Dpto"];

                } else {

                    var deptoD = "-";

                }

                $("#detalleCalle").html(respuesta["Calle"]);
                $("#detalleNumCalle").html(respuesta["Nro"]);
                $("#detallePiso").html(pisoD);
                $("#detalleDpto").html(deptoD);
                $("#detalleLocalidad").html(respuesta["Localidad"]);
                $("#detalleBarrio").html(respuesta["Barrio"]);
                $("#detalleCP").html(respuesta["CP"]);


            }

        });

        var datosRef = new FormData();
        datosRef.append("traigoReferente" ,idProvRef);
        $.ajax({

            url: "ajax/proveedores.ajax.php",
            method: "POST",
            data: datosRef,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                if (respuesta != "") {


                    $("#menuPestania").html('<ul class="nav nav-tabs md-tabs tab-timeline" role="tablist"><li class="nav-item" style="width: calc(100% / 3) !important;"><a class="nav-link active" data-toggle="tab" href="#proveedor" role="tab">Proveedor</a><div class="slide" style="width: calc(100% / 3) !important;"></div></li><li class="nav-item" style="width: calc(100% / 3) !important;"><a class="nav-link" data-toggle="tab" href="#domicilio" role="tab">Domicilio</a><div class="slide" style="width: calc(100% / 3) !important;"></div></li><li class="nav-item" style="width: calc(100% / 3) !important;"><a class="nav-link" data-toggle="tab" href="#referente" role="tab">Referente</a><div class="slide" style="width: calc(100% / 3) !important;"></div></li></ul>');

                    $("#detalleNombreRef").html(respuesta["Nombre"]);
                    $("#detalleApellidoRef").html(respuesta["Apellido"]);
                    $("#detalleEmailRef").html(respuesta["Email"]);
                    $("#detalleTelRef").html('('+respuesta["Prefijo"]+' ) - '+respuesta["NroTelefono"]);


                } else {



                    $("#menuPestania").html('<ul class="nav nav-tabs md-tabs tab-timeline" role="tablist"><li class="nav-item" style="width: calc(100% / 2) !important;"><a class="nav-link active" data-toggle="tab" href="#proveedor" role="tab">Proveedor</a><div class="slide" style="width: calc(100% / 2) !important;"></div></li><li class="nav-item" style="width: calc(100% / 2) !important;"><a class="nav-link" data-toggle="tab" href="#domicilio" role="tab">Domicilio</a><div class="slide" style="width: calc(100% / 2) !important;"></div></li></ul>');

                    $("#detalleNombreRef").html("-");
                    $("#detalleApellidoRef").html("-");
                    $("#detalleEmailRef").html("-");
                    $("#detalleTelRef").html("-");

                }






            }

        });

    }

    function volveraListas(){

      window.location="proveedores";
    }

/*==========================================
        ACTIVAR/DESACTIVAR PROVEEDOR
==========================================*/

    function activarDesactivarProveedor(id, nombre, activo){

        var idProveedor = id;
        var valorActivar = activo;
        var nombreProveedor = nombre;

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
            text: "¿Desea "+estado+" el proveedor "+nombreProveedor+"?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(){
            var datos = new FormData();
            datos.append("activarProveedor", idProveedor);
            datos.append("estadoProveedor", cambio);
            $.ajax({
                url:"ajax/proveedores.ajax.php",
                type:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta ="ok"){

                        swal({
                            title:"Proveedor "+estadoActual+"!",
                            text:"¡El proveedor "+nombreProveedor+" se "+cambioActual+" correctamente!",
                            type:"success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="proveedores";

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

                                window.location="proveedores";

                            }

                        });
                    }

                }

            });

        });
    }

/*==========================================
            ELIMINAR PROVEEDOR
==========================================*/
    function eliminarProveedor(idProv, idPer, nombre){

        var idProv = idProv;
        var idPersona = idPer;
        var nombreProv = nombre;

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el proveedor "+nombreProv+"?",
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
            datos.append("eliminarProveedor", idProv);
            datos.append("eliminarPersona", idPersona);

            $.ajax({
                url:"ajax/proveedores.ajax.php",
                method:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta==0){

                    swal({
                        title:"Proveedor eliminado!",
                        text:"¡El proveedor se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){

                        if(isConfirm){

                            window.location="proveedores";
                        }

                    });

                    } else {

                        swal({
                            title:"Error!",
                            text:"¡No se pudo eliminar el proveedor!",
                            type:"error",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="proveedores";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });
    }
