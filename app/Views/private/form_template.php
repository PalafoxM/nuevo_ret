<?php

/*
  controller: Controlador origen - str
  next_cont: Controlador destino - str
  form_icon: Icono bootstrap - str
  form_title: Título del formulario - str
  form_giro: Giro de la empresa - str
  alert_type: Tipo de alerta (danger, success, warning, etc) - str
  form_action: Tipo de envío del formulario - str
  form_id: ID de formulario - str

  form_field: Array con los campos del formulario
    [0] field_type: Tipo de campo (text, email, select, etc) - str
    [1] field_label: Etiqueta de campo - str
    [2] field_name: Nombre de campo - str
    [3] field_value: Valor del campo - str
    [4] field_minlen: Longitud minima - int
    [5] field_maxlen: Longitud maxima - int
    [6] field_required: Requerido - bool
    [7] field_disabled: Deshabilitado - bool
    [8] field_placeholder: Placeholder - str
    [9] field_values: Valores (select-multiselect) - array
        {value_id}: ID del valor
        {value_name}: Nombre del valor
   [10] validate: Restricciones para validar - str
   [11] field_col: Ancho del campo - str
   [12] field_readonly: Solo lectura - bool
   [13] html_element: Elemento adicional al tag html - str

  form_buttons: Array con los botones
*/



$this->session          = \Config\Services::session();

?>


  <main class="form-body">
    <div class="py-5 text-center" style="padding: 5px;">
      <i class="bi-<?=$form_icon?> icon-redirect"></i>
      <h1 class="ret-titulo-panel"><?=$form_title?></h1>
      <h4 class="mb-3"><?=$form_pst?></h4>
      <h4 class="mb-3"><?=$form_giro?></h4>
      <h4 class="mb-3">Usted está a un avance del</h4>
      <div class="col-sm-6 progress container contenedor-ret" style="padding: 0; height: 25px;">
        <div class="progress-bar-animated progress-bar-striped bg-success" style="width:<?=$form_percent?>%; height: 25px; color: #fff; font-size: 1rem;"><?=$form_percent?>%</div>
      </div>       
    </div>

  <?php
  if($this->session->getFlashdata('titulo'))
  { ?>
    <div class="text-center container alert alert-<?=$this->session->getFlashdata('alert_type')?> alert-dismissible fade show">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <b><?=$this->session->getFlashdata('titulo')?></b>
      <p><?=$this->session->getFlashdata('mensaje')?></p>
    </div>
  <?php } 
  ?>

    <div class="text-center container contenedor-ret">
      <div class="col-lg-12">
        <form class="was-validated" id="<?=$form_id?>" role="<?=$form_id?>" enctype="multipart/form-data" action="<?=$form_action?>" method="post">
        
          <div class="row g-3">

            <?php
            $validate   =   [];
            $fields     =   [];
            $files      =   [];
            $matrix     =   [];

            for($i = 0; $i < count($form_field); $i ++)
            {
              switch($form_field[$i][0])
              {
                /********************************************TEXT-PASSWORD-EMAIL-URL********************************************/
                case 'text':
                case 'password':
                case 'url':
                case 'email': 
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2]  =>  $form_field[$i][10]]);

                    $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                  }

                ?>

            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6])?' *':'')?></label>
              <input type="<?=$form_field[$i][0]?>" class="form-control" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$form_field[$i][3]?>" minlength="<?=$form_field[$i][4]?>" maxlength="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6])?' required':'')?><?=(($form_field[$i][7])?' disabled':'')?><?=((isset($form_field[$i][13]))?' '.$form_field[$i][13]:'')?>>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Campo requerido
              </div>
              <?php } ?>
            </div>
              


          <?php break;                
                /********************************************FILE********************************************/
                case 'file': 
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2]  =>  $form_field[$i][10]]);

                    $files = array_merge($files, [['name' => $form_field[$i][2]]]);
                  }

                ?>

            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6] && $form_field[$i][3] == '')?' *':'')?><?=(($form_field[$i][3] != '')?'<br><a href="'.BASE_URL.'descargar/'.$form_field[$i][2].'" target="_blank"><i class="bi-file-earmark-arrow-down-fill"></i> Archivo Asignado</a>':'')?>
              </label>
              <input type="<?=$form_field[$i][0]?>" class="form-control" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>"<?=(($form_field[$i][6] && $form_field[$i][3] == '')?' required':'')?><?=(($form_field[$i][7])?' disabled':'')?><?=((isset($form_field[$i][13]))?' '.$form_field[$i][13]:'')?>>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Campo requerido
              </div>
              <?php } ?>
            </div>
              


          <?php break;                
                /********************************************MAP********************************************/
                case 'map':
                  $name_map   =   $form_field[$i][2];
                  $ubicacion  =   $form_field[$i][8];
                  $value      =   $form_field[$i][3];

                  if(! $form_field[$i][7])
                  {

                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [
                                                    $name_map[0]  =>  $form_field[$i][10],
                                                    $name_map[1]  =>  $form_field[$i][10]
                                                  ]);

                    
                    $fields     =   array_merge($fields, [
                                                    ['name' => $name_map[0], 'type' => 'text'],
                                                    ['name' => $name_map[1], 'type' => 'text']
                                                  ]);
                  }

                ?>

            <div class="col-12">
              <label class="form-label"><?=$form_field[$i][1]?></label>
              <p>Arrastra el PIN rojo en la ubicación deseada o captura manualmente la latitud y longitud.</p>
              <div id="map" name="map" style="width:100%; height:400px; background-color:#000000;"></div>
            </div>

            <div class="col-6">
              <label for="<?=$name_map[0]?>" class="form-label"><?=$ubicacion[0]?><?=(($form_field[$i][6])?' *':'')?></label>
              <input type="text" class="form-control" id="<?=$name_map[0]?>" name="<?=$name_map[0]?>" placeholder="<?=$ubicacion[0]?>" value="<?=$value[0]?>" minlength="<?=$form_field[$i][4]?>" maxlength="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6])?' required':'')?><?=(($form_field[$i][7])?' disabled':'')?>>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Campo requerido
              </div>
              <?php } ?>
            </div>
            <div class="col-6">
              <label for="<?=$name_map[1]?>" class="form-label"><?=$ubicacion[1]?><?=(($form_field[$i][6])?' *':'')?></label>
              <input type="text" class="form-control" id="<?=$name_map[1]?>" name="<?=$name_map[1]?>" placeholder="<?=$ubicacion[1]?>" value="<?=$value[1]?>" minlength="<?=$form_field[$i][4]?>" maxlength="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6])?' required':'')?><?=(($form_field[$i][7])?' disabled':'')?>>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Campo requerido
              </div>
              <?php } ?>
            </div>

            <input type="hidden" name="txtlongitudgeo_v" id="txtlongitudgeo_v" value="">
                                                        
            <input type="hidden" name="txtlatitudgeo_v" id="txtlatitudgeo_v" value="">

            <input type="hidden" name="txtlatitudutm_v" id="txtlatitudutm_v" value="">

            <input type="hidden" name="txtlongitudutm_v" id="txtlongitudutm_v" value="">
              


          <?php break;                
                /********************************************TEXTO********************************************/
                case 'texto': 

                ?>
            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <h6 class="mb-3"><?=$form_field[$i][1]?></h6>
            </div>
              


          <?php break;                
          /********************************************NUMBER********************************************/
                case 'number':
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2]  =>  $form_field[$i][10]]);

                    $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                  }

                ?>

            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6])?' *':'')?></label>
              <input type="<?=$form_field[$i][0]?>" class="form-control" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$form_field[$i][3]?>" min="<?=$form_field[$i][4]?>" max="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6])?' required':'')?><?=(($form_field[$i][7])?' disabled':'')?><?=((isset($form_field[$i][13]))?' '.$form_field[$i][13]:'')?>>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Campo requerido y/o valores erróneos
              </div>
              <?php } ?>
            </div>
              
          <?php break;                
          /********************************************MATRIX********************************************/
                case 'matrix':
                  $fieldm  =  $form_field[$i][2]; 
                  $valuem  =  $form_field[$i][3]; 

                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                    {
                      $validate = array_merge($validate, [$fieldm[0]  =>  $form_field[$i][10]]);
                      $validate = array_merge($validate, [$fieldm[1]  =>  $form_field[$i][10]]);
                      $validate = array_merge($validate, [$fieldm[2]  =>  $form_field[$i][10]]);
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
                      $matrix = array_merge($matrix, [
                                                    ['name0' => $fieldm[0], 'dbfield0'  =>  $fieldm[3],
                                                    'name1' => $fieldm[1], 'dbfield1'  =>  $fieldm[4],
                                                    'name2' => $fieldm[2], 'dbfield2'  =>  $fieldm[5]]
                                                  ]);
                    }
                  }

                ?>


            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <h6 class="mb-3"><?=$form_field[$i][1]?></h6>
            </div>

            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <input type="number" class="form-control" id="<?=$fieldm[0]?>" name="<?=$fieldm[0]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$valuem[0]?>" min="<?=$form_field[$i][4]?>" max="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6])?' required':'')?><?=(($form_field[$i][7])?' disabled':'')?><?=(($form_field[$i][12])?' readonly="true"':' onblur="contCamas();" onfocus="contCamas();"')?>>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Campo requerido y/o valores erróneos
              </div>
              <?php } ?>
            </div>
              
            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <input type="number" class="form-control" id="<?=$fieldm[1]?>" name="<?=$fieldm[1]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$valuem[1]?>" min="<?=$form_field[$i][4]?>" max="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6])?' required':'')?><?=(($form_field[$i][7])?' disabled':'')?><?=(($form_field[$i][12])?' readonly="true"':' onblur="contCuartos();"')?>>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Campo requerido y/o valores erróneos
              </div>
              <?php } ?>
            </div>
              
            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <input type="number" class="form-control" id="<?=$fieldm[2]?>" name="<?=$fieldm[2]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$valuem[2]?>" min="<?=$form_field[$i][4]?>" max="<?=$form_field[$i][5]?>"<?=(($form_field[$i][6])?' required':'')?><?=(($form_field[$i][7])?' disabled':'')?><?=(($form_field[$i][12])?' readonly="true"':' onblur="contOcupa();"')?>>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Campo requerido y/o valores erróneos
              </div>
              <?php } ?>
            </div>
              

          <?php break;
          /********************************************HR********************************************/
                case 'hr':
          ?>

          <hr class="my-4">

          <?php break;                
          /********************************************DATE********************************************/
                case 'date':
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2]  =>  $form_field[$i][10]]);

                    $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                  }

                ?>

            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6])?' *':'')?></label>
              <input type="<?=$form_field[$i][0]?>" class="form-control" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>" placeholder="<?=$form_field[$i][8]?>" value="<?=$form_field[$i][3]?>"<?=(($form_field[$i][6])?' required':'')?><?=(($form_field[$i][7])?' disabled':'')?><?=((isset($form_field[$i][13]))?' '.$form_field[$i][13]:'')?>>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Campo requerido
              </div>
              <?php } ?>
            </div>
              


          <?php break;
                /********************************************BAR********************************************/
                case 'bar': ?>

              <div class="d-flex align-items-center p-3 my-3 text-white bg-blue rounded shadow-sm">
                <i class="bi-<?=$form_field[$i][2]?> icon-bar"></i>
                <div class="lh-1">
                  <h1 class="h6 mb-0 text-white lh-1 form-bar"><?=$form_field[$i][1]?></h1>
                  <small><?=$form_field[$i][8]?></small>
                </div>
              </div>

          <?php break;
                /********************************************IFRAME********************************************/
                case 'iframe': ?>

              <div class="d-flex align-items-center p-3 my-3 text-white bg-blue rounded shadow-sm">
                <div class="lh-1">
                  <h1 class="h6 mb-0 text-white lh-1 form-bar"><?=$form_field[$i][1]?></h1>
                  <small><?=$form_field[$i][8]?></small>
                </div>
              </div>
              <iframe src="<?=$form_field[$i][3]?>" width="100%" height="1900" frameborder="0" marginheight="0" marginwidth="0">Espere un momento...</iframe>

          <?php break;

                /********************************************HIDDEN********************************************/
                case 'hidden':
                  if(isset($form_field[$i][10]) && $form_field[$i][10] != '')
                    $validate = array_merge($validate, [$form_field[$i][2]  =>  $form_field[$i][10]]);


                  $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]); ?>

              <input type="hidden" name="<?=$form_field[$i][2]?>" id="<?=$form_field[$i][2]?>" value="<?=$form_field[$i][3]?>">

          <?php break;
                /********************************************BUTTON********************************************/
                case 'button': ?>

              <button class="w-<?=(($form_field[$i][4] != '')?$form_field[$i][4]:'100')?> btn btn-<?=$form_field[$i][3]?>" type="submit"><?=$form_field[$i][1]?></button>
              <div class="invalid-feedback">
                Faltan campos por capturar, favor de verificar.
              </div>

          <?php break;
                /********************************************ENLACE********************************************/
                case 'link': ?>

              <a class="w-<?=(($form_field[$i][4] != '')?$form_field[$i][4]:'100')?> btn btn-<?=$form_field[$i][6]?>" href="<?=$form_field[$i][3]?>" target="<?=$form_field[$i][2]?>"><?=$form_field[$i][1]?></a> 

          <?php break;

                /********************************************TEXTAREA********************************************/
                case 'textarea': 
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2]  =>  $form_field[$i][10]]);

                    $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                  }

                ?>

            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6])?' *':'')?></label>
              <textarea class="form-control" minlength="<?=$form_field[$i][4]?>" maxlength="<?=$form_field[$i][5]?>" name="<?=$form_field[$i][2]?>" id="<?=$form_field[$i][2]?>" placeholder="<?=$form_field[$i][8]?>"<?=(($form_field[$i][6] == true)?' required=""':'')?><?=(($form_field[$i][7] == true)?' disabled=""':'')?><?=((isset($form_field[$i][13]))?' '.$form_field[$i][13]:'')?>><?=$form_field[$i][3]?></textarea>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Campo requerido
              </div>
              <?php } ?>
            </div>
              


          <?php break;
                /********************************************SELECT********************************************/
                case 'select': 
                  if(! $form_field[$i][7])
                  {
                    if($form_field[$i][10] != '')
                      $validate = array_merge($validate, [$form_field[$i][2]  =>  $form_field[$i][10]]);

                    $fields = array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                  }

                ?>

            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <label for="<?=$form_field[$i][2]?>" class="form-label"><?=$form_field[$i][1]?><?=(($form_field[$i][6])?' *':'')?></label>
              <select class="form-select" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>"<?=(($form_field[$i][6])?' required':'')?><?=(($form_field[$i][7])?' disabled':'')?><?=((isset($form_field[$i][13]))?' '.$form_field[$i][13]:'')?>>
                <option value="">Elegir opción...</option>
                <?php
                if($form_field[$i][9])
                {
                  foreach($form_field[$i][9] as $values)
                  { ?>
                
                <option value="<?=$values['value_id']?>" <?=(($form_field[$i][3] == $values['value_id'])?'selected':'')?>><?=$values['value_name']?></option>

                <?php  }
                }
                ?>
              </select>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Favor de elegir una opción
              </div>
              <?php } ?>
            </div>
              


          <?php break;
                /********************************************CHECKBOX********************************************/
                case 'checkbox': 
                  if($form_field[$i][10] != '')
                    $validate = array_merge($validate, [$form_field[$i][2]  =>  $form_field[$i][10]]);


                  $fields =array_merge($fields, [['name' => $form_field[$i][2], 'type' => $form_field[$i][0]]]);
                ?>


            <div class="col-<?=((isset($form_field[$i][11]))?$form_field[$i][11]:'12')?>">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="<?=$form_field[$i][2]?>" name="<?=$form_field[$i][2]?>"<?=(($form_field[$i][6])?' required':'')?><?=(($form_field[$i][3] == 'checked')?' checked':'')?><?=((isset($form_field[$i][13]))?' '.$form_field[$i][13]:'')?>>
                <label class="form-check-label" for="<?=$form_field[$i][2]?>"><?=$form_field[$i][1]?><?=(($form_field[$i][6])?' *':'')?> </label>
              <?php if($form_field[$i][6]) { ?>
              <div class="invalid-feedback">
                  Favor de aceptar para continuar
              </div>
              <?php } ?>
              </div>
            </div>
                


          <?php break;
              }//switch
            }//for

            $this->session->setFlashdata([
                                        'fields'      =>  $fields,
                                        'files'       =>  $files,
                                        'matrix'      =>  $matrix,
                                        'validate'    =>  $validate,
                                        'controller'  =>  $controller,
                                        'next_cont'   =>  $next_cont
                                      ]);
            ?>

            </div>

          </div>

        </form>

      </div>
    </div>
  </main>