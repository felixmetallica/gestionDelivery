<?php 

    if ($_SESSION["rol"] != "Administrador") {
        
       echo '<script> window.location = "inicio"; </script>';
    
    } 

?>
<div class="pcoded-content">
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h4 class="m-b-10">Administración de usuarios</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Usuarios</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<!--=====================================
            LISTADO USUARIOS
======================================-->   
    
    <div class="pcoded-inner-content" id="tablaListaUsuarios">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="card-header-text p-t-15">Listado de usuarios</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button class="btn btn-mat waves-effect btn-md waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario"><i class="icofont icofont-plus m-r-5"></i>Nuevo usuario</button>
                                        </div>
                                    </div>   
                                </div>
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Imagen</th>
                                                <th class="text-center">Usuario</th>
                                                <th class="text-center">Rol</th>
                                                <th class="text-center">Nombre</th>
                                                <th class="text-center">Apellido</th>
                                                <th class="text-center">Activo</th>
                                                <th class="text-center">Empleado</th>
                                                <th class="text-center">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php

                                                    $item = null;
                                                    $valor = null;
                                                    $listar = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

                                                        foreach ($listar as $key => $value) {
                                                            
                                                            echo '<tr>
                                                                    <td class="text-center">'.($key+1) .'</td>';

                                                                if ($value["Imagen"] != "") {

                                                                    echo '<td style="text-align: center;"><img src="'.$value["Imagen"].'" class="img-radius img-60 align-top m-r-15" alt="tbl" style="width: 40px; height: 40px;"></td>';

                                                                } else {

                                                                    echo '<td style="text-align: center;"><img src="vistas/img/usuarios/default/User_ring.png" class="img-radius img-60 align-top m-r-15" alt="tbl" style="width: 40px; height: 40px;"></td>';
                                                                }
                                                                echo ' <td>'.$value["NombreUsuario"].'</td>
                                                                       <td>'.$value["Rol"].'</td>
                                                                       <td>'.$value["Nombre"].'</td>
                                                                       <td>'.$value["Apellido"].'</td>';

                                                                       if($value["Activo"] =="S"){

                                                                            if ($_SESSION["idUser"] == $value["UsuarioID"]) {
                                                                           
                                                                                echo '<td style="text-align: center;"><button  class="btn btn-success btn-disabled disabled btn-md waves-effect waves-ligh">Si</button></td>';

                                                                            } else {

                                                                                echo '<td style="text-align: center;"><button  class="btn btn-success btn-md waves-effect waves-ligh" onclick="activarDesactivarUsuario(\''.$value["UsuarioID"].'\' , \''.$value["NombreUsuario"].'\', \''.$value["Activo"].'\')">Si</button></td>';

 
                                                                            }

                                                                        } else {

                                                                            echo '<td style="text-align: center;"><button  class="btn btn-danger btn-md waves-effect waves-ligh" onclick="activarDesactivarUsuario(\''.$value["UsuarioID"].'\' , \''.$value["NombreUsuario"].'\', \''.$value["Activo"].'\')">No</button></td>';

                                                                        }

                                                                        if(!empty($value["EmpleadoID"])){

                                                                            echo '<td style="text-align: center;"><button class="btn btn-success btn-md waves-effect waves-ligh">Si</button></td>';

                                                                        } else {

                                                                            echo '<td style="text-align: center;"><button  class="btn btn-danger btn-md waves-effect waves-ligh">No</button></td>';

                                                                        }

                                                                        echo '<td style="text-align: center;">
                                                                            <div class="btn-group">
                                                                                <button class="btn btn-warning btn-md waves-effect waves-ligh btnEditarUsuario" idUsuario ="'.$value["UsuarioID"].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="icofont icofont-ui-edit"></i></button></div>
                                                                            <div class="btn-group">
                                                                                <button class="btn btn-danger btn-md waves-effect waves-ligh btnEliminarUsuario"  usuarioId="'.$value["UsuarioID"].'" personaId="'.$value["PersonaID"].'" nombreUsuario ="'.$value["NombreUsuario"].'" foto="'.$value["Imagen"].'" empleadoId="'.$value["EmpleadoID"].'"><i class="icofont icofont-ui-delete"></i></button>
                                                                            </div>
                                                                            <div class="btn-group">
                                                                                <button class="btn btn-success btn-md waves-effect waves-ligh" onclick="detalleUsuario(\''.$value["UsuarioID"].'\')"><i class="icofont icofont-eye-alt"></i></button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>';

                                                                }

                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                       </div>
                    </div>
            
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            DETALLE USUARIO
======================================-->
        
    <div class="pcoded-inner-content" id="detallesUsuario" style="display: none;">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4">
                            <div class="card faq-left">
                                <div class="social-profile">
                                    <img class="img-fluid" id="imagenDetalle" src="vistas/assets/images/social/profile.jpg" alt="">
                                </div>
                                <div class="card-block">
                                    <h4 class="f-18 f-normal m-b-10 txt-primary" id="detalleNombreApellido"></h4>
                                    <h5 class="f-14" id="titulodetalleRol"></h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-8">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personal" role="tabpanel">
                                    <div class="card">
                                        
                                            <div class="card-header">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <h5 class="card-header-text p-t-15" id="tituloDetalleUser">Listados de usuarios</h5>
                                                    </div>
                                                    <div class="col-lg-6 text-right">
                                                        <button class="btn btn-mat waves-effect waves-light btn-primary" onclick="volveraListas();"><i class="icofont icofont-simple-left"></i>Volver</button>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        <div class="card-block">
                                            <div class="view-info">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="general-info">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-xl-6">
                                                                    <table class="table m-0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row">Nombre</th>
                                                                                <td id="nombreDetalleUser"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Documento</th>
                                                                                <td id="detalleDocumentoUser"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Genero</th>
                                                                                <td id="detalleGeneroUser"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Usuario</th>
                                                                                <td id="detalleUsuarioUser"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Rol</th>
                                                                                <td id="detalleRolUser"></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="col-lg-12 col-xl-6">
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row">Apellido</th>
                                                                                <td id="apellidoDetalleUser"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Fecha de nacimiento</th>
                                                                                <td id="detalleNacimientoUser"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Email</th>
                                                                                <td id="detalleEmailUser"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Fecha de alta</th>
                                                                                <td id="detalleFechaAltaUser"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Estado</th>
                                                                                <td id="detalleEstadoUser"></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!--=====================================
            AGREGAR USUARIO
======================================-->

    <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo usuario</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formIngreso" method="post" class="form-material" enctype="multipart/form-data">
                        <h6>Datos personales</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                   <i class="icofont icofont-user-alt-7"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="nombreUsuario" id="nombreUsuario" class="form-control" minlength="3" maxlength="20" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-user-alt-7"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="apellidoUsuario" id="apellidoUsuario" minlength="3" maxlength="30" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Apellido</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-gavel"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="dniUsuario" id="dniUsuario" minlength="7" maxlength="8" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Dni</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-email"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="email" class="form-control" name="emailUsuario" id="emailUsuario" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Email</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm ">
                                <div class="material-addone">
                                    <i class="icofont icofont-calendar"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control date" name="fechaUsuario" id="fechaUsuario" data-mask="99/99/9999" required="" />
                                    <span class="form-bar"></span>
                                    <label class="float-label">Fecha de nacimiento</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-users-alt-2"></i>
                                </div>
                                <div class="form-group form-primary form-static-label p-t-5">
                                    <select class="form-control" name="sexoUsuario" id="sexoUsuario">
                                        <option value="">Seleccione el sexo</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Sexo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6>Datos del usuario</h6>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-user"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="userUsuario" id="userUsuario" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Usuario</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-unlock"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" class="form-control"  name="passUsuario" id="passUsuario" title="Minimo 8 caracteres. Debe contener al menos
                            un número, una minúscula y una mayúscula" data-placement="right" required="" autocomplete="new-password" #password>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Contraseña</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm ">
                                <div class="material-addone">
                                    <i class="icofont icofont-users-alt-1"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="rolUsuario" id="rolUsuario">
                                        <option value="">Selecionar rol</option>
                                        <?php
                                            $item = null;
                                            $valor = null;

                                            $roles = ControladorConfiguracion::ctrMostrarRoles($item, $valor);

                                            foreach ($roles as $row => $item){

                                                echo '<option value="'.$item["RolesID"].'">'.$item["Nombre"].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rol</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="md-group-add-on form-group form-primary material-group-sm">
                                <span class="md-add-on-file">
                                    <button class="btn btn-primary waves-effect waves-light">Seleccionar archivo</button>
                                </span>
                                <div class="md-input-file">
                                    <input type="file" class="nuevaFoto" name="nuevaFoto">
                                    <input type="text" class="md-form-control md-form-file form-control foto" placeholder="No se elijio archivo">
                                    <span class="form-bar">Peso máximo de la foto 2MB</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                             <img src="vistas/img/usuarios/default/User_ring.png" class="img-thumbnail previsualizar" width="100px">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Aceptar</button>
                </div>
                <?php
                    $crearUsuario = new ControladorUsuarios();
                    $crearUsuario -> ctrRegistroUsuario();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR USUARIO
======================================-->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title" id="tituloEditar"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formIngresoEdito" method="post" class="form-material" enctype="multipart/form-data">
                        <h6>Datos personales</h6>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                   <i class="icofont icofont-user-alt-7"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="enombreUsuario" id="enombreUsuario" class="form-control" minlength="3" maxlength="20" required="">
                                    <input type="hidden" id="idUser" name="idUser">
                                    <input type="hidden" id="idPersona" name="idPersona">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-user-alt-7"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="eapellidoUsuario" id="eapellidoUsuario" minlength="3" maxlength="30" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Apellido</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-gavel"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="edniUsuario" id="edniUsuario" minlength="7" maxlength="8" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Dni</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-email"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="email" class="form-control" name="eemailUsuario" id="eemailUsuario" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Email</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm ">
                                <div class="material-addone">
                                    <i class="icofont icofont-calendar"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control date" name="efechaUsuario" id="efechaUsuario" data-mask="99/99/9999" required="" />
                                    <span class="form-bar"></span>
                                    <label class="float-label">Fecha de nacimiento</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-users-alt-2"></i>
                                </div>
                                <div class="form-group form-primary form-static-label p-t-5">
                                    <select class="form-control" name="esexoUsuario">
                                        <option value="" id="esexoUsuario"></option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Sexo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6>Datos del usuario</h6>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-user"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="euserUsuario" id="euserUsuario" readonly>
                                    <span class="form-bar"></span>
                                    <label class="float-label p-t-10">Usuario</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-unlock"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" class="form-control" name="epassUsuario" id="epassUsuario" title="Minimo 8 caracteres. Debe contener al menos
                            un número, una minúscula y una mayúscula" data-placement="right" required="" autocomplete="new-password" #password>
                                    <input type="hidden" id="passwordActual" name="passwordActual">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Contraseña</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-sm-12">
                            <div class="material-group material-group-primary material-group-sm ">
                                <div class="material-addone">
                                    <i class="icofont icofont-users-alt-1"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="erolUsuario" id="erolUsuario">
                                        <?php

                                            $item = null;
                                            $valor = null;

                                            $roles = ControladorConfiguracion::ctrMostrarRoles($item, $valor);

                                            foreach ($roles as $row => $item){

                                                echo '<option value="'.$item["RolesID"].'">'.$item["Nombre"].'</option>';
                                            }
                                        ?>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Rol</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="md-group-add-on form-group form-primary material-group-sm">
                                <span class="md-add-on-file">
                                    <button class="btn btn-primary waves-effect waves-light">Seleccionar archivo</button>
                                </span>
                                <div class="md-input-file">
                                    <input type="file" class="nuevaFoto" name="editarFoto">
                                    <input type="text" class="md-form-control md-form-file form-control foto" placeholder="No se elijio archivo">
                                    <input type="hidden" name="fotoActual" id="fotoActual">
                                    <span class="form-bar">Peso máximo de la foto 2MB</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                             <img src="vistas/img/usuarios/default/User_ring.png" class="img-thumbnail previsualizar" width="100px">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Aceptar</button>
                </div>
                <?php
                    $editarUsuario = new ControladorUsuarios();
                    $editarUsuario -> ctrEditarUsuario();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/usuarios.js"></script>