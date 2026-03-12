<?php
$this->session          = \Config\Services::session();
?>


  <main class="form-body">
    <div class="py-5 text-center">
      <i class="bi-person-plus-fill icon-redirect"></i>
      <h1 class="ret-titulo-panel">Inscripción al RET</h1>
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
        <h4 class="mb-3">Formulario de Registro Inicial</h4>
        <form class="needs-validation" novalidate id="register_form" action="<?=BASE_URL?>registro-guardar" method="post">
          <div class="row g-3">

            <div class="col-12">
              <label for="rfc" class="form-label">Registro Federal de Contribuyentes (RFC)</label>
              <input type="text" class="form-control" id="rfc" name="rfc" placeholder="RFC" value="<?=$this->session->getFlashdata('rfc')?>" minlength="9" maxlength="13" required>
              <div class="invalid-feedback">
                  Campo requerido
                </div>
            </div>

            <div class="col-md-12">
              <label for="giro" class="form-label">Giro Comercial</label>
              <select class="form-select" id="giro" name="giro" required>
                <option value="">Elegir giro...</option>
                <?php
                if($giros)
                {
                  foreach($giros as $g)
                  { ?>
                
                <option value="<?=$g['id_giro']?>" <?=(($this->session->getFlashdata('giro') == $g['id_giro'])?'selected':'')?>><?=$g['giro']?></option>

                <?php  }
                }
                ?>
              </select>
              <div class="invalid-feedback">
                Favor de elegir un giro comercial
              </div>
            </div>

            <div class="col-md-12">
              <label for="municipio" class="form-label">Municipio</label>
              <select class="form-select" id="municipio" name="municipio" required>
                <option value="">Elegir municipio...</option>
                <?php
                if($municipios)
                {
                  foreach($municipios as $m)
                  { ?>
                
                <option value="<?=$m['id_municipio']?>" <?=(($this->session->getFlashdata('municipio') == $m['id_municipio'])?'selected':'')?>><?=$m['municipio']?></option>

                <?php  }
                }
                ?>
              </select>
              <div class="invalid-feedback">
                Favor de elegir un municipio
              </div>
            </div>

            <div class="col-12">
              <label for="nombre_comercial" class="form-label">Nombre Comercial</label>
              <input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" value="<?=$this->session->getFlashdata('nombre_comercial')?>" minlength="3" maxlength="200" placeholder="<?=$this->session->get('name')?>" required>
              <div class="invalid-feedback">
                  Campo requerido
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?=$this->session->get('email')?>" disabled>
            </div>


          <hr class="my-4">

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="acepta_avisos" name="acepta_avisos" required>
            <label class="form-check-label" for="acepta_avisos">Acepto y estoy de acuerdo con lo manifestado en el <a href="<?=BASE_URL?>aviso-privacidad" target="_blank">Aviso de Privacidad Integral RET</a><!-- y <a href="<?=BASE_URL?>aviso-legal" target="_blank">Aviso Legal</a> --></label>
            <div class="invalid-feedback">
                  Favor de aceptar para continuar
            </div>
          </div>

          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit">Registrarme</button>
        </form>
      </div>
    </div>
  </main>