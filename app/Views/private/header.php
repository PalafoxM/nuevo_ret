    <header>
      <nav class="navbar navbar-expand-md navbar-dark header-main-p">
        <div class="container container_ret">
          <a href="<?=BASE_URL?>" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
            <img src="<?=BASE_URL?>static/images/logo_ret_altb.png">
          </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav me-auto mb-2 mb-md-0 nav-pills">
              <?php
              if($this->session->get('logged') && isset($controller))
              { ?>
              <li class="nav-item">
                <a class="nav-link menu-link-p<?=(($controller == 'datos-generales')?' active-p':'')?>" href="<?=BASE_URL?>datos-generales">Datos Generales</a>
              </li>
              <li class="nav-item">
                <a class="nav-link menu-link-p<?=(($controller == 'datos-tecnicos')?' active-p':'')?>" href="<?=BASE_URL?>datos-tecnicos">Datos Técnicos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link menu-link-p<?=(($controller == 'datos-legales')?' active-p':'')?>" href="<?=BASE_URL?>datos-legales">Datos Legales</a>
              </li>
              <li class="nav-item">
                <a class="nav-link menu-link-p<?=(($controller == 'imagenes')?' active-p':'')?>" href="<?=BASE_URL?>imagenes">Imágenes</a>
              </li>
              <?php if($this->session->get('giro') != 8) { //If que retira del menú, el enlace al formulario de Museos ?>
              <li class="nav-item">
                <a class="nav-link menu-link-p<?=(($controller == 'hospedaje' || $controller == 'agencia' || $controller == 'guias' || $controller == 'promotor' || $controller == 'restaurante' || $controller == 'golf' || $controller == 'arte' || $controller == 'educativa' || $controller == 'arrendadora' || $controller == 'parque' || $controller == 'auxilio' || $controller == 'balneario' || $controller == 'capacitacion' || $controller == 'deporte' || $controller == 'spa' || $controller == 'recinto' || $controller == 'hospedaje-digital')?' active-p':'')?>" href="<?=BASE_URL?>giro"><?=$this->session->get('g_resumen')?></a>
              </li>
              <?php }?>
              <li class="nav-item">
                <a class="nav-link menu-link-p<?=(($controller == 'concluir-registro')?' active-p':'')?>" href="<?=BASE_URL?>concluir-registro">Concluir Registro</a>
              </li>

              <?php }
              ?>



              <li class="nav-item d-md-none">
                <a class="nav-link menu-link-p" target="_blank" href="<?=BASE_URL?>telefono"><i class="bi-telephone"></i> Llámanos</a>
              </li>
              <li class="nav-item d-md-none">
                <a class="nav-link menu-link-p" target="_blank" href="<?=BASE_URL?>email"><i class="bi-envelope"></i> Escríbenos</a></a>
              </li>
            </ul>

          </div>
        </div>
      </nav>
    </header>
