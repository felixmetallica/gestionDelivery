/*==========================================
        VALIDAR CREAR FAMILIAR
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

            $.validator.addMethod("passP", function(value, element, param) {

                if (this.optional(element)) {

                    return true;

                }

                if (typeof param === 'string') {

                    param = new RegExp('^(?:' + param + ')$');

                }

                    return param.test(value);

            }, "Por favor cumpla el requisito de contraseña");

            /* VALIDAMOS EL FORMULARIO DE CREAR USUARIO */

            $("#formRegistroFamiliar").validate({

                errorClass: "text-danger error",
                validClass: "state-primary",
                errorElement: "span",

                rules: {
                    nombreFamiliar: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 20,
                        minlength: 3
                    },
                    apellidoFamiliar: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 30
                    },
                    dniFamiliar: {
                        required: true,
                        digits: true,
                        maxlength: 8,
                        minlength:7,
                        remote: {
                        url: 'ajax/grupoFamiliar.ajax.php',
                        type: 'post',
                        data: {
                            dniFamiliar: function(){

                                return $('#dniFamiliar').val();

                            }
                        }
                        }
                    },
                    fechaFamiliar: {
                        required: true,
                        date: true
                    },
                    sexoFamiliar: {
                        required: true,
                    },
                    parentezcoFamiliar: {
                        required: true,
                    },
                    
                },

                messages: {
                    nombreFamiliar: {
                        required: 'Ingrese un nombre',
                        minlength: 'Minimo 3 caracteres'
                    },
                    apellidoFamiliar: {
                        required: 'Ingrese Apellido',
                        minlength: 'Minimo 3 caracteres'
                    },
                    dniFamiliar: {
                        required: 'Ingrese DNI',
                        digits: "Ingrese solo números",
                        minlength: 'Mínimo 7 digitos',
                        remote: 'Este DNI ya se encuentra registrado'
                    },
                    fechaFamiliar: {
                        required: 'Ingrese una fecha',
                        date: 'Ingrese una fecha valida'
                    },
                    sexoFamiliar: {
                        required: "Seleccione una opción",
                    },
                    parentezcoFamiliar: {
                        required: 'Seleccione una opción',
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
        EDITAR FAMILIAR
=========================================*/

    function editarFamiliar(idPar, idEmp){

        var idFamiliar = idPar;
        var idEmpleado = idEmp;
               
        var datos = new FormData();
        datos.append("idFamiliar" ,idFamiliar);
        datos.append("idEmpleado" ,idEmpleado);

        $.ajax({

            url: "ajax/grupoFamiliar.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

            	if (respuesta["Sexo"]=="M") {

                    var sexo = "Masculino";

                } else {

                    var  sexo = "Femenino";
                }

                switch (respuesta["Parentesco"]) {
                    case '1':
                       var parentesco = "Conyugue";
                       break;
                    case '2':
                       var parentesco = "Hijo";
                       break;
                    case '3':
                       var parentesco = "Hija";
                       break;
                    case '4':
                       var parentesco = "Padre";
                       break;
                    case '5':
                       var parentesco = "Madre";
                       break;
                    case '6':
                       var parentesco = "Hermano";
                       break;
                    case '7':
                       var parentesco = "Hermana";
                       break;
                    case '8':
                       var parentesco = "Otro";
                       break;
                   
                   default:
                       var parentesco = "Otro";
                       break;
               }

               	$("#idFamiliarEditar").val(respuesta["GrupoFamiliarID"]);
               	$("#idEmpleadoEditar").val(respuesta["EmpleadoID"]);
               	$("#idPersonaEditar").val(respuesta["PersonaID"]);

                $("#enombreFamiliar").val(respuesta["Nombre"]);
                $("#eapellidoFamiliar").val(respuesta["Apellido"]);
                $("#edniFamiliar").val(respuesta["DNI"]);
                $("#efechaFamiliar").val(respuesta["Nacimiento"]);
                $("#esexoFamiliar").val(respuesta["Sexo"]);
                $("#esexoFamiliar").html(sexo);
                $("#eparentezcoFamiliar").val(respuesta["Parentesco"]);
                $("#eparentezcoFamiliar").html(parentesco);

            }

        });

    }

/*=========================================
        ELIMINAR FAMILIAR
=========================================*/

    function eliminarFamiliar(idFam, idPer, IdEmp, nomb, apell){

        var idFamiliarEliminar = idFam;
        var idPersonaE = idPer;
        var idEmpleadoE = IdEmp;
        var nombreFamiliar = nomb;
        var apellidoFamiliar = apell;
        

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el familiar "+nombreFamiliar+" "+apellidoFamiliar+"?",
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
            datos.append("eliminarFamiliar", idFamiliarEliminar);
            datos.append("eliminarEmpleado", idEmpleadoE);
            datos.append("eliminarPersona", idPersonaE);

            $.ajax({
                url:"ajax/grupoFamiliar.ajax.php",
                method:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta==0){

                        swal({
                        title:"Familiar eliminado!",
                        text:"¡El familiar se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                            	$.redirect("grupoFamiliar",{ empleado: idEmpleadoE},"POST");

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

                                $.redirect("grupoFamiliar",{ empleado: idEmpleadoE},"POST");

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });

    }