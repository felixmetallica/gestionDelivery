/*=========================================
            EDITAR PUESTO
=========================================*/

    function editarPuesto(id){

        var idPuesto = id;

        var datos = new FormData();
        datos.append("idPuesto" ,idPuesto);

        $.ajax({

            url: "ajax/configuracion.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                
                $("#epuesto").val(respuesta["Nombre"]);
                $("#idPuesto").val(respuesta["PuestoID"]);
                $("#nombrePuesto").html('Editar puesto '+respuesta["Nombre"]);

            }

        });

    }

/*=========================================
        ELIMINAR PUESTO
=========================================*/

    function eliminarPuesto(id, nomb){

        var idPuesto = id;
        var nombrePuesto = nomb;

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el puesto "+nombrePuesto+"?",
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
            datos.append("eliminarPuesto", idPuesto);

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
                        title:"Puesto eliminado!",
                        text:"¡El puesto se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="puestos";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar el puesto!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="puestos";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });

    }

/*==========================================
        VALIDAR CREAR PUESTO
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

        $("#formAgregarPuesto").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                puesto: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                    },
            },
            messages: {
                puesto: {
                    required: 'Ingrese el nombre del puesto',
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

/*==========================================
        VALIDAR EDITAR PUESTO
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

        $("#formEditarPuesto").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                epuesto: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                    },
            },
            messages: {
                epuesto: {
                    required: 'Ingrese el nombre del puesto',
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
