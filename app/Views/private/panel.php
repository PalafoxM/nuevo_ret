<main>

  <div class="px-4 py-5 my-5 text-center">
    <i class="bi-list-stars icon-redirect"></i>
    <h1 class="ret-titulo-panel">Registros Asociados a su Cuenta</h1>
    <div class="col-lg-6 mx-auto">
      <p class="lead mb-4">Usted tiene <?=count($result)?> empresa(s) asociadas a su cuenta <?=$this->session->get('email')?></p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <table id="panel" class="table table-striped">
          <caption></caption>
          <thead>
            <tr>
              <th scope="col">Clave</th>
              <th scope="col">Giro</th>
              <th scope="col">Empresa</th>
              <th scope="col">Registro</th>
              <th scope="col">Avance</th>
              <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
            
            <?php
            for($i = 0; $i < count($result); $i ++){
            ?>
            
            <tr>
              <th scope="row"><?=$result[$i]['id']?></th>
              <td><?=$result[$i]['resumen']?></td>
              <td><?=$result[$i]['nombre_comercial']?></td>
              <td><?=$result[$i]['fecha_alt']?></td>
              <td>
                <div class="col-sm-6 progress container contenedor-ret" style="padding: 0; height: 25px;">
                  <div class="progress-bar-animated progress-bar-striped bg-success" style="width:<?=$result[$i]['porcentaje_registro']?>%; height: 25px; color: #000; font-size: 1rem;"><?=$result[$i]['porcentaje_registro']?>%</div>
                </div>  
              </td>
              <td>
                <?php if($result[$i]['aprobado'] != 1){?><a href="<?=BASE_URL?>panel/empresa/<?=$result[$i]['id']?>" class="btn btn-primary" title="Ver detalle de la empresa"><i class="bi-check2-square"></i> Elegir</a><?php }else{?>
                  <a href="<?=BASE_URL?>panel/enviar-cedula/<?=$result[$i]['id']?>" class="btn btn-success" title="Enviar Cédula"><i class="bi-envelope-check"></i> Enviar Cédula</a><?php }?>
                <?php if($result[$i]['concluido'] == 0){?><a href="<?=BASE_URL?>panel/eliminar-empresa/<?=$result[$i]['id']?>" class="btn btn-danger" title="Eliminar empresa" onclick="return confirm('¿Desea ELIMINAR esta empresa de forma PERMANENTE')"><i class="bi-trash"></i></a><?php }?>
              </td>
            </tr>
            
            <?php 
            }
            ?>
          
          </tbody>
        </table>
      </div>
    </div>
  </div>

</main>

<script type="text/javascript">
  $(document).ready(function() {
    $('#panel').DataTable({
      language: {
        url: '<?=$dt_mx?>'
      }

    });
  } );
</script>