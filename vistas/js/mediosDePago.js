/*=========================================
        EDITAR MDP
=========================================*/

    function editarMdp(id){

        var idMdp = id;
        console.log("idMdp", idMdp);

        var datos = new FormData();
        datos.append("idMdp" ,idMdp);

        $.ajax({

            url: "ajax/configuracion.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                
                $("#nombreMedio").html('Editar Medio de Pago '+respuesta["Nombre"]);
                $("#emdpNombre").val(respuesta["Nombre"]);
                $("#idMedio").val(respuesta["MedioPagoID"]);

                

            }

        });

    }

/*=========================================
        ELIMINAR MDP
=========================================*/

    function eliminarMdp(id, nomb){

        var idMdp = id;
        var nombreMdp = nomb;
        
        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el medio de pago "+nombreMdp+"?",
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
            datos.append("eliminarMdp", idMdp);
            
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
                        title:"Medio de pago eliminado!",
                        text:"¡El medio de pago se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="mediosDePago";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar el medio de pago!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="mediosDePago";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });

    }

/*==========================================
        VALIDAR CREAR MDP
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

        $("#formAgregarMdP").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                mdpNombre: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ.\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                    },
                
            },
            messages: {
                mdpNombre: {
                    required: "Ingrese el nombre",
                    maxlength: 'No se permiten más de dos caracteres',
                    minlength: 'Minimo un caracter'
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
        VALIDAR EDITAR MDP
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

        $("#formEditarMdP").validate({

            errorClass: "messages text-danger",
            validClass: "state-success",
            errorElement: "p",

            rules: {
                emdpNombre: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ.\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                    },
               
            },
            messages: {
                emdpNombre: {
                    required: "Ingrese el nombre",
                    maxlength: 'No se permiten más de dos caracteres',
                    minlength: 'Minimo un caracter'
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
        ACTIVAR/DESACTIVAR MDP              
=========================================*/

    function activarDesactivarMdp(id, nombre, activo){

        var idMdp = id;
        var valorActivar = activo;
        var nombreMdp = nombre;
        
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
            text: "¿Desea "+estado+" el Mdp "+nombreMdp+"?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(){

            var datos = new FormData();
            datos.append("activarMdp", idMdp);
            datos.append("estadoMdp", cambio);

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
                                title:"Medio de pago "+estadoActual+"!",
                                text:"¡El MDP "+nombreMdp+" se "+cambioActual+" correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){

                                    if(isConfirm){

                                        window.location="mediosDePago";

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

                                        window.location="mediosDePago";

                                    }

                                });
                        }

                    }

                });

        });

    }