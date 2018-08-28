/*=========================================
        CARGAR TABLA INSUMOS
=========================================*/

    var table2 = $(".tablaInsumosReceta").DataTable({

        "ajax":"ajax/tablaInsumosReceta.ajax.php",

        "columnDefs": [
            {"className": "text-center", "targets": "_all"},
            {

            "targets": -1,
            "data": null,
            "defaultContent": '<div class="btn-group"><button class="btn btn-primary waves-effect waves-ligh agregarInsumo recuperarBoton"><i class="icofont icofont-plus"></i> Agregar</button></div>'
            
            }

         ],

         "language": {

            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Registros del _START_ al _END_ de _TOTAL_",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
            "sInfoFiltered":   "",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }

        }

    });


    //CARGAMOS LOS IDS EN LOS BOTONES DE ACCION

    $('.tablaInsumosReceta tbody').on( 'click', 'button.agregarInsumo', function () {
    
        if (window.matchMedia("(min-width:992px)").matches){

            var data2 = table2.row( $(this).parents('tr') ).data();
                                     
        } else {

            var data2 = table2.row( $(this).parents('tbody tr ul li') ).data();
               
        }

        $(this).attr("idInsumo", data2[3]);
                               
    });

/*=========================================
        AGREGAR INSUMOS A LA RECETA
=========================================*/
    
    $('.tablaInsumosReceta tbody').on("click", "button.agregarInsumo", function(){

        var idInsumo = $(this).attr("idInsumo");
                      
        $(this).removeClass("btn-primary agregarInsumo");
        $(this).addClass("btn-default");
        
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
                                        
                    var descripcion = respuesta["Nombre"];
                    var medida = respuesta["Medida"];
                    
                    $(".nuevoInsumo").append(

                        '<div class="row">'+
                            '<div class="col-sm-8">'+
                                '<div class="material-group">'+
                                    '<div class="material-addone">'+
                                        '<button type="button" class="btn btn-danger btn-mini waves-effect waves-light p-1 quitarInsumo" idInsumo="'+idInsumo+'"><i class="icofont icofont-close m-0"></i></button>'+
                                    '</div>'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="text" class="form-control md-static nuevaDescripcionInsumo" name="descInsumoCompra" id="descInsumoCompra" idInsumo="'+idInsumo+'" value="'+descripcion+'" nombreInsumo="'+descripcion+'" readonly required>'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Descripción</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2 ingresoCantidad">'+
                                '<div class="material-group">'+
                                    '<div class="form-group form-default form-static-label">'+
                                        '<input type="text" class="form-control form-control-right cantidadInsumo" name="cantidadInsumo">'+
                                        '<span class="form-bar"></span>'+
                                        '<label class="float-label text-dark">Cantidad</label>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2 muestroMedidaInsumo">'+
                                '<label class="text-dark medidaInsumo p-t-20">'+medida+'</label>'+
                            '</div>'+
                        '</div>'

                        );

                    
                    //LISTAMOS LOS INSUMOS PARA CREAR LA RECETA
                    listarInsumos();

                }
 
            });
        
    });

/*=========================================
        QUITAR INSUMOS DE LA RECETA
=========================================*/

    $('#formNuevaReceta').on("click", "button.quitarInsumo", function(){

        $(this).parent().parent().parent().parent().remove();

        var idInsumo = $(this).attr("idInsumo");

        $("button.recuperarBoton[idInsumo='"+idInsumo+"']").removeClass('btn-default');

        $("button.recuperarBoton[idInsumo='"+idInsumo+"']").addClass('btn-primary agregarInsumo');

            if ($(".nuevoInsumo").children().length == 0 ) {

                $("#listadoInsumos").val(0);

            } else {

                //LISTAMOS LOS INSUMOS PARA CREAR LA RECETA
                listarInsumos();

            }
        
    });

/*=========================================
        AGREGAR INSUMOS DESDE EL BOTON
=========================================*/

    $(".btnAgregarInsumo").click(function(){

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
        SELECCIONAR INSUMO
=========================================*/

    $('#formNuevaReceta').on("change", "select.nuevaDescripcionInsumo", function(){

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
                    listarInsumos();
                             
                }
        });       
        

    });

/*=========================================
        MODIFICAR CANTIDAD
=========================================*/

    $('#formNuevaReceta').on("change", "input.cantidadInsumo", function(){

        //LISTAMOS LOS PRODUCTOS PARA CREAR LA RECETA
        listarInsumos();

     
    });

/*=========================================
        LISTAR TODOS LOS INSUMOS
=========================================*/

    function listarInsumos(){

        var listaInsumos = [];
        var descripcion = $(".nuevaDescripcionInsumo");
        var cantidad = $(".cantidadInsumo"); 

        for (var i = 0; i < descripcion.length; i++) {
            
            listaInsumos.push({"idInsumo":$(descripcion[i]).attr("idInsumo"),
                                 "nombreInsumo":$(descripcion[i]).attr("nombreInsumo"),
                                 "cantidadInsumo":$(cantidad[i]).val()});

        }

        $("#listadoInsumos").val(JSON.stringify(listaInsumos));
        
    }

/*=========================================
        EDITAR RECETA
=========================================*/

    $(".tablas").on("click", ".btnEditarReceta", function(){

        var idReceta = $(this).attr("idReceta");

        window.location= "index.php?ruta=editar-receta&idReceta="+idReceta;

    })

/*=========================================
        ELIMINAR RECETA
=========================================*/

    $(".tablas").on("click", ".btnEliminarReceta", function(){

        var idReceta = $(this).attr("idReceta");
        var nombre = $(this).attr("nombre");
        
        swal({
            title: "¡Atencion!",
            text: "¿Desea eliminar la receta "+nombre+"?",
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
            datos.append("eliminarReceta", idReceta);

            $.ajax({
                url:"ajax/recetas.ajax.php",
                method:"POST",
                data: datos,
                cache: false,
                contentType: false,
                processData: false,
                success:function(respuesta){

                    if(respuesta==0){

                        swal({
                        title:"Receta eliminada!",
                        text:"¡La receta se eliminó correctamente!",
                        type:"success",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="recetas";

                            }

                        });

                    } else {

                        swal({
                        title:"Error!",
                        text:"¡No se pudo eliminar la receta!",
                        type:"error",
                        confirmButtonText: "Cerrar",
                        closeOnConfirm: false
                        },
                        function(isConfirm){

                            if(isConfirm){

                                window.location="recetas";

                            }
                        });
                    }
                }
            });;
        }, 1000);
        });
        

    })

/*=========================================
        DETALLE RECETA
=========================================*/

    $(".tablas").on("click", ".btnDetalleReceta", function(){

        var idReceta = $(this).attr("idReceta");
         
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
                                
                $(".img-receta").attr("src", respuesta["Imagen"]);
                $(".tituloDetalleReceta").html("Receta de "+respuesta["Nombre"]);

            }
        
        });


        var datos = new FormData();
        datos.append("idRecetaDetalle" ,idReceta);

        $.ajax({

            url: "ajax/recetas.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(respuesta){
                                
                respuesta.forEach(function(respuesta, index) {
                  
                   $(".listadoProductosDetalle").append(

                        '<span class="text-dark">'+respuesta.Cantidad+' '+respuesta.Medida+' '+respuesta.Nombre+'</span><br>'
                    
                    );
                });
            }
        });

    })

/*==========================================
        FORMATEAR MODAL DETALLE RECETA
==========================================*/

    $("#modalDetalleDeReceta").on('show.bs.modal', function () {

        $(".listadoProductosDetalle").empty();

    });