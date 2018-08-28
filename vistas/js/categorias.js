/*=========================================
        EDITAR CATEGORIA
=========================================*/

    function editarCategoria(id){

        var idCategoria = id;

        var datos = new FormData();
        datos.append("idCategoria" ,idCategoria);

        $.ajax({

            url: "ajax/configuracion.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                $("#ecategoria").val(respuesta["NombreCategoria"]);
                $("#epuesto").val(respuesta["PuestoID"]);
                $("#epuesto").html(respuesta["NombrePuesto"]);
                $("#idCategoria").val(respuesta["CategoriasID"]);
                $("#esueldoBasico").val(respuesta["SueldoBasico"]);
                $("#nombreCategoria").html('Editar '+ respuesta["NombrePuesto"] + ' ' + respuesta["NombreCategoria"]);

            }

        });

    }

/*=========================================
        ELIMINAR CATEGORIA
=========================================*/

    function eliminarCategoria(id, nomb){

        var idCategoria = id;
        console.log("idCategoria", idCategoria);
        var nombreCategoria = nomb;

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar la categoría "+nombreCategoria+"?",
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
            datos.append("eliminarCategoria", idCategoria);

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
                        title:"Categoría eliminada!",
                        text:"¡La categoría se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="categorias";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar la categoría!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="categorias";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });

    }

/*==========================================
        VALIDAR CREAR CATEGORIA
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

        $("#formAgregarCategoria").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                categoria: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                    },
                sueldoBasico: {
                    required: true,
                    pattern: /^[0-9.]+$/,
                    maxlength: 20,
                    minlength: 3
                    },
                puesto: {
                    required: true,
                },
            },
            messages: {
                categoria: {
                    required: 'Ingrese el nombre de la categoria',
                    minlength: 'Minimo 3 caracteres'
                },
                sueldoBasico: {
                    required: 'Ingrese el monto del sueldo',
                    minlength: 'Minimo 3 caracteres'
                },
                puesto: {
                    required: "Seleccione un puesto",
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
        VALIDAR EDITAR CATEGORIA
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

        $("#formEditarCategoria").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                ecategoria: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                    },
                esueldoBasico: {
                    required: true,
                    pattern: /^[0-9.]+$/,
                    maxlength: 20,
                    minlength: 3
                    },
            },
            messages: {
                ecategoria: {
                    required: 'Ingrese el nombre de la categoria',
                    minlength: 'Minimo 3 caracteres'
                },
                esueldoBasico: {
                    required: 'Ingrese el monto del sueldo',
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
