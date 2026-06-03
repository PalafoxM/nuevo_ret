<main class="signin-shell">
  <section class="signin-hero">
    <div class="signin-copy">
      <span class="signin-eyebrow">Acceso RET</span>
      <h1 class="signin-title">Ingresa y continua tu tramite.</h1>
      <p class="signin-lead">Accede a tu panel para capturar informacion, cargar documentos y dar seguimiento al avance de tu registro en una experiencia mas clara y actual.</p>

      <div class="signin-feature-list">
        <article class="signin-feature">
          <span class="signin-feature-icon"><i class="bi bi-speedometer2"></i></span>
          <div>
            <h2>Panel centralizado</h2>
            <p>Consulta tu avance, retoma formularios pendientes y administra tus registros en un solo lugar.</p>
          </div>
        </article>
        <article class="signin-feature">
          <span class="signin-feature-icon"><i class="bi bi-cloud-arrow-up"></i></span>
          <div>
            <h2>Carga de documentos</h2>
            <p>Sube informacion legal, tecnica e imagenes del establecimiento con seguimiento por etapas.</p>
          </div>
        </article>
        <article class="signin-feature">
          <span class="signin-feature-icon"><i class="bi bi-shield-lock"></i></span>
          <div>
            <h2>Acceso seguro</h2>
            <p>Ingresa con tu usuario RET y recupera tus credenciales si ya no tienes acceso al correo original.</p>
          </div>
        </article>
      </div>
    </div>

    <div class="signin-panel">
      <div class="signin-card">
        <span class="signin-badge">Iniciar sesion</span>
        <h2 class="ret-titulo signin-card-title">Ingresa al RET</h2>
        <p class="signin-card-copy">Usa tu usuario y contrasena para continuar con tu registro.</p>

        <form id="login_form" class="signin-form" action="<?=BASE_URL?>sesion" method="post">
          <div class="form-floating">
            <input type="text" class="form-control" id="clave" name="clave" placeholder="Usuario" required>
            <label for="clave">Usuario</label>
          </div>
          <div class="form-floating">
            <input type="password" class="form-control" id="pass" name="pass" placeholder="Contrasena" required>
            <label for="pass">Contrasena</label>
          </div>

          <button id="loginBtn" class="btn signin-primary-btn" type="submit">
            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            Iniciar sesion
            <i class="bi bi-arrow-right-short"></i>
          </button>
        </form>

        <div class="signin-recovery-box">
          <div>
            <span class="signin-recovery-label">Necesitas ayuda</span>
            <p class="signin-recovery-copy">Recupera tu acceso con el correo registrado en el RET o valida el correo anterior para enviar tus nuevas credenciales a otro correo.</p>
          </div>
          <div class="signin-recovery-actions">
            <button type="button" class="signin-text-action" id="forgot_password_trigger">
              <i class="bi bi-key"></i>
              Restablecer contrasena
            </button>
            <button type="button" class="signin-text-action signin-text-action-alt" id="reroute_password_trigger">
              <i class="bi bi-envelope-arrow-up"></i>
              Enviar a otro correo
            </button>
          </div>
        </div>

        <a class="signin-secondary-link" href="<?=BASE_URL?>registro">No eres usuario? Registrate</a>
      </div>
    </div>
  </section>
</main>

<script>
  $('#forgot_password_trigger').on('click', function() {
    Swal.fire({
      title: 'Restablecer contrasena',
      text: 'Captura el correo con el que te registraste en el RET.',
      input: 'email',
      inputLabel: 'Correo electronico',
      inputPlaceholder: 'nombre@correo.com',
      showCancelButton: true,
      confirmButtonText: 'Enviar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#0f57a8',
      cancelButtonColor: '#7b8796',
      inputValidator: function(value) {
        if (!value) {
          return 'Debes capturar un correo electronico.';
        }
      },
      preConfirm: function(email) {
        return $.ajax({
          url: '<?=BASE_URL?>restablecer-password',
          type: 'POST',
          dataType: 'json',
          data: { email: email }
        }).then(function(result) {
          return result;
        }).catch(function(xhr) {
          var response = xhr.responseJSON || {};
          Swal.showValidationMessage(response.message || 'No fue posible procesar la solicitud.');
        });
      }
    }).then(function(result) {
      if (!result.isConfirmed || !result.value) {
        return;
      }

      if (result.value.success) {
        Swal.fire({
          icon: 'success',
          title: 'Correo enviado',
          text: result.value.message
        });
        return;
      }

      if (result.value.level === 'mail_error' && result.value.credentials) {
        Swal.fire({
          icon: 'warning',
          title: 'Correo no disponible',
          html: 'La contrasena fue restablecida, pero no se pudo enviar el correo.<br><br><strong style="color:#198754;">Usuario:</strong> <strong style="color:#198754;">' + result.value.credentials.usuario + '</strong><br><strong style="color:#198754;">Contrasena:</strong> <strong style="color:#198754;">' + result.value.credentials.contrasena + '</strong>'
        });
        return;
      }

      Swal.fire({
        icon: 'warning',
        title: 'Validacion',
        text: result.value.message || 'No fue posible procesar la solicitud.'
      });
    });
  });

  $('#reroute_password_trigger').on('click', function() {
    Swal.fire({
      title: 'Enviar a otro correo',
      html:
        '<div style="text-align:left;">' +
          '<label for="swal-email-old" style="display:block;font-weight:600;margin-bottom:6px;">Correo anterior</label>' +
          '<input id="swal-email-old" class="swal2-input" type="email" placeholder="correo-anterior@dominio.com" style="margin:0 0 14px;width:100%;">' +
          '<label for="swal-email-new" style="display:block;font-weight:600;margin-bottom:6px;">Correo nuevo</label>' +
          '<input id="swal-email-new" class="swal2-input" type="email" placeholder="correo-nuevo@dominio.com" style="margin:0;width:100%;">' +
        '</div>',
      showCancelButton: true,
      confirmButtonText: 'Actualizar y enviar',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#0f57a8',
      cancelButtonColor: '#7b8796',
      focusConfirm: false,
      preConfirm: function() {
        var emailOld = $('#swal-email-old').val().trim();
        var emailNew = $('#swal-email-new').val().trim();

        if (!emailOld || !emailNew) {
          Swal.showValidationMessage('Debes capturar el correo anterior y el nuevo correo.');
          return false;
        }

        return $.ajax({
          url: '<?=BASE_URL?>restablecer-password-otro-correo',
          type: 'POST',
          dataType: 'json',
          data: { email_old: emailOld, email_new: emailNew }
        }).then(function(result) {
          return result;
        }).catch(function(xhr) {
          var response = xhr.responseJSON || {};
          Swal.showValidationMessage(response.message || 'No fue posible procesar la solicitud.');
        });
      }
    }).then(function(result) {
      if (!result.isConfirmed || !result.value) {
        return;
      }

      if (result.value.success) {
        Swal.fire({
          icon: 'success',
          title: 'Correo actualizado',
          text: result.value.message
        });
        return;
      }

      if (result.value.level === 'mail_error' && result.value.credentials) {
        Swal.fire({
          icon: 'warning',
          title: 'Correo no disponible',
          html: 'Actualizamos el correo y restablecimos la contrasena, pero no se pudo enviar el mensaje.<br><br><strong style="color:#198754;">Usuario:</strong> <strong style="color:#198754;">' + result.value.credentials.usuario + '</strong><br><strong style="color:#198754;">Correo:</strong> <strong style="color:#198754;">' + result.value.credentials.correo + '</strong><br><strong style="color:#198754;">Contrasena:</strong> <strong style="color:#198754;">' + result.value.credentials.contrasena + '</strong>'
        });
        return;
      }

      Swal.fire({
        icon: 'warning',
        title: 'Validacion',
        text: result.value.message || 'No fue posible procesar la solicitud.'
      });
    });
  });

  $('#login_form').submit(function(event) {
    event.preventDefault();
    var clave = $('#clave').val();
    var passw = $('#pass').val();

    $('#loginBtn').prop('disabled', true).find('.spinner-border').removeClass('d-none');

    grecaptcha.ready(function() {
      grecaptcha.execute('<?php echo SITE_KEY; ?>', {action: 'submit'}).then(function(token) {
        $('#login_form').prepend('<input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="' + token + '">');
        $.post('sesion', {clave: clave, pass: passw, token: token}, function(result) {
          if (result.success) {
            window.setTimeout(function() { window.location = '<?php echo BASE_URL; ?>ingresar'; }, 5);
          } else {
            alert('No puedes acceder a la plataforma.');
          }

          $('#loginBtn').prop('disabled', false).find('.spinner-border').addClass('d-none');
        });
      });
    });
  });
</script>
