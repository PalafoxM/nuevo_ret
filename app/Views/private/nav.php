<?php
helper('ret');
?>
    <nav class="py-2 border-bottom border-header-p">
      <div class="container d-flex flex-wrap container_ret">
        <ul class="nav me-auto">
          <li class="nav-item d-none d-md-block"><a href="<?=BASE_URL?>email" target="_blank" class="nav-link link-dark px-2 btn btn-outline-secondary">Para reportar fallos, favor de enviar detalle a ret@guanajuato.gob.mx</a></li>
        </ul>
        <ul class="nav">
          <li class="nav-item"><a href="<?=BASE_URL?>panel" class="nav-link link-dark px-2 btn btn-outline-success me-2"><i class="bi-list-stars"></i> Panel</a></li>
          <?php if(funcionalidad(1) && $this->session->get('logged')) {?><li class="nav-item"><a href="<?=BASE_URL?>cambiar-contrasena" class="nav-link link-dark px-2 btn btn-outline-primary me-2"><i class="bi-key"></i> Cambiar contraseña</a></li><?php } ?>
          <?php if($this->session->get('api_logged') && $main != 'private/registro_nuevo') {?><li class="nav-item"><a href="<?=BASE_URL?>registro/nuevo" class="nav-link link-dark px-2 btn btn-outline-primary me-2"><i class="bi-person-plus-fill"></i> Nuevo Registro</a></li><?php } ?>
          <li class="nav-item"><a href="<?=BASE_URL?>salir" class="nav-link link-dark px-2 btn btn-outline-danger me-2"><i class="bi-door-open"></i> Salir</a></li>
        </ul>
      </div>
    </nav>
