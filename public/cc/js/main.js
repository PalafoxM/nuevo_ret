$(function() {
	$(".btnGiro").each(function() {
		$( this ).click(function() {
			$("#cajaGiro").val($(this).data('idgiro'));
			$("#frmFiltro").submit();
		});
	});

	$(".btnCert").each(function() {
		$( this ).click(function() {
			$("#boxCert").val($(this).data('idcert'));
			$("#frmCert").submit();
		});
	});
	Rez();
});

$( window ).resize(function() {
	Rez();
});

//Resize
function Rez(){
	var ancho = $( window ).width();

	/*if(ancho >= 1200){
		$("#topLogo").css('text-align','left');
		$(".title").css('text-align','left');
		$(".title").css('width','100%');
		$(".title").css('font-size','38px');
	}*/
	if(ancho >= 992){
		$("#topLogo").css('text-align','left');
		$(".title").css('text-align','left');
		$(".title").css('font-size','38px');
		$("#topCert").css('text-align','right');
	}
	if(ancho >= 768){
		$("#topLogo").css('text-align','center');
		$(".title").css('text-align','center');
		$(".title").css('width','100%');
		$(".title").css('font-size','32px');
		$("#topCert").css('text-align','center');
	}
	if(ancho < 768){
		$("#topLogo").css('text-align','center');
		$(".title").css('text-align','center');
		$(".title").css('width','100%');
		$(".title").css('font-size','32px');
		$("#topCert").css('text-align','center');
	}
}