<?php 
$session          		= 	\Config\Services::session(); 
$this->usuario_model    =	new \App\Models\Usuario_model();
?>


<div id="page-wrapper">
	<div class="row">
            <?php if(isset($header_bar)) { ?>
        	
            <div class="col-lg-12">
    			<h4 class="border page-header text-primary" style="text-align: left; color: <?=$header_bar['color']?>; background-color: <?=$header_bar['bgcolor']?>; padding: 14px 20px; border-bottom-right-radius:40px; border-top-right-radius:40px;">
				<strong><?=$header_bar['title']?></strong> <?=$header_bar['detail']?>
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
		<form id="edit_form" role="edit_form" enctype="multipart/form-data" action="<?=BASE_URL?>paneladm/guardar/<?=$detalle[0]['clave']?>" method="post">
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
	    													<td> <?=$detalle[0]['fecha_registro_alt']?> - <input type="checkbox" id="renovar_registro" name="renovar_registro" value="renovar"> <label for="renovar_registro"> Renovar Registro con Fecha: <?=date("d/m/Y")?> <input type="hidden" value="<?=$detalle[0]['fecha_registro']?>" name="fecha_registro" id="fecha_registro"></label> 
	    													</td>
	  													</tr>
	  													
	  													<tr>
	    													<th>Giro Principal</th>
	    													<td> <?=$detalle[0]['g_giro']?> </td>
	  													</tr>
	  													
	  													<?php
	  													$subrubros = $this->usuario_model->get_subrubros(false,$detalle[0]['giro']);
	  													
	  													if($subrubros) {
	  													?>
	      												<tr>
	        												<th> Subrubro </th>
	        												<td> 
	    														<select class="form-select" id="idgiro_subrubro" name="idgiro_subrubro" required>
	    															<?php foreach($subrubros as $s){ ?>
	    															<option value="<?=$s['idgiro_subrubro']?>" <?=(($detalle[0]['idgiro_subrubro'] == $s['idgiro_subrubro'])?'selected':'')?>><?=$s['descripcion']?></option>
	    															<?php }?>
	    														</select>


	        												</td>
	      												</tr>
	      												<?php } ?>

	  													<tr>
	    													<th>Nombre Comercial</th>
	    													<td><input type="text" class="form-control" id="nombre_comercial" name="nombre_comercial" placeholder="Nombre Comercial" value="<?=$detalle[0]['nombre_comercial']?>" minlength="3" maxlength="200" required="required"></td>
	  													</tr> 
	  													
	  													<tr>
	    													<th>Contacto</th>
	    													<td> <?=$detalle[0]['contacto']?> </td>
	  													</tr>
	  													
	  													<tr>
	    													<th>RFC</th>
	    													<td><input type="text" class="form-control" id="info_rfc" name="info_rfc" placeholder="RFC" value="<?=$detalle[0]['info_rfc']?>" minlength="9" maxlength="13" required="required"></td>
	  													</tr>  
	  													
	  													<tr>
	    													<th>Tipo de Persona</th>
	    													<td>
	    														<select class="form-select" id="tipo_persona" name="tipo_persona" required>
	    															<option value="1" <?=(($detalle[0]['tipo_persona'] == 1)?'selected':'')?>>PERSONA FÍSICA</option>
	    															<option value="2" <?=(($detalle[0]['tipo_persona'] == 2)?'selected':'')?>>PERSONA MORAL</option>
	    														</select>
	    													</td>
	  													</tr> 
														
	      												<tr>
	        												<th> Nombre de la Razón Social </th>
	        												<td><input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razón Social" value="<?=$detalle[0]['razon_social']?>" minlength="3" maxlength="255" required="required"></td>
	      												</tr>

	      												<tr>
	        												<th> Representante Legal (Persona Moral) </th>
	        												<td><input type="text" class="form-control" id="representante_moral" name="representante_moral" placeholder="Representante Legal" value="<?=$detalle[0]['representante_moral']?>" minlength="0" maxlength="60"></td>
	      												</tr> 

	      												<tr>
	        												<th> Calle </th>
	        												<td> <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" value="<?=$detalle[0]['calle']?>" minlength="3" maxlength="120" required="required"> </td>
	      												</tr> 

	      												<tr>
	        												<th> Número Exterior </th>
	        												<td> <input type="text" class="form-control" id="numero" name="numero" placeholder="Número Exterior" value="<?=$detalle[0]['numero']?>" minlength="1" maxlength="10" required="required"> </td>
	      												</tr> 

	      												<tr>
	        												<th> Número Interior </th>
	        												<td> <input type="text" class="form-control" id="interior" name="interior" placeholder="Número Interior" value="<?=$detalle[0]['interior']?>" minlength="0" maxlength="5"> </td>
	      												</tr> 

	      												<tr>
	        												<th> Colonia </th>
	        												<td> <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Colonia" value="<?=$detalle[0]['colonia']?>" minlength="3" maxlength="50" required="required"> </td>
	      												</tr> 

	      												<tr>
	        												<th> Código Postal </th>
	        												<td> <input type="text" class="form-control" id="cp" name="cp" placeholder="Código Postal" value="<?=$detalle[0]['cp']?>" minlength="3" maxlength="10" required="required"> </td>
	      												</tr> 

	      												<tr>
	        												<th> Municipio </th>
	        												<td> 
	    														<select class="form-select" id="municipio" name="municipio" required>
	    															<?php foreach($municipios as $m){?>
	    															<option value="<?=$m['id_municipio']?>" <?=(($detalle[0]['municipio'] == $m['id_municipio'])?'selected':'')?>><?=$m['municipio']?></option>
	    															<?php }?>
	    														</select>


	        												</td>
	      												</tr>

														<tr>
	        												<th> Teléfono: </th>
	        												<td> <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" value="<?=$detalle[0]['telefono']?>" minlength="3" maxlength="200" required="required"> </td>
	      												</tr>

	      												<tr>
	        												<th> Correo Electrónico </th>
	        												<td> <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo Electrónico" value="<?=$detalle[0]['correo']?>" minlength="6" maxlength="120" required="required"> </td>
	      												</tr>
													
													</tbody>
													</table>
											</div>        
										</div>  
									</section>

									<section class="invoice table-participantes box" style="margin-bottom: 10px !important">  
											<div class="datos_generales">
											<div class="col-xs-12 table-responsive">
												<div class="panel-footer" style="text-align: justify;"> <h5><b> DESCRIPCIÓN </b></h5> <textarea class="form-control" minlength="10" maxlength="400" name="descripcion" id="descripcion" placeholder="Descripción"
												 required=""><?=$detalle[0]['descripcion']?></textarea>
													 </div>
											</div>
										</div>
									</section>
																			
								</div>																	
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
	        												<input type="file" class="form-control" id="rfc" name="rfc"><br>
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
	        												<input type="file" class="form-control" id="curp" name="curp"><br>
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
	        												<input type="file" class="form-control" id="ife" name="ife"><br>
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
	        												<input type="file" class="form-control" id="licencia_suelo" name="licencia_suelo"><br>
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
	        												<input type="file" class="form-control" id="escritura_publica" name="escritura_publica"><br> 
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
	        												<input type="file" class="form-control" id="acta_constitutiva" name="acta_constitutiva"><br>
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
	        												<input type="file" class="form-control" id="rfc_legal" name="rfc_legal"><br>
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
	        												<input type="file" class="form-control" id="domicilio" name="domicilio"><br>
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
	        												<input type="file" class="form-control" id="protocolo_higiene" name="protocolo_higiene"><br>
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
	        												<input type="file" class="form-control" id="carta_protesta" name="carta_protesta"><br>
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
	        												<input type="file" class="form-control" id="logo" name="logo"><br>
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
	        												<input type="file" class="form-control" id="imagen1" name="imagen1"><br>
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
	        												<input type="file" class="form-control" id="imagen2" name="imagen2"><br>
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
	        												<input type="file" class="form-control" id="imagen3" name="imagen3"><br>
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
	        												<input type="file" class="form-control" id="imagen_promocional" name="imagen_promocional"><br>
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

					</div>

					<div class="col-4"><a href="<?=BASE_URL?>paneladm/<?=$o_function?>" style="float:left" class="btn btn-primary"> Regresar </a></div> 

					<div class="col-4"><button style="float:left; margin-left:10px;" class="btn btn-success" type="submit"> Guardar Registro </button></div>

				</div>  					
			</div>
		</form>
	</div>

</div>
