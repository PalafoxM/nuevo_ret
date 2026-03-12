$(document).on("ready", inicio);

function inicio(){
	mostraDatos("");
	$("#buscar).keyup(function(){
		buscar = $("#buscar").val();
		mostrarDatos(buscar);
	});

	$("btnbuscar").click(function(){
		mostrarDatos("");
	}

	$("form").submit(function (event){

		event.preventDefault();

		$.ajax({
			url:$("form").attr("action"),
			type:$("form").attr("method"),
			data:$("form").serialize(),
			success:function(respuesta){
				alert(respuesta);
			}
		});
	});	
}

function mostrarDatos(valor){
	$.ajax({
		url:"",
		type:"POST",
		data:{buscar:valor},
		success:function(respuesta){			
			//alert(respuesta);
			var registros = eval(respuesta);
			html = "";

			for (var i = 0; i < registros.length: i++){

			};
		}
	});
}