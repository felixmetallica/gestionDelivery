'use strict';
$(document).ready(function() {

/*=======================================
                CREAR EMPLEADO
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


    // FORMULARIO WIZARD

    var form = $("#registrarEmpleado").show();

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
            var datos = new FormData ($('#registrarEmpleado')[0]);

            $.ajax({
                url: 'ajax/empleados.ajax.php',
                type: 'post',
                dataType: 'json',
                cache: true,
                processData: false,
                contentType: false,
                data: datos,
                timeout: 8000,
                success: function(respuesta){

                    $('#modalAgregarEmpleado').modal().hide();

                    if(respuesta =="ok"){

                        swal({
                            title:"Registro Exitoso!",
                            text:"¡El empleado se registró correctamente!",
                            type:"success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                        
                            if(isConfirm){
                            
                                window.location="empleados";
                        
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
                        
                                window.location="empleados";
                        
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

                nombreEmpleado: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3
                },
                apellidoEmpleado: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                    maxlength: 30
                },
                dniEmpleado: {
                    required: true,
                    digits: true,
                    maxlength: 8,
                    minlength:7,
                    remote: {
                    url: 'ajax/empleados.ajax.php',
                    type: 'post',
                    data: {
                        dniUsuario: function(){
                            return $('#dniEmpleado').val();
                        }
                    }
                    }
                },
                emailEmpleado: {
                    required: true,
                    email: true,
                    remote: {
                    url: 'ajax/empleados.ajax.php',
                    type: 'post',
                    data: {
                        mail: function(){
                            return $('#emailEmpleado').val();
                        }
                    }
                    }
                },
                fechaEmpleado: {
                    required: true,
                    date: true
                },
                sexoEmpleado: {
                    required: true,
                },
                codPostalEmpleado: {
                    required: false,
                    number:true,
                    maxlength: 5,
                    minlength: 3
                },
                codAreaTelefonoEmpleado: {
                    required: true,
                    number:true,
                    maxlength: 5,
                    minlength: 3
                },
                calleEmpleado: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 25,
                    minlength: 3
                },
                numCalleEmpleado: {
                    required: true,
                    number:true,
                    maxlength: 4,
                    minlength: 1
                },
                barrioEmpleado: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 20,
                    minlength: 3,
                },
                localidadEmpleado: {
                    required: true,
                    pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ0-9\'\"\s]+$/,
                    maxlength: 40,
                    minlength: 3,
                },
                numeroTeléfonoEmpleado: {
                    required: true,
                    number:true,
                    maxlength: 10,
                    minlength: 3
                },
                fechaIngresoEmpleado: {
                    required: true,
                    date: true
                },
                puestoEmpleado: {
                    required: true,
                },
                categoriaEmpleado: {
                    required: true,
                },
                cuilEmpleado: {
                    required: true,
                    maxlength: 13,
                    minlength:13,
                    remote: {
                    url: 'ajax/empleados.ajax.php',
                    type: 'post',
                    data: {
                        cuil: function(){
                            return $('#cuilEmpleado').val();
                        }
                    }
                    }
                },
            },
            messages: {

                nombreEmpleado: {
                    required: 'Ingrese un nombre',
                    minlength: 'Minimo 3 caracteres'
                },
                apellidoEmpleado: {
                    required: 'Ingrese Apellido',
                    minlength: 'Minimo 3 caracteres'
                },
                dniEmpleado: {
                    required: 'Ingrese DNI',
                    digits: "Ingrese solo números",
                    minlength: 'Mínimo 7 digitos',
                    remote: 'Este DNI ya se encuentra registrado'
                },
                emailEmpleado: {
                    required: 'Ingrese una dirección de email',
                    email: 'Ingrese una dirección de email valida',
                    remote: 'El email ya se encuentra registrado'
                },
                fechaEmpleado: {
                    required: 'Ingrese una fecha',
                    date: 'Ingrese una fecha valida'
                },
                codAreaTelefonoEmpleado: {
                    required: 'Ingresar',
                    minlength: 'Mínimo 3 caracteres',
                    number: 'Solo números'
                },
                numeroTeléfonoEmpleado: {
                    required: 'Ingresar',
                    minlength: 'Mínimo 3 caracteres',
                    number: 'Solo  números'
                },
                sexoEmpleado: {
                    required: 'Seleccione una opción',
                },
                calleEmpleado: {
                    required: 'Ingrese nombre de calle',
                    minlength:'Mínimo 3 caracteres'
                },
                numCalleEmpleado: {
                    required: 'Ingrese número de calle',
                    minlength:'Mínimo 1 número',
                    number: 'Solo se permiten números'
                },
                barrioEmpleado: {
                    required: 'Ingrese el barrio',
                    minlength: 'Mínimo 3 caracteres'
                },
                localidadEmpleado: {
                    required: 'Ingrese la localidad',
                    minlength: 'Mínimo 3 caracteres'
                },
                codPostalEmpleado: {
                    number: 'Solo se permiten números'
                },
                fechaIngresoEmpleado: {
                    required: 'Ingrese una fecha',
                    date: 'Ingrese una fecha valida'
                },
                puestoEmpleado: {
                    required: 'Seleccione una opción',
                },
                categoriaEmpleado: {
                    required: 'Seleccione una opción',
                },
                cuilEmpleado: {
                    required: 'Ingrese el Cuil',
                    minlength: 'Debe ingresar todos los dígitos',
                    remote: 'El Cuil ya esta registrado'
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
=            EDITAR EMPLEADO            =
=======================================*/

    $("#modalEditarEmpleado").on('hidden.bs.modal', function(e){

        window.location="empleados";
   
    });

    $("#modificarEmpleado").steps({
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

            var datos = new FormData ($('#modificarEmpleado')[0]);

            $.ajax({
                url: 'ajax/empleados.ajax.php',
                type: 'post',
                dataType: 'json',
                cache: true,
                processData: false,
                contentType: false,
                data: datos,
                timeout: 8000,
                success: function(respuesta){

                    $('#modalEditarEmpleado').modal().hide();

                    if(respuesta =="ok"){

                        swal({
                            title:"Modificación Exitosa!",
                            text:"¡El empleado se modificó correctamente!",
                            type:"success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                            
                            if(isConfirm){
                    
                                window.location="empleados";
                            }
                        });

                    } else {

                        swal({
                            title:"Error!",
                            text:"¡ocurrió un error, revise los datos!",
                            type:"error",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                        
                            if(isConfirm){
                        
                                window.location="empleados";
                            
                            }
                        
                        });
                    }
                }
            });
        }
    });


////////////////////////////////////////////////////
});

    function editarEmpleado(id, categoria, puesto){

        var idEmpleado = id;
        var idCategoria = categoria;
        var idPuesto = puesto;
        
        var datos = new FormData();
        
        datos.append("idEmpleado" ,idEmpleado);
    
        $.ajax({

            url: "ajax/empleados.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){

                if (respuesta["Sexo"] == "M") {

                    var sexo = "Masculino";

                } else {

                    var sexo = "Femenino";

                }

                $(".tituloEditoEmpleado").html("Editar "+respuesta["Nombre"]+" "+respuesta["Apellido"]);
                $("#eidEmpleado").val(respuesta["EmpleadoID"]);
                $("#eidPersona").val(respuesta["PersonaID"]);
                $("#enombreEmpleado").val(respuesta["Nombre"]);
                $("#eapellidoEmpleado").val(respuesta["Apellido"]);
                $("#edniEmpleado").val(respuesta["DNI"]);
                $("#eEmailEmpleado").val(respuesta["Email"]);
                $("#efechaEmpleado").val(respuesta["Nacimiento"]);
                $("#esexoEmpleado").val(respuesta["Sexo"]);
                $("#esexoEmpleado").html(sexo);
                $("#ecalleEmpleado").val(respuesta["Calle"]);
                $("#enumCalleEmpleado").val(respuesta["Nro"]);
                $("#episoEmpleado").val(respuesta["Piso"]);
                $("#edeptoEmpleado").val(respuesta["Dpto"]);
                $("#elocalidadEmpleado").val(respuesta["Localidad"]);
                $("#ebarrioEmpleado").val(respuesta["Barrio"]);
                $("#ecodPostalEmpleado").val(respuesta["CP"]);
                $("#ecodAreaTelefonoEmpleado").val(respuesta["Prefijo"]);
                $("#enumeroTeléfonoEmpleado").val(respuesta["NroTelefono"]);
                $("#elegajoEmpleado").val(respuesta["Legajo"]);
                $("#efechaIngresoEmpleado").val(respuesta["Ingreso"]);
                $("#epuestoEmpleado").val(respuesta["PuestoID"]);
                $("#epuestoEmpleado").html(respuesta["Puesto"]);
                //$("#ecategoriaEmpleado").val(respuesta["CategoriasID"]);
                //$("#ecategoriaEmpleado").html(respuesta["Categoria"]);
                $("#ecuilEmpleado").val(respuesta["CUIL"]);

            }

        });

        var datosC = new FormData();
        datosC.append("idPuesto", idPuesto);
        datosC.append("idCate", idCategoria);
        
        $.ajax({

                url: "ajax/empleados.ajax.php",
                method: "POST",
                data: datosC,
                cache: false,
                contentType: false,
                processData: false,
                success: function(respuesta){
                    

                    $(".ecategoriaEmpleado").html(respuesta);
                                               
                   
                }
        });

     
    $('#modificarEmpleado').on("change", "select.epuestoEmpleado", function(){

        var idPuesto = $(this).val();
                                
        var datos = new FormData();
        datos.append("idPuesto", idPuesto);
        datos.append("idCate", null);
        
        $.ajax({

                url: "ajax/empleados.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success: function(respuesta){
                    

                    $(".ecategoriaEmpleado").html(respuesta);
                                               
                   
                }
        });       
    
        });

    }

/*==========================================
            AUTOCOMPLETAR LOCALIDAD         
==========================================*/

    function aLocalidad(accion){

        var modo = accion;

        if (modo == 'Nuevo') {

            var cambio = "#localidadEmpleado";
            
        } else {

            var cambio = "#elocalidadEmpleado";
            
        }
         
        var datos = new FormData();
        datos.append("TablaL", "Localidad");
        $.ajax({
            url:"ajax/empleados.ajax.php",
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

            var mostrar = '#barrioEmpleado';
            
        } else {

            var mostrar = '#ebarrioEmpleado';
            
        }

        var datos = new FormData();
        datos.append("TablaB", "Barrio");
        $.ajax({
            url:"ajax/empleados.ajax.php",
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

/*==========================================
            TRAER CATEGORIA EMPLEADO
==========================================*/

    $('#registrarEmpleado').on("change", "select.puestoEmpleado", function(){

        var idPuesto = $(this).val();
                        
        var datos = new FormData();
        datos.append("idPuesto", idPuesto);
        datos.append("idCate", null);

        $.ajax({

            url: "ajax/empleados.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function(respuesta){
                
                $("#categoriaEmpleado").html(respuesta);
                         
            }
        });       
        

    });

/*==========================================
            ACTIVAR/DESACTIVAR EMPLEADO
==========================================*/

     $(".tablas").on("click", ".btnDesactivarEmpleado", function(){

        var idEmpleado = $(this).attr("idEmpleado");
        var valorActivar = $(this).attr("valor");
        var nombreEmpleado = $(this).attr("nombreEmpleado");
        var apellidoEmpleado = $(this).attr("apellidoEmpleado");

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
            text: "¿Desea "+estado+" el empleado "+nombreEmpleado+" "+apellidoEmpleado+"?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        },
        function(){
            var datos = new FormData();
            datos.append("activarEmpleado", idEmpleado);
            datos.append("estadoEmpleado", cambio);
            $.ajax({
                url:"ajax/empleados.ajax.php",
                type:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta ="ok"){

                        swal({
                            title:"Empleado "+estadoActual+"!",
                            text:"¡El empleado "+nombreEmpleado+" "+apellidoEmpleado+" se "+cambioActual+" correctamente!",
                            type:"success",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){
                            
                            if(isConfirm){
                            
                                window.location="empleados";
                            
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
                            
                                window.location="empleados";
                            
                            }

                        });
                    }

                }

            });

        });
    });

/*========================================
            ELIMINAR EMPLEADO           
========================================*/

    function eliminarEmpleado(idEmpl, idPer, nombre, apellido,usuario, imagen, userNombre, imagenEmpl){

        var idEmpleado = idEmpl;
        var idPersona = idPer;
        var nombreEmpleado = nombre;
        var apellidoEmpleado = apellido;
        var idUsuario = usuario;
        var imagenUser = imagen;
        var userName = userNombre;
        var imagenEmple = imagenEmpl;
      
        swal({
          title: "¡Atencion!",
          text: "¿Desea eliminar el empleado "+nombreEmpleado+" "+apellidoEmpleado+"?",
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
            datos.append("eliminarEmpleado", idEmpleado);
            datos.append("eliminarPersona", idPersona);
            datos.append("eliminarUsuario", idUsuario);
            datos.append("eliminarUserName", userName);
            datos.append("eliminarUserImagen", imagenUser);
            datos.append("eliminarEmpleadoImagen", imagenEmpl);
            
            $.ajax({
                url:"ajax/empleados.ajax.php",
                method:"POST",
                data: datos, 
                cache: false,
                contentType: false,
                processData: false,

                success:function(respuesta){
                    
                    if(respuesta==0){

                        swal({
                                title:"Empleado eliminado!",
                                text:"¡El empleado se eliminó correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                window.location="empleados";
                                }
                                });

                    }else{

                        swal({
                                title:"Error!",
                                text:"¡No se pudo eliminar el empleado!"+respuesta,
                                type:"error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                window.location="empleados";
                                }
                                });
                    }
                } 
            });;
          }, 1000);
        });
    }

/*==========================================
            CREAR USUARIO            
==========================================*/
    $(".btnCrearUsuario").click(function(){

        var nombreCusuario = $(this).attr("nombreCuser"); 
        var apellidoCusuario = $(this).attr("apeCuser");

        $("#tituloCrear").html("Crear usuario para "+nombreCusuario +" "+ apellidoCusuario);

    })

    //SUBIR FOTO
    $(".nuevaFoto").change(function(){

        var imagen = this.files[0];
        var nombreImagen = this.files[0]["name"];
        var rutaDefault = 'vistas/img/usuarios/default/User_ring.png';

        $(".foto").val(nombreImagen);


        //VALIDAR EL FORMATO DE IMAGEN PNG O JPG  

        if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png" ) {

            $(".nuevaFoto").val("");
            $(".foto").val("");
            $(".previsualizar").attr("src", rutaDefault);

            swal({
                title: "Error al subir la imagen",
                text: "¡La imagen debe estar en formato JPG o PNG!",
                type: "error",
                confirmButtonText: "Cerrar"
            });


        } else if(imagen["size"] > 2000000){

            $(".nuevaFoto").val("");
            $(".foto").val("");
            $(".previsualizar").attr("src", rutaDefault);

            swal({
                title: "Error al subir la imagen",
                text: "¡El tamaño de la imagen no puede superar los 2 MB!",
                type: "error",
                confirmButtonText: "Cerrar"
            });

        } else {

            var datosImagen = new FileReader;
            datosImagen.readAsDataURL(imagen);

            $(datosImagen).on("load", function(event){

                var rutaImagen = event.target.result;
                $(".previsualizar").attr("src", rutaImagen);

            })
        }

        $("#crearUsuario").on('hidden.bs.modal', function(e){

            $(".nuevaFoto").val("");
            $(".foto").val("");
            $(".previsualizar").attr("src", rutaDefault);

            });

    });

    $(".tablas").on("click", ".btnCrearUsuario", function(){
         
        var idEmpl = $(this).attr("idEmpleadoCrearUsuario");
        var idPers = $(this).attr("idPersonaCrearUsuario");  

        $("#iEmpleado").val(idEmpl);
        $("#iPersona").val(idPers);

    })

/*==========================================
            VALIDAR CREAR USUARIO
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
        
            $("#formCrearUsuario").validate({

                errorClass: "messages text-danger",
                validClass: "state-success",
                errorElement: "span",
         
                errorPlacement: function(error, element) {
            
                    error.appendTo( element.parent("label").next("span") );
          
                },

                rules: {
                    nombreUsuario: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 20,
                        minlength: 3
                    },
                    apellidoUsuario: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 30
                    },
                    dniUsuario: {
                        required: true,
                        digits: true,
                        maxlength: 8,
                        minlength:7,
                        remote: {
                        url: 'ajax/usuarios.ajax.php',
                        type: 'post',
                        data: {
                            dniUsuario: function(){
                
                                return $('#dniUsuario').val();
                
                            }
                        }
                        }
                    },
                    emailUsuario: {
                        required: true,
                        email: true,
                        remote: {
                        url: 'ajax/usuarios.ajax.php',
                        type: 'post',
                        data: {
                        mail: function(){
                    
                            return $('#emailUsuario').val();
                    
                            }
                        }
                        }
                    },
                    fechaUsuario: {
                        required: true,
                        date: true
                    },
                    sexoUsuario: {
                        required: true,
                    },
                    userUsuario: {
                        required: true,
                        pattern: /^[a-zA-Z0-9_]+$/,
                        maxlength: 16,
                        minlength: 5,
                        remote: {
                        url: 'ajax/usuarios.ajax.php',
                        type: 'post',
                        data: {
                            user: function(){
                    
                                return $('#userUsuario').val();
                            }
                        }
                        }
                    },
                    passUsuario: {
                        required: true,
                        passP: /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/,
                        minlength: 8,
                        maxlength: 16
                    },
                    rolUsuario: {
                        required: true,
                    },
                },
         
                messages: {
                    nombreUsuario: {
                        required: 'Ingrese un nombre',
                        minlength: 'Minimo 3 caracteres'
                    },
                    apellidoUsuario: {
                        required: 'Ingrese Apellido',
                        minlength: 'Minimo 3 caracteres'
                    },
                    dniUsuario: {
                        required: 'Ingrese DNI',
                        digits: "Ingrese solo números",
                        minlength: 'Mínimo 7 digitos',
                        remote: 'Este DNI ya se encuentra registrado'
                    },
                    emailUsuario: {
                        required: 'Ingrese una dirección de email',
                        email: 'Ingrese una dirección de email valida',
                        remote: 'El email ya se encuentra registrado'
                    },
                    fechaUsuario: {
                        required: 'Ingrese una fecha',
                        date: 'Ingrese una fecha valida'
                    },
                    sexoUsuario: {
                        required: 'Seleccione una opción',
                    },
                    userUsuario: {
                        required: 'Ingrese nombre de usuario',
                        minlength: 'Minimo 5 caracteres',
                        remote: 'Usuario no disponible'
                    },
                    passUsuario: {
                        required: 'Ingrese contraseña',
                        minlength: 'Minimo 5 caracteres'
                    },
                    rolUsuario: {
                        required: 'Seleccione una opción',
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
            TOOLTIP CONTRASEÑA        
==========================================*/

    $("#passUsuario").tooltip({});
    
/*==========================================
            DETALLES DE EMPLEADO            
==========================================*/

    function detalleEmpleado(id){

        $("#listadoEmpleados").hide(300);
        $('#detalleEmpleado').show(300);

        
        var idEmpleado = id;
            
        var datos = new FormData();
        datos.append("idEmpleado" ,idEmpleado);
      
        $.ajax({

            url: "ajax/empleados.ajax.php",
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
          
                if (respuesta["Activo"]=="S") {

                    var estado = "Activo";
          
                } else {
          
                    var  estado = "Desactivado";
                }

                if (respuesta["Imagen"]!="") {


                    var imagen = respuesta["Imagen"];


                } else {

                    var imagen = "vistas/img/usuarios/default/User_ring.png";

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

                if (respuesta["Imagen"]!="") {


                  var imagen = respuesta["Imagen"];


                } else {

                  var imagen = "vistas/img/usuarios/default/User_ring.png";

                }

                $("#detalleNombreApellido").html(respuesta["Nombre"]+" "+respuesta["Apellido"]);
                $("#detallePuestoD").html(respuesta["Puesto"]);
                $("#detalleTelefonoD").html(respuesta["NroTelefono"]);
                $("#detalleEmailD").html(respuesta["Email"]);
                $("#detalleNombreEmpleado").html(respuesta["Nombre"]);
                $("#detalleApellidoEmpleado").html(respuesta["Apellido"]);
                $("#detalleDNIEmpleado").html(respuesta["DNI"]);
                $("#detalleSexoEmpleado").html(sexo);
                $("#detalleFechaNacimientoEmpleado").html(respuesta["Nacimiento"]);

                $("#detalleCalleEmpleado").html(respuesta["Calle"]);
                $("#detallePisoEmpleado").html(piso);
                $("#detalleLocalidadEmpleado").html(respuesta["Localidad"]);
                $("#detalleCodPostalEmpleado").html(respuesta["CP"]);

                $("#detalleNumeroEmpleado").html(respuesta["Nro"]);
                $("#detalleDeptoEmpleado").html(Dpto);
                $("#detalleBarrioEmpleado").html(respuesta["Barrio"]);
                
                $("#detalleFechaIngresoEmpleado").html(respuesta["Ingreso"]);
                $("#detalleCategoriaEmpleado").html(respuesta["Categoria"]);
                $("#detallePuestoEmpleado").html(respuesta["Puesto"]);
                $("#detalleCuilEmpleado").html(respuesta["CUIL"]);
                $("#detalleEstadoEmpleado").html(estado);
                $("#detalleLegajoEmpleado").html(respuesta["Legajo"]);
                $("#empleadoIdFoto").val(respuesta["EmpleadoID"]);
                $("#fotoActual").val(respuesta["Imagen"]);
                $("#imagenDetalle").attr("src", imagen);

                $("#detalleSueldoEmpleado").html('$'+respuesta["Basico"]);

            }

        });

        $('#edit-cancel').on('click',function(){
  
            var c=$('#edit-btn').find( "i" );
            c.removeClass('icofont-close');
            c.addClass('icofont-edit');
            $('.EditfotoEmpleado').hide();

        });

        $('.EditfotoEmpleado').hide();


        $('#edit-btn').on('click',function(){
            var b=$(this).find( "i" );
            var edit_class=b.attr('class');
            
            if(edit_class=='icofont icofont-edit'){
                b.removeClass('icofont-edit');
                b.addClass('icofont-close');
                $('.EditfotoEmpleado').show();
            } else {
                b.removeClass('icofont-close');
                b.addClass('icofont-edit');
                $('.EditfotoEmpleado').hide();
            }
        });
    }

/*==========================================
            SUBIR FOTO EMPLEADO
==========================================*/

    $(".nuevaFotoEmpleado").change(function(){

        var imagen = this.files[0];

        var rutaDefault = 'vistas/img/usuarios/default/User_ring.png';

        /*==========================================
            VALIDAR EL FORMATO DE IMAGEN PNG O JPG
        ==========================================*/

        if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png" ) {

            $(".nuevaFotoEmpleado").val("");

                swal({
                    title: "Error!!",
                    text: "¡Solo se adminten archivos JPG o PNG!",
                    type: "error",
                    confirmButtonText: "Cerrar"
                });

        } else if (imagen["size"] > 2000000){

            $(".nuevaFotoEmpleado").val("");

                swal({
                    title: "Error!!",
                    text: "¡El tamaño de la imagen no puede superar los 2 MB!",
                    type: "error",
                    confirmButtonText: "Cerrar"
                });

            } else {

               var datosImagen = new FileReader;
               datosImagen.readAsDataURL(imagen);

               $(datosImagen).on("load", function(event){

                    var rutaImagen = event.target.result;
                    $(".previsualizar").attr("src", rutaImagen);

               })

            }

                
    })

    function volveraListas(){

        window.location="empleados";

    }

