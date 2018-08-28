/*=========================================
            EDITAR RUBRO
=========================================*/

    function editarRubro(id, tipo){

        var idRubro = id;
        var tipoRubro = tipo;
           
        var datos = new FormData();
        datos.append("idRubro" ,idRubro);

        $.ajax({

            url: "ajax/configuracion.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                
                $("#erubro").val(respuesta["Nombre"]);
                $("#nombreEdito").html('Editar rubro '+respuesta["Nombre"]);
                $("#idRubro").val(respuesta["RubroID"]);
                $("#etipoRubro").val(respuesta["Tipo"]);
                $("#etipoRubro").html(respuesta["Tipo"]);
                

            }

        });

    }

/*=========================================
        ELIMINAR RUBRO
=========================================*/

    function eliminarRubro(id, nomb){

        var idRubro = id;
        var nombreRubro = nomb;

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el rubro "+nombreRubro+"?",
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
            datos.append("eliminarRubro", idRubro);

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
                        title:"Rubro eliminado!",
                        text:"¡El rubro se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="rubros";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar el rubro!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="rubros";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });

    }

/*==========================================
        VALIDAR CREAR RUBRO
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

        $("#formAgregarRubro").validate({

            errorClass: "messages text-danger",
            validClass: "state-success",
            errorElement: "p",

            rules: {
                rubro: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                },
                tipoRubro: {
                    required: true,
                },
            },
            messages: {
                rubro: {
                    required: 'Ingrese el nombre del rubro',
                    minlength: 'Minimo 3 caracteres'
                },
                tipoRubro: {
                    required: "seleccione una opción",
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
        VALIDAR EDITAR RUBRO
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

        $("#formEditarRubro").validate({

            errorClass: "messages text-danger",
            validClass: "state-success",
            errorElement: "p",

            rules: {
                erubro: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                },
                etipoRubro: {
                    required: true,
                    
                },
            },
            messages: {
                erubro: {
                    required: 'Ingrese el nombre del rubro',
                    minlength: 'Minimo 3 caracteres'
                },
                etipoRubro: {
                    required: "Seleccione una opción",
                    
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
