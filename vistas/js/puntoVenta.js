/*==========================================
        AUTOCOMPLETAR LOCALIDAD         
==========================================*/

    function aLocalidad(accion){

        var modo = accion;

        if (modo == 'Nuevo') {

            var cambio = "#localidadPdv";
            
        } else {

            var cambio = "#elocalidadPdv";
            
        }
         
        var datos = new FormData();
        datos.append("TablaL", "Localidad");
        $.ajax({
            url:"ajax/configuracion.ajax.php",
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
==========================================*/

    function aBarrio(accion){

        var tipo = accion;

        if (tipo == "Nuevo") {

            var mostrar = '#barrioPdv';
            
        } else {

            var mostrar = '#ebarrioPdv';
            
        }

        var datos = new FormData();
        datos.append("TablaB", "Barrio");
        $.ajax({
            url:"ajax/configuracion.ajax.php",
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
        EDITAR PDV
=========================================*/

    $('.tablas tbody').on("click", "button.btnEditarPDV", function(){

        var idPdv = $(this).attr("idPDV");
        
        var datos = new FormData();
        datos.append("idPdv" ,idPdv);

        $.ajax({

            url: "ajax/configuracion.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                
                console.log('respuesta', respuesta);
                $("#NombrePuntoVenta").html('Editar Punto de Venta '+respuesta["Nombre"]);
                $("#epdvNombre").val(respuesta["Nombre"]);
                $("#idPdv").val(respuesta["PuntoVentaID"]);
                $("#estadoPDV").val(respuesta["Activo"]);
 
                $("#epdvCUIT").val(respuesta["CUITT"]);
                $("#epdvIngresosBrutos").val(respuesta["IngresosBrutos"]);
                $("#epdvInicioActividades").val(respuesta["Inicio"]);
                $("#epdvCodArea").val(respuesta["Prefijo"]);
                $("#epdvTelefono").val(respuesta["NroTelefono"]);

                $("#ecallePdv").val(respuesta["Calle"]);
                $("#enumCallePdv").val(respuesta["Nro"]);
                $("#episoPdv").val(respuesta["Piso"]);
                $("#edeptoPdv").val(respuesta["Dpto"]);
                $("#elocalidadPdv").val(respuesta["Localidad"]);
                $("#ebarrioPdv").val(respuesta["Barrio"]);
                $("#ecodPostalPdv").val(respuesta["CP"]);

            }

        });

    })

/*=========================================
        ELIMINAR PDV
=========================================*/

    $('.tablas tbody').on("click", "button.btnEliminarPDV", function(){

        var idPdv = $(this).attr("idPDV");
        var nombrePdv = $(this).attr("nombrePDV");
        
        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el Punto de Venta "+nombrePdv+"?",
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
            datos.append("eliminarPdv", idPdv);
            
            $.ajax({
                url:"ajax/configuracion.ajax.php",
                method:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta==0){

                        swal({
                        title:"Punto de Venta eliminado!",
                        text:"¡El Punto de Venta se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="puntoVenta";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar el Punto de Venta!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="puntoVenta";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });

    });

/*==========================================
        VALIDAR CREAR PDV
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

        $("#formAgregarPdv").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                pdvNombre: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                    },
                callePdv: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 25,
                    minlength: 3
                },
                numCallePdv: {
                    required: true,
                    number:true,
                    maxlength: 4,
                    minlength: 1
                },
                pisoPdv: {
                    required: false,
                    number:true,
                    maxlength: 2,
                    minlength: 1
                },
                deptoPdv: {
                    required: false,
                    pattern: /^[a-zA-Z0-9]+$/,
                    maxlength: 2,
                    minlength: 1
                },
                localidadPdv: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 80,
                    minlength: 3,
                },
                barrioPdv: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 80,
                    minlength: 3,
                },
                codPostalPdv: {
                    required: true,
                    number:true,
                    maxlength: 4,
                    minlength: 1
                },
            },
            messages: {
                pdvNombre: {
                    required: "Ingrese el nombre",
                    maxlength: 'No se permiten más de dos caracteres',
                    minlength: 'Minimo un caracter'
                    },
                callePdv: {
                    required: "Ingrese el nombre de la calle",
                    maxlength: 'No se permiten más de 22 caracteres',
                    minlength: 'Minimo tres caracter'
                },
                numCallePdv: {
                    required: 'Ingrese el número de la calle',
                    number:'Solo números',
                    maxlength: 'No se permiten más de 4 caracteres',
                    minlength: 'Minimo 1 caracter'
                },
                pisoPdv: {
                    required: 'Ingrese el piso',
                    number:'Solo números',
                    maxlength: 'No se permiten más de 2 caracteres',
                    minlength: 'Minimo 1 caracter'
                },
                deptoPdv: {
                    required: 'Ingrese el depto',
                    maxlength: 'No se permiten más de 2 caracteres',
                    minlength: 'Minimo 1 caracter'
                },
                localidadPdv: {
                    required: "Ingrese la localidad",
                    maxlength: 'No se permiten más de 40 caracteres',
                    minlength: 'Minimo 3 caracteres'
                },
                barrioPdv: {
                    required: "Ingrese el barrio",
                    maxlength: 'No se permiten más de 40 caracteres',
                    minlength: 'Minimo 3 caracteres'
                },
                codPostalPdv: {
                    required: "Ingrese el código postal",
                    number:"Solo números",
                    maxlength: 'No se permiten más de 4 caracteres',
                    minlength: 'Minimo 1 caracter'
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
        VALIDAR EDITAR PDV
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

        $("#formEditarPdv").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                epdvNombre: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                    },
                ecallePdv: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 25,
                    minlength: 3
                },
                enumCallePdv: {
                    required: true,
                    number:true,
                    maxlength: 4,
                    minlength: 1
                },
                episoPdv: {
                    required: false,
                    number:true,
                    maxlength: 2,
                    minlength: 1
                },
                edeptoPdv: {
                    required: false,
                    pattern: /^[a-zA-Z0-9]+$/,
                    maxlength: 2,
                    minlength: 1
                },
                elocalidadPdv: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 80,
                    minlength: 3,
                },
                ebarrioPdv: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 80,
                    minlength: 3,
                },
                ecodPostalPdv: {
                    required: true,
                    number:true,
                    maxlength: 4,
                    minlength: 1
                },
            },
            messages: {
                epdvNombre: {
                    required: "Ingrese el nombre",
                    maxlength: 'No se permiten más de dos caracteres',
                    minlength: 'Minimo un caracter'
                    },
                ecallePdv: {
                    required: "Ingrese el nombre de la calle",
                    maxlength: 'No se permiten más de 22 caracteres',
                    minlength: 'Minimo tres caracter'
                },
                enumCallePdv: {
                    required: 'Ingrese el número de la calle',
                    number:'Solo números',
                    maxlength: 'No se permiten más de 4 caracteres',
                    minlength: 'Minimo 1 caracter'
                },
                episoPdv: {
                    required: 'Ingrese el piso',
                    number:'Solo números',
                    maxlength: 'No se permiten más de 2 caracteres',
                    minlength: 'Minimo 1 caracter'
                },
                edeptoPdv: {
                    required: 'Ingrese el depto',
                    maxlength: 'No se permiten más de 2 caracteres',
                    minlength: 'Minimo 1 caracter'
                },
                elocalidadPdv: {
                    required: "Ingrese la localidad",
                    maxlength: 'No se permiten más de 40 caracteres',
                    minlength: 'Minimo 3 caracteres'
                },
                ebarrioPdv: {
                    required: "Ingrese el barrio",
                    maxlength: 'No se permiten más de 40 caracteres',
                    minlength: 'Minimo 3 caracteres'
                },
                ecodPostalPdv: {
                    required: "Ingrese el código postal",
                    number:"Solo números",
                    maxlength: 'No se permiten más de 4 caracteres',
                    minlength: 'Minimo 1 caracter'
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
        ACTIVAR/DESACTIVAR PDV              
=========================================*/

    function activarDesactivarPdv(id, nombre, activo){

        var idPdv = id;
        var valorActivar = activo;
        var nombrePdv = nombre;
        
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
            text: "¿Desea "+estado+" el PDV "+nombrePdv+"?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(){

            var datos = new FormData();
            datos.append("activarPdv", idPdv);
            datos.append("estadoPdv", cambio);

                $.ajax({
                    url:"ajax/configuracion.ajax.php",
                    type:"POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){

                        if(respuesta ="ok"){

                            swal({
                                title:"Punto de Venta "+estadoActual+"!",
                                text:"¡El PDV "+nombrePdv+" se "+cambioActual+" correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="puntoVenta";

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

                                        window.location="puntoVenta";

                                    }

                                });
                        }

                    }

                });

        });

    }