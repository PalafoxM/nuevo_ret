<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?=BASE_URL?>assets/images/favicon.ico" type="image/x-icon">

    <title>Registro Estatal de Turismo del Estado de Guanajuato</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=BASE_URL?>assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?=BASE_URL?>assets/css/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=BASE_URL?>assets/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?=BASE_URL?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?render=<?=SITE_KEY?>"></script>
</head>

<body>
	<div class="container">
		<div class="row">
	        	<div class="col-md-4 col-md-offset-4">
	            		<div class="login-panel panel panel-default">
	                		<div class="panel-heading">
	                    			<h3 class="panel-title"><center><img class="img-responsive center-block" src="<?=BASE_URL?>assets/images/logo_ret.png" /></center></h3>
	                		</div>
	                		<div class="panel-body">
	                    			<form id="login_form" role="form" method="post" action="<?=BASE_URL?>panelauth/login/">
	                        			<fieldset>
	                            				<div class="form-group">
	                                				<input type="email" class="form-control" id="email" placeholder="correo@guanajuato.gob.mx" name="email" style="text-transform: lowercase;" required autofocus>
	                            				</div>

	                            				<div class="form-group">
	                                				<input class="form-control" id="password" placeholder="contraseña" name="password" type="password" value="" required>
	                            				</div>

	                            				<div class="form-group">
	                                				<small><a href="#" onclick="alert('Por favor, contacta al administrador para restablecer tu contraseña!')">¿Olvidaste tu contraseña?</a></small>
	                            				</div>

	                            				<input id="login-submit" type="submit" value="Ingresar" class="btn btn-primary btn-block">
	                        			</fieldset>
	                    			</form>
	                		</div>
	            		</div>
	        	</div>
	    	</div>
	</div>

	
    	<!-- jQuery -->
    	<script src="<?=BASE_URL?>assets/js/jquery.min.js"></script>

    	<!-- Bootstrap Core JavaScript -->
    	<script src="<?=BASE_URL?>assets/js/bootstrap.min.js"></script>

    	<!-- Metis Menu Plugin JavaScript -->
    	<script src="<?=BASE_URL?>assets/js/metisMenu.min.js"></script>

    	<!-- Custom Theme JavaScript -->
    	<script src="<?=BASE_URL?>assets/js/sb-admin-2.js"></script>

		<script>
		  $('#login_form').submit(function() {
		    event.preventDefault();
		    var clave = $('#email').val();
		    var passw = $('#password').val();
		    grecaptcha.ready(function() {
		      grecaptcha.execute('<?=SITE_KEY?>', {action: 'submit'}).then(function(token) {
		        
		        $('#login_form').prepend('<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="' + token + '">');
		        $.post("panelauth/login",{clave: clave, pass: passw, token: token}, function(result) {
		          
		          if (result.alert)
		            t1 = window.setTimeout(function(){ window.location = "<?=BASE_URL?>paneldash"; },5);
		          else
		            alert('No puedes acceder. Razón: ' + result.msg);
		          
		        });

		      });;
		    });
		  });
		</script>

</body>

</html>
