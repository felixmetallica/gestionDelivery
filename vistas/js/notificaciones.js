/*=============================================
ACTUALIZAR NOTIFICACIONES
=============================================*/

    
	$(".actualizarNotificaciones").click(function(e){

		e.preventDefault();

		var item = $(this).attr("item");
				
		var datos = new FormData();
	 	datos.append("item", item );

	  	$.ajax({

	  		url:"ajax/notificaciones.ajax.php",
	  		method: "POST",
		  	data: datos,
		  	cache: false,
	      	contentType: false,
	      	processData: false,
	      	success: function(respuesta){
	      			      		
	      		if (respuesta == "ok") {

	      			if (item == "NuevasVentas") {

	      				window.location = "ventas";
	      			}
	      		}
	      		
	  		}

	  	})

	})

