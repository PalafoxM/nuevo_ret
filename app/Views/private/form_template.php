<?php

$this->session = \Config\Services::session();
$alertType = $this->session->getFlashdata('alert_type') ?: 'info';
$formErrors = $this->session->getFlashdata('errors');
$modalTitle = $this->session->getFlashdata('modal_title');
$modalMessage = $this->session->getFlashdata('modal_message');
$modalIcon = $this->session->getFlashdata('modal_icon') ?: 'success';

?>

<main class="ret-dynamic-shell">
  <section class="ret-dynamic-layout">
    <aside class="ret-dynamic-aside">
      <span class="ret-form-kicker">Registro RET</span>
      <h1 class="ret-dynamic-title"><?=$form_title?></h1>
      <p class="ret-dynamic-lead">Completa esta etapa para mantener el avance de tu registro con una captura clara, ordenada y segura.</p>

      <div class="ret-dynamic-summary">
        <div class="ret-dynamic-summary-card">
          <span class="ret-dynamic-summary-label">Folio y establecimiento</span>
          <strong><?=$form_pst?></strong>
        </div>
        <div class="ret-dynamic-summary-card">
          <span class="ret-dynamic-summary-label">Giro registrado</span>
          <strong><?=$form_giro?></strong>
        </div>
      </div>

      <div class="ret-dynamic-progress-card">
        <div class="ret-dynamic-progress-copy">
          <span>Avance actual</span>
          <strong><?=$form_percent?>%</strong>
        </div>
        <div class="progress ret-dynamic-progress">
          <div class="progress-bar ret-dynamic-progress-bar progress-bar-striped progress-bar-animated" style="width:<?=$form_percent?>%"><?=$form_percent?>%</div>
        </div>
        <p>Guarda esta sección para continuar con el siguiente bloque del trámite.</p>
      </div>
    </aside>

    <section class="ret-dynamic-content">
      <?php if($this->session->getFlashdata('titulo')): ?>
        <div class="alert alert-<?=$alertType?> ret-form-alert ret-dynamic-alert alert-dismissible fade show" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
          <strong><?=$this->session->getFlashdata('titulo')?></strong>
          <p><?=$this->session->getFlashdata('mensaje')?></p>
          <?php if(is_array($formErrors) && ! empty($formErrors)): ?>
          <ul class="ret-error-list">
            <?php foreach($formErrors as $errorField => $errorMessage): ?>
            <li><strong><?=$errorField?>:</strong> <?=$errorMessage?></li>
            <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <div class="ret-dynamic-card">
        <div class="ret-dynamic-card-header">
          <div>
            <span class="ret-form-badge">Formulario activo</span>
            <h2 class="ret-titulo-panel ret-dynamic-card-title"><?=$form_title?></h2>
            <p class="ret-dynamic-card-copy">Los campos marcados como obligatorios deben capturarse antes de continuar.</p>
          </div>
          <div class="ret-dynamic-card-side">
            <span>Paso en curso</span>
            <strong><?=$form_percent?>% completado</strong>
          </div>
        </div>

        <form class="was-validated ret-dynamic-form" id="<?=$form_id?>" role="<?=$form_id?>" enctype="multipart/form-data" action="<?=$form_action?>" method="post">
          <div class="row g-4 ret-dynamic-grid">
            <?php
            $validate = [];
            $fields = [];
            $files = [];
            $matrix = [];

            for($i = 0; $i < count($form_field); $i ++)
            {
              switch($form_field[$i][0])
              {
                case 'text':
                case 'password':
                case 'url':
                case 'email':
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2] => $form_field[$i][10]]);

                    $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                  }
            ?>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-form-field">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6]) ? ' *' : '')?></label>
              <input type="<?=$form_field[$i][0]?>" class="form-control" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$form_field[$i][3]?>" minlength="<?=$form_field[$i][4]?>" maxlength="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6]) ? ' required' : '')?><?=(($form_field[$i][7]) ? ' disabled' : '')?><?=((isset($form_field[$i][13])) ? ' '.$form_field[$i][13] : '')?>>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Campo requerido.</div>
              <?php endif; ?>
            </div>
            <?php break;

                case 'file':
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2] => $form_field[$i][10]]);

                    $files = array_merge($files, [['name' => $form_field[$i][2]]]);
                  }
            ?>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-form-field">
              <label for="<?=$form_field[$i][2]?>" class="form-label">
                <?=$form_field[$i][1]?><?=(($form_field[$i][6] && $form_field[$i][3] == '') ? ' *' : '')?>
                <?=(($form_field[$i][3] != '') ? '<br><a class="ret-file-link" href="'.BASE_URL.'descargar/'.$form_field[$i][2].'" target="_blank"><i class="bi-file-earmark-arrow-down-fill"></i> Archivo asignado</a>' : '')?>
              </label>
              <input type="<?=$form_field[$i][0]?>" class="form-control" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>"<?=(($form_field[$i][6] && $form_field[$i][3] == '') ? ' required' : '')?><?=(($form_field[$i][7]) ? ' disabled' : '')?><?=((isset($form_field[$i][13])) ? ' '.$form_field[$i][13] : '')?>>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Campo requerido.</div>
              <?php endif; ?>
            </div>
            <?php break;

                case 'map':
                  $name_map = $form_field[$i][2];
                  $ubicacion = $form_field[$i][8];
                  $value = $form_field[$i][3];

                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [
                        $name_map[0] => $form_field[$i][10],
                        $name_map[1] => $form_field[$i][10],
                      ]);

                    $fields = array_merge($fields, [
                      ['name' => $name_map[0], 'type' => 'text'],
                      ['name' => $name_map[1], 'type' => 'text'],
                    ]);
                  }
            ?>
            <div class="col-12 ret-map-card">
              <label class="form-label"><?=$form_field[$i][1]?></label>
              <p class="ret-map-copy">Arrastra el pin rojo a la ubicación deseada o captura manualmente la latitud y longitud.</p>
              <div id="map" name="map" class="ret-map-surface"></div>
            </div>

            <div class="col-6 ret-form-field">
              <label for="<?=$name_map[0]?>" class="form-label"><?=$ubicacion[0]?><?=(($form_field[$i][6]) ? ' *' : '')?></label>
              <input type="text" class="form-control" id="<?=$name_map[0]?>" name="<?=$name_map[0]?>" placeholder="<?=$ubicacion[0]?>" value="<?=$value[0]?>" minlength="<?=$form_field[$i][4]?>" maxlength="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6]) ? ' required' : '')?><?=(($form_field[$i][7]) ? ' disabled' : '')?>>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Campo requerido.</div>
              <?php endif; ?>
            </div>

            <div class="col-6 ret-form-field">
              <label for="<?=$name_map[1]?>" class="form-label"><?=$ubicacion[1]?><?=(($form_field[$i][6]) ? ' *' : '')?></label>
              <input type="text" class="form-control" id="<?=$name_map[1]?>" name="<?=$name_map[1]?>" placeholder="<?=$ubicacion[1]?>" value="<?=$value[1]?>" minlength="<?=$form_field[$i][4]?>" maxlength="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6]) ? ' required' : '')?><?=(($form_field[$i][7]) ? ' disabled' : '')?>>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Campo requerido.</div>
              <?php endif; ?>
            </div>

            <input type="hidden" name="txtlongitudgeo_v" id="txtlongitudgeo_v" value="">
            <input type="hidden" name="txtlatitudgeo_v" id="txtlatitudgeo_v" value="">
            <input type="hidden" name="txtlatitudutm_v" id="txtlatitudutm_v" value="">
            <input type="hidden" name="txtlongitudutm_v" id="txtlongitudutm_v" value="">
            <?php break;

                case 'texto':
            ?>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-text-block">
              <h6><?=$form_field[$i][1]?></h6>
            </div>
            <?php break;

                case 'number':
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2] => $form_field[$i][10]]);

                    $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                  }
            ?>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-form-field">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6]) ? ' *' : '')?></label>
              <input type="<?=$form_field[$i][0]?>" class="form-control" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$form_field[$i][3]?>" min="<?=$form_field[$i][4]?>" max="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6]) ? ' required' : '')?><?=(($form_field[$i][7]) ? ' disabled' : '')?><?=((isset($form_field[$i][13])) ? ' '.$form_field[$i][13] : '')?>>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Campo requerido y/o valores erróneos.</div>
              <?php endif; ?>
            </div>
            <?php break;

                case 'matrix':
                  $fieldm = $form_field[$i][2];
                  $valuem = $form_field[$i][3];

                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                    {
                      $validate = array_merge($validate, [$fieldm[0] => $form_field[$i][10]]);
                      $validate = array_merge($validate, [$fieldm[1] => $form_field[$i][10]]);
                      $validate = array_merge($validate, [$fieldm[2] => $form_field[$i][10]]);
                    }

                    if($form_field[$i][12])
                    {
                      $fields = array_merge($fields, [
                        ['name' => $fieldm[0], 'type' => 'number'],
                        ['name' => $fieldm[1], 'type' => 'number'],
                        ['name' => $fieldm[2], 'type' => 'number'],
                      ]);
                    }
                    else
                    {
                      $matrix = array_merge($matrix, [[
                        'name0' => $fieldm[0], 'dbfield0' => $fieldm[3],
                        'name1' => $fieldm[1], 'dbfield1' => $fieldm[4],
                        'name2' => $fieldm[2], 'dbfield2' => $fieldm[5]
                      ]]);
                    }
                  }
            ?>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-text-block">
              <h6><?=$form_field[$i][1]?></h6>
            </div>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-form-field">
              <input type="number" class="form-control" id="<?=$fieldm[0]?>" name="<?=$fieldm[0]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$valuem[0]?>" min="<?=$form_field[$i][4]?>" max="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6]) ? ' required' : '')?><?=(($form_field[$i][7]) ? ' disabled' : '')?><?=(($form_field[$i][12]) ? ' readonly="true"' : ' onblur="contCamas();" onfocus="contCamas();"')?>>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Campo requerido y/o valores erróneos.</div>
              <?php endif; ?>
            </div>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-form-field">
              <input type="number" class="form-control" id="<?=$fieldm[1]?>" name="<?=$fieldm[1]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$valuem[1]?>" min="<?=$form_field[$i][4]?>" max="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6]) ? ' required' : '')?><?=(($form_field[$i][7]) ? ' disabled' : '')?><?=(($form_field[$i][12]) ? ' readonly="true"' : ' onblur="contCuartos();"')?>>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Campo requerido y/o valores erróneos.</div>
              <?php endif; ?>
            </div>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-form-field">
              <input type="number" class="form-control" id="<?=$fieldm[2]?>" name="<?=$fieldm[2]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$valuem[2]?>" min="<?=$form_field[$i][4]?>" max="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6]) ? ' required' : '')?><?=(($form_field[$i][7]) ? ' disabled' : '')?><?=(($form_field[$i][12]) ? ' readonly="true"' : ' onblur="contOcupa();"')?>>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Campo requerido y/o valores erróneos.</div>
              <?php endif; ?>
            </div>
            <?php break;

                case 'hr':
            ?>
            <div class="col-12">
              <hr class="ret-divider">
            </div>
            <?php break;

                case 'date':
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2] => $form_field[$i][10]]);

                    $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                  }
            ?>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-form-field">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6]) ? ' *' : '')?></label>
              <input type="<?=$form_field[$i][0]?>" class="form-control" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$form_field[$i][3]?>"<?=(($form_field[$i][6]) ? ' required' : '')?><?=(($form_field[$i][7]) ? ' disabled' : '')?><?=((isset($form_field[$i][13])) ? ' '.$form_field[$i][13] : '')?>>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Campo requerido.</div>
              <?php endif; ?>
            </div>
            <?php break;

                case 'bar':
            ?>
            <div class="col-12">
              <div class="ret-section-bar">
                <span class="ret-section-icon"><i class="bi-<?=$form_field[$i][2]?>"></i></span>
                <div>
                  <h3><?=$form_field[$i][1]?></h3>
                  <p><?=$form_field[$i][8]?></p>
                </div>
              </div>
            </div>
            <?php break;

                case 'iframe':
            ?>
            <div class="col-12">
              <div class="ret-section-bar">
                <div>
                  <h3><?=$form_field[$i][1]?></h3>
                  <p><?=$form_field[$i][8]?></p>
                </div>
              </div>
              <iframe src="<?=$form_field[$i][3]?>" width="100%" height="1900" frameborder="0" marginheight="0" marginwidth="0">Espere un momento...</iframe>
            </div>
            <?php break;

                case 'hidden':
                  if(isset($form_field[$i][10]) && $form_field[$i][10] != '')
                    $validate = array_merge($validate, [$form_field[$i][2] => $form_field[$i][10]]);

                  $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
            ?>
            <input type="hidden" name="<?=$form_field[$i][2]?>" id="<?=$form_field[$i][2]?>" value="<?=$form_field[$i][3]?>">
            <?php break;

                case 'button':
            ?>
            <div class="col-12 col-lg-6 ret-action-slot">
              <button class="w-100 btn ret-form-action ret-form-action-<?=$form_field[$i][3]?>" type="submit"><?=$form_field[$i][1]?></button>
              <div class="invalid-feedback ret-action-feedback">Faltan campos por capturar, favor de verificar.</div>
            </div>
            <?php break;

                case 'link':
            ?>
            <div class="col-12 col-lg-6 ret-action-slot">
              <a class="w-100 btn ret-form-link" href="<?=$form_field[$i][3]?>" target="<?=$form_field[$i][2]?>"><?=$form_field[$i][1]?></a>
            </div>
            <?php break;

                case 'textarea':
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2] => $form_field[$i][10]]);

                    $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                  }
            ?>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-form-field">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6]) ? ' *' : '')?></label>
              <textarea class="form-control ret-textarea" minlength="<?=$form_field[$i][4]?>" maxlength="<?=$form_field[$i][5]?>" name="<?=$form_field[$i][2]?>" id="<?=$form_field[$i][2]?>" placeholder="<?=$form_field[$i][8]?>"<?=(($form_field[$i][6] == true) ? ' required=""' : '')?><?=(($form_field[$i][7] == true) ? ' disabled=""' : '')?><?=((isset($form_field[$i][13])) ? ' '.$form_field[$i][13] : '')?>><?=$form_field[$i][3]?></textarea>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Campo requerido.</div>
              <?php endif; ?>
            </div>
            <?php break;

                case 'select':
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2] => $form_field[$i][10]]);

                    $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                  }
            ?>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-form-field">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6]) ? ' *' : '')?></label>
              <select class="form-select" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>"<?=(($form_field[$i][6]) ? ' required' : '')?><?=(($form_field[$i][7]) ? ' disabled' : '')?><?=((isset($form_field[$i][13])) ? ' '.$form_field[$i][13] : '')?>>
                <option value="">Elegir opción...</option>
                <?php if($form_field[$i][9]): ?>
                  <?php foreach($form_field[$i][9] as $values): ?>
                <option value="<?=$values['value_id']?>" <?=(($form_field[$i][3] == $values['value_id']) ? 'selected' : '')?>><?=$values['value_name']?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              <?php if($form_field[$i][6]): ?>
              <div class="invalid-feedback">Favor de elegir una opción.</div>
              <?php endif; ?>
            </div>
            <?php break;

                case 'checkbox':
                  if($form_field[$i][10] != '')
                    $validate = array_merge($validate, [$form_field[$i][2] => $form_field[$i][10]]);

                  $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
            ?>
            <div class="col-<?=((isset($form_field[$i][11])) ? $form_field[$i][11] : '12')?> ret-checkbox-slot">
              <div class="form-check ret-form-check">
                <input type="checkbox" class="form-check-input" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>"<?=(($form_field[$i][6]) ? ' required' : '')?><?=(($form_field[$i][3] == 'checked') ? ' checked' : '')?><?=((isset($form_field[$i][13])) ? ' '.$form_field[$i][13] : '')?>>
                <label class="form-check-label" for="<?=$form_field[$i][2]?>"><?=$form_field[$i][1]?><?=(($form_field[$i][6]) ? ' *' : '')?></label>
                <?php if($form_field[$i][6]): ?>
                <div class="invalid-feedback">Favor de aceptar para continuar.</div>
                <?php endif; ?>
              </div>
            </div>
            <?php break;
              }
            }

            $this->session->setFlashdata([
              'fields' => $fields,
              'files' => $files,
              'matrix' => $matrix,
              'validate' => $validate,
              'controller' => $controller,
              'next_cont' => $next_cont
            ]);
            ?>
          </div>
        </form>
      </div>
    </section>
  </section>
</main>

<div class="ret-loading-overlay" id="ret_dynamic_loading" hidden>
  <div class="ret-loading-card">
    <div class="spinner-border ret-loading-spinner" role="status" aria-hidden="true"></div>
    <h3>Guardando tu avance</h3>
    <p>Estamos validando la información y preparando la siguiente etapa del registro.</p>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('<?=$form_id?>');
    const overlay = document.getElementById('ret_dynamic_loading');

    if (!form || !overlay) {
      return;
    }

    form.addEventListener('submit', function () {
      if (!form.checkValidity()) {
        return;
      }

      const buttons = form.querySelectorAll('button[type="submit"]');
      buttons.forEach(function (button) {
        button.disabled = true;
      });

      overlay.hidden = false;
    });

    <?php if($modalTitle && $modalMessage): ?>
    if (window.Swal) {
      Swal.fire({
        icon: '<?=$modalIcon?>',
        title: <?=json_encode($modalTitle)?>,
        html: <?=json_encode($modalMessage)?>,
        confirmButtonText: 'Continuar',
        confirmButtonColor: '#1565c0',
      });
    }
    <?php endif; ?>
  });
</script>
