/*=========================================
        EDITAR IVA
=========================================*/

    function editarIva(id){

        var idIva = id;

        var datos = new FormData();
        datos.append("idIva" ,idIva);

        $.ajax({

            url: "ajax/configuracion.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                $("#eiva").val(respuesta["Descripcion"]);
                $("#idIva").val(respuesta["IVAID"]);
                $("#nombreIva").html('Editar '+respuesta["Descripcion"]);

            }

        });

    }

/*=========================================
        ELIMINAR IVA
=========================================*/

    function eliminarIva(id, nomb){

        var idIva = id;
        var nombreCategoria = nomb;

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el impuesto "+nombreCategoria+"?",
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
            datos.append("eliminarIva", idIva);

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
                        title:"Iva eliminado!",
                        text:"¡El impuesto se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="iva";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar el impuesto!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="iva";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });

    }

/*==========================================
        VALIDAR CREAR IVA
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

        $("#formAgregarIva").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                iva: {
                    required: true,
                    pattern: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9-°.\s]+$/,
                    maxlength: 60,
                    minlength: 3
                },
            },
            messages: {
                iva: {
                    required: 'Ingrese descripción',
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
        VALIDAR EDITAR IVA
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

        $("#formEditarIva").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                eiva: {
                    required: true,
                    pattern: /^[a-zA-ZñÑáéíóúÁÉÍÓÚ0-9-°.\s]+$/,
                    maxlength: 60,
                    minlength: 3
                    },
            },
            messages: {
                eiva: {
                    required: 'Ingrese el nombre de la categoria',
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
