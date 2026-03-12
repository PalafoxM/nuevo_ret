
<main class="form-signin text-center form-body">
  <form id="signin_form" action="<?=BASE_URL?>pre-registro" method="post">
    <h1 class="h3 mb-3 fw-normal ret-titulo">Inscríbete al RET</h1>
    <hr class="my-4">
    <p class="lead">Inicia tu registro con una dirección de correo electrónico válida</p>

    <div class="form-floating">
      <input type="email" class="form-control" id="email" name="email" minlength="6" maxlength="120" placeholder="Correo Electrónico">
      <label for="email">Correo Electrónico</label>
    </div>

    <div class="form-floating">
      <input type="email" class="form-control" id="repeat_email" name="repeat_email" minlength="6" maxlength="120" placeholder="Repetir Correo Electrónico">
      <label for="repeat_email">Repetir Correo Electrónico</label>
    </div>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Iniciar Registro</button>
    <hr class="my-4">
    <p class="lead">Como alternativa, valida tu registro con las siguientes tecnologías</p>
    <a href="<?=BASE_URL?>registro/facebook-signin" class="w-30 btn btn-sm btn-secondary btn-fcbk">Iniciar con Facebook</a>
    <a href="<?=BASE_URL?>registro/google-signin" class="w-30 btn btn-sm btn-secondary btn-goog">Iniciar con Google</a>
    <a href="<?=BASE_URL?>registro/microsoft-signin" class="w-30 btn btn-sm btn-secondary btn-msft">Iniciar con Microsoft</a>
    <hr class="my-4">
    <a href="<?=BASE_URL?>ingresar">¿Ya eres usuario? Inicia Sesión</a>
  </form>
</main>

<script>
  $('#signin_form').submit(function() {
    event.preventDefault();
    var email = $('#email').val();
    var repeat_email = $('#repeat_email').val();

    if(email == repeat_email && email.length >=5)
      grecaptcha.ready(function() {
        grecaptcha.execute('<?=SITE_KEY?>', {action: 'submit'}).then(function(token) {
          
          $('#signin_form').prepend('<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="' + token + '">');
          $.post("pre-registro",{email: email, token: token}, function(result) {
            
            if (result.success)
            {
              alert('Recibirás un mensaje en tu bandeja de correo. Da clic en el enlace y continúa con tu registro.');
              t1 = window.setTimeout(function(){ window.location = "<?=BASE_URL?>"; },5);
            }
            else
              alert('Algo salió mal. Reporta este mensaje a ret@guanajuato.gob.mx o intenta más tarde.');
            
          });

        });;
      });
    else
      alert('El correo electrónico no coincide.');
  });
</script>