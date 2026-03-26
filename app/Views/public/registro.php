<main class="signup-shell">
  <section class="signup-hero">
    <div class="signup-copy">
      <span class="signup-eyebrow">Registro Estatal de Turismo</span>
      <h1 class="signup-title">Abre tu registro en minutos.</h1>
      <p class="signup-lead">Eliminamos el pre-registro por correo para que el alta sea mas directa, clara y comoda. Captura tu email, confirmalo y continuamos al formulario principal.</p>

      <div class="signup-highlights">
        <article class="signup-highlight-card">
          <span class="signup-highlight-icon"><i class="bi bi-lightning-charge-fill"></i></span>
          <div>
            <h2>Acceso inmediato</h2>
            <p>Entras al registro sin esperar ligas de validacion.</p>
          </div>
        </article>
        <article class="signup-highlight-card">
          <span class="signup-highlight-icon"><i class="bi bi-shield-check"></i></span>
          <div>
            <h2>Flujo mas simple</h2>
            <p>Menos pasos y menos puntos de falla para completar el tramite.</p>
          </div>
        </article>
        <article class="signup-highlight-card">
          <span class="signup-highlight-icon"><i class="bi bi-journal-text"></i></span>
          <div>
            <h2>Preparacion recomendada</h2>
            <p>Ten a la mano RFC, datos del establecimiento y documentos basicos.</p>
          </div>
        </article>
      </div>
    </div>

    <div class="signup-panel">
      <div class="signup-card">
        <span class="signup-card-badge">Nuevo flujo</span>
        <h2 class="ret-titulo signup-card-title">Inscribete al RET</h2>
        <p class="signup-card-copy">Usa un correo vigente para iniciar tu expediente y continuar con el formulario completo.</p>

        <?php if (session()->getFlashdata('mensaje')): ?>
          <div class="alert alert-warning signup-alert" role="alert">
            <?=session()->getFlashdata('mensaje')?>
          </div>
        <?php endif; ?>

        <form id="signin_form" class="signup-form" action="<?=BASE_URL?>pre-registro" method="post" novalidate>
          <div class="form-floating">
            <input type="email" class="form-control" id="email" name="email" minlength="6" maxlength="120" placeholder="Correo electronico" required>
            <label for="email">Correo electronico</label>
          </div>

          <div class="form-floating">
            <input type="email" class="form-control" id="repeat_email" name="repeat_email" minlength="6" maxlength="120" placeholder="Confirmar correo electronico" required>
            <label for="repeat_email">Confirmar correo electronico</label>
          </div>

          <div class="signup-inline-note">
            <i class="bi bi-info-circle"></i>
            Continuaras directamente al formulario de registro.
          </div>

          <button class="btn signup-primary-btn" type="submit">
            Continuar al registro
            <i class="bi bi-arrow-right-short"></i>
          </button>
        </form>

        <a class="signup-secondary-link" href="<?=BASE_URL?>ingresar">Ya eres usuario? Inicia sesion</a>
      </div>
    </div>
  </section>
</main>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('signin_form');
    const email = document.getElementById('email');
    const repeatEmail = document.getElementById('repeat_email');

    form.addEventListener('submit', function (event) {
      email.value = email.value.trim().toLowerCase();
      repeatEmail.value = repeatEmail.value.trim().toLowerCase();

      if (!email.value || !repeatEmail.value || email.value !== repeatEmail.value) {
        event.preventDefault();
        window.alert('Verifica que ambos correos electronicos coincidan antes de continuar.');
      }
    });
  });
</script>
