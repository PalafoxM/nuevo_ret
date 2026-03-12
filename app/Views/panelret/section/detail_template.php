<?php $session          = \Config\Services::session(); ?>


<div id="page-wrapper">
	<div class="row">
            <?php if(isset($header_bar)) { ?>
        	
            <div class="col-lg-12">
    			<h4 class="border page-header text-primary" style="text-align: left; color: <?=$header_bar['color']?>; background-color: <?=$header_bar['bgcolor']?>; padding: 14px 20px; border-bottom-right-radius:40px; border-top-right-radius:40px;">
				<strong><?=$header_bar['title']?></strong> <?=$header_bar['detail']?>
				<a href="<?=BASE_URL?>paneladm/editar/<?=$detalle[0]['clave']?>" style="float:right; margin-top:10px;" class="btn btn-success"> <i class="fa fa-pencil"></i> Editar  </a>  
				<?php if(($detalle[0]['visible'] == 1 AND $detalle[0]['renovar'] == 1) || ($detalle[0]['visible'] == 1 AND $detalle[0]['concluido'] == 0 AND $detalle[0]['renovar'] == 0 AND $detalle[0]['aprobado'] == 0)){?>
				<a href="<?=BASE_URL?>paneladm/accion/aprobar/<?=$detalle[0]['clave']?>" style="float:right; margin-top:10px;" class="btn btn-info"> <i class="fa fa-check"></i> Aprobar  </a>
				<?php }?>
				<br><br>


                <?php 
              $pendiente 	= false;
              $renovar 		= false;
              $concluido	= false;
              $aprobado		= false;
              $registrado 	= false;
              $vencido		= false;

                if($detalle[0]['visible'] == 1 AND $detalle[0]['renovar'] == 0 AND $detalle[0]['concluido'] == 0)
                {
                	$registrado =	true;
                    echo '<span class="label" style="background-color: #FF8200; color: #fff;"> REGISTRADO </span><span class="label"> </span> ';
                }
                if($detalle[0]['visible'] == 1 AND $detalle[0]['renovar'] == 1)
                {
                	$renovar	=	true;
                    echo '<span class="label" style="background-color: #40a9ea; color: #fff;"> RENOVACIÓN </span><span class="label"> </span> ';
                }
                if($detalle[0]['visible'] == 1 AND $detalle[0]['concluido'] == 0 AND $detalle[0]['renovar'] == 0 AND $detalle[0]['aprobado'] == 0)
                {
                	$pendiente 	= 	true;
                    echo '<span class="label label-warning"> PENDIENTE </span><span class="label"> </span> ';
                }
                if($detalle[0]['concluido'] == 1 AND $detalle[0]['renovar'] == 0 AND $detalle[0]['visible'] == 1 AND $detalle[0]['aprobado'] == 0)
                {
                	$concluido	=	true;
                    echo '<span class="label" style="background-color: #0066FF; color: #fff;"> CONCLUIDO </span><span class="label"> </span> ';
                }
                if($detalle[0]['dias_transcurridos'] <= 1095 AND $detalle[0]['concluido'] == 1 AND $detalle[0]['aprobado'] == 1 AND $detalle[0]['visible'] == 1)
                {
                	$aprobado 	=	true;
                    echo '<span class="label" style="background-color: #32AA00; color: #fff;"> APROBADO </span><span class="label"> </span> ';
                }
                if($detalle[0]['dias_transcurridos'] > 1095 AND $detalle[0]['renovar'] == 0)
                {
                	$vencido	=	true;
                    echo '<span class="label" style="background-color: #df0a15; color: #fff;"> VENCIDO </span><span class="label"> </span> ';
                }


                ?>

			    </h4>
            </div>

            <?php } ?>


    </div>

    <br>
            <?php if($session->getFlashdata('success')):?>
                <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?=$session->getFlashdata('success')?></strong>
                </div>
            <?php elseif($session->getFlashdata('error')):?>
                <div class="alert alert-warning">
                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong><?=$session->getFlashdata('error')?></strong>
                </div>
            <?php endif;?>


	<div class="row">

        <div class="col-lg-12">				      
        	<div id="accordion" role="tablist">					 					
				<div class="panel-group">
					<div class="panel panel-default">
							<div class="panel-heading" style="background-color:#0066FF; color:#FFFFFF;">
							<h4 class="panel-title">
  								<a data-toggle="collapse" href="#collapse1"><b>1. DATOS GENERALES </b></a>
							</h4>
							</div>							

							<div id="collapse1" class="panel-collapse collapse">
								<div class="panel-body">

								<section class="invoice table-participantes box" style="margin-bottom: 10px !important">  
									<div class="row">
										<div class="col-xs-12 table-responsive">
											<table class="table table-striped table-bordered table-hover" style="margin-bottom: 0">
												<tbody>
  													<tr>
														<th style="background-color:#205081; color:#FFFFFF">Clave RET </th>
														<td style="background-color:#FF8200; color:#FFFFFF"><b> <?=$detalle[0]['clave']?> </b></td>
  													</tr>
  													
  													<tr>
    													<th>Fecha de Registro</th>
    													<td> <?=$detalle[0]['fecha_registro_alt']?> </td>
  													</tr>
  													
  													<tr>
    													<th>Giro Principal</th>
    													<td> <?=$detalle[0]['g_giro']?> </td>
  													</tr>
  													
  													<tr>
    													<th>Subrubro</th>
    													<td> <?=$detalle[0]['subrubro_descripcion']?> </td>
  													</tr>

  													<tr>
    													<th>Nombre Comercial</th>
    													<td> <?=$detalle[0]['nombre_comercial']?> </td>
  													</tr> 
  													
  													<tr>
    													<th>Representante</th>
    													<td> <?=$detalle[0]['representante']?> </td>
  													</tr> 
  													
  													<tr>
    													<th>Contacto</th>
    													<td> <?=$detalle[0]['contacto']?> </td>
  													</tr>
  													
  													<tr>
    													<th>RFC</th>
    													<td> <?=$detalle[0]['info_rfc']?> </td>
  													</tr>  
  													
  													<tr>
    													<th>Tipo de Persona</th>
    													<td><?=(($detalle[0]['tipo_persona'] == 1)?'PERSONA FÍSICA':'PERSONA MORAL')?></td>
  													</tr> 
													
      												<tr>
        												<th> Nombre de la Razón Social </th>
        												<td> <?=$detalle[0]['razon_social']?> </td>
      												</tr>

      												<tr>
        												<th> Representante Legal (Persona Moral) </th>
        												<td> <?=$detalle[0]['representante_moral']?> </td>
      												</tr> 

													<tr>
        												<th> Calle: </th>
        												<td> <?=$detalle[0]['calle']?> </td>
      												</tr>

      												<tr>
        												<th> Número Exterior </th>
        												<td> <?=$detalle[0]['numero']?> </td>
      												</tr>

      												<tr>
        												<th> Interior </th>
        												<td> <?=$detalle[0]['interior']?> </td>
      												</tr>

      												<tr>
        												<th> Colonia </th>
        												<td> <?=$detalle[0]['colonia']?> </td>
      												</tr>

      												<tr>
        												<th> C.P </th>
        												<td> <?=$detalle[0]['cp']?> </td>
      												</tr>

      												<tr>
        												<th> Municipio </th>
        												<td> <?=$detalle[0]['municipio_nombre'].', Guanajuato'?> </td>
      												</tr>

													<tr>
        												<th> Teléfono: </th>
        												<td> <?=$detalle[0]['lada'].' '.$detalle[0]['telefono']?> </td>
      												</tr>


													<tr>
        												<th> Pagina Web: </th>
        												<td> <?=$detalle[0]['web']?> </td>
      												</tr>

      												<tr>
        												<th> Correo Electrónico </th>
        												<td> <?=$detalle[0]['correo']?> </td>
      												</tr>

      												<tr>
        												<th> Facebook </th>
        												<td> <?=$detalle[0]['facebook']?> </td>
      												</tr>

  													<tr>
    													<th> Twitter </th>
    													<td> <?=$detalle[0]['twitter']?> </td>
  													</tr>

  													<tr>
    													<th> Latitud / Longitud </th>
    													<td> <?=$detalle[0]['latitud']?>, <?=$detalle[0]['longitud']?> </td>
  													</tr>
 

  													<tr>
    													<th> Georeferenciación </th>
														<td>
															<?php  if(isset($detalle[0]['latitud']) && isset($detalle[0]['longitud']) != NULL) {?> 
															<iframe width="750" height="400" frameborder="0" style="border:0"  src="https://www.google.com/maps/embed/v1/place?key=<?=GOOGLE_MAPS?>&q=<?=$detalle[0]['latitud']?>,<?=$detalle[0]['longitud']?>&zoom=9" allowfullscreen> </iframe> 
															<?php }else{?>
															Aún sin datos de Georeferencia
															<?php }?>
														</td>
      												</tr> 
												
												</tbody>
												</table>
										</div>        
									</div>  
								</section>

								<section class="invoice table-participantes box" style="margin-bottom: 10px !important">  
										<div class="datos_generales">
										<div class="col-xs-12 table-responsive">
											<div class="panel-footer" style="text-align: justify;"> <h5><b> DESCRIPCIÓN </b></h5> <?=$detalle[0]['descripcion']?> </div>
										</div>
									</div>
								</section>
																		
							</div>																	
							</div>
					</div>


					<div class="panel panel-default">
							<div class="panel-heading" style="background-color:#0066FF; color:#FFFFFF;">
							<h4 class="panel-title">
  								<a data-toggle="collapse" href="#collapse2"><b>2. DATOS TÉCNICOS </b></a>
							</h4>
							</div>							

							<div id="collapse2" class="panel-collapse collapse">
								<div class="panel-body">
								<div class="row">
									<div class="col-xs-12 table-responsive">
										<div class="table-responsive">
											<table class="table table-striped">
  												<tr>
    												<th><b> Número de Empleados (Fijos) </b></th>
    												<td>  <?=$detalle[0]['fijos_h']?> Hombre(s) </td>
														<td>  <?=$detalle[0]['fijos_m']?> Mujer(s) </td>
  												</tr>

												<tr>
    												<th> Número de Empleados (Temporales) </th>
														<td>  <?=$detalle[0]['tempo_h']?> Hombre(s) </td>
														<td>  <?=$detalle[0]['tempo_m']?> Mujer(s) </td>
												</tr>
												
												<tr>
													<th> Número de Empleados con Discapacidad </th>
														<td>  <?=$detalle[0]['disca_h']?> Hombre(s) </td>
														<td>  <?=$detalle[0]['disca_m']?> Mujer(s) </td>
												</tr>
												
												<tr>
            										<th> ¿Brinda capacitación a sus empleados? </th>
														<td>  <?php if($detalle[0]['capacita'] != 1) echo 'No'; else echo 'Si'; ?> </td>
													<td>&nbsp</td>
												</tr>

          										<tr>
            										<th> ¿Cuenta con Certificados Médicos de sus empleados? </th>
														<td>  <?php if($detalle[0]['cert_med'] != 1) echo 'No'; else echo 'Si'; ?> </td>
													<td>&nbsp</td>
												</tr>

          										<tr>
            										<th> ¿Cuenta con instalaciones para personas con discapacidad? </th>
														<td>  <?php if($detalle[0]['inst_disca'] != 1) echo 'No'; else echo 'Si'; ?> </td>
													<td>&nbsp</td>
												</tr>

          										<tr>
													<th> Tipo de Inversión </th>
														<td> <?=$detalle[0]['inversion']?> </td>
													<td>&nbsp</td>
          										</tr>

          										<tr>
													<th> Fecha de Inicio de Operaciones </th>
														<td> <?=$detalle[0]['inicio_opera']?> </td>
													<td>&nbsp</td>
          										</tr>

          										<tr>
													<th> Tipo de Organización </th>
														<td> <?=$detalle[0]['organizacion']?> </td>
													<td>&nbsp</td>
          										</tr>

          										<tr>
													<th> Tipo de Mercado </th>
														<td> <?php if($detalle[0]['local']!= 1) echo ''; else echo '(Local)'; ?> <?php if($detalle[0]['nacional'] != 1) echo ''; else echo '(Nacional)'; ?> <?php if($detalle[0]['regional']!= 1) echo ''; else echo '(Regional)'; ?> <?php if($detalle[0]['internacional']!= 1) echo ''; else echo '(Internacional)'; ?> </td>
													<td>&nbsp</td>
          										</tr>

          										<tr>
													<th> Cámaras, cadenas o asociaciones turísticas a las que pertenece: </th>
														<td> <?=$detalle[0]['cadenaper']?> </td>
													<td>&nbsp</td>
          										</tr>
											
											</table>
  										</div>
									</div>									
								</div>									
							</div>
								
								<div class="panel-footer"> </div>
  							
							</div>
					</div>


					<div class="panel panel-default">
							<div class="panel-heading" style="background-color:#0066FF; color:#FFFFFF;">
							<h4 class="panel-title">
  								<a data-toggle="collapse" href="#collapse3"><b>3. DOCUMENTACIÓN LEGAL E IMÁGENES </b></a>
							</h4>
							</div>							

							<div id="collapse3" class="panel-collapse collapse">
								<div class="panel-body">
							<div class="row">
								<div class="col-xs-12 table-responsive">
  										<div class="table-responsive">
    											<table class="table table-striped">
      												<tr>
        												<th> Constancia de Situación Fiscal / RFC </th>
        												<td> 															 
													<?php
														if (($detalle[0]['a_rfc']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/rfc/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a>

												<?php }?>
												</td>
      												</tr>

      												<tr>
        												<th> CURP </th>
        												<td>  
													<?php
														if (($detalle[0]['a_curp']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/curp/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a>

												<?php }?>
												</td>
      												</tr>

											<tr>
        												<th> Identificación Oficial con Fotografía / INE </th>
        												<td>
													<?php
														if (($detalle[0]['a_ife']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/ife/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>

											<tr>
        												<th> Licencia de Uso de Suelo / Constancia de Situación Fiscal </th>
        												<td>
													<?php
														if (($detalle[0]['a_licencia_suelo']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/licencia_suelo/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>


											<tr>
        												<th> Escritura Pública / Contrato de Arrendamiento / Contrato de Comodato </th>
        												<td> 
													<?php
														if (($detalle[0]['a_escritura_publica']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/escritura_publica/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>


											<tr>
        												<th> Acta Constitutiva y carta poder del representante en caso de NO aparecer en Acta Constitutiva el representante legal </th>
        												<td> 
													<?php
														if (($detalle[0]['a_acta_constitutiva']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/acta_constitutiva/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>


      												<tr>
        												<th> RFC Representante Legal </th>
        												<td> 
													<?php
														if (($detalle[0]['a_rfc_legal']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span> <a href=""> </a>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/rfc_legal/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>

											<tr>
        												<th> Comprobante de Domicilio </th>
        												<td>
													<?php
														if (($detalle[0]['a_domicilio']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/domicilio/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>



											<tr>
        												<th> Protocolo de Higiene </th>
        												<td> 
													<?php
														if (($detalle[0]['a_protocolo_higiene']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/protocolo_higiene/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>

											<tr>
        												<th> Carta Bajo Protesta </th>
        												<td> 
													<?php
														if (($detalle[0]['a_carta_protesta']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/carta_protesta/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>




      												<tr>
        												<th> Logotipo </th>
        												<td> 
													<?php
														if (($detalle[0]['a_logo']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/logo/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>

      												<tr>
        												<th> Imagen 1 </th>
        												<td> 
													<?php
														if (($detalle[0]['a_imagen1']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/imagen1/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>

      												<tr>
        												<th> Imagen 2 </th>
        												<td> 
													<?php
														if (($detalle[0]['a_imagen2']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/imagen2/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>

											<tr>
        												<th> Imagen 3 </th>
        												<td> 
													<?php
														if (($detalle[0]['a_imagen3']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

													<a href="<?=BASE_URL?>paneladm/descargar/imagen3/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

												<?php }?>
												</td>
      												</tr>

											<tr>
        												<th> Imagen Promocional </th>
        												<td> 
													<?php
														if (($detalle[0]['a_imagen_promocional']) == NULL){																	
															echo '<span style="color:#ca2934" class="glyphicon glyphicon-remove"></span>';
														}
														else{
													?>

														<a href="<?=BASE_URL?>paneladm/descargar/imagen_promocional/<?=$detalle[0]['clave']?>" target="_blank"> Descargar archivo asignado </a> 

														<?php }?>
														</td>
      												</tr>
    											</table>
  										</div>
									</div>									
							</div>									
						</div>
								<div class="panel-footer"> </div>
							</div>
					</div>


					<div class="panel panel-default">
							<div class="panel-heading" style="background-color:#0066FF; color:#FFFFFF;">
							<h4 class="panel-title">
  								<a data-toggle="collapse" href="#collapse4"><b>4. INFORMACIÓN DEL GIRO </b></a>
							</h4>
							</div>							

							<div id="collapse4" class="panel-collapse collapse">
								<div class="panel-body">
								<div class="row">
									<div class="col-xs-12 table-responsive">
										<div class="table-responsive">
											<?php switch($giro) { 
												case 1: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Categoría</b></th>
    												<td><?=$giro_data[0]['categoria']?></td>
  												</tr>
												<tr>
    												<th>Establecimiento</th>
													<td><?=$giro_data[0]['establecimiento']?></td>
												</tr>
												<tr>
    												<th>Tipo</th>
													<td><?=$giro_data[0]['tipo']?></td>
												</tr>
												<tr>
    												<th>Tipo 2</th>
													<td><?=$giro_data[0]['tipo2']?></td>
												</tr>
												<tr>
    												<th>Habitaciones</th>
													<td><?=$giro_data[0]['cuartos']?></td>
												</tr>
												<tr>
    												<th>Pisos</th>
													<td><?=$giro_data[0]['pisos']?></td>
												</tr>
												<tr>
    												<th>Cocineta</th>
													<td><?=(($giro_data[0]['cocineta'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>TV</th>
													<td><?=(($giro_data[0]['tv'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Caja Fuerte</th>
													<td><?=(($giro_data[0]['cajafuerte'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Cocineta Parcial</th>
													<td><?=(($giro_data[0]['cocinetaparcial'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Cable</th>
													<td><?=(($giro_data[0]['cable'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Jacuzzi</th>
													<td><?=(($giro_data[0]['jacuzzi'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Aire Acondicionado</th>
													<td><?=(($giro_data[0]['aireacondicionado'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Teléfono</th>
													<td><?=(($giro_data[0]['telefono'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Agua Caliente</th>
													<td><?=(($giro_data[0]['aguacaliente'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Ventilador</th>
													<td><?=(($giro_data[0]['ventilador'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Minibar</th>
													<td><?=(($giro_data[0]['minibar'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Cafetería</th>
													<td><?=(($giro_data[0]['cafeteria'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Bar</th>
													<td><?=(($giro_data[0]['bar'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Acceso a Personas con Capacidades Diferentes</th>
													<td><?=(($giro_data[0]['acceso'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Restaurante</th>
													<td><?=(($giro_data[0]['restaurante'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Boutique</th>
													<td><?=(($giro_data[0]['boutique'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Agencia de Viajes</th>
													<td><?=(($giro_data[0]['agencia'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Cocina Industrial</th>
													<td><?=(($giro_data[0]['cocinaindustrial'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Regalos</th>
													<td><?=(($giro_data[0]['regalo'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Spa</th>
													<td><?=(($giro_data[0]['spa'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
													<th>Banquete</th>
													<td><?=(($giro_data[0]['banquete'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Tabaquería</th>
													<td><?=(($giro_data[0]['tabaqueria'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Room Service</th>
													<td><?=(($giro_data[0]['room'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Salones de Eventos</th>
													<td><?=(($giro_data[0]['salon'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Internet</th>
													<td><?=(($giro_data[0]['internet'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Florería</th>
													<td><?=(($giro_data[0]['floreria'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Alberca</th>
													<td><?=(($giro_data[0]['alberca'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Salón de Belleza y Peluquería</th>
													<td><?=(($giro_data[0]['sala'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Arrendadora de Autos</th>
													<td><?=(($giro_data[0]['arrendadora'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Chapoteadero</th>
													<td><?=(($giro_data[0]['chapoteadero'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Gimnasio</th>
													<td><?=(($giro_data[0]['gimnasio'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Campo de Golf</th>
													<td><?=(($giro_data[0]['golf'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Áreas Verdes</th>
													<td><?=(($giro_data[0]['area'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Lavandería</th>
													<td><?=(($giro_data[0]['lavanderia'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Cancha de Tenis</th>
													<td><?=(($giro_data[0]['tenis'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Juegos Infantiles</th>
													<td><?=(($giro_data[0]['juego'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Tintorería</th>
													<td><?=(($giro_data[0]['tintoreria'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Centro Ejecutivo</th>
													<td><?=(($giro_data[0]['ejecutivo'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Actividades Recreativas</th>
													<td><?=(($giro_data[0]['actividad'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Elevador</th>
													<td><?=(($giro_data[0]['elevador'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Estacionamiento</th>
													<td><?=(($giro_data[0]['estacionamiento'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Distintivo H</th>
													<td><?=(($giro_data[0]['h'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Distintivo M</th>
													<td><?=(($giro_data[0]['m'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Tesoros de Guanajuato</th>
													<td><?=(($giro_data[0]['tesoros'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Certificación ISO</th>
													<td><?=(($giro_data[0]['iso'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Punto Limpio</th>
													<td><?=(($giro_data[0]['puntolimpio'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Gran Anfitrión</th>
													<td><?=(($giro_data[0]['anfitrion'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Estándares de Competencia Laboral</th>
													<td><?=(($giro_data[0]['estandares'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Otro</th>
													<td><?=$giro_data[0]['otracertificacion']?></td>
												</tr>
												<tr>
    												<th>No. de Cajones de Estacionamiento</th>
													<td><?=$giro_data[0]['nocajon']?></td>
												</tr>
												<tr>
    												<th>Tipo de Estacionamiento</th>
													<td><?=$giro_data[0]['tipocajon']?></td>
												</tr>
												<tr>
    												<th>Seguro de Responsabilidad</th>
													<td><?=(($giro_data[0]['seguro'] == 1)?'SI - '.$giro_data[0]['aseguradora']:'NO')?></td>
												</tr>
												<tr>
    												<th>¿Cuenta con unidades y espacios para paraderos?</th>
													<td><?=(($giro_data[0]['unidad'] == 1)?'SI':'NO')?></td>
												</tr>
											</table>
												<?php break;
												case 2: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Modalidad</b></th>
    												<td><?=$giro_data[0]['modalidad']?></td>
  												</tr>
												<tr>
    												<th>Segmento</th>
													<td><?=$giro_data[0]['segmento']?></td>
												</tr>
												<tr>
    												<th>Asociación</th>
													<td><?=(($giro_data[0]['asociacion'] == 1)?'SI - '.$giro_data[0]['nombre_asociacion']:'NO')?></td>
												</tr>
											</table>
												<?php break;
												case 3: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Tipo de Guía</b></th>
    												<td><?=$giro_data[0]['guia']?></td>
  												</tr>
												<tr>
    												<th>Recorridos de Historia</th>
													<td><?=(($giro_data[0]['tip_historia'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Recorridos de Arte</th>
													<td><?=(($giro_data[0]['tip_arte'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Recorridos de Cultura</th>
													<td><?=(($giro_data[0]['tip_cultura'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Recorridos de Museos</th>
													<td><?=(($giro_data[0]['tip_museos'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Recorridos Religiosos</th>
													<td><?=(($giro_data[0]['tip_religiosos'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Recorridos de Compras</th>
													<td><?=(($giro_data[0]['tip_compras'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Recorridos de Aventura</th>
													<td><?=(($giro_data[0]['tip_aventura'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>No. de Credenciales como Guía</th>
													<td><?=$giro_data[0]['num_credencial']?></td>
												</tr>
												<tr>
    												<th>Asociación a la que pertenece</th>
													<td><?=$giro_data[0]['nombre_asociacion']?></td>
												</tr>
												<tr>
    												<th>Español</th>
													<td><?=(($giro_data[0]['esp'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Francés</th>
													<td><?=(($giro_data[0]['fra'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Inglés</th>
													<td><?=(($giro_data[0]['eng'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Italiano</th>
													<td><?=(($giro_data[0]['ita'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Alemán</th>
													<td><?=(($giro_data[0]['ale'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Coreano</th>
													<td><?=(($giro_data[0]['cor'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Portugués</th>
													<td><?=(($giro_data[0]['por'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Otro idioma</th>
													<td><?=$giro_data[0]['otro_idioma']?></td>
												</tr>
											</table>
												<?php break;
												case 4: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Licencia para operar en vía pública</b></th>
    												<td><?=(($giro_data[0]['licencia'] == 1)?'SI':'NO')?></td>
  												</tr>
												<tr>
    												<th>Detalle de Licencia</th>
													<td><?=$giro_data[0]['txt_licencia']?></td>
												</tr>
												<tr>
    												<th>No. de Licencia</th>
													<td><?=$giro_data[0]['nolicencia']?></td>
												</tr>
												<tr>
    												<th>Zona de Trabajo</th>
													<td><?=$giro_data[0]['zona']?></td>
												</tr>
												<tr>
    												<th>Hospedaje</th>
													<td><?=(($giro_data[0]['tipo_giro1'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Recorridos</th>
													<td><?=(($giro_data[0]['tipo_giro2'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Callejoneadas</th>
													<td><?=(($giro_data[0]['tipo_giro3'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Tiendas de Souvenirs</th>
													<td><?=(($giro_data[0]['tipo_giro4'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Museos</th>
													<td><?=(($giro_data[0]['tipo_giro5'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Restaurantes</th>
													<td><?=(($giro_data[0]['tipo_giro6'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Centros Nocturnos</th>
													<td><?=(($giro_data[0]['tipo_giro7'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Tiendas de Artesanías</th>
													<td><?=(($giro_data[0]['tipo_giro8'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Convenios de giros que comercializa</th>
													<td><?=$giro_data[0]['convenio']?></td>
												</tr>
												<tr>
    												<th>Convenio</th>
													<td><?=$giro_data[0]['txt_convenio']?></td>
												</tr>
											</table>
												<?php break;
												case 5: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Licencia de funcionamiento por Secretaría de Salud Guanajuato</b></th>
    												<td><?=(($giro_data[0]['licencia'] == 1)?'SI':'NO')?></td>
  												</tr>
												<tr>
    												<th>No. de Licencia</th>
													<td><?=$giro_data[0]['num_licencia']?></td>
												</tr>
  												<tr>
    												<th><b>Permisos Municipales</b></th>
    												<td><?=(($giro_data[0]['permiso'] == 1)?'SI':'NO')?></td>
  												</tr>
												<tr>
    												<th>Servicio</th>
													<td><?=(($giro_data[0]['tipo_servicio'] == 0)?'ALIMENTOS Y BEBIDAS':(($giro_data[0]['tipo_servicio'] == 1)?'SOLO ALIMENTOS':'SOLO BEBIDAS'))?></td>
												</tr>
												<tr>
    												<th>Permiso de Bebidas</th>
													<td><?=$giro_data[0]['num_bebidas']?></td>
												</tr>
												<tr>
    												<th>Matutino</th>
													<td><?=(($giro_data[0]['hro_matutino'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Vespertino</th>
													<td><?=(($giro_data[0]['hro_vespertino'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Diurno</th>
													<td><?=(($giro_data[0]['hro_diurno'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Nocturno</th>
													<td><?=(($giro_data[0]['hro_nocturno'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Comensales Potenciales</th>
													<td><?=$giro_data[0]['num_potenciales']?></td>
												</tr>
												<tr>
    												<th>No. de Mesas</th>
													<td><?=$giro_data[0]['num_mesas']?></td>
												</tr>
												<tr>
    												<th>A la mesa</th>
													<td><?=(($giro_data[0]['op_mesa'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Autoservicio</th>
													<td><?=(($giro_data[0]['op_autoservicio'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Buffete</th>
													<td><?=(($giro_data[0]['op_buffete'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>A la carta</th>
													<td><?=(($giro_data[0]['op_alacarta'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Tipo de Establecimiento</th>
													<td><?=$giro_data[0]['tipo_establecimiento']?></td>
												</tr>
												<tr>
    												<th>Tipo de Cocina</th>
													<td><?=$giro_data[0]['tipo_cocina']?></td>
												</tr>
											</table>
												<?php break;
												case 6: ?>
											<table class="table table-striped">
												<tr>
    												<th>Campo</th>
													<td><?=$giro_data[0]['turistico']?></td>
												</tr>
												<tr>
    												<th>No. de Hoyos</th>
													<td><?=$giro_data[0]['hoyos']?></td>
												</tr>
												<tr>
    												<th>Par</th>
													<td><?=$giro_data[0]['par']?></td>
												</tr>
												<tr>
    												<th>Longitud en Yardas</th>
													<td><?=$giro_data[0]['longitud']?></td>
												</tr>
  												<tr>
    												<th><b>Uso obligatorio de carrito</b></th>
    												<td><?=(($giro_data[0]['carrito'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Privado con facilidades</b></th>
    												<td><?=(($giro_data[0]['privado'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tipo de Campo Plano</b></th>
    												<td><?=(($giro_data[0]['plano'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tipo de Campo Semiplano</b></th>
    												<td><?=(($giro_data[0]['semiplano'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tipo de Campo Ondulado</b></th>
    												<td><?=(($giro_data[0]['ondulado'] == 1)?'SI':'NO')?></td>
  												</tr>
												<tr>
    												<th>Diseñado por</th>
													<td><?=$giro_data[0]['disenado']?></td>
												</tr>
												<tr>
    												<th>Faiways</th>
													<td><?=$giro_data[0]['fairways']?></td>
												</tr>
												<tr>
    												<th>Greens</th>
													<td><?=$giro_data[0]['greens']?></td>
												</tr>
  												<tr>
    												<th><b>Servicio: Casa Club</b></th>
    												<td><?=(($giro_data[0]['serv01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio: Putting Green</b></th>
    												<td><?=(($giro_data[0]['serv02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio: Marcas de Yardas</b></th>
    												<td><?=(($giro_data[0]['serv03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio: Clases de Golf</b></th>
    												<td><?=(($giro_data[0]['serv04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio: Restaurante</b></th>
    												<td><?=(($giro_data[0]['serv05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio: Reservación de Salidas</b></th>
    												<td><?=(($giro_data[0]['serv06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio: Teen de Práctica</b></th>
    												<td><?=(($giro_data[0]['serv07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio: Renta de Autos</b></th>
    												<td><?=(($giro_data[0]['serv08'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio: Tienda Profesional</b></th>
    												<td><?=(($giro_data[0]['serv09'] == 1)?'SI':'NO')?></td>
  												</tr>
												<tr>
    												<th>Forma de pago: American Express</th>
													<td><?=(($giro_data[0]['tc01'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Forma de pago: Visa</th>
													<td><?=(($giro_data[0]['tc02'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Forma de pago: Master Card</th>
													<td><?=(($giro_data[0]['tc03'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Forma de pago: Efectivo</th>
													<td><?=(($giro_data[0]['tc04'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Forma de pago: Cheque de Viajero</th>
													<td><?=(($giro_data[0]['tc05'] == 1)?'SI':'NO')?></td>
												</tr>
												<tr>
    												<th>Forma de pago: Otra</th>
													<td><?=(($giro_data[0]['tc06'] == 1)?'SI, '.$giro_data[0]['otra_tc']:'NO')?></td>
												</tr>
											</table>
												<?php break;
												case 7: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Tipo: Establecimiento de dulces típicos</b></th>
    												<td><?=(($giro_data[0]['tipo1'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tipo: Galerías de arte y salas de exhibición</b></th>
    												<td><?=(($giro_data[0]['tipo2'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tipo: Establecimiento de artesanías</b></th>
    												<td><?=(($giro_data[0]['tipo3'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tipo: Establecimiento de productos típicos</b></th>
    												<td><?=(($giro_data[0]['tipo4'] == 1)?'SI':'NO')?></td>
  												</tr>
												<tr>
    												<th>Descripción</th>
													<td><?=$giro_data[0]['descripcion']?></td>
												</tr>
												<tr>
    												<th>Tipo de Operación</th>
													<td><?=$giro_data[0]['operacion']?></td>
												</tr>
											</table>
												<?php break;
												case 8: ?>
											<table class="table table-striped">
												<tr>
    												<th>Actividad Educativa</th>
													<td><?=$giro_data[0]['descripcion']?></td>
												</tr>
											</table>
												<?php break;
												case 9: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Tipo de permiso: Municipal</b></th>
    												<td><?=(($giro_data[0]['perm1'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tipo de permiso: Estatal</b></th>
    												<td><?=(($giro_data[0]['perm2'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tipo de permiso: Federal</b></th>
    												<td><?=(($giro_data[0]['perm3'] == 1)?'SI':'NO')?></td>
  												</tr>
												<tr>
    												<th>Número de Unidades</th>
													<td><?=$giro_data[0]['novehiculos']?></td>
												</tr>
												<tr>
    												<th>Tipo de unidades</th>
													<td><?=$giro_data[0]['tipovehiculos']?></td>
												</tr>
												<tr>
    												<th>Capacidad de unidades</th>
													<td><?=$giro_data[0]['capavehiculos']?></td>
												</tr>
												<tr>
    												<th>Tipo de Servicio</th>
													<td><?=$giro_data[0]['servicio']?></td>
												</tr>
  												<tr>
    												<th><b>Características del servicio: Aire Acondicionado</b></th>
    												<td><?=(($giro_data[0]['caract1'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características del servicio: Cafetería a Bordo</b></th>
    												<td><?=(($giro_data[0]['caract2'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características del servicio: Servicio de Edecanes</b></th>
    												<td><?=(($giro_data[0]['caract3'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características del servicio: Primeros Auxilios</b></th>
    												<td><?=(($giro_data[0]['caract4'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características del servicio: Transporte de Equipo Especial</b></th>
    												<td><?=(($giro_data[0]['caract5'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características del servicio: Bar a Bordo</b></th>
    												<td><?=(($giro_data[0]['caract6'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características del servicio: Restaurante a Bordo</b></th>
    												<td><?=(($giro_data[0]['caract7'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características del servicio: Tours Guiados</b></th>
    												<td><?=(($giro_data[0]['caract8'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características del servicio: Guía</b></th>
    												<td><?=(($giro_data[0]['caract9'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características de< servicio: Paquetes Promocionales</b></th>
    												<td><?=(($giro_data[0]['caract10'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características de< servicio: Abordaje a Domicilio</b></th>
    												<td><?=(($giro_data[0]['caract11'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características de< servicio: Salón VIP</b></th>
    												<td><?=(($giro_data[0]['caract12'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características de< servicio: Transporte de Menaje</b></th>
    												<td><?=(($giro_data[0]['caract13'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Características de< servicio: Transporte de Vehículos</b></th>
    												<td><?=(($giro_data[0]['caract14'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Automóviles</b></th>
    												<td><?=(($giro_data[0]['serv01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Bicicletas y Motocicletas</b></th>
    												<td><?=(($giro_data[0]['serv02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Combis y Vans</b></th>
    												<td><?=(($giro_data[0]['serv03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Limousines</b></th>
    												<td><?=(($giro_data[0]['serv04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Autobuses</b></th>
    												<td><?=(($giro_data[0]['serv05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Campers</b></th>
    												<td><?=(($giro_data[0]['serv06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Vehículos para Carretera</b></th>
    												<td><?=(($giro_data[0]['serv07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Motocicletas</b></th>
    												<td><?=(($giro_data[0]['serv08'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Bicicletas</b></th>
    												<td><?=(($giro_data[0]['serv09'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Aviones</b></th>
    												<td><?=(($giro_data[0]['serv10'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Ultraligeros</b></th>
    												<td><?=(($giro_data[0]['serv11'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Planeadores</b></th>
    												<td><?=(($giro_data[0]['serv12'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: American Express</b></th>
    												<td><?=(($giro_data[0]['tc01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Visa</b></th>
    												<td><?=(($giro_data[0]['tc02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Master Card</b></th>
    												<td><?=(($giro_data[0]['tc03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Efectivo</b></th>
    												<td><?=(($giro_data[0]['tc04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Cheque de Viajero</b></th>
    												<td><?=(($giro_data[0]['tc05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Otra</b></th>
    												<td><?=(($giro_data[0]['tc06'] == 1)?'SI, '.$giro_data[0]['otra_tc']:'NO')?></td>
  												</tr>
											</table>
												<?php break;
												case 10: ?>
											<table class="table table-striped">
												<tr>
    												<th>Tipo de Empresa</th>
													<td><?=$giro_data[0]['tipoempresa']?></td>
												</tr>
												<tr>
    												<th>Capacidad máxima del lugar</th>
													<td><?=$giro_data[0]['capacidad']?></td>
												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Agencia de viajes</b></th>
    												<td><?=(($giro_data[0]['serv01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Jardines </b></th>
    												<td><?=(($giro_data[0]['serv02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Zona de carga y descarga</b></th>
    												<td><?=(($giro_data[0]['serv03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Area de registro</b></th>
    												<td><?=(($giro_data[0]['serv04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Restaurante</b></th>
    												<td><?=(($giro_data[0]['serv05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Cafetería </b></th>
    												<td><?=(($giro_data[0]['serv06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Arrendadora de auto</b></th>
    												<td><?=(($giro_data[0]['serv07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Asesoría financiera</b></th>
    												<td><?=(($giro_data[0]['serv08'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Centro de negocios</b></th>
    												<td><?=(($giro_data[0]['serv09'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Centro de servicios</b></th>
    												<td><?=(($giro_data[0]['serv10'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Edecanes</b></th>
    												<td><?=(($giro_data[0]['serv11'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Equipo audiovisual</b></th>
    												<td><?=(($giro_data[0]['serv12'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Equipo de sonido</b></th>
    												<td><?=(($giro_data[0]['serv13'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Estacionamiento</b></th>
    												<td><?=(($giro_data[0]['serv14'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Fax</b></th>
    												<td><?=(($giro_data[0]['serv15'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Florería</b></th>
    												<td><?=(($giro_data[0]['serv16'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Guía de turismo</b></th>
    												<td><?=(($giro_data[0]['serv17'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Colgado de lonas y mantas</b></th>
    												<td><?=(($giro_data[0]['serv18'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Mobiliario de montaje</b></th>
    												<td><?=(($giro_data[0]['serv19'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Montaje de stands</b></th>
    												<td><?=(($giro_data[0]['serv20'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Oficinas administrativas</b></th>
    												<td><?=(($giro_data[0]['serv21'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Renta de bodegas</b></th>
    												<td><?=(($giro_data[0]['serv22'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Renta de taquillas</b></th>
    												<td><?=(($giro_data[0]['serv23'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Sanitarios</b></th>
    												<td><?=(($giro_data[0]['serv24'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Servicio médico</b></th>
    												<td><?=(($giro_data[0]['serv25'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Guardería</b></th>
    												<td><?=(($giro_data[0]['serv26'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Servicio de taxis</b></th>
    												<td><?=(($giro_data[0]['serv27'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Tabaquería</b></th>
    												<td><?=(($giro_data[0]['serv28'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Teléfonos</b></th>
    												<td><?=(($giro_data[0]['serv29'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Traducción simultánea</b></th>
    												<td><?=(($giro_data[0]['serv30'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Proveedores</b></th>
    												<td><?=(($giro_data[0]['serv31'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Organización de exposiciones</b></th>
    												<td><?=(($giro_data[0]['serv32'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Organización de convenciones</b></th>
    												<td><?=(($giro_data[0]['serv33'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Oficinas para comité organizador</b></th>
    												<td><?=(($giro_data[0]['serv34'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Equipo de cómputo</b></th>
    												<td><?=(($giro_data[0]['serv35'] == 1)?'SI':'NO')?></td>
  												</tr>
 												<tr>
    												<th><b>Forma de Pago: American Express</b></th>
    												<td><?=(($giro_data[0]['tc01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Visa</b></th>
    												<td><?=(($giro_data[0]['tc02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Master Card</b></th>
    												<td><?=(($giro_data[0]['tc03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Efectivo</b></th>
    												<td><?=(($giro_data[0]['tc04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Cheque de Viajero</b></th>
    												<td><?=(($giro_data[0]['tc05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Otra</b></th>
    												<td><?=(($giro_data[0]['tc06'] == 1)?'SI, '.$giro_data[0]['otra_tc']:'NO')?></td>
  												</tr>
											</table>
												<?php break;
												case 11: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Horarios: Matutino</b></th>
    												<td><?=(($giro_data[0]['hora01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Horarios: Vespertino</b></th>
    												<td><?=(($giro_data[0]['hora02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Horarios: Diurno</b></th>
    												<td><?=(($giro_data[0]['hora03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Horarios: Nocturno</b></th>
    												<td><?=(($giro_data[0]['hora04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Horario</b></th>
    												<td><?=$giro_data[0]['horario']?></td>
  												</tr>  												
  												<tr>
    												<th><b>Capacidad máxima del lugar</b></th>
    												<td><?=$giro_data[0]['capacidad']?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Ángeles verdes</b></th>
    												<td><?=(($giro_data[0]['mod01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Oficinas de turismo</b></th>
    												<td><?=(($giro_data[0]['mod02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Módulos de información</b></th>
    												<td><?=(($giro_data[0]['mod03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Casetas de auxilio turístico</b></th>
    												<td><?=(($giro_data[0]['mod04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Talleres mecánicos</b></th>
    												<td><?=(($giro_data[0]['mod05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Estaciones de gasolina</b></th>
    												<td><?=(($giro_data[0]['mod06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Servicios de grúas</b></th>
    												<td><?=(($giro_data[0]['mod07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Otros</b></th>
    												<td><?=(($giro_data[0]['mod08'] == 1)?'SI, '.$giro_data[0]['otro_mod']:'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Asesoría legal</b></th>
    												<td><?=(($giro_data[0]['serv01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Servicio mecánico</b></th>
    												<td><?=(($giro_data[0]['serv02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Reservaciones</b></th>
    												<td><?=(($giro_data[0]['serv03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Primeros auxilios</b></th>
    												<td><?=(($giro_data[0]['serv04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Folletería</b></th>
    												<td><?=(($giro_data[0]['serv05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Planos y mapas</b></th>
    												<td><?=(($giro_data[0]['serv06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Venta de material promocional</b></th>
    												<td><?=(($giro_data[0]['serv07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Proyección de documentales</b></th>
    												<td><?=(($giro_data[0]['serv08'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Consulta de bancos de información</b></th>
    												<td><?=(($giro_data[0]['serv09'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Touch Screen</b></th>
    												<td><?=(($giro_data[0]['serv10'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Venta de espacios publicitarios</b></th>
    												<td><?=(($giro_data[0]['serv11'] == 1)?'SI':'NO')?></td>
  												</tr>
 												<tr>
    												<th><b>Forma de Pago: American Express</b></th>
    												<td><?=(($giro_data[0]['tc01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Visa</b></th>
    												<td><?=(($giro_data[0]['tc02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Master Card</b></th>
    												<td><?=(($giro_data[0]['tc03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Efectivo</b></th>
    												<td><?=(($giro_data[0]['tc04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Cheque de Viajero</b></th>
    												<td><?=(($giro_data[0]['tc05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Otra</b></th>
    												<td><?=(($giro_data[0]['tc06'] == 1)?'SI, '.$giro_data[0]['otra_tc']:'NO')?></td>
  												</tr>
											</table>
												<?php break;
												case 12: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Horarios: Matutino</b></th>
    												<td><?=(($giro_data[0]['hor_mat'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Horarios: Vespertino</b></th>
    												<td><?=(($giro_data[0]['hor_vesp'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Horarios: Diurno</b></th>
    												<td><?=(($giro_data[0]['hor_diur'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Capacidad máxima del lugar</b></th>
    												<td><?=$giro_data[0]['capacidad']?></td>
  												</tr>
  												<tr>
    												<th><b>Número de Albercas</b></th>
    												<td><?=$giro_data[0]['alberca']?></td>
  												</tr>
  												<tr>
    												<th><b>Número de Chapoteaderos</b></th>
    												<td><?=$giro_data[0]['chapoteadero']?></td>
  												</tr>
  												<tr>
    												<th><b>Número de Toboganes</b></th>
    												<td><?=$giro_data[0]['tobogan']?></td>
  												</tr>
  												<tr>
    												<th><b>Número de Cajones de Estacionamiento</b></th>
    												<td><?=$giro_data[0]['estacionamiento']?></td>
  												</tr>
  												<tr>
    												<th><b>Apertura al Público</b></th>
    												<td><?=$giro_data[0]['apertura']?></td>
  												</tr>
  												<tr>
    												<th><b>Mencionar el material promocional que manejanal</b></th>
    												<td><?=$giro_data[0]['material']?></td>
  												</tr>
  												<tr>
    												<th><b>Mencionar los medios publicidad que manejanal</b></th>
    												<td><?=$giro_data[0]['medios']?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Lago artificial</b></th>
    												<td><?=(($giro_data[0]['serv01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Lago natural</b></th>
    												<td><?=(($giro_data[0]['serv02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Aguas termales</b></th>
    												<td><?=(($giro_data[0]['serv03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Albercas de olas</b></th>
    												<td><?=(($giro_data[0]['serv04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Personal salvavidas</b></th>
    												<td><?=(($giro_data[0]['serv05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Toboganes</b></th>
    												<td><?=(($giro_data[0]['serv06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Chapoteaderos</b></th>
    												<td><?=(($giro_data[0]['serv07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Tren escénico</b></th>
    												<td><?=(($giro_data[0]['serv08'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Áreas verdes</b></th>
    												<td><?=(($giro_data[0]['serv09'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Regaderas</b></th>
    												<td><?=(($giro_data[0]['serv10'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Cafetería</b></th>
    												<td><?=(($giro_data[0]['serv11'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Área de asadores</b></th>
    												<td><?=(($giro_data[0]['serv12'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Vestidores</b></th>
    												<td><?=(($giro_data[0]['serv13'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Sanitarios</b></th>
    												<td><?=(($giro_data[0]['serv14'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Área de juegos infantiles</b></th>
    												<td><?=(($giro_data[0]['serv15'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Equipo de contingencias</b></th>
    												<td><?=(($giro_data[0]['serv16'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Aplicación de mascarillas</b></th>
    												<td><?=(($giro_data[0]['serv17'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Masajes</b></th>
    												<td><?=(($giro_data[0]['serv18'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Fuentes de sodas</b></th>
    												<td><?=(($giro_data[0]['serv19'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Restaruante</b></th>
    												<td><?=(($giro_data[0]['serv20'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Tienda de souvenirs</b></th>
    												<td><?=(($giro_data[0]['serv21'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Boutique</b></th>
    												<td><?=(($giro_data[0]['serv22'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Bar</b></th>
    												<td><?=(($giro_data[0]['serv23'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Albercas privadas</b></th>
    												<td><?=(($giro_data[0]['serv24'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Servicio médico</b></th>
    												<td><?=(($giro_data[0]['serv25'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Estacionamiento</b></th>
    												<td><?=(($giro_data[0]['serv26'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Hotel</b></th>
    												<td><?=(($giro_data[0]['serv27'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Villas</b></th>
    												<td><?=(($giro_data[0]['serv28'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Cabañas</b></th>
    												<td><?=(($giro_data[0]['serv29'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Bungalows</b></th>
    												<td><?=(($giro_data[0]['serv30'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Área de acampar</b></th>
    												<td><?=(($giro_data[0]['serv31'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Área de para eventos</b></th>
    												<td><?=(($giro_data[0]['serv32'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Lavandería y tintorería</b></th>
    												<td><?=(($giro_data[0]['serv33'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Spa</b></th>
    												<td><?=(($giro_data[0]['serv34'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Palapas</b></th>
    												<td><?=(($giro_data[0]['serv35'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Temazcal</b></th>
    												<td><?=(($giro_data[0]['serv36'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Adicionales: Otros servicios</b></th>
    												<td><?=$giro_data[0]['serv_otro']?></td>
  												</tr>
 												<tr>
    												<th><b>Forma de Pago: American Express</b></th>
    												<td><?=(($giro_data[0]['tc01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Visa</b></th>
    												<td><?=(($giro_data[0]['tc02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Master Card</b></th>
    												<td><?=(($giro_data[0]['tc03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Efectivo</b></th>
    												<td><?=(($giro_data[0]['tc04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Cheque de Viajero</b></th>
    												<td><?=(($giro_data[0]['tc05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Otra</b></th>
    												<td><?=(($giro_data[0]['tc06'] == 1)?'SI, '.$giro_data[0]['otra_tc']:'NO')?></td>
  												</tr>
											</table>
												<?php break;
												case 13: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Horario de servicio</b></th>
    												<td><?=$giro_data[0]['horario']?></td>
  												</tr>
  												<tr>
    												<th><b>Asociaciones a las que pertenece</b></th>
    												<td><?=$giro_data[0]['asociaciones']?></td>
  												</tr>
  												<tr>
    												<th><b>Certificaciones y/o acreditaciones obtenidas</b></th>
    												<td><?=$giro_data[0]['certificaciones']?></td>
  												</tr>
  												<tr>
    												<th><b>Matrícula de carreras enfocadas al turismo</b></th>
    												<td><?=$giro_data[0]['matricula']?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Escuelas de licenciatura</b></th>
    												<td><?=(($giro_data[0]['lic'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Escuelas de bachillerato y técnicas</b></th>
    												<td><?=(($giro_data[0]['bac'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Centros de capacitación</b></th>
    												<td><?=(($giro_data[0]['cca'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad: Instructores</b></th>
    												<td><?=(($giro_data[0]['ins'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>No. de personas que imparten la capacitación en los planteles</b></th>
    												<td><?=$giro_data[0]['nopersonas']?></td>
  												</tr>
  												<tr>
    												<th><b>Registro estatal</b></th>
    												<td><?=(($giro_data[0]['serv01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Registro federal</b></th>
    												<td><?=(($giro_data[0]['serv02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Sin registro</b></th>
    												<td><?=(($giro_data[0]['serv03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Autónoma</b></th>
    												<td><?=(($giro_data[0]['serv04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pública</b></th>
    												<td><?=(($giro_data[0]['serv05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Privada</b></th>
    												<td><?=(($giro_data[0]['serv06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Postgrados</b></th>
    												<td><?=(($giro_data[0]['serv07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Registro STPS</b></th>
    												<td><?=(($giro_data[0]['serv08'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Instructor independiente</b></th>
    												<td><?=(($giro_data[0]['serv09'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Instructor habilitado</b></th>
    												<td><?=(($giro_data[0]['serv10'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Institución capacitadora</b></th>
    												<td><?=(($giro_data[0]['serv11'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Vinculación escuela-empresa</b></th>
    												<td><?=(($giro_data[0]['serv12'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Programa de becas</b></th>
    												<td><?=(($giro_data[0]['serv13'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Intercambio escolar</b></th>
    												<td><?=(($giro_data[0]['serv14'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Talleres especializados</b></th>
    												<td><?=(($giro_data[0]['serv15'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Idiomas</b></th>
    												<td><?=(($giro_data[0]['serv16'] == 1)?'SI':'NO')?></td>
  												</tr>
 												<tr>
    												<th><b>Forma de Pago: American Express</b></th>
    												<td><?=(($giro_data[0]['tc01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Visa</b></th>
    												<td><?=(($giro_data[0]['tc02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Master Card</b></th>
    												<td><?=(($giro_data[0]['tc03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Efectivo</b></th>
    												<td><?=(($giro_data[0]['tc04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Cheque de Viajero</b></th>
    												<td><?=(($giro_data[0]['tc05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Otra</b></th>
    												<td><?=(($giro_data[0]['tc06'] == 1)?'SI, '.$giro_data[0]['otra_tc']:'NO')?></td>
  												</tr>
											</table>
												<?php break;
												case 14: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Pesca Deportiva</b></th>
    												<td><?=(($giro_data[0]['pesca'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Rancho Cinegético</b></th>
    												<td><?=(($giro_data[0]['rancho'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Deporte</b></th>
    												<td><?=(($giro_data[0]['deporte'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Recreación</b></th>
    												<td><?=(($giro_data[0]['recreacion'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Detallar la Actividad</b></th>
    												<td><?=$giro_data[0]['detalle']?></td>
  												</tr>
  												<tr>
    												<th><b>Superficie (hectáreas)</b></th>
    												<td><?=$giro_data[0]['superficie']?></td>
  												</tr>
  												<tr>
    												<th><b>Hotel</b></th>
    												<td><?=(($giro_data[0]['serv01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Restaurante</b></th>
    												<td><?=(($giro_data[0]['serv02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Renta de armas</b></th>
    												<td><?=(($giro_data[0]['serv03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Venta de cartuchos</b></th>
    												<td><?=(($giro_data[0]['serv04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Venta de equipo fotográfico</b></th>
    												<td><?=(($giro_data[0]['serv05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio de transporte</b></th>
    												<td><?=(($giro_data[0]['serv06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Asistente o guía</b></th>
    												<td><?=(($giro_data[0]['serv07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Safari fotográfico</b></th>
    												<td><?=(($giro_data[0]['serv08'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Evaluación física y nutricionalr independiente</b></th>
    												<td><?=(($giro_data[0]['serv09'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Gimnasiado</b></th>
    												<td><?=(($giro_data[0]['serv10'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Aerobicsn capacitadora</b></th>
    												<td><?=(($giro_data[0]['serv11'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Piscina cubiertaa-empresa</b></th>
    												<td><?=(($giro_data[0]['serv12'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Piscina descubierta</b></th>
    												<td><?=(($giro_data[0]['serv13'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Gimnasia acuática</b></th>
    												<td><?=(($giro_data[0]['serv14'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Campos de golfs especializados</b></th>
    												<td><?=(($giro_data[0]['serv15'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Club hípico</b></th>
    												<td><?=(($giro_data[0]['serv16'] == 1)?'SI':'NO')?></td>
  												</tr>  												
  												<tr>
    												<th><b>Talasoterapia</b></th>
    												<td><?=(($giro_data[0]['serv17'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Masaje suizo</b></th>
    												<td><?=(($giro_data[0]['serv18'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Masaje reductivo</b></th>
    												<td><?=(($giro_data[0]['serv19'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Masaje terapéutico</b></th>
    												<td><?=(($giro_data[0]['serv20'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Masaje deportivo</b></th>
    												<td><?=(($giro_data[0]['serv21'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Aroma terapia</b></th>
    												<td><?=(($giro_data[0]['serv22'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Reflexología</b></th>
    												<td><?=(($giro_data[0]['serv23'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Algas</b></th>
    												<td><?=(($giro_data[0]['serv24'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Fangosr independiente</b></th>
    												<td><?=(($giro_data[0]['serv25'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Herbalesdo</b></th>
    												<td><?=(($giro_data[0]['serv26'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Saunan capacitadora</b></th>
    												<td><?=(($giro_data[0]['serv27'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Vapor</b></th>
    												<td><?=(($giro_data[0]['serv28'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Jacuzzi</b></th>
    												<td><?=(($giro_data[0]['serv29'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tratamientos faciales</b></th>
    												<td><?=(($giro_data[0]['serv30'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Boutiques especializados</b></th>
    												<td><?=(($giro_data[0]['serv31'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Salón de belleza</b></th>
    												<td><?=(($giro_data[0]['serv32'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Cafetería</b></th>
    												<td><?=(($giro_data[0]['serv33'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Restaurantes</b></th>
    												<td><?=(($giro_data[0]['serv34'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Enfermería</b></th>
    												<td><?=(($giro_data[0]['serv35'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Hotel</b></th>
    												<td><?=(($giro_data[0]['serv36'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Villas</b></th>
    												<td><?=(($giro_data[0]['serv37'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Cabañas</b></th>
    												<td><?=(($giro_data[0]['serv38'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Bungalows</b></th>
    												<td><?=(($giro_data[0]['serv39'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Áreas de acampar</b></th>
    												<td><?=(($giro_data[0]['serv40'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio a cuartosr independiente</b></th>
    												<td><?=(($giro_data[0]['serv41'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Áreas para eventosdo</b></th>
    												<td><?=(($giro_data[0]['serv42'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Lavandería y tintorerían capacitadora</b></th>
    												<td><?=(($giro_data[0]['serv43'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Bara-empresa</b></th>
    												<td><?=(($giro_data[0]['serv44'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Entrenadores</b></th>
    												<td><?=(($giro_data[0]['serv45'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Otros</b></th>
    												<td><?=(($giro_data[0]['serv46'] == 1)?'SI, '.$giro_data[0]['otrostxt']:'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>No. de personas que imparten la capacitación en los planteles</b></th>
    												<td><?=$giro_data[0]['nopersonas']?></td>
  												</tr>
  												<tr>
    												<th><b>Pato charreteras</b></th>
    												<td><?=(($giro_data[0]['caza01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato golondrino</b></th>
    												<td><?=(($giro_data[0]['caza02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato chalcuan</b></th>
    												<td><?=(($giro_data[0]['caza03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato cuaresmeño</b></th>
    												<td><?=(($giro_data[0]['caza04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Cercetas listas verdes</b></th>
    												<td><?=(($giro_data[0]['caza05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Cerceta café</b></th>
    												<td><?=(($giro_data[0]['caza06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato triguero</b></th>
    												<td><?=(($giro_data[0]['caza07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Cerceta alas azules</b></th>
    												<td><?=(($giro_data[0]['caza08'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato cabeza roja</b></th>
    												<td><?=(($giro_data[0]['caza09'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato boludo prieto</b></th>
    												<td><?=(($giro_data[0]['caza10'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato boludo grande</b></th>
    												<td><?=(($giro_data[0]['caza11'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato coacoxtle</b></th>
    												<td><?=(($giro_data[0]['caza12'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Branta negra o del pacífico</b></th>
    												<td><?=(($giro_data[0]['caza13'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ganso canadiense</b></th>
    												<td><?=(($giro_data[0]['caza14'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato chillón jorobado</b></th>
    												<td><?=(($giro_data[0]['caza15'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato chillón ojos dorados</b></th>
    												<td><?=(($giro_data[0]['caza16'] == 1)?'SI':'NO')?></td>
  												</tr>  												
  												<tr>
    												<th><b>Ganso nevado o ansar azul</b></th>
    												<td><?=(($giro_data[0]['caza17'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ganso ross</b></th>
    												<td><?=(($giro_data[0]['caza18'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato pichichi</b></th>
    												<td><?=(($giro_data[0]['caza19'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato phichihuila</b></th>
    												<td><?=(($giro_data[0]['caza20'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Gallaereta</b></th>
    												<td><?=(($giro_data[0]['caza21'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Grulla gris</b></th>
    												<td><?=(($giro_data[0]['caza22'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Mergo caperuza</b></th>
    												<td><?=(($giro_data[0]['caza23'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Negreta alas blancas</b></th>
    												<td><?=(($giro_data[0]['caza24'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Negreta de merejada</b></th>
    												<td><?=(($giro_data[0]['caza25'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Mergo americano</b></th>
    												<td><?=(($giro_data[0]['caza26'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Mergo copetón</b></th>
    												<td><?=(($giro_data[0]['caza27'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pato tepalcate</b></th>
    												<td><?=(($giro_data[0]['caza28'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Paloma de collar</b></th>
    												<td><?=(($giro_data[0]['caza29'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Paloma morada</b></th>
    												<td><?=(($giro_data[0]['caza30'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Paloma montañera</b></th>
    												<td><?=(($giro_data[0]['caza31'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Paloma arroyera o suelera</b></th>
    												<td><?=(($giro_data[0]['caza32'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tordo charretero ganga</b></th>
    												<td><?=(($giro_data[0]['caza33'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Codorniz de california</b></th>
    												<td><?=(($giro_data[0]['caza34'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Codorniz de douglas</b></th>
    												<td><?=(($giro_data[0]['caza35'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Codorniz de gambel</b></th>
    												<td><?=(($giro_data[0]['caza36'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Codorniz de yucatán</b></th>
    												<td><?=(($giro_data[0]['caza37'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Codorniz enmascarada o común</b></th>
    												<td><?=(($giro_data[0]['caza38'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Codorniz moctezuma o pinta</b></th>
    												<td><?=(($giro_data[0]['caza39'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Agachona</b></th>
    												<td><?=(($giro_data[0]['caza40'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Agrarista o tordo negro</b></th>
    												<td><?=(($giro_data[0]['caza41'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Chachalaca</b></th>
    												<td><?=(($giro_data[0]['caza42'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Codorniz listada</b></th>
    												<td><?=(($giro_data[0]['caza43'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Zanate cola de bote</b></th>
    												<td><?=(($giro_data[0]['caza44'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Estornino</b></th>
    												<td><?=(($giro_data[0]['caza45'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Chanate cabeza amarilla</b></th>
    												<td><?=(($giro_data[0]['caza46'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tepezcuintle</b></th>
    												<td><?=(($giro_data[0]['caza47'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ardilla de harris</b></th>
    												<td><?=(($giro_data[0]['caza48'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Agutio guaqueque</b></th>
    												<td><?=(($giro_data[0]['caza49'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Armadillo de nueve cintas</b></th>
    												<td><?=(($giro_data[0]['caza50'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tlacuache</b></th>
    												<td><?=(($giro_data[0]['caza51'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Coyote</b></th>
    												<td><?=(($giro_data[0]['caza52'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Liebre cola negra</b></th>
    												<td><?=(($giro_data[0]['caza53'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Liebre torda</b></th>
    												<td><?=(($giro_data[0]['caza54'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Tejón o coatí</b></th>
    												<td><?=(($giro_data[0]['caza55'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Mapache</b></th>
    												<td><?=(($giro_data[0]['caza56'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ardilla collie</b></th>
    												<td><?=(($giro_data[0]['caza57'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ardilla nayarita</b></th>
    												<td><?=(($giro_data[0]['caza58'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ardilla cola anallada</b></th>
    												<td><?=(($giro_data[0]['caza59'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ardilla mexicana</b></th>
    												<td><?=(($giro_data[0]['caza60'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ardilla moteada</b></th>
    												<td><?=(($giro_data[0]['caza61'] == 1)?'SI':'NO')?></td>
  												</tr>  												
  												<tr>
    												<th><b>Ardilla de las rocas</b></th>
    												<td><?=(($giro_data[0]['caza62'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ardilla gris</b></th>
    												<td><?=(($giro_data[0]['caza63'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Conejo audubon</b></th>
    												<td><?=(($giro_data[0]['caza64'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Conejo del bosque tropical</b></th>
    												<td><?=(($giro_data[0]['caza65'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Conejo mexicano</b></th>
    												<td><?=(($giro_data[0]['caza66'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Conejo del este</b></th>
    												<td><?=(($giro_data[0]['caza67'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Venado bura de sonora</b></th>
    												<td><?=(($giro_data[0]['caza68'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Venado cola blanca texano	</b></th>
    												<td><?=(($giro_data[0]['caza69'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Borrego de cimarrón</b></th>
    												<td><?=(($giro_data[0]['caza70'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Becerrillo</b></th>
    												<td><?=(($giro_data[0]['caza71'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Perdiz o tinamu</b></th>
    												<td><?=(($giro_data[0]['caza72'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Gato montes</b></th>
    												<td><?=(($giro_data[0]['caza73'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Venado temazate rojo</b></th>
    												<td><?=(($giro_data[0]['caza74'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Venado temazate café</b></th>
    												<td><?=(($giro_data[0]['caza75'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Guajolote silvestre</b></th>
    												<td><?=(($giro_data[0]['caza76'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Pavo ocelado</b></th>
    												<td><?=(($giro_data[0]['caza77'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Faisán de collar	</b></th>
    												<td><?=(($giro_data[0]['caza78'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Puma</b></th>
    												<td><?=(($giro_data[0]['caza79'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Venado bura</b></th>
    												<td><?=(($giro_data[0]['caza80'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Venado cola blanca</b></th>
    												<td><?=(($giro_data[0]['caza81'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Jabalí europeo</b></th>
    												<td><?=(($giro_data[0]['caza82'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Jabalí de collar</b></th>
    												<td><?=(($giro_data[0]['caza83'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Jabalí de labios blancos</b></th>
    												<td><?=(($giro_data[0]['caza84'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Perdíz o tinamu real</b></th>
    												<td><?=(($giro_data[0]['caza85'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Zorra gris</b></th>
    												<td><?=(($giro_data[0]['caza86'] == 1)?'SI':'NO')?></td>
  												</tr>
 												<tr>
    												<th><b>Forma de Pago: American Express</b></th>
    												<td><?=(($giro_data[0]['tc01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Visa</b></th>
    												<td><?=(($giro_data[0]['tc02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Master Card</b></th>
    												<td><?=(($giro_data[0]['tc03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Efectivo</b></th>
    												<td><?=(($giro_data[0]['tc04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Cheque de Viajero</b></th>
    												<td><?=(($giro_data[0]['tc05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Otra</b></th>
    												<td><?=(($giro_data[0]['tc06'] == 1)?'SI, '.$giro_data[0]['otra_tc']:'NO')?></td>
  												</tr>
											</table>
												<?php break;
												case 15: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Horario de servicio</b></th>
    												<td><?=$giro_data[0]['horario']?></td>
  												</tr>
  												<tr>
    												<th><b>Ubicación: Dentro de un Hotel</b></th>
    												<td><?=(($giro_data[0]['hotel'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ubicación: Local Comercial</b></th>
    												<td><?=(($giro_data[0]['local'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ubicación: Complejo Turístico</b></th>
    												<td><?=(($giro_data[0]['complejo'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Ubicación: Clínica</b></th>
    												<td><?=(($giro_data[0]['clinica'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Evaluación Física y Nutricional</b></th>
    												<td><?=(($giro_data[0]['serv01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Gimnasia</b></th>
    												<td><?=(($giro_data[0]['serv02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Aerobics</b></th>
    												<td><?=(($giro_data[0]['serv03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Entrenadores</b></th>
    												<td><?=(($giro_data[0]['serv04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Piscina Cubierta</b></th>
    												<td><?=(($giro_data[0]['serv05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Piscina Descubierta</b></th>
    												<td><?=(($giro_data[0]['serv06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Gimnasia Acuática</b></th>
    												<td><?=(($giro_data[0]['serv07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Campos de Golf</b></th>
    												<td><?=(($giro_data[0]['serv08'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Club Hípico</b></th>
    												<td><?=(($giro_data[0]['serv09'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Talasoterapia</b></th>
    												<td><?=(($giro_data[0]['serv10'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Masaje Suizo</b></th>
    												<td><?=(($giro_data[0]['serv11'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Masaje Reductivo</b></th>
    												<td><?=(($giro_data[0]['serv12'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Tienda de Souvenirs</b></th>
    												<td><?=(($giro_data[0]['serv13'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Masaje Terapéutico</b></th>
    												<td><?=(($giro_data[0]['serv14'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Masaje Deportivo</b></th>
    												<td><?=(($giro_data[0]['serv15'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Aroma Terapia</b></th>
    												<td><?=(($giro_data[0]['serv16'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Reflexología</b></th>
    												<td><?=(($giro_data[0]['serv17'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Algas</b></th>
    												<td><?=(($giro_data[0]['serv18'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Fangos</b></th>
    												<td><?=(($giro_data[0]['serv19'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Herbales</b></th>
    												<td><?=(($giro_data[0]['serv20'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Sauna</b></th>
    												<td><?=(($giro_data[0]['serv21'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Vapor</b></th>
    												<td><?=(($giro_data[0]['serv22'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Jacuzzi	</b></th>
    												<td><?=(($giro_data[0]['serv23'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Tratamientos faciales</b></th>
    												<td><?=(($giro_data[0]['serv24'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Boutique</b></th>
    												<td><?=(($giro_data[0]['serv25'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Estacionamiento</b></th>
    												<td><?=(($giro_data[0]['serv26'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Salón de belleza</b></th>
    												<td><?=(($giro_data[0]['serv27'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Cafetería</b></th>
    												<td><?=(($giro_data[0]['serv28'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Restaurantes</b></th>
    												<td><?=(($giro_data[0]['serv29'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Enfermería</b></th>
    												<td><?=(($giro_data[0]['serv30'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Hotel</b></th>
    												<td><?=(($giro_data[0]['serv31'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Villas</b></th>
    												<td><?=(($giro_data[0]['serv32'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Cabañas</b></th>
    												<td><?=(($giro_data[0]['serv33'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Bungalows</b></th>
    												<td><?=(($giro_data[0]['serv34'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Áreas de acampar</b></th>
    												<td><?=(($giro_data[0]['serv35'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Servicio a cuartos</b></th>
    												<td><?=(($giro_data[0]['serv36'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: reas para eventos</b></th>
    												<td><?=(($giro_data[0]['serv37'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Lavandería y tintorería</b></th>
    												<td><?=(($giro_data[0]['serv38'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Temazcal</b></th>
    												<td><?=(($giro_data[0]['serv39'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Bar</b></th>
    												<td><?=(($giro_data[0]['serv40'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Otros</b></th>
    												<td><?=(($giro_data[0]['serv41'] == 1)?'SI, '.$giro_data[0]['serv_otro']:'NO')?></td>
  												</tr>
 												<tr>
    												<th><b>Forma de Pago: American Express</b></th>
    												<td><?=(($giro_data[0]['tc01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Visa</b></th>
    												<td><?=(($giro_data[0]['tc02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Master Card</b></th>
    												<td><?=(($giro_data[0]['tc03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Efectivo</b></th>
    												<td><?=(($giro_data[0]['tc04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Cheque de Viajero</b></th>
    												<td><?=(($giro_data[0]['tc05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Otra</b></th>
    												<td><?=(($giro_data[0]['tc06'] == 1)?'SI, '.$giro_data[0]['otra_tc']:'NO')?></td>
  												</tr>
											</table>
												<?php break;
												case 16: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Horario de servicio</b></th>
    												<td><?=$giro_data[0]['horario']?></td>
  												</tr>
  												<tr>
    												<th><b>Modalidad</b></th>
    												<td><?=$giro_data[0]['modalidad']?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Agencia de viajes</b></th>
    												<td><?=(($giro_data[0]['serv01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Jardines</b></th>
    												<td><?=(($giro_data[0]['serv02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Zona de carga y descarga</b></th>
    												<td><?=(($giro_data[0]['serv03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Área de Registro</b></th>
    												<td><?=(($giro_data[0]['serv04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Restaurante</b></th>
    												<td><?=(($giro_data[0]['serv05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Cafetería</b></th>
    												<td><?=(($giro_data[0]['serv06'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Arrendadora de auto</b></th>
    												<td><?=(($giro_data[0]['serv07'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Asesoría financiera</b></th>
    												<td><?=(($giro_data[0]['serv08'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Centro de negocios</b></th>
    												<td><?=(($giro_data[0]['serv09'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Centro de servicios</b></th>
    												<td><?=(($giro_data[0]['serv10'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Edecanes</b></th>
    												<td><?=(($giro_data[0]['serv11'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Equipo audiovisual</b></th>
    												<td><?=(($giro_data[0]['serv12'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Equipo de Sonido</b></th>
    												<td><?=(($giro_data[0]['serv13'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Estacionamiento</b></th>
    												<td><?=(($giro_data[0]['serv14'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Fax</b></th>
    												<td><?=(($giro_data[0]['serv15'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Florería</b></th>
    												<td><?=(($giro_data[0]['serv16'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Guía de turismo</b></th>
    												<td><?=(($giro_data[0]['serv17'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Colgado de lonas y manta	</b></th>
    												<td><?=(($giro_data[0]['serv18'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Mobiliario de montaje</b></th>
    												<td><?=(($giro_data[0]['serv19'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Montaje de stands</b></th>
    												<td><?=(($giro_data[0]['serv20'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Oficinas administrativas</b></th>
    												<td><?=(($giro_data[0]['serv21'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Renta de bodegas</b></th>
    												<td><?=(($giro_data[0]['serv22'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Renta de taquillas</b></th>
    												<td><?=(($giro_data[0]['serv23'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Sanitarios</b></th>
    												<td><?=(($giro_data[0]['serv24'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Servicio médico</b></th>
    												<td><?=(($giro_data[0]['serv25'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Guardería</b></th>
    												<td><?=(($giro_data[0]['serv26'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Servicio de taxis</b></th>
    												<td><?=(($giro_data[0]['serv27'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Tabaquería</b></th>
    												<td><?=(($giro_data[0]['serv28'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Teléfonos</b></th>
    												<td><?=(($giro_data[0]['serv29'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Traducción simultánea</b></th>
    												<td><?=(($giro_data[0]['serv30'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Proveedores</b></th>
    												<td><?=(($giro_data[0]['serv31'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Organización de exposiciones</b></th>
    												<td><?=(($giro_data[0]['serv32'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Organización de convenciones</b></th>
    												<td><?=(($giro_data[0]['serv33'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Oficinas para comité organizador</b></th>
    												<td><?=(($giro_data[0]['serv34'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios: Equipo de cómputo</b></th>
    												<td><?=(($giro_data[0]['serv35'] == 1)?'SI':'NO')?></td>
  												</tr>
 												<tr>
    												<th><b>Forma de Pago: American Express</b></th>
    												<td><?=(($giro_data[0]['tc01'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Visa</b></th>
    												<td><?=(($giro_data[0]['tc02'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Master Card</b></th>
    												<td><?=(($giro_data[0]['tc03'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Efectivo</b></th>
    												<td><?=(($giro_data[0]['tc04'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Cheque de Viajero</b></th>
    												<td><?=(($giro_data[0]['tc05'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Forma de Pago: Otra</b></th>
    												<td><?=(($giro_data[0]['tc06'] == 1)?'SI, '.$giro_data[0]['otra_tc']:'NO')?></td>
  												</tr>
											</table>
												<?php break;
												case 17: ?>
											<table class="table table-striped">
  												<tr>
    												<th><b>Tipo de Alojamiento</b></th>
    												<td><?=$giro_data[0]['categoria']?></td>
  												</tr>
  												<tr>
    												<th><b>Alojamiento que se ofrece</b></th>
    												<td><?=$giro_data[0]['establecimiento']?></td>
  												</tr>
  												<tr>
    												<th><b>Número de Habitaciones</b></th>
    												<td><?=$giro_data[0]['cuartos']?></td>
  												</tr>
  												<tr>
    												<th><b>Número de camas que pueden utilizar los huéspedes</b></th>
    												<td><?=$giro_data[0]['pisos']?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Cocineta</b></th>
    												<td><?=(($giro_data[0]['cocineta'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Televisión</b></th>
    												<td><?=(($giro_data[0]['tv'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Caja Fuerte</b></th>
    												<td><?=(($giro_data[0]['cajafuerte'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Cocineta Parcial</b></th>
    												<td><?=(($giro_data[0]['cocinetaparcial'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Cable</b></th>
    												<td><?=(($giro_data[0]['cable'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Jacuzzi</b></th>
    												<td><?=(($giro_data[0]['jacuzzi'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Aire Acondicionado</b></th>
    												<td><?=(($giro_data[0]['aireacondicionado'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Teléfono</b></th>
    												<td><?=(($giro_data[0]['telefono'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Agua Caliente</b></th>
    												<td><?=(($giro_data[0]['aguacaliente'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Ventilador</b></th>
    												<td><?=(($giro_data[0]['ventilador'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicio en las Habitaciones: Minibar</b></th>
    												<td><?=(($giro_data[0]['minibar'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Cafetería</b></th>
    												<td><?=(($giro_data[0]['cafeteria'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Bar</b></th>
    												<td><?=(($giro_data[0]['bar'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Acceso para personas con capacidades diferentes</b></th>
    												<td><?=(($giro_data[0]['acceso'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Restaurante</b></th>
    												<td><?=(($giro_data[0]['restaurante'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Boutique</b></th>
    												<td><?=(($giro_data[0]['boutique'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Agencia de Viajes</b></th>
    												<td><?=(($giro_data[0]['agencia'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Cocina Industrial</b></th>
    												<td><?=(($giro_data[0]['cocinaindustrial'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Regalos</b></th>
    												<td><?=(($giro_data[0]['regalo'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Spa</b></th>
    												<td><?=(($giro_data[0]['spa'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Banquetes y Convenciones</b></th>
    												<td><?=(($giro_data[0]['banquete'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Tabaquería</b></th>
    												<td><?=(($giro_data[0]['tabaqueria'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Room Service</b></th>
    												<td><?=(($giro_data[0]['room'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Salones de Eventos</b></th>
    												<td><?=(($giro_data[0]['salon'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Internet</b></th>
    												<td><?=(($giro_data[0]['internet'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Florería</b></th>
    												<td><?=(($giro_data[0]['floreria'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Alberca</b></th>
    												<td><?=(($giro_data[0]['alberca'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Sala de Belleza y Peluquería</b></th>
    												<td><?=(($giro_data[0]['sala'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Arrendadora de Vehículos</b></th>
    												<td><?=(($giro_data[0]['arrendadora'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Chapoteadero</b></th>
    												<td><?=(($giro_data[0]['chapoteadero'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Gimnasio</b></th>
    												<td><?=(($giro_data[0]['gimnasio'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Campo de Golf</b></th>
    												<td><?=(($giro_data[0]['golf'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Áreas Verdes</b></th>
    												<td><?=(($giro_data[0]['area'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Lavandería</b></th>
    												<td><?=(($giro_data[0]['lavanderia'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Cancha de Tenis</b></th>
    												<td><?=(($giro_data[0]['tenis'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Juegos Infantiles</b></th>
    												<td><?=(($giro_data[0]['juego'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Tintorería</b></th>
    												<td><?=(($giro_data[0]['tintoreria'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Centro Ejecutivo</b></th>
    												<td><?=(($giro_data[0]['ejecutivo'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Actividades Recreativas</b></th>
    												<td><?=(($giro_data[0]['actividad'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Elevador</b></th>
    												<td><?=(($giro_data[0]['elevador'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Servicios Comunes: Estacionamiento</b></th>
    												<td><?=(($giro_data[0]['estacionamiento'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Certificaciones: Distintivo H</b></th>
    												<td><?=(($giro_data[0]['h'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Certificaciones: Distintivo M</b></th>
    												<td><?=(($giro_data[0]['m'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Certificaciones: Tesoros de Guanajuato</b></th>
    												<td><?=(($giro_data[0]['tesoros'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Certificaciones: ISO</b></th>
    												<td><?=(($giro_data[0]['iso'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Certificaciones: Punto Limpio</b></th>
    												<td><?=(($giro_data[0]['puntolimpio'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Certificaciones: Gran Anfitrion</b></th>
    												<td><?=(($giro_data[0]['anfitrion'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Certificaciones: Estándares de Competencia Laboral</b></th>
    												<td><?=(($giro_data[0]['estandares'] == 1)?'SI':'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Certificaciones: Otra</b></th>
    												<td><?=(($giro_data[0]['otro'] == 1)?'SI, '.$giro_data[0]['otracertificacion']:'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>Estacionamiento: Número de Cajones</b></th>
    												<td><?=$giro_data[0]['nocajon']?></td>
  												</tr>
  												<tr>
    												<th><b>Estacionamiento: Tipo de Estacionamiento</b></th>
    												<td><?=$giro_data[0]['tipocajon']?></td>
  												</tr>
  												<tr>
    												<th><b>¿Cuenta de con seguro de responsabilidad?</b></th>
    												<td><?=(($giro_data[0]['seguro'] == 1)?'SI, '.$giro_data[0]['aseguradora']:'NO')?></td>
  												</tr>
  												<tr>
    												<th><b>¿Cuenta con unidades y espacios para paraderos?</b></th>
    												<td><?=(($giro_data[0]['unidad'] == 1)?'SI':'NO')?></td>
  												</tr>
											</table>
												<?php break;?>
											<?php } ?>
  										</div>
									</div>									
								</div>									
							</div>
								
								<div class="panel-footer"> </div>
  							
							</div>
					</div>


					<!-- NOTIFICACIÓN DE OBSERVACIONES -->
					<?php if($renovar || $concluido || $vencido || $pendiente) {?>

					<div class="panel panel-info">
							<div class="panel-heading">
							<h4 class="panel-title">
								<span class="glyphicon glyphicon-comment"></span>
  								<a data-toggle="collapse" href="#collapse5"><b> NOTIFICAR OBSERVACIONES </b> </a>
							</h4>
							</div>

						<script type="text/javascript">
							window.onload = function () {
								document.frmObservaciones.txtObservaciones.focus();	
								document.frmObservaciones.addEventListener('submit', validarFormulario);
							}
							function validarFormulario(evObject) 
							{
								evObject.preventDefault();
								var todoCorrecto = true;
								var formulario = document.frmObservaciones;

								for (var i=0; i<formulario.length; i++) {
            								if(formulario[i].type =='text') {
                           								if (formulario[i].value == null || formulario[i].value.length == 0 || /^\s*$/.test(formulario[i].value)){
                           								alert (formulario[i].name+ ' es un campo obligatorio.');
                           								todoCorrecto=false;
                           							}
            							}
            						}

								if (todoCorrecto ==true) {
									formulario.submit();
								}
							}
						</script>							

						<div id="collapse5" class="panel-collapse collapse">
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">

										<form action="<?=BASE_URL?>paneladm/enviar-observaciones" method="post" name="frmObservaciones">
											<div class="form-group">
												<h4>
													<b> Al enviar las observaciones, el registro pasará a estatus PENDIENTE. </b> <br>
													<small>Redacta el detalle que el PST debe realizar para continuar con su proceso de trámite que será enviado a su cuenta de correo electrónico proporcionado a continuación.</small>
												</h4>			
											</div>

											<div class="leyenda inputforma" style="color: blue; text-align: justify">
												<strong> Estimado Prestador de Servicios Turísticos, </strong> <br><br>Te informamos que su trámite <b>no ha sido aprobado por falta de documentación o sus documentos están incorrectos</b>, el motivo es el siguiente: <br>
											</div>

											<div class="form-group">
													<input type="hidden" id="clave" name="clave" value="<?=$detalle[0]['clave']?>">
													<input type="text" id="txtEmail" name="txtEmail" class="form-control" value="<?php echo mb_strtolower($detalle[0]['correo']); ?>" readonly> <br>
													<textarea class="form-control" rows="5" id="txtObservaciones" name="txtObservaciones" placeholder="Redacta los detalles..." required></textarea>												
											</div>

											<div class="leyenda inputforma" style="color: blue; text-align: justify">
												Contarás con <strong> 3 días </strong> a partir de esta fecha para realizar las modificaciones solicitadas para concluir tu trámite. <br> 
												Cualquier duda o aclaración con respecto a su trámite, favor de comunicarte al teléfono (472) 103 99 00 ext. 229 <br><br>

												<strong> ATENTAMENTE <br>
												Registro Estatal de Turismo <br>
												Secretaría de Turismo del Estado de Guanajuato <strong> <br>
											</div>

											<input type="submit" style="float:right" class="btn btn-warning" value="NOTIFICAR OBSERVACIONES">											
								
										</form>



									</div>
								</div>
							</div>
						</div>
					</div>

					<?php }?>

					</div>

				<div class="col-4"><a href="<?=BASE_URL?>paneladm/<?=$o_function?>" style="float:left" class="btn btn-primary"> Regresar </a></div> 

				<?php if($concluido) {?>
				<div class="col-4"><a href="<?=BASE_URL?>paneladm/accion/aprobar/<?=$detalle[0]['clave']?>" style="float:left; margin-left:10px;" class="btn btn-success"> Aprobar Registro </a></div> 
				<?php }?>

			</div>  					
		</div>
	</div>

</div>
