<?php
$this->session = \Config\Services::session();
$demo_mode = isset($demo_mode) ? (bool) $demo_mode : false;
?>

<main class="ret-form-shell">
  <section class="ret-form-layout">
    <aside class="ret-form-aside">
      <span class="ret-form-kicker">Alta Inicial</span>
      <h1 class="ret-form-title">Construye tu expediente RET.</h1>
      <p class="ret-form-lead">Completa la informacion principal del establecimiento para abrir tu registro. Organizamos el proceso en una sola vista, mas clara y mucho mas amable de usar.</p>

      <div class="ret-form-steps">
        <article class="ret-form-step">
          <span class="ret-form-step-icon"><i class="bi bi-building"></i></span>
          <div>
            <h2>Datos base</h2>
            <p>RFC, giro, municipio y nombre comercial del negocio.</p>
          </div>
        </article>
        <article class="ret-form-step">
          <span class="ret-form-step-icon"><i class="bi bi-envelope-paper"></i></span>
          <div>
            <h2>Contacto confirmado</h2>
            <p>El correo que capturaste sera el punto de seguimiento del tramite.</p>
          </div>
        </article>
        <article class="ret-form-step">
          <span class="ret-form-step-icon"><i class="bi bi-file-earmark-check"></i></span>
          <div>
            <h2>Siguiente etapa</h2>
            <p>Despues pasaras a capturar informacion general, tecnica y legal.</p>
          </div>
        </article>
      </div>
    </aside>

    <section class="ret-form-card-wrap">
      <div class="ret-form-card">
        <div class="ret-form-card-header">
          <div>
            <span class="ret-form-badge"><?php echo $demo_mode ? 'Vista demo' : 'Paso 1'; ?></span>
            <h2 class="ret-titulo-panel ret-form-panel-title">Inscripcion al RET</h2>
            <p class="ret-form-panel-copy">Formulario inicial para registrar tu establecimiento en el sistema.</p>
          </div>
          <div class="ret-form-userbox">
            <span class="ret-form-user-label">Correo de acceso</span>
            <strong><?=(string) $this->session->get('email')?></strong>
          </div>
        </div>

        <?php if ($demo_mode): ?>
          <div class="alert alert-info ret-form-alert" role="alert">
            Estás viendo una version de demostracion local. El diseño y la navegacion ya se pueden revisar, pero para guardar el tramite real necesitas la base de datos completa del RET.
          </div>
        <?php endif; ?>

        <?php if ($this->session->getFlashdata('titulo')): ?>
          <div class="alert alert-danger ret-form-alert" role="alert">
            <strong><?=$this->session->getFlashdata('titulo')?></strong>
            <p><?=$this->session->getFlashdata('mensaje')?></p>
          </div>
        <?php endif; ?>

        <form class="needs-validation ret-modern-form" novalidate id="register_form" action="<?=BASE_URL?>registro-guardar" method="post">
          <div class="ret-grid">
            <div class="ret-field ret-field-full">
              <label for="rfc" class="form-label">Registro Federal de Contribuyentes (RFC)</label>
              <input type="text" class="form-control" id="rfc" name="rfc" placeholder="Ej. ABCD010203EF4" value="<?=$this->session->getFlashdata('rfc')?>" minlength="9" maxlength="13" required <?=$demo_mode ? 'disabled' : ''?>>
              <div class="invalid-feedback">Campo requerido.</div>
            </div>

            <div class="ret-field">
              <label for="giro" class="form-label">Giro comercial</label>
              <select class="form-select" id="giro" name="giro" required <?=$demo_mode ? 'disabled' : ''?>>
                <option value="">Elegir giro...</option>
                <?php if ($giros): ?>
                  <?php foreach ($giros as $g): ?>
                    <option value="<?=$g['id_giro']?>" <?=(($this->session->getFlashdata('giro') == $g['id_giro']) ? 'selected' : '')?>><?=$g['giro']?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              <div class="invalid-feedback">Favor de elegir un giro comercial.</div>
            </div>

            <div class="ret-field">
              <label for="municipio" class="form-label">Municipio</label>
              <select class="form-select" id="municipio" name="municipio" required <?=$demo_mode ? 'disabled' : ''?>>
                <option value="">Elegir municipio...</option>
                <?php if ($municipios): ?>
                  <?php foreach ($municipios as $m): ?>
                    <option value="<?=$m['id_municipio']?>" <?=(($this->session->getFlashdata('municipio') == $m['id_municipio']) ? 'selected' : '')?>><?=$m['municipio']?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              <div class="invalid-feedback">Favor de elegir un municipio.</div>
            </div>

            <div class="ret-field ret-field-full">
              <label for="nombre_comercial" class="form-label">Nombre comercial</label>
              <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" value="<?=$this->session->getFlashdata('nombre_comercial')?>" minlength="3" maxlength="200" placeholder="<?=$this->session->get('name')?>" required <?=$demo_mode ? 'disabled' : ''?>>
              <div class="invalid-feedback">Campo requerido.</div>
            </div>

            <div class="ret-field">
              <label for="fecha_inicio_operacion" class="form-label">Fecha de inicio de operacion y/o apertura del establecimiento</label>
              <input type="date" class="form-control" id="fecha_inicio_operacion" name="fecha_inicio_operacion" value="<?=$this->session->getFlashdata('fecha_inicio_operacion')?>" required <?=$demo_mode ? 'disabled' : ''?>>
              <div class="invalid-feedback">Favor de capturar la fecha de inicio de operacion y/o apertura del establecimiento.</div>
            </div>

            <div class="ret-field ret-field-full">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?=$this->session->get('email')?>" disabled>
            </div>
          </div>

          <div class="ret-privacy-box">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="acepta_avisos" name="acepta_avisos" required <?=$demo_mode ? 'disabled' : ''?>>
              <label class="form-check-label" for="acepta_avisos">
                Acepto y estoy de acuerdo con lo manifestado en el <a href="<?=BASE_URL?>aviso-privacidad" target="_blank">Aviso de Privacidad Integral RET</a>.
              </label>
              <div class="invalid-feedback">Favor de aceptar para continuar.</div>
            </div>
          </div>

          <div class="ret-form-actions">
            <button class="btn ret-primary-action" id="register_submit" type="submit" <?=$demo_mode ? 'disabled' : ''?>>
              <?=$demo_mode ? 'Guardado disponible con BD' : 'Registrarme'?>
              <i class="bi bi-arrow-right-short"></i>
            </button>
            <a class="ret-secondary-action" href="<?=BASE_URL?>registro">Volver al inicio del registro</a>
          </div>
        </form>
      </div>
    </section>
  </section>
</main>

<div class="ret-loading-overlay" id="ret_loading_overlay" hidden>
  <div class="ret-loading-card">
    <div class="spinner-border ret-loading-spinner" role="status" aria-hidden="true"></div>
    <h3>Creando tu acceso RET</h3>
    <p>Estamos guardando la inscripcion inicial y enviando las credenciales por correo.</p>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('register_form');
    const submitButton = document.getElementById('register_submit');
    const overlay = document.getElementById('ret_loading_overlay');

    if (!form || !submitButton || !overlay || submitButton.disabled) {
      return;
    }

    form.addEventListener('submit', function () {
      if (!form.checkValidity()) {
        return;
      }

      submitButton.disabled = true;
      overlay.hidden = false;
    });
  });
</script>
