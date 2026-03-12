$(document).on("ready",inicio);

function inicio(){


	$("form").submit(function (event){

		event.preventDefault();

		$.ajax({
			url:$("form").attr("action"),
			type:$("form").attr("method"),
			data:$("form").selialize(),
			succes:function(respuesta){
				alert(respuesta);
			}
		})
	})
}