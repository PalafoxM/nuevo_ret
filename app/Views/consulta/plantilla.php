<html lang="es"> 
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="description" content=""/><meta name="author" content=""/>
		<meta name="robots" content="all"/><meta name="geo.placename" content="México"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<link rel="shortcut icon" href="{DIR}img/favicon.ico"/>
		<title>Consulta Ciudadana del Estado de Guanajuato</title>
		<script src="{DIR}js/jquery-1.11.1.min.js"></script><script src="{DIR}js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="{DIR}css/bootstrap.css"/>
		<link rel="stylesheet" href="{DIR}css/bootstrap-theme.css"/>
		<link rel="stylesheet" href="{DIR}css/main.css"/>

		<!-- INTEGRACIÓN Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-33018357-1"></script>
		<script>
  			window.dataLayer = window.dataLayer || [];
  			function gtag(){dataLayer.push(arguments);}
  			gtag('js', new Date());

  			gtag('config', 'UA-33018357-1');
		</script>

	</head>


	<body rel="{DIR}">
		<div class="container-fluid">
			<div class="row bgMarino">
				<div class="col-md-10" style="padding: 10px 15px; margin:0 auto">
					<div class="col-md-2"><p class="m-0 text-center address" style="font-family: Proxima Nova, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:12px; color:#FFF"><span class="fa fa-phone" style="letter-spacing:10px;"></span> </p></div>
					<div class="col-md-3"><p class="m-0 text-center address" style="font-family: Proxima Nova, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:12px; color:#FFF"><span class="fa fa-envelope" style="letter-spacing:10px;"></span> </p></div>
				</div>
			</div>

			<div class="row bgAzulIns">
				<div class="container">
					<div class="row">
						<div id="topLogo" class="col-md-2 col-sm-10 col-xs-10" style="padding: 10px 15px; margin:0 auto">
							<a href="{DIR}"><img src="https://registroestataldeturismo.com/frontend/imgs/home/logo_sectur_gto.png" /></a>
						</div>

						<div class="col-md-8 col-sm-10 col-xs-10">
							<h4 class="title" style="font-family: Proxima Nova, Helvetica Neue, Helvetica, Arial, sans-serif; color:#FFF"> Consulta Ciudadana del Estado de Guanajuato </h4>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<form action="{DIR}directorio/mostrar" method="post" id="frmCert">
					<input name="cert" type="hidden" id="boxCert" class="boxSearch"/>
					<input name="giro" type="hidden" value="" id="boxGiro" class="boxSearch"/>
				</form>

				<h5 style="text-align: left; background-color:#FF8200; color: #FFF; border-bottom-right-radius:40px; border-top-right-radius:40px; padding: 14px 20px;" font-family: Proxima Nova, Helvetica Neue, Helvetica, Arial, sans-serif; color:#FFF"> Inventario de Servicios Turísticos del Estado de Guanajuato </h5>
				<b> Haz clic para consultarlo </b> >> <a href="http://www.observatorioturistico.org/publicaciones/seccion/2" target="_blank"><img src="{DIR}img/inventario_oteg.png"/></a>


				<h5 class="bgMarino" style="text-align: left; color: #FFF; border-bottom-right-radius:40px; border-top-right-radius:40px; padding: 14px 20px;" font-family: Proxima Nova, Helvetica Neue, Helvetica, Arial, sans-serif; color:#FFF"> FILTRO POR CERTIFICACIONES <small style="text-align: left; color: #fff;"> (En un sólo clic) </small> </h5>

				<div id="topCert" class="col-md-12 col-sm-12 col-xs-10">
					<img src="{DIR}img/line.jpg"/>
					<img src="{DIR}img/gran-anfitrion.jpg" data-idcert="ga" class="btnCert"/>
					<img src="{DIR}img/line.jpg"/>
					<img src="{DIR}img/tesoros.jpg" data-idcert="t" class="btnCert"/>
					<img src="{DIR}img/line.jpg"/>
					<img src="{DIR}img/punto-limpio.jpg" data-idcert="pl" class="btnCert"/>
					<img src="{DIR}img/line.jpg"/>
					<img src="{DIR}img/distintivo-h.jpg" data-idcert="h" class="btnCert"/>
					<img src="{DIR}img/line.jpg"/>
					<img src="{DIR}img/distintivo_m.jpg" width="70px" data-idcert="m" class="btnCert"/>
					<img src="{DIR}img/line.jpg"/>
					<img src="{DIR}img/premio_competitividad.jpg" width="70px" data-idcert="ct" class="btnCert"/>
					<img src="{DIR}img/line.jpg"/>
				</div>


				<form action="{DIR}directorio/mostrar" method="post" id="frmFiltro">
					<div class="col-md-4">
						<select name="idmun" class="boxSearch" style="font-family: Proxima Nova, Helvetica Neue, Helvetica, Arial, sans-serif;">
							<option value=""> Municipio... </option>
							{MUNS}
						</select>
					</div>

					<div class="col-md-4">
						<input name="nomcom" type="text" style="font-family: Proxima Nova, Helvetica Neue, Helvetica, Arial, sans-serif;" placeholder="Nombre Comercial" class="boxSearch"/>
						<input name="giro" type="hidden" id="cajaGiro" class="boxSearch"/>
					</div>

					<div class="col-md-2">
						<input type="submit" class="btnSend" style="font-family: Proxima Nova, Helvetica Neue, Helvetica, Arial, sans-serif;" value="CONSULTAR" />
					</div>

					<div class="clear"></div>
				</form>


				<div class="row">
					<div class="col-md-10">
						<p class="tac"></p>
					</div>
				</div>
			</div>
		</div>

		{CONTENT}


		<!-- PIE DE PAGINA | FRONTEND CONSULTA CIUDADANA RET -->
		<footer class="container-fluid bgGris">
			<div class="container">
				<br>
				<center><img src="{DIR}img/IgualdadLaboral.png" width="100" height="" alt=""></center>

				<p class="m-0 text-center address" style="font-family: Proxima Nova, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:14px; color:#000"> <br>
					<b>Secretaría de Turismo</b> <br>
				</p>

				<p class="m-0 text-center address" style="font-family: Proxima Nova, Helvetica Neue, Helvetica, Arial, sans-serif; font-size:12px; color:#000"> 
					Carretera de cuota Silao-Guanajuato Km. 3.8 (dentro de las instalaciones de Parque Guanajuato Bicentenario) <br>
					C.P. 36270 Silao, Guanajuato <br>
					Tel. (472) 103 99 00 <br><br>

					<a href="https://www.facebook.com/Sectur.Guanajuato" target="_blank"><img src="https://registroestataldeturismo.com/frontend/imgs/home/facebook-i.png" width="20" height="" alt=""></a>
					<a href="https://twitter.com/SECTURGTO" target="_blank"><img src="https://registroestataldeturismo.com/frontend/imgs/home/twitter-i.png" width="20" height="" alt=""></a>

					<br><br>

					&copy; <label id="fecha"></label> <script type="text/javascript"> var year = (new Date).getFullYear(); $(document).ready(function() { $("#fecha").text( year );}); </script> Gobierno del Estado de Guanajuato, Derechos Reservados. <br>
					<a href="https://registroestataldeturismo.com/informativos/aviso_legal.pdf" target="_blank" style="color:#000"><b> Aviso Legal </b></a>
				</p>	
			</div>		
		</footer>

		<script src="{DIR}js/main.js"></script>

	</body>
</html>