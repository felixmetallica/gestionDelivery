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
                        <h4 class="m-b-10">Administración de conceptos</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="inicio">
                                <i class="ti-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#!">Conceptos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            LISTADO CONCEPTOS
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
                                            <h5 class="card-header-text p-t-15">Listado de conceptos</h5>
                                        </div>
                                        <div class="col-lg-6 text-right">
                                            <button class="btn btn-mat waves-effect waves-light btn-primary" data-toggle="modal" data-target="#modalAgregarConcepto"><i class="icofont icofont-plus m-r-5"></i>agregar concepto</button>
                                        </div>
                                    </div>
                                </div>   
                                <div class="card-block">
                                    <div class="md-card-block">
                                        <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
                                            <thead>
                                                <th style="text-align: center;">#</th>
                                                <th style="text-align: center;">Código</th>
                                                <th style="text-align: center;">Descripcion</th>
                                                <th style="text-align: center;">Unidades</th>
                                                <th style="text-align: center;">Tipo</th>
                                                <th style="text-align: center;">Fijo</th>
                                                <th style="text-align: center;">Porcentual</th>
                                                <th style="text-align: center;">Acciones</th>
                                            </thead>
                                            <tbody>
                                                <?php  

                                                    $item = null;
                                                    $valor = null;

                                                    $listar = ControladorPayment::ctrMostrarConceptos($item, $valor);

                                                    foreach ($listar as $key => $value) {
                                                        
                                                        if ($value["Porcentaje"] == "S") {
                                                            
                                                            $porcentaje = '<button class="btn btn-mat waves-effect waves-light btn-success">Si</button>';
                                                        
                                                        } else {

                                                            $porcentaje = '<button class="btn btn-mat waves-effect waves-light btn-danger">No</button>';
                                                        
                                                        }

                                                        if ($value["Fijo"] == "S") {
                                                            
                                                            $fijo = '<button class="btn btn-mat waves-effect waves-light btn-success">Si</button>';
                                                        
                                                        } else {

                                                            $fijo = '<button class="btn btn-mat waves-effect waves-light btn-danger">No</button>';
                                                        
                                                        }

                                                        switch ($value["Tipo"]) {
                                                            case '1':
                                                                $tipo = "Remunerativo";
                                                                break;
                                                            case '2':
                                                                $tipo = "No remunerativo";
                                                                break;
                                                            case '3':
                                                                $tipo = "Retención";
                                                                break;
                                                            
                                                            
                                                        }

                                                        echo '<tr>
                                                                <td style="text-align: center;">'.($key+1).'</td>
                                                                <td style="text-align: center;">'.$value["Codigo"].'</td>
                                                                <td style="text-align: center;">'.$value["Descripcion"].'</td>
                                                                <td style="text-align: center;">'.$value["Unidades"].'</td>
                                                                <td style="text-align: center;">'.$tipo.'</td>
                                                                <td style="text-align: center;">'.$fijo.'</td>
                                                                <td style="text-align: center;">'.$porcentaje.'</td>
                                                                <td style="text-align: center;">
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-warning waves-effect waves-ligh btnEditarConcepto" idConcepto="'.$value["ConceptoID"].'" data-toggle="modal" data-target="#modalEditarConcepto"><i class="icofont icofont-ui-edit"></i></button>
                                                                    </div>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-danger waves-effect waves-ligh btnEliminarConcepto" idConcepto="'.$value["ConceptoID"].'" nombre="'.$value["Descripcion"].'"><i class="icofont icofont-ui-delete"></i></button>
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


</div>

<!--=====================================
            AGREGAR CONCEPTO
======================================-->

    <div class="modal fade" id="modalAgregarConcepto" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title">Nuevo concepto</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formAgregarConcepto" method="post" class="form-material">
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-barcode"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="codConcepto" id="codConcepto" minlength="3" maxlength="4">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Código</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-label"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="descConcepto" id="descConcepto" minlength="3" maxlength="20">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                       
                    
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-label"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" class="form-control" name="unidadesConcepto" id="unidadesConcepto" minlength="1" maxlength="4">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Unidades</label>
                                </div>
                            </div>
                        </div>
                        
                        
                       <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-calculator-alt-2"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="porcentajeConcepto" id="porcentajeConcepto">
                                        <option value="">Selecione una opcion</option>
                                        <option value="S">Sí</option>
                                        <option value="N">No</option>
                                            
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Porcentaje</label>
                                </div>
                            </div>
                        </div>
                    
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-calculator-alt-2"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="tipoConcepto" id="tipoConcepto">
                                        <option value="">Selecione una opcion</option>
                                        <option value="1">Remunerativo</option>
                                        <option value="2">No remunerativo</option>
                                        <option value="3">Retención</option>    
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Tipo</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-calculator-alt-2"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="fijoConcepto" id="fijoConcepto">
                                        <option value="">Selecione una opcion</option>
                                        <option value="S">Si</option>
                                        <option value="N">No</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Fijo</label>
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
                    $crearConcepto = new ControladorPayment();
                    $crearConcepto -> ctrRegistrarConcepto();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!--=====================================
            EDITAR CONCEPTO
======================================-->

    <div class="modal fade" id="modalEditarConcepto" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header background-primary">
                    <h4 class="modal-title" id="nombreIsumoModal"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="formEditarConcepto" method="post" class="form-material">
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-barcode"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="codConceptoE" id="codConceptoE" minlength="3" maxlength="4">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Código</label>
                                </div>
                            </div>
                        </div>
                        
                       <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-label"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="descConceptoE" id="descConceptoE" minlength="3" maxlength="20">
                                    <input type="hidden" name="idConceptoE" id="idConceptoE">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Nombre</label>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-label"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <input type="text" class="form-control" name="eunidadesConcepto" id="eunidadesConcepto" minlength="1" maxlength="4">
                                    
                                    <span class="form-bar"></span>
                                    <label class="float-label">Unidades</label>
                                </div>
                            </div>
                        </div>
                        
                       <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-calculator-alt-2"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="porcentajeConceptoE">
                                        <option value="" id="porcentajeConceptoE">Selecione una opcion</option>
                                        <option value="S">Sí</option>
                                        <option value="N">No</option>
                                            
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Porcentaje</label>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-calculator-alt-2"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="tipoConceptoE">
                                        <option value="" id="tipoConceptoE">Selecione una opcion</option>
                                        <option value="1">Remunerativo</option>
                                        <option value="2">No remunerativo</option>
                                        <option value="3">Retención</option>    
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Tipo</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="material-group material-group-primary">
                                <div class="material-addone">
                                    <i class="icofont icofont-calculator-alt-2"></i>
                                </div>
                                <div class="form-group form-primary form-static-label">
                                    <select class="form-control" name="fijoConceptoE" >
                                        <option value="" id="fijoConceptoE">Selecione una opcion</option>
                                        <option value="S">Si</option>
                                        <option value="N">No</option>
                                    </select>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Fijo</label>
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
                    $editarConcepto = new ControladorPayment();
                    $editarConcepto -> ctrEditarConcepto();
                ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="vistas/js/payment.js"></script>