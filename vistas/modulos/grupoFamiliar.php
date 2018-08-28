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
                        <h4 class="m-b-10">Administración de Grupos de Familiares</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Empleados</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<!--=====================================
            BUSCAR EMPLEADO
======================================-->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Seleccionar empleado</h5>
                                    <form action="grupoFamiliar" class="form-material" method="post">
                                        <div class="row">
                                            <div class="col-md-3">

                                                <div class="material-group material-group-primary material-group-sm p-t-15">
                                                    <div class="material-addone">
                                                        <i class="icofont icofont-users-alt-2"></i>
                                                    </div>
                                                    <div class="form-group form-primary form-static-label p-t-5">
                                                        <select class="form-control" name="empleado" id="empleado">
                                                            <option value="">Seleccione un empleado</option>
                                                                <?php

                                                                    $traigoEmpleados = ControladorGrupoFamiliar::ctrTraerEmpleados();

                                                                    if (isset($_POST["empleado"])) {

                                                                        foreach ($traigoEmpleados as $row => $item){

                                                                            if ($_POST["empleado"] == $item["EmpleadoID"]) {

                                                                                $nombre = 'de '.$item["Nombre"].' '.$item["Apellido"];

                                                                                echo '<option value="'.$item["EmpleadoID"].'" selected>'.$item["Nombre"].' '.$item["Apellido"].'</option>';

                                                                            } else {

                                                                                echo '<option value="'.$item["EmpleadoID"].'">'.$item["Nombre"].' '.$item["Apellido"].'</option>';

                                                                            }

                                                                        }

                                                                    }else{

                                                                        foreach ($traigoEmpleados as $row => $item){

                                                                            echo '<option value="'.$item["EmpleadoID"].'">'.$item["Nombre"].' '.$item["Apellido"].'</option>';

                                                                        }

                                                                    }

                                                                ?>
                                                        </select>
                                                        <span class="form-bar"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="padding-top: 15px;">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light md-trigger"><i class="icofont icofont-search"></i> Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            LISTADO FAMILIARES
======================================-->

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header">

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <h5 class="card-header-text p-t-15">Listado de Familiares
                                                <?php

                                                    if (isset($nombre)) {

                                                        echo $nombre;

                                                    }

                                                 ?>
                                            </h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <?php

                                                if (isset($nombre)) {

                                                    echo '<button class="btn btn-primary waves-effect waves-light f-right md-trigger" data-toggle="modal" data-target="#modalAgregarFamiliar"><i class="icofont icofont-plus m-r-5"></i>Agregar familiar</button>';

                                                }

                                             ?>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Nombre</th>
                                                <th style="text-align: center;">Apellido</th>
                                                <th style="text-align: center;">DNI</th>
                                                <th style="text-align: center;">Fecha de Nacimiento</th>
                                                <th style="text-align: center;">Parentesco</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>

                                                <?php

                                                    if (isset($_POST["empleado"])) {

                                                        $idEmpleado = $_POST["empleado"];

                                                        $listar = ControladorGrupoFamiliar::ctrTraerFamiliares($idEmpleado);

                                                        foreach ($listar as $row => $item){

                                                           switch ($item["Parentesco"]) {
                                                                case '1':
                                                                   $parentesco = "Conyugue";
                                                                   break;
                                                                case '2':
                                                                   $parentesco = "Hijo";
                                                                   break;
                                                                case '3':
                                                                   $parentesco = "Hija";
                                                                   break;
                                                                case '4':
                                                                   $parentesco = "Padre";
                                                                   break;
                                                                case '5':
                                                                   $parentesco = "Madre";
                                                                   break;
                                                                case '6':
                                                                   $parentesco = "Hermano";
                                                                   break;
                                                                case '7':
                                                                   $parentesco = "Hermana";
                                                                   break;
                                                                case '8':
                                                                   $parentesco = "Otro";
                                                                   break;

                                                               default:
                                                                   # code...
                                                                   break;
                                                           }


                                                            echo '  <tr>
                                                                        <td style="text-align: center;">'.($row+1).'</td>
                                                                        <td style="text-align: center;">'.$item["Nombre"].'</td>
                                                                        <td style="text-align: center;">'.$item["Apellido"].'</td>
                                                                        <td style="text-align: center;">'.$item["DNI"].'</td>
                                                                        <td style="text-align: center;">'.$item["Nacimiento"].'</td>
                                                                        <td style="text-align: center;">'.$parentesco.'</td>
                                                                        <td style="text-align: center;">
                                                                            <div class="btn-group">
                                                                                <button class="btn btn-warning waves-effect waves-ligh" onclick="editarFamiliar(\''.$item["GrupoFamiliarID"].'\', \''.$item["EmpleadoID"].'\')" data-toggle="modal" data-target="#modalEditarFamiliar"><i class="icofont icofont-ui-edit"></i></button>
                                                                            </div>
                                                                            <div class="btn-group">
                                                                                <button class="btn btn-danger waves-effect waves-ligh"  onclick="eliminarFamiliar(\''.$item["GrupoFamiliarID"].'\', \''.$item["PersonaID"].'\', \''.$item["EmpleadoID"].'\', \''.$item["Nombre"].'\', \''.$item["Apellido"].'\')"><i class="icofont icofont-ui-delete"></i></button>
                                                                            </div>
                                                                        </td>

                                                                    </tr>';
                                                            }

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

</div>

<!--=====================================
            AGREGAR FAMILIAR
======================================-->

    <div class="modal fade" id="modalAgregarFamiliar" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Agregar Familiar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formRegistroFamiliar" method="post" class="form-material">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="material-group material-group-primary material-group-sm">
                                    <div class="material-addone">
                                       <i class="icofont icofont-user-alt-7"></i>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="nombreFamiliar" id="nombreFamiliar" class="form-control" minlength="3" maxlength="20" required="">
                                        <input type="hidden" name="idEmpleadoCrear" id="idEmpleadoCrear" value="<?php echo $_POST["empleado"]?>">
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
                                        <input type="text" class="form-control" name="apellidoFamiliar" id="apellidoFamiliar" minlength="3" maxlength="30" required="">
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
                                        <input type="text" class="form-control" name="dniFamiliar" id="dniFamiliar" minlength="7" maxlength="8" required="">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Dni</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="material-group material-group-primary material-group-sm ">
                                    <div class="material-addone">
                                        <i class="icofont icofont-calendar"></i>
                                    </div>
                                    <div class="form-group form-primary form-static-label">
                                        <input type="text" class="form-control date" name="fechaFamiliar" id="fechaFamiliar" data-mask="99/99/9999" required="" />
                                        <span class="form-bar"></span>
                                        <label class="float-label">Fecha de nacimiento</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="material-group material-group-primary material-group-sm">
                                    <div class="material-addone">
                                        <i class="icofont icofont-users-alt-2"></i>
                                    </div>
                                    <div class="form-group form-primary form-static-label p-t-5">
                                        <select class="form-control" name="sexoFamiliar" id="sexoFamiliar">
                                            <option value="">Seleccione el sexo</option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                        <span class="form-bar"></span>
                                        <label class="float-label">Sexo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="material-group material-group-primary material-group-sm">
                                    <div class="material-addone">
                                        <i class="icofont icofont-users-alt-2"></i>
                                    </div>
                                    <div class="form-group form-primary form-static-label p-t-5">
                                        <select class="form-control" name="parentezcoFamiliar" id="parentezcoFamiliar">
                                            <option value="">Seleccione el parentezco</option>
                                            <option value="1">Conyugue</option>
                                            <option value="2">Hijo</option>
                                            <option value="3">Hija</option>
                                            <option value="4">Padre</option>
                                            <option value="5">Madre</option>
                                            <option value="6">Hermano</option>
                                            <option value="7">Hermana</option>
                                            <option value="8">Otro</option>
                                        </select>
                                        <span class="form-bar"></span>
                                        <label class="float-label">Parentezco</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Aceptar</button>
                </div>
                <?php
                    $nuevoFamiliar = new ControladorGrupoFamiliar();
                    $nuevoFamiliar -> ctrRegistroFamiliar();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR FAMILIAR
======================================-->

    <div class="modal fade" id="modalEditarFamiliar" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Editar Familiar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formEditoFamiliar" method="post" class="form-material">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="material-group material-group-primary material-group-sm">
                                    <div class="material-addone">
                                       <i class="icofont icofont-user-alt-7"></i>
                                    </div>
                                    <div class="form-group form-primary">
                                        <input type="text" name="enombreFamiliar" id="enombreFamiliar" class="form-control" minlength="3" maxlength="20" required="">
                                        <input type="hidden" name="idFamiliarEditar" id="idFamiliarEditar">
                                        <input type="hidden" name="idEmpleadoEditar" id="idEmpleadoEditar">
                                        <input type="hidden" name="idPersonaEditar" id="idPersonaEditar">
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
                                        <input type="text" class="form-control" name="eapellidoFamiliar" id="eapellidoFamiliar" minlength="3" maxlength="30" required="">
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
                                        <input type="text" class="form-control" name="edniFamiliar" id="edniFamiliar" minlength="7" maxlength="8" required="">
                                        <span class="form-bar"></span>
                                        <label class="float-label">Dni</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="material-group material-group-primary material-group-sm ">
                                    <div class="material-addone">
                                        <i class="icofont icofont-calendar"></i>
                                    </div>
                                    <div class="form-group form-primary form-static-label">
                                        <input type="text" class="form-control date" name="efechaFamiliar" id="efechaFamiliar" data-mask="99/99/9999" required="" />
                                        <span class="form-bar"></span>
                                        <label class="float-label">Fecha de nacimiento</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="material-group material-group-primary material-group-sm">
                                    <div class="material-addone">
                                        <i class="icofont icofont-users-alt-2"></i>
                                    </div>
                                    <div class="form-group form-primary form-static-label p-t-5">
                                        <select class="form-control" name="esexoFamiliar">
                                            <option id="esexoFamiliar" value=""></option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Femenino</option>
                                        </select>
                                        <span class="form-bar"></span>
                                        <label class="float-label">Sexo</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="material-group material-group-primary material-group-sm">
                                    <div class="material-addone">
                                        <i class="icofont icofont-users-alt-2"></i>
                                    </div>
                                    <div class="form-group form-primary form-static-label p-t-5">
                                        <select class="form-control" name="eparentezcoFamiliar">
                                            <option  id="eparentezcoFamiliar" value=""></option>
                                            <option value="1">Conyugue</option>
                                            <option value="2">Hijo</option>
                                            <option value="3">Hija</option>
                                            <option value="4">Padre</option>
                                            <option value="5">Madre</option>
                                            <option value="6">Hermano</option>
                                            <option value="7">Hermana</option>
                                            <option value="8">Otro</option>
                                        </select>
                                        <span class="form-bar"></span>
                                        <label class="float-label">Parentezco</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light ">Aceptar</button>
                </div>
                <?php
                    $editarFamiliar = new ControladorGrupoFamiliar();
                    $editarFamiliar -> ctrModificoFamiliar();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript" src="vistas/js/grupoFamiliar.js"></script>
