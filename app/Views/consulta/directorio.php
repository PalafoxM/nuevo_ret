<html lang="es"> 
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta name="description" content=""/><meta name="author" content=""/>
		<meta name="robots" content="all"/><meta name="geo.placename" content="México"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    		<title>Consulta Ciudadana del Estado de Guanajuato | Registro Estatal de Turismo</title>

		<link rel="shortcut icon" href="<?=BASE_URL?>static/images/favicon.ico" type="image/x-icon">
		<link rel="stylesheet" href="<?=BASE_URL?>static/css/bootstrap.min.5.1.0.css"/>
		<link rel="stylesheet" href="<?=BASE_URL?>cc/css/main.css"/>
		<link rel="stylesheet" href="<?=BASE_URL?>static/css/template.css?v=1.1.2"/>
		<link rel="stylesheet" href="<?=BASE_URL?>static/css/header.css"/>
		<link rel="stylesheet" href="<?=BASE_URL?>static/css/inicio.css?v=1.2"/>
		<link rel="stylesheet" href="<?=BASE_URL?>static/css/footer.css?v=1.1"/>
		<link rel="stylesheet" href="<?=BASE_URL?>static/css/bootstrap-icons.css"/>
    	<script type="text/javascript" src="<?=BASE_URL?>static/js/bootstrap.bundle.min.5.1.0.js"></script>
    	<script type="text/javascript" src="<?=BASE_URL?>static/js/jquery.min-3.3.1.js"></script>

  		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

		<!-- INTEGRACIÓN Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-33018357-1"></script>
		<script>
  			window.dataLayer = window.dataLayer || [];
  			function gtag(){dataLayer.push(arguments);}
  			gtag('js', new Date());

  			gtag('config', 'UA-33018357-1');
		</script>

	</head>


	<body>
   		<?php echo view('public/nav');?>
		<?php echo view('public/header');?>
		<?php echo view($content);?>
		<?php echo view('public/footer');?>
		<?php
		if(isset($footer_js))
		for($i = 0; $i < count($footer_js); $i++)
		  echo '<script type="text/javascript" src="'.$footer_js[$i].'"></script>';

		if(isset($footer_script))
		for($i = 0; $i < count($footer_script); $i++)
		  echo view($footer_script[$i]);
		?>

	</body>
</html>

