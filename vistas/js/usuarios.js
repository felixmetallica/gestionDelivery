/*==========================================
        SUBIR FOTO USUARIO
==========================================*/

    $(".nuevaFoto").change(function(){

        var imagen = this.files[0];
        var nombreImagen = this.files[0]["name"];
        var rutaDefault = 'vistas/img/usuarios/default/User_ring.png';

        $(".foto").val(nombreImagen);

        /*==========================================
            VALIDAR EL FORMATO DE IMAGEN PNG O JPG
        ==========================================*/

        if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png" ) {

            $(".nuevaFoto").val("");
            $(".foto").val("");
            $(".previsualizar").attr("src", rutaDefault);

                swal({
                    title: "Error!!",
                    text: "¡Solo se adminten archivos JPG o PNG!",
                    type: "error",
                    confirmButtonText: "Cerrar"
                });

        } else if (imagen["size"] > 2000000){

            $(".nuevaFoto").val("");
            $(".foto").val("");
            $(".previsualizar").attr("src", rutaDefault);

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

                $("#modalAgregarUsuario").on('hidden.bs.modal', function () {

                    var rutaDefault = 'vistas/img/usuarios/default/User_ring.png';
                    $(".nuevaFoto").val("");
                    $(".foto").val("");
                    $(".previsualizar").attr("src", rutaDefault);


                });
    })

    $("#modalEditarUsuario").on('hidden.bs.modal', function () {

        var rutaDefault = 'vistas/img/usuarios/default/User_ring.png';
        $(".nuevaFoto").val("");
        $(".foto").val("");
        $(".previsualizar").attr("src", rutaDefault);

    });

/*==========================================
        TOOLTIP CONTRASEÑA
==========================================*/

    $("#passUsuario").tooltip({});
    $("#epassUsuario").tooltip({});

/*==========================================
        EDITAR USUARIO
==========================================*/

    $(".tablas").on("click", ".btnEditarUsuario", function(){

        var idUser = $(this).attr("idUsuario");

        var datos = new FormData();
        datos.append("idUsuario" ,idUser);

        $.ajax({

            url: "ajax/usuarios.ajax.php",
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

                $("#enombreUsuario").val(respuesta["nombrePersona"]);
                $("#idPersona").val(respuesta["PersonaID"]);
                $("#idUser").val(respuesta["UsuarioID"]);
                $("#tituloEditar").html("Editar usuario "+respuesta["NombreUsuario"]);
                $("#eapellidoUsuario").val(respuesta["Apellido"]);
                $("#edniUsuario").val(respuesta["DNI"]);
                $("#eemailUsuario").val(respuesta["Email"]);
                $("#mailExiste").val(respuesta["Email"]);
                $("#efechaUsuario").val(respuesta["Nacimiento"]);
                $("#esexoUsuario").val(respuesta["Sexo"]);
                $("#esexoUsuario").html(sexo);
                $("#euserUsuario").val(respuesta["NombreUsuario"]);
                $("#passwordActual").val(respuesta["Clave"]);
                $('#erolUsuario > option[value="'+respuesta["RolesID"]+'"]').attr('selected', 'selected');
                $("#fotoActual").val(respuesta["Imagen"]);

                if (respuesta["Imagen"] !="") {

                    $(".previsualizar").attr("src", respuesta["Imagen"]);

                }

            }

        });

    });

/*==========================================
        ACTIVAR/DESACTIVAR USUARIO
==========================================*/

    function activarDesactivarUsuario(id, nombre, activo){

        var idUser = id;
        var valorActivar = activo;
        var nombreUser = nombre;

            if (valorActivar=="S") {

                var estado = "desactivar";
                var cambio = "N";
                var estadoActual = "Desactivado";
                var cambioActual = "desactivó";

            } else {

                var estado = "activar";
                var cambio = "S";
                var estadoActual = "Activado";
                var cambioActual = "activó";

            }

            swal({
                title: "¡Atención!",
                text: "¿Desea "+estado+" el usuario "+nombreUser+"?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Aceptar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            },
            function(){

                var datos = new FormData();
                    datos.append("acvivarUsuario", idUser);
                    datos.append("estadoUsuario", cambio);

                $.ajax({
                    url:"ajax/usuarios.ajax.php",
                    type:"POST",
                    data: datos,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function(respuesta){
                        
                       switch (respuesta) {
 
                            case "ok":
                              swal({
                                title:"Usuario "+estadoActual+"!",
                                text:"¡El usuario "+nombreUser+" se "+cambioActual+" correctamente!",
                                type:"success",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                if(isConfirm){
                                window.location="usuarios";
                                }
                           
                            });
                              break;
                         
                            case "no":
                              swal({
                                title:"Error!",
                                text:"¡Empleado desactivado!",
                                type:"error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                    if(isConfirm){
                                        window.location="usuarios";
                                    }
                                 });
                              break;

                            case "error":
                              swal({
                                title:"Error!",
                                text:"¡El cambio no efectuó correctamente!",
                                type:"error",
                                confirmButtonText: "Cerrar",
                                closeOnConfirm: false
                                },
                                function(isConfirm){
                                    if(isConfirm){
                                        window.location="usuarios";
                                    }
                                });
                              break;
                         
                            default:
                              swal("Got away safely!");
                          }
                            
                           
                        
                    }
                });
            });
        }

/*==========================================
        ELIMINAR USUARIO
==========================================*/
    $(".tablas").on("click", ".btnEliminarUsuario", function(){

        var idUsuario = $(this).attr("usuarioId");
        var idPersona = $(this).attr("personaId");
        var nombreUser = $(this).attr("nombreUsuario");
        var imagenUser = $(this).attr("foto");
        var idEmpleado = $(this).attr("empleadoId");

        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar el usuario "+nombreUser+"?",
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
            datos.append("eliminarUsuario", idUsuario);
            datos.append("eliminarPersona", idPersona);
            datos.append("eliminarFoto", imagenUser);
            datos.append("eliminarNombre", nombreUser);
            datos.append("idEmpleado", idEmpleado);

            $.ajax({
                url:"ajax/usuarios.ajax.php",
                method:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta==0){

                    swal({
                        title:"Usuario eliminado!",
                        text:"¡El usuario se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                    },
                    function(isConfirm){

                        if(isConfirm){

                            window.location="usuarios";
                        }

                    });

                    } else {

                        swal({
                            title:"Error!",
                            text:"¡No se pudo eliminar el usuario!",
                            type:"error",
                            confirmButtonText: "Cerrar",
                            closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="usuarios";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });
    

    });

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

            $("#formIngreso").validate({

                errorClass: "text-danger error",
                validClass: "state-primary",
                errorElement: "span",

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
        VALIDAR EDITAR USUARIO
=============================================*/

    'use strict';
    $(document).ready(function() {


            $.validator.addMethod("pattern", function(value, element, param) {

                if (this.optional(element)) {

                    return true;

                }

                if (typeof param === 'string') {

                    param = new RegExp('^(?:' + param + ')$');

                }

                    return param.test(value);

            }, "Formato Invalido.");

            /* VALIDAMOS EL FORMULARIO DE CREAR USUARIO */

            $("#formIngresoEdito").validate({

                errorClass: "text-danger error",
                validClass: "state-success",
                errorElement: "span",

                errorPlacement: function(error, element) {

                    error.appendTo( element.parent("label").next("span") );

                },

                rules: {
                    enombreUsuario: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 20,
                        minlength: 3
                    },
                    eapellidoUsuario: {
                        required: true,
                        pattern: /^[a-zA-ZáéíïóúüÁÉÍÏÓÚÜñÑ\'\"\s]+$/,
                        maxlength: 30
                    },
                    efechaUsuario: {
                        required: true,
                        date: true
                    },
                    esexoUsuario: {
                        required: true,
                    },

                    epassUsuario: {
                        required: false,
                        pattern: /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/,
                        minlength: 8,
                        maxlength: 16
                    },
                    erolUsuario: {
                        required: true,
                    },
                },

                messages: {
                    enombreUsuario: {
                        required: 'Ingrese un nombre',
                        minlength: 'Minimo 3 caracteres'
                    },
                    eapellidoUsuario: {
                        required: 'Ingrese Apellido',
                        minlength: 'Minimo 3 caracteres'
                    },
                    efechaUsuario: {
                        required: 'Ingrese una fecha',
                        date: 'Ingrese una fecha valida'
                    },
                    esexoUsuario: {
                        required: 'Seleccione una opción',
                    },
                    epassUsuario: {
                        required: 'Ingrese contraseña',
                        minlength: 'Minimo 5 caracteres'
                    },
                    erolUsuario: {
                        required: 'Seleccione una opción',
                    },

                        onkeyup : false

                },

                    highlight: function(element){

                        $(element).closest('.form-group').addClass('form-danger');
                        $(element).closest('.form-group').removeClass('form-primary');

                        $(element).closest('.material-group').addClass('material-group-danger');
                        $(element).closest('.material-group').removeClass('material-group-primary');

                    },

                    unhighlight: function(element){

                        $(element).closest('.form-group').addClass('form-primary');
                        $(element).closest('.form-group').removeClass('form-danger');

                        $(element).closest('.material-group').addClass('material-group-primary');
                        $(element).closest('.material-group').removeClass('material-group-danger');

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
        DETALLES DE USUARIO
==========================================*/

  function detalleUsuario(id){

      $("#tablaListaUsuarios").hide(300);
      $('#detallesUsuario').show(300);

      var idUser = id;

      var datos = new FormData();
      datos.append("idUsuario" ,idUser);

      $.ajax({

          url: "ajax/usuarios.ajax.php",
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

              $("#imagenDetalle").attr("src", imagen);
              $("#detalleNombreApellido").html(respuesta["nombrePersona"]+" "+respuesta["Apellido"]);
              $("#tituloDetalleUser").html("Información del usuario "+respuesta["NombreUsuario"]);
              $("#titulodetalleRol").html(respuesta["rol"]);
              $("#nombreDetalleUser").html(respuesta["nombrePersona"]);
              $("#apellidoDetalleUser").html(respuesta["Apellido"]);
              $("#detalleDocumentoUser").html(respuesta["DNI"]);
              $("#detalleNacimientoUser").html(respuesta["Nacimiento"]);
              $("#detalleUsuarioUser").html(respuesta["NombreUsuario"]);
              $("#detalleFechaAltaUser").html(respuesta["Alta"]);
              $("#detalleGeneroUser").html(sexo);
              $("#detalleEmailUser").html(respuesta["Email"]);
              $("#detalleRolUser").html(respuesta["rol"]);
              $("#detalleEstadoUser").html(estado);

          }

      });
  }

  function volveraListas(){

      //$("#tablaListaUsuarios").show(500);
      //$('#detallesUsuario').hide(500);

      window.location="usuarios";
  }
