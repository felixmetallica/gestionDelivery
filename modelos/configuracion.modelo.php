<?php

require_once "conexion.php";

class ModeloConfiguracion{

//////////////////////////////////////////////////////////////////////////  RUBROS ////////////////////////////////////////////////////////////////

/*=============================================
        MOSTRAR RUBROS
=============================================*/

    static public function mdlMostrarRubros($tabla, $item, $valor){

        if ($item != null) {
            
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY RubroID ASC");

            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY RubroID ASC");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
        }

    }

/*=============================================
        REGISTRAR RUBRO
=============================================*/

	static public function mdlRegistrarRubro($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("INSERT INTO $tabla (Nombre, Tipo) VALUES (:nombre, :tipo)");
		$stmt -> bindParam(":nombre", $datosModel["rubro"], PDO::PARAM_STR);
        $stmt -> bindParam(":tipo", $datosModel["tipo"], PDO::PARAM_STR);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error ';

			}
            $stmt->close();

    }

/*=============================================
        MODIFICAR RUBRO
=============================================*/

	static public function mdlModificarRubro($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("UPDATE $tabla SET Nombre = :nombre, Tipo = :tipo WHERE RubroID = :idRubro");
		$stmt -> bindParam(":idRubro", $datosModel["IdRubro"], PDO::PARAM_INT);
        $stmt -> bindParam(":nombre", $datosModel["Rubro"], PDO::PARAM_STR);
        $stmt -> bindParam(":tipo", $datosModel["Tipo"], PDO::PARAM_STR);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}
            $stmt->close();

    }

/*=============================================
        ELIMINAR RUBRO
=============================================*/

	static public function mdlEliminarRubro($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("DELETE FROM $tabla WHERE RubroID = :idRubro");
		$stmt -> bindParam(":idRubro", $datosModel, PDO::PARAM_INT);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}

            $stmt->close();

    }

//////////////////////////////////////////////////////////////////////////  ROLES ////////////////////////////////////////////////////////////////

/*=============================================
        MOSTRAR ROLES
=============================================*/

    static public function mdlMostrarRoles($tabla, $item, $valor){

        if ($item != null) {
            
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY RolesID ASC");

            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY RolesID ASC");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
        }

    }

/*=============================================
        REGISTRAR ROL
=============================================*/

	static public function mdlRegistrarRol($rol, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("INSERT INTO $tabla (Nombre) VALUES (:nombre)");
		$stmt -> bindParam(":nombre", $rol, PDO::PARAM_STR);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}
            $stmt->close();

    }

/*=============================================
        MODIFICAR ROL
=============================================*/

	static public function mdlModificarRol($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("UPDATE $tabla SET Nombre = :nombre WHERE RolesID = :idRol");
		$stmt -> bindParam(":idRol", $datosModel["idRol"], PDO::PARAM_INT);
        $stmt -> bindParam(":nombre", $datosModel["Rol"], PDO::PARAM_STR);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}
            $stmt->close();

    }

/*=============================================
        ELIMINAR ROL
=============================================*/

	static public function mdlEliminarRol($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("DELETE FROM $tabla WHERE RolesID = :idRoles");
		$stmt -> bindParam(":idRoles", $datosModel, PDO::PARAM_INT);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}

            $stmt->close();

    }

//////////////////////////////////////////////////////////////////////////  PUESTOS ////////////////////////////////////////////////////////////////

/*=============================================
        MOSTRAR PUESTOS
=============================================*/

    static public function mdlMostrarPuestos($tabla, $item, $valor){

        if ($item != null) {
            
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY PuestoID ASC");

            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY PuestoID ASC");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
        }

    }

/*=============================================
        REGISTRAR PUESTO
=============================================*/

	static public function mdlRegistrarPuesto($puesto, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("INSERT INTO $tabla (Nombre) VALUES (:nombre)");
		$stmt -> bindParam(":nombre", $puesto, PDO::PARAM_STR);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}
            $stmt->close();

    }

/*=============================================
        MODIFICAR PUESTO
=============================================*/

	static public function mdlModificarPuesto($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("UPDATE $tabla SET Nombre = :nombre WHERE PuestoID = :idPuesto");
		$stmt -> bindParam(":idPuesto", $datosModel["idPuesto"], PDO::PARAM_INT);
        $stmt -> bindParam(":nombre", $datosModel["Puesto"], PDO::PARAM_STR);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}
            $stmt->close();

    }

/*=============================================
        ELIMINAR PUESTO
=============================================*/

	static public function mdlEliminarPuesto($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("DELETE FROM $tabla WHERE PuestoID = :idPuesto");
		$stmt -> bindParam(":idPuesto", $datosModel, PDO::PARAM_INT);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}

            $stmt->close();

    }

//////////////////////////////////////////////////////////////////////////  CATEGORIAS ////////////////////////////////////////////////////////////////

/*=============================================
        MOSTRAR CATEGORIAS
=============================================*/

    static public function mdlMostrarCategorias($tabla1, $tabla2, $item, $valor){

        if ($item != null) {
            
            $stmt = Conexion::conectar()->prepare("SELECT Categorias.CategoriasID, Categorias.Nombre AS NombreCategoria, Categorias.SueldoBasico, Puesto.PuestoID, Puesto.Nombre AS NombrePuesto FROM Categorias INNER JOIN Puesto ON Categorias.PuestoID = Puesto.PuestoID WHERE $item = :$item");

            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT Categorias.CategoriasID, Categorias.Nombre AS NombreCategoria, Categorias.SueldoBasico, Puesto.PuestoID, Puesto.Nombre AS NombrePuesto FROM Categorias INNER JOIN Puesto ON Categorias.PuestoID = Puesto.PuestoID ORDER BY Categorias.CategoriasID ASC");
                $stmt->execute();
                return $stmt->fetchAll();
                $stmt->close();
            }

    }

/*=============================================
        REGISTRAR CATEGORIA
=============================================*/

    static public function mdlRegistrarCategoria($datosModel, $tabla){

        $link = Conexion::conectar();
        $stmt = $link ->prepare("INSERT INTO $tabla (PuestoID, Nombre, SueldoBasico) VALUES (:puesto, :nombre, :sueldo)");
        $stmt -> bindParam(":puesto", $datosModel["puesto"], PDO::PARAM_INT);
        $stmt -> bindParam(":nombre", $datosModel["categoria"], PDO::PARAM_STR);
        $stmt -> bindParam(":sueldo", $datosModel["sueldo"], PDO::PARAM_STR);

            if($stmt -> execute()){

                return 'ok';

            } else {

                return 'error';

            }
            $stmt->close();

    }

/*=============================================
        MODIFICAR CATEGORIA
=============================================*/

    static public function mdlModificarCategoria($datosModel, $tabla){

        $link = Conexion::conectar();
        $stmt = $link ->prepare("UPDATE $tabla SET PuestoID = :puesto, Nombre = :nombre, SueldoBasico = :sueldo WHERE CategoriasID = :idCategorias");
        $stmt -> bindParam(":idCategorias", $datosModel["idCategoria"], PDO::PARAM_INT);
        $stmt -> bindParam(":puesto", $datosModel["Puesto"], PDO::PARAM_INT);
        $stmt -> bindParam(":nombre", $datosModel["Categoria"], PDO::PARAM_STR);
        $stmt -> bindParam(":sueldo", $datosModel["Sueldo"], PDO::PARAM_STR);

            if($stmt -> execute()){

                return 'ok';

            } else {

                return 'error';

            }
            $stmt->close();

    }

/*=============================================
        ELIMINAR CATEGORIA
=============================================*/

    static public function mdlEliminarCategoria($idCategoria, $tabla){

        $link = Conexion::conectar();
        $stmt = $link ->prepare("DELETE FROM $tabla WHERE CategoriasID = :id");
        $stmt -> bindParam(":id", $idCategoria, PDO::PARAM_INT);

            if($stmt -> execute()){

                return 'ok';

            } else {

                return 'error';

            }

            $stmt->close();

    }

//////////////////////////////////////////////////////////////////////////  IVA ////////////////////////////////////////////////////////////////

/*=============================================
        MOSTRAR IVA
=============================================*/

    static public function mdlMostrarIva($tabla, $item, $valor) {

        if ($item != null) {
            
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY IVAID ASC");

            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY IVAID ASC");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
        }

    }

/*=============================================
        REGISTRAR IVA
=============================================*/

	static public function mdlRegistrarIva($iva, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("INSERT INTO $tabla (Descripcion) VALUES (:descripcion)");
		$stmt -> bindParam(":descripcion", $iva, PDO::PARAM_STR);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}
            $stmt->close();

    }

/*=============================================
        MODIFICAR IVA
=============================================*/

	static public function mdlModificarIva($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("UPDATE $tabla SET Descripcion = :descripcion WHERE IVAID = :idIva");
		$stmt -> bindParam(":idIva", $datosModel["idIva"], PDO::PARAM_INT);
        $stmt -> bindParam(":descripcion", $datosModel["Descripcion"], PDO::PARAM_STR);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}
            $stmt->close();

    }

/*=============================================
        ELIMINAR IVA
=============================================*/

	static public function mdlEliminarIva($datosModel, $tabla){

		$link = Conexion::conectar();
		$stmt = $link ->prepare("DELETE FROM $tabla WHERE IVAID = :ivaId");
		$stmt -> bindParam(":ivaId", $datosModel, PDO::PARAM_INT);

			if($stmt -> execute()){

				return 'ok';

			} else {

				return 'error';

			}

            $stmt->close();

    }

//////////////////////////////////////////////////////////////////////////  PDV ////////////////////////////////////////////////////////////////

/*=============================================
        MOSTRAR PDV
=============================================*/

    static public function mdlMostrarPdvs($tabla1, $tabla2, $tabla3, $tabla4, $tabla5, $item, $valor){

        if ($item != null) {
            
            $stmt = Conexion::conectar()->prepare("SELECT PuntoVenta.PuntoVentaID, PuntoVenta.Nombre, PuntoVenta.Activo, PuntoVenta.CUITT, PuntoVenta.IngresosBrutos, date_format(PuntoVenta.InicioActividades,'%d/%m/%Y') AS Inicio, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.DomicilioID, Domicilio.CP, Localidad.Nombre AS Localidad, Barrio.Nombre AS Barrio, Telefono.Prefijo, Telefono.NroTelefono FROM $tabla1 INNER JOIN $tabla2 ON PuntoVenta.PuntoVentaID = Domicilio.PuntoVentaID INNER JOIN $tabla3 ON Domicilio.LocalidadID = Localidad.LocalidadID INNER JOIN $tabla4 ON Domicilio.BarrioID = Barrio.BarrioID INNER JOIN $tabla5 ON PuntoVenta.PuntoVentaID = Telefono.PuntoVentaID WHERE PuntoVenta.PuntoVentaID = :valor");

            $stmt -> bindParam(":valor", $valor, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetch();
        
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT PuntoVenta.PuntoVentaID, PuntoVenta.Nombre, PuntoVenta.Activo, PuntoVenta.CUITT, PuntoVenta.IngresosBrutos, date_format(PuntoVenta.InicioActividades,'%d/%m/%Y') AS Inicio, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.DomicilioID, Localidad.Nombre AS Localidad, Barrio.Nombre AS Barrio, Telefono.Prefijo, Telefono.NroTelefono FROM $tabla1 INNER JOIN $tabla2 ON PuntoVenta.PuntoVentaID = Domicilio.PuntoVentaID INNER JOIN $tabla3 ON Domicilio.LocalidadID = Localidad.LocalidadID INNER JOIN $tabla4 ON Domicilio.BarrioID = Barrio.BarrioID INNER JOIN $tabla5 ON PuntoVenta.PuntoVentaID = Telefono.PuntoVentaID ORDER BY PuntoVenta.PuntoVentaID ASC");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
        }

    }

/*=============================================
        MOSTRAR PDV ACTIVO
=============================================*/

    static public function mdlMostrarPdvActivo($tabla1, $tabla2, $tabla3, $tabla4, $tabla5){

        $stmt = Conexion::conectar()->prepare("SELECT PuntoVenta.PuntoVentaID, PuntoVenta.Nombre, PuntoVenta.Activo, PuntoVenta.CUITT, PuntoVenta.IngresosBrutos, date_format(PuntoVenta.InicioActividades,'%d/%m/%Y') AS Inicio, Domicilio.Calle, Domicilio.Nro, Domicilio.Piso, Domicilio.Dpto, Domicilio.DomicilioID, Domicilio.CP, Localidad.Nombre AS Localidad, Barrio.Nombre AS Barrio, Telefono.Prefijo, Telefono.NroTelefono FROM ((((PuntoVenta INNER JOIN Domicilio ON PuntoVenta.PuntoVentaID = Domicilio.PuntoVentaID) INNER JOIN Localidad ON Domicilio.LocalidadID = Localidad.LocalidadID) INNER JOIN Barrio ON Domicilio.BarrioID = Barrio.BarrioID) INNER JOIN Telefono ON PuntoVenta.PuntoVentaID = Telefono.PuntoVentaID) WHERE Activo = 'S' ORDER BY PuntoVentaID ASC");

        $stmt->execute();

        return $stmt->fetch();
        
        

    }

/*=============================================
        REGISTRAR PDV
=============================================*/

    static public function mdlRegistrarPdv($datosModel, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5){

        $link = Conexion::conectar();
        
        //PRIMERO INSERTAMOS EL PUNTO DE VENTA
        $fecha_temp= explode('/', $datosModel["inicio"]);
        $fechaok= $fecha_temp[2].'-'.$fecha_temp[1].'-'.$fecha_temp[0];
        
        $stmt = $link->prepare("INSERT INTO $tabla1 (Nombre, CUITT, IngresosBrutos, InicioActividades) VALUES (:nombre, :cuitt, :ingresos, :inicio)");
        $stmt -> bindParam(":nombre", $datosModel["pdvNombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":cuitt", $datosModel["cuit"], PDO::PARAM_STR);
        $stmt -> bindParam(":ingresos", $datosModel["ingresos"], PDO::PARAM_STR);
        $stmt -> bindParam(":inicio", $fechaok, PDO::PARAM_STR);
        
        if($stmt -> execute()){

            #OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
            $idPdv = $link->lastInsertId();

        } else {

            return 'error pdv';

        }

        #INSERTAMOS EL TELEFONO
        $tipo = 'PuntoVenta';

        $stmt = $link->prepare("INSERT INTO $tabla5 (Prefijo, NroTelefono, Tipo, PuntoVentaID) VALUES (:prefijo, :numero, :tipo, :puntoVentaId)");
        $stmt -> bindParam(":prefijo", $datosModel["codArea"], PDO::PARAM_INT);
        $stmt -> bindParam(":numero", $datosModel["telefono"], PDO::PARAM_INT);
        $stmt -> bindParam(":tipo", $tipo, PDO::PARAM_STR);
        $stmt -> bindParam(":puntoVentaId", $idPdv, PDO::PARAM_INT);

        if($stmt -> execute()){

                #OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
                $idTelefono = $link->lastInsertId();

        } else {

            return 'error telefono';

        }

        #ANTES DE INGRESAR LA LOCALIDAD VERIFICAMOS SU EXISTENCIA

        $stmt = $link->prepare("SELECT * FROM $tabla3 WHERE Nombre = :localidad");
        $stmt -> bindParam(":localidad", $datosModel["localidad"], PDO::PARAM_STR);

        if ($stmt -> execute()) {

            $respuesta= $stmt->fetch();

                if (!empty($respuesta)) {

                    #LA LOCALIDAD EXISTE
                    $idLocalidad = $respuesta["LocalidadID"];

                    } else {

                        #LA LOCALIDAD NO EXISTE, INSERTAMOS LA LOCALIDAD

                        $stmt = $link->prepare("INSERT INTO $tabla3 (Nombre) VALUES (:nombre)");
                        $stmt -> bindParam(":nombre", $datosModel["localidad"], PDO::PARAM_STR);

                        if ($stmt -> execute()) {

                            #OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
                            $idLocalidad = $link->lastInsertId();

                            } else {

                                return 'error crear localidad';

                        }

                    }

            } else {

            return 'error verificar localidad';

        }

        #ANTES DE INGRESAR EL BARRIO VERIFICAMOS SU EXISTENCIA

        $stmt = $link->prepare("SELECT * FROM $tabla4 WHERE Nombre = :barrio");
        $stmt -> bindParam(":barrio", $datosModel["barrio"], PDO::PARAM_STR);

        if ($stmt -> execute()) {

            $respuesta= $stmt->fetch();

                if (!empty($respuesta)) {

                    #EL BARRIO EXISTE
                    $idBarrio = $respuesta["BarrioID"];


                } else {

                    #EL BARIO NO EXISTE, INSERTAMOS LA LOCALIDAD

                    $stmt = $link->prepare("INSERT INTO $tabla4 (Nombre) VALUES (:nombre)");
                    $stmt -> bindParam(":nombre", $datosModel["barrio"], PDO::PARAM_STR);

                    if ($stmt -> execute()) {

                        #OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
                        $idBarrio = $link->lastInsertId();

                    } else {

                        return 'error crear barrio';

                    }


                }

            } else {

                return 'error verificar barrio';

            }

        #INSERTAMOS EL DOMICILIO

        $stmt = $link->prepare("INSERT INTO $tabla2 (Calle, Nro, Piso, Dpto, CP, BarrioID, LocalidadID, PuntoVentaID) VALUES (:calle, :nro, :piso, :depto, :cp, :barrioID, :localidadID, :idPDV)");
        $stmt -> bindParam(":calle", $datosModel["calle"], PDO::PARAM_STR);
        $stmt -> bindParam(":nro", $datosModel["numCalle"], PDO::PARAM_INT);
        $stmt -> bindParam(":piso", $datosModel["piso"], PDO::PARAM_INT);
        $stmt -> bindParam(":depto", $datosModel["depto"], PDO::PARAM_STR);
        $stmt -> bindParam(":cp", $datosModel["codPostal"], PDO::PARAM_INT);
        $stmt -> bindParam(":barrioID", $idBarrio, PDO::PARAM_INT);
        $stmt -> bindParam(":localidadID", $idLocalidad, PDO::PARAM_INT);
        $stmt -> bindParam(":idPDV", $idPdv, PDO::PARAM_INT);

            if($stmt -> execute()){

                    return 'ok';

                } else {

                    return 'error domicilio';

            }
            
        $stmt->close();

    }

/*=============================================
        MODIFICAR PDV
=============================================*/

    static public function mdlModificarPdv($datosModel, $tabla1, $tabla2, $tabla3, $tabla4, $tabla5){

        $link = Conexion::conectar();
        
        #ANTES DE INGRESAR LA LOCALIDAD VERIFICAMOS SU EXISTENCIA

        $stmt = $link->prepare("SELECT * FROM $tabla3 WHERE Nombre = :localidad");
        $stmt -> bindParam(":localidad", $datosModel["localidad"], PDO::PARAM_STR);

            if ($stmt -> execute()) {

                $respuesta= $stmt->fetch();

                    if (!empty($respuesta)) {

                        #LA LOCALIDAD EXISTE
                        $idLocalidad = $respuesta["LocalidadID"];


                        } else {

                            #LA LOCALIDAD NO EXISTE, INSERTAMOS LA LOCALIDAD

                            $stmt = $link->prepare("INSERT INTO $tabla3 (Nombre) VALUES (:nombre)");
                            $stmt -> bindParam(":nombre", $datosModel["localidad"], PDO::PARAM_STR);

                                if ($stmt -> execute()) {

                                    #OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
                                    $idLocalidad = $link->lastInsertId();

                                    } else {

                                        return 'error crear localidad';

                                }


                        }

                } else {

                return 'error verificar localidad';

            }

        #ANTES DE INGRESAR EL BARRIO VERIFICAMOS SU EXISTENCIA

        $stmt = $link->prepare("SELECT * FROM $tabla4 WHERE Nombre = :barrio");
        $stmt -> bindParam(":barrio", $datosModel["barrio"], PDO::PARAM_STR);

            if ($stmt -> execute()) {

                $respuesta= $stmt->fetch();

                    if (!empty($respuesta)) {

                        #EL BARRIO EXISTE
                        $idBarrio = $respuesta["BarrioID"];


                    } else {

                        #EL BARIO NO EXISTE, INSERTAMOS LA LOCALIDAD

                        $stmt = $link->prepare("INSERT INTO $tabla4 (Nombre) VALUES (:nombre)");
                        $stmt -> bindParam(":nombre", $datosModel["barrio"], PDO::PARAM_STR);

                            if ($stmt -> execute()) {

                                #OBTENEMOS EL ID DEL ULTIMO REGISTRO INSERTADO
                                $idBarrio = $link->lastInsertId();

                            } else {

                                return 'error crear barrio';

                            }


                        }

                } else {

                    return 'error verificar barrio';

            }


            #MODIFICAMOS EL DOMICILIO

            $stmt = $link->prepare("UPDATE $tabla2 SET Calle = :calle, Nro = :nro, Piso = :piso, Dpto = :depto, CP = :cp, BarrioID = :barrioID, LocalidadID = :localidadID WHERE PuntoVentaID = :idPdv");

            $stmt -> bindParam(":calle", $datosModel["calle"], PDO::PARAM_STR);
            $stmt -> bindParam(":nro", $datosModel["numCalle"], PDO::PARAM_INT);
            $stmt -> bindParam(":piso", $datosModel["piso"], PDO::PARAM_INT);
            $stmt -> bindParam(":depto", $datosModel["depto"], PDO::PARAM_STR);
            $stmt -> bindParam(":cp", $datosModel["codPostal"], PDO::PARAM_INT);
            $stmt -> bindParam(":barrioID", $idBarrio, PDO::PARAM_INT);
            $stmt -> bindParam(":localidadID", $idLocalidad, PDO::PARAM_INT);
            $stmt -> bindParam(":idPdv", $datosModel["idPdv"], PDO::PARAM_INT);

                if($stmt -> execute()){

                    
                    } else {

                        return 'error domicilio';

                }

            #MODIFICAMOS EL TELEFONO

            $stmt = $link->prepare("UPDATE $tabla5 SET Prefijo = :prefijo, NroTelefono = :nroTelefono WHERE PuntoVentaID = :idPdv");

            $stmt -> bindParam(":prefijo", $datosModel["codArea"], PDO::PARAM_STR);
            $stmt -> bindParam(":nroTelefono", $datosModel["telefono"], PDO::PARAM_INT);
            $stmt -> bindParam(":idPdv", $datosModel["idPdv"], PDO::PARAM_INT);

                if($stmt -> execute()){

                    
                    } else {

                        return 'error telefono';

                }

            $fecha_temp= explode('/', $datosModel["inicio"]);
            $fechaok= $fecha_temp[2].'-'.$fecha_temp[1].'-'.$fecha_temp[0];
            
            $stmt = $link->prepare("UPDATE $tabla1 SET Nombre = :nombre, Activo = :activo, CUITT = :cuitt, IngresosBrutos = :ingresos, InicioActividades = :inicio WHERE PuntoVentaID = :idPdv");

            $stmt -> bindParam(":nombre", $datosModel["pdvNombre"], PDO::PARAM_STR);
            $stmt -> bindParam(":activo", $datosModel["activo"], PDO::PARAM_STR);
            $stmt -> bindParam(":cuitt", $datosModel["cuit"], PDO::PARAM_STR);
            $stmt -> bindParam(":ingresos", $datosModel["ingresos"], PDO::PARAM_STR);
            $stmt -> bindParam(":inicio", $fechaok, PDO::PARAM_STR);
            $stmt -> bindParam(":idPdv", $datosModel["idPdv"], PDO::PARAM_INT);

            if($stmt -> execute()){

                return 'ok';

            } else {

                return 'error punto de venta';

            }
            
            $stmt->close();

    }

/*=============================================
        ELIMINAR PDV
=============================================*/

    static public function mdlEliminarPdv($tabla, $idPDV){

        $link = Conexion::conectar();
        $stmt = $link ->prepare("DELETE FROM $tabla WHERE PuntoVentaID = :pdv");
        $stmt -> bindParam(":pdv", $idPDV, PDO::PARAM_INT);

            if($stmt -> execute()){

                return 'ok';      

            } else {

                return 'error';

            }
        
            $stmt->close();

    }

/*=============================================
        ACTIVAR PDV
=============================================*/

    static public function mdlActivarPdv($tabla, $item1, $valor1, $item2, $valor2){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
        $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
        $stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

        if($stmt -> execute()){

            return "ok";

        }else{

            return "error";

        }

        $stmt -> close();

        $stmt = null;

    }

//////////////////////////////////////////////////////////////////////////  MEDIOS DE PAGO ////////////////////////////////////////////////////////////////

/*=============================================
        MOSTRAR MDP
=============================================*/

    static public function mdlMostrarMdPs($tabla, $item, $valor){

        if ($item != null) {
            
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY MedioPagoID ASC");

            $stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();
        
        } else {

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY MedioPagoID ASC");
            $stmt->execute();
            return $stmt->fetchAll();
            $stmt->close();
        }

    }

/*=============================================
        REGISTRAR MDP
=============================================*/

    static public function mdlRegistrarMdp($datosModel, $tabla){

        $link = Conexion::conectar();
        
        $activo = "S";
        $stmt = $link->prepare("INSERT INTO $tabla (Nombre, Activo) VALUES (:nombre, :activo)");
        $stmt -> bindParam(":nombre", $datosModel, PDO::PARAM_STR);
        $stmt -> bindParam(":activo", $activo, PDO::PARAM_STR);
        
        if($stmt -> execute()){

            return 'ok';

        } else {

            return 'error';

        }
        
        $stmt->close();

    }

/*=============================================
        MODIFICAR MDP
=============================================*/

    static public function mdlModificarMdp($datosModel, $tabla){

        $link = Conexion::conectar();
        
        $activo = "S";
        $stmt = $link->prepare("UPDATE $tabla SET Nombre = :nombre, Activo = :activo WHERE MedioPagoID = :idMdP");
        $stmt -> bindParam(":nombre", $datosModel["nombre"], PDO::PARAM_STR);
        $stmt -> bindParam(":activo", $activo, PDO::PARAM_STR);
        $stmt -> bindParam(":idMdP", $datosModel["idMdp"], PDO::PARAM_INT);
        
        if($stmt -> execute()){

            return 'ok';

        } else {

            return 'error';

        }
        
        $stmt->close();

    }

/*=============================================
        ELIMINAR MDP
=============================================*/

    static public function mdlEliminarMdp($datosModel, $tabla){

        $link = Conexion::conectar();
        $stmt = $link ->prepare("DELETE FROM $tabla WHERE MedioPagoID = :idMdp");
        $stmt -> bindParam(":idMdp", $datosModel, PDO::PARAM_INT);

            if($stmt -> execute()){

                return 'ok';

            } else {

                return 'error';

            }

            $stmt->close();

    }

/*=============================================
        ACTIVAR MDP
=============================================*/

    static public function mdlActivarMdp($tabla, $item1, $valor1, $item2, $valor2){

        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");
        $stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
        $stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

        if($stmt -> execute()){

            return "ok";

        }else{

            return "error";

        }

        $stmt -> close();

        $stmt = null;

    }


}
