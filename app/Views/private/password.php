<?php
$this->session          = \Config\Services::session();
?>

  <main class="form-body">
    <div class="py-5 text-center">
      <i class="bi-key icon-redirect"></i>
      <h1 class="display-5 fw-bold">Cambiar Contraseña</h1>
    </div>

  <?php
  if($this->session->getFlashdata('titulo'))
  { ?>
    <div class="text-center container alert alert-danger alert-dismissible fade show">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <b><?=$this->session->getFlashdata('titulo')?></b>
      <p><?=$this->session->getFlashdata('mensaje')?></p>
    </div>
  <?php } 
  ?>

    <div class="text-center container contenedor-ret">
      <div class="col-lg-12">
        <h4 class="mb-3">Para brindar mayor seguridad, favor de actualizar tu contraseña. Al finalizar, deberás iniciar sesión nuevamente.</h4>
        <form action="<?=BASE_URL?>actualizar-contrasena" method="post" class="needs-validation" novalidate>

            <div class="col-12">
              <label for="keypass_new" class="form-label">Contraseña Nueva</label>
              <input type="password" class="form-control" id="keypass_new" name="keypass_new" value="<?php=$this->session->getFlashdata('keypass_new')?>" placeholder="Contraseña Nueva" minlength="8" maxlength="15" required>
              <div class="invalid-feedback">
                  Campo requerido. Debe tener al menos 8 caracteres.
              </div>
            </div>

            <div class="col-12">
              <label for="keypass_rpt" class="form-label">Repetir Contraseña</label>
              <input type="password" class="form-control" id="keypass_rpt" name="keypass_rpt" value="<?php=$this->session->getFlashdata('keypass_rpt')?>" placeholder="Repetir Contraseña" minlength="8" maxlength="15" required>
              <div class="invalid-feedback">
                  Campo requerido. Debe tener al menos 8 caracteres. Las contraseñas deben coincidir.
                </div>
            </div>


          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit">Cambiar contraseña</button>
        </form>
      </div>
    </div>
  </main>
<script type="text/javascript">
  var password = document.getElementById("keypass_new"), confirm_password = document.getElementById("keypass_rpt");

  function validatePassword(){
    if(password.value != confirm_password.value) {
      confirm_password.setCustomValidity("Las contraseñas no coinciden");
    } else {
      confirm_password.setCustomValidity('');
    }
  }

  password.onchange = validatePassword;
  confirm_password.onkeyup = validatePassword;
</script>