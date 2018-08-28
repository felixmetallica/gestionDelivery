/*==========================================
        ASIGNAR CODIGO A INSUMO
==========================================*/

    $("#rubroInsumo").change(function(){

        var idRubro = $(this).val();
                        
        var datos = new FormData();
        datos.append("idRubro", idRubro);

        $.ajax({
            url: "ajax/insumos.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType:false,
            processData: false,
            dataType: "json",
            success:function(respuesta){
                console.log("respuesta", respuesta);
                               
                if (!respuesta) {

                    var nuevoCodigo = idRubro+"01";

                    $("#codigoInsumo").val(nuevoCodigo);
                
                } else {

                    var nuevoCodigo = Number(respuesta["Codigo"]) + 1;
                
                    $("#codigoInsumo").val(nuevoCodigo);


                } 

                

            }
        })



    })

/*=========================================
        EDITAR INSUMO
=========================================*/

    $('.tablas tbody').on("click", "button.btnEditarInsumo", function(){

        var idInsumo = $(this).attr("idInsumo");
        
        var datos = new FormData();
        datos.append("idEditarInsumo" ,idInsumo);

        $.ajax({

            url: "ajax/insumos.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                
                $("#nombreIsumoModal").html("Editar "+respuesta["Nombre"]);
                $("#enombreInsumo").val(respuesta["Nombre"]);
                $("#erubroInsumo").val(respuesta["Rubro"]);
                $("#emedidaInsumo").val(respuesta["Medida"]);
                $("#emedidaInsumo").html(respuesta["Medida"]);
                $("#esMinimoInsumo").val(respuesta["StockMinimo"]);
                $("#epCompra").val(respuesta["PrecioCompra"]);
                $("#idInsumo").val(respuesta["InsumosID"]);
                $("#idRubro").val(respuesta["RubroID"]);
                $("#ecodigoInsumo").val(respuesta["Codigo"]);
                         
            }

        });

    })

/*=========================================
        ELIMINAR INSUMO
=========================================*/

     $('.tablas tbody').on("click", "button.btnEliminarInsumo", function(){

        var idInsumoEliminar = $(this).attr("idInsumo");
        var nombreInsumo = $(this).attr("Nombre");
              

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el insumo "+nombreInsumo+"?",
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
            datos.append("eliminarinsumo", idInsumoEliminar);
            
            $.ajax({
                url:"ajax/insumos.ajax.php",
                method:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta==0){

                        swal({
                        title:"Insumo eliminado!",
                        text:"¡El insumo se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="insumos";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar el insumo!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="insumos";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });

     })

/*==========================================
        VALIDAR CREAR INSUMO
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

        $("#formAgregarInsumo").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                nombreInsumo: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9.\'\"\s]+$/,
                    maxlength: 30,
                    minlength: 3
                },
                rubroInsumo: {
                    required: true,
                    
                },
                medidaInsumo: {
                    required: true,
                          
                },
                sMinimoInsumo: {
                    required: true,
                    number: true,
                    minlength: 1,
                    maxlength: 4
                    
                },
                pCompra: {
                    required: true,
                    number: true,
                    maxlength: 10,
                    minlength: 2
                },
            },
            messages: {
                nombreInsumo: {
                    required: 'Ingrese el nombre del insumo',
                    minlength: 'Minimo 3 caracteres'
                },
                rubroInsumo: {
                    required: "Seleccione una opción",
                    
                },
                medidaInsumo: {
                    required: "Seleccione una opción",
                    
                },
                sMinimoInsumo: {
                    required: "Ingrese una cantidad",
                    number: "Ingrese una cantidad válida",

                },
                pCompra: {
                    required: 'Ingrese precio',
                    number: "Ingrese una cantidad correcta",
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
        VALIDAR EDITAR INSUMO
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

        $("#formEditarInsumo").validate({

            errorClass: "text-danger error",
            validClass: "state-primary",
            errorElement: "span",

            rules: {
                enombreInsumo: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9.\'\"\s]+$/,
                    maxlength: 30,
                    minlength: 3
                },
                erubroInsumo: {
                    required: true,
                    
                },
                emedidaInsumo: {
                    required: true,
                          
                },
                esMinimoInsumo: {
                    required: true,
                    number: true,
                    minlength: 1,
                    maxlength: 4
                    
                },
                epCompra: {
                    required: true,
                    number: true,
                    maxlength: 10,
                    minlength: 2
                },
            },
            messages: {
                enombreInsumo: {
                    required: 'Ingrese el nombre del insumo',
                    minlength: 'Minimo 3 caracteres'
                },
                erubroInsumo: {
                    required: "Seleccione una opción",
                    
                },
                emedidaInsumo: {
                    required: "Seleccione una opción",
                    
                },
                esMinimoInsumo: {
                    required: "Ingrese una cantidad",
                    number: "Ingrese una cantidad válida",

                },
                epCompra: {
                    required: 'Ingrese precio',
                    number: "Ingrese una cantidad correcta",
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

    $("#modalAgregarInsumo").on('show.bs.modal', function () {

            var validator = $( "#formAgregarInsumo" ).validate();
            validator.resetForm();
            
        });

    $("#modalEditarInsumo").on('show.bs.modal', function () {

            var validator = $( "#formEditarInsumo" ).validate();
            validator.resetForm();
            
        });