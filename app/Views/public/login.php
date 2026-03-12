
<main class="form-signin text-center form-body">
  <form id="login_form" action="<?=BASE_URL?>sesion" method="post">
    <h1 class="h3 mb-3 fw-normal ret-titulo">Ingresa al RET</h1>
    <hr class="my-4">
    <div class="form-floating">
      <input type="text" class="form-control" id="clave" name="clave" placeholder="Usuario">
      <label for="clave">Usuario</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="pass" name="pass" placeholder="Contraseña">
      <label for="pass">Contraseña</label>
    </div>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Iniciar sesión</button>
    <hr class="my-4">
    <p class="lead">Como alternativa, inicia sesión con las siguientes tecnologías</p>
    <a href="<?=BASE_URL?>ingresar/facebook-login" class="w-30 btn btn-sm btn-secondary btn-fcbk">Iniciar con Facebook</a>
    <a href="<?=BASE_URL?>ingresar/google-login" class="w-30 btn btn-sm btn-secondary btn-goog">Iniciar con Google</a>
    <a href="<?=BASE_URL?>ingresar/microsoft-login" class="w-30 btn btn-sm btn-secondary btn-msft">Iniciar con Microsoft</a>
    <hr class="my-4">
    <a href="<?=BASE_URL?>registro">¿No eres usuario? Regístrate</a>
  </form>
</main>

<script>
  $('#login_form').submit(function() {
    event.preventDefault();
    var clave = $('#clave').val();
    var passw = $('#pass').val();
    grecaptcha.ready(function() {
      grecaptcha.execute('<?=SITE_KEY?>', {action: 'submit'}).then(function(token) {
        
        $('#login_form').prepend('<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="' + token + '">');
        $.post("sesion",{clave: clave, pass: passw, token: token}, function(result) {
          
          if (result.success)
            t1 = window.setTimeout(function(){ window.location = "<?=BASE_URL?>ingresar"; },5);
          else
            alert('No puedes acceder a la plataforma.');
          
        });

      });;
    });
  });
</script>