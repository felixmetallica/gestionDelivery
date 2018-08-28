/*=============================================
		NUEVO CAMPO INSUMO
=============================================*/

	 $("#agregarInsumo").click(function(){

        var datos = new FormData();
        datos.append("traerInsumos", "ok");

        $.ajax({

                url: "ajax/insumos.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                    
                    $(".nuevoInsumo").append(

                        '<div class="row">'+
                            '<div class="col-sm-8">'+
                                '<div class="material-group p-t-5">'+
                                    '<span class="material-addone">'+
                                        '<button  type="button" class="btn waves-effect waves-light btn-danger btn-mini idInsumo quitarInsumo"><i class="icofont icofont-close m-0"></i></button>'+
                                    '</span>'+
                                    '<div class="form-group form-primary form-static-label">'+
                                        '<select class="form-control nuevaDescripcionInsumo" idInsumo name="nuevaDescripcionInsumo" required>'+
                                            '<option value="">Seleccione insumo</option>'+
                                        '</select>'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label">Insumo</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2 ingresoCantidad">'+
                                '<div class="material-group material-group-primary">'+
                                    '<div class="form-group form-primary form-static-label">'+
                                        '<input type="text" class="form-control cantidadInsumo" name="cantidadInsumo[]" required>'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label">Cantidad</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2 muestroMedidaInsumo">'+
                                '<label class="text-dark medidaInsumo p-t-20 medidaInsumo"></label>'+
                            '</div>'+
                        '</div>'
                    ); 
                    
                    //AGREGAR LOS PRODUCTOS AL SELECT

                    respuesta.forEach(funcionForEach);

                    function funcionForEach(item, index){

                        $(".nuevaDescripcionInsumo").append(

                            '<option idInsumo="'+item.InsumosID+'" value="'+item.InsumosID+'">'+item.Nombre+'</option>'

                        )

                    }
                                   
                }

        	});

    	})

/*=========================================
        QUITAR INSUMOS DE LA RECETA
=========================================*/

    $('#formAgregarReceta').on("click", "button.quitarInsumo", function(){

    	$(this).parent().parent().parent().parent().remove();

                       
    })

/*=========================================
        SELECCIONAR INSUMO
=========================================*/

    $('#formAgregarReceta').on("change", "select.nuevaDescripcionInsumo", function(){

        var idInsumo= $(this).val();
        var nuevaDescripcionInsumo = $(this).parent().parent().parent().parent().children().children().children().children(".nuevaDescripcionInsumo");
        var muestroMedidaInsumo = $(this).parent().parent().parent().parent().children(".muestroMedidaInsumo").children(".medidaInsumo");
             
        var datos = new FormData();
        datos.append("idEditarInsumo", idInsumo);

        $.ajax({

                url: "ajax/insumos.ajax.php",
                method: "POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(respuesta){
                   
                    $(nuevaDescripcionInsumo).attr("idInsumo", respuesta["InsumosID"]);
                    $(nuevaDescripcionInsumo).attr("nombreInsumo", respuesta["Nombre"]);
                    $(muestroMedidaInsumo).html(respuesta["Medida"]);

                    //LISTAMOS LOS PRODUCTOS PARA CREAR LA RECETA
                    listarProductos();
                             
                }
        });       
        

    });

/*=========================================
        LISTAR TODOS LOS PRODUCTOS
=========================================*/

    function listarProductos(){

        var listaProductos = [];
        var descripcion = $('.nuevaDescripcionInsumo');
        var cantidad = $(".cantidadInsumo"); 

        for (var i = 0; i < descripcion.length; i++) {
            
            listaProductos.push({"idInsumo":$(descripcion[i]).attr("idInsumo"),
                                 "nombreInsumo":$(descripcion[i]).attr("nombreInsumo"),
                                 "cantidadInsumo":$(cantidad[i]).val()});

        }

        $("#listadoInsumos").val(JSON.stringify(listaProductos));

        
        
    }

/*=========================================
    	MODIFICAR CANTIDAD
=========================================*/

    $('#formAgregarReceta').on("change", "input.cantidadInsumo", function(){

        //LISTAMOS LOS PRODUCTOS PARA CREAR LA RECETA
        listarProductos();

     
    });

/*==================================================================================================================================*/

/*=========================================
   		EDITAR RECETA
=========================================*/

    $(".tablas").on("click", ".btnEditarReceta", function(){

        var idReceta = $(this).attr("idReceta");
        var idProducto = $(this).attr("idProducto");
        var nombreProducto = $(this).attr("productoNombre");
                
        $("#eidReceta").val(idReceta);
        $("#eidProductoReceta").val(idProducto);

        var datos = new FormData();
        datos.append("idReceta" ,idReceta);
        
        $.ajax({

            url: "ajax/recetas.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                
                $(".tituloEditarReceta").html("Editar receta "+respuesta["Nombre"]);
                $("#eProductoReceta").val(respuesta["Nombre"]);


            }

        });

        var datosReceta = new FormData();
        datosReceta.append("idRecetaDetalle" ,idReceta);
        datosReceta.append("idProducto", 0);

        $.ajax({

            url: "ajax/recetas.ajax.php",
            method: "POST",
            data: datosReceta,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                           
                respuesta.forEach(funcionForEach);

                function funcionForEach(item, index){

                    $(".enuevoInsumo").append(

                                                '<div class="row">'+
                                                        '<div class="col-sm-8">'+
                                                            '<div class="material-group p-t-5">'+
                                                                '<span class="material-addone">'+
                                                                    '<button type="button" class="btn waves-effect waves-light btn-danger btn-mini idInsumo equitarInsumo"><i class="icofont icofont-close m-0"></i></button>'+
                                                                '</span>'+
                                                                '<div class="form-group form-primary form-static-label">'+
                                                                    '<select class="form-control enuevaDescripcionInsumo" idInsumo name="enuevaDescripcionInsumo" id="enuevaDescripcionInsumo" required>'+
                                                                        '<option value="">Seleccione insumo</option>'+
                                                                    '</select>'+
                                                                    '<span class="form-bar"></span>'+
                                                                    '<label class="float-label">Insumo</label>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="col-sm-2 eingresoCantidad">'+
                                                            '<div class="material-group material-group-primary">'+
                                                                '<div class="form-group form-primary form-static-label">'+
                                                                    '<input type="text" class="form-control ecantidadInsumo" name="ecantidadInsumo[]" required>'+
                                                                    '<span class="form-bar"></span>'+
                                                                    '<label class="float-label">Cantidad</label>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="col-sm-2 emuestroMedidaInsumo">'+
                                                            '<label class="text-dark p-t-20 emedidaInsumo"></label>'+
                                                        '</div>'+
                                                    '</div>'

                                                );

                    }


                
                


            }

        });

       setTimeout(function(){
        var datosRecetaSelect = new FormData();
        datosRecetaSelect.append("idRecetaDetalle" ,idReceta);
        datosRecetaSelect.append("idProducto" ,idProducto);

        $.ajax({

            url: "ajax/recetas.ajax.php",
            method: "POST",
            data: datosRecetaSelect,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                                
                $("#enuevaDescripcionInsumo").html(respuesta);


            }

        });
 },300) 
        
    })




        
               
   
