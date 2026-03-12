<div class="container_ret mb-3">
	<div id="container">
		<div id="search-box" style="background-color: #00b5d4; border-radius:10px; padding: 12px 45px 40px 45px; font-family: 'Baloo', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; color:#FFF">
		    <h1 class="text-center mt-4">
		        <i class="bi bi-search"></i> Consulta Ciudadana del Estado de Guanajuato
		    </h1>
		    <form class="mt-4 text-center" action="<?=BASE_URL?>consulta-ciudadana" method="post">
		        <div class="row justify-content-center">
		            <div class="col-md-2">
		                <div class="form-group">
		                    <label for="service">
		                        <i class="bi bi-shop"></i> Nombre comercial
		                    </label>
		                    <input type="text" class="form-control" id="service" name="service" value="<?=$busqueda['service']?>">
		                </div>
		            </div>
		            <div class="col-md-2">
		                <div class="form-group">
		                    <label for="category">
		                        <i class="bi bi-briefcase"></i> Giro
		                    </label>
		                    <select class="form-control" id="category" name="category">
		                        <option value="0">Cualquiera</option>
		                    	<?php
		                    	if(isset($giros))
		                    		foreach($giros as $g) { ?>
		                        <option value="<?=$g['id_giro']?>"<?=(($busqueda['category'] == $g['id_giro'])?' selected':'')?>><?=$g['giro']?></option>
		                        <?php }?>
		                    </select>
		                </div>
		            </div>
		            <div class="col-md-2">
		                <div class="form-group">
		                    <label for="city">
		                        <i class="bi bi-geo-alt"></i> Municipio
		                    </label>
		                    <select class="form-control" id="city" name="city">
		                        <option value="0">Cualquiera</option>
		                    	<?php
		                    	if(isset($municipios))
		                    		foreach($municipios as $m) { ?>
		                        <option value="<?=$m['id_municipio']?>"<?=(($busqueda['city'] == $m['id_municipio'])?' selected':'')?>><?=$m['municipio']?></option>
		                        <?php }?>
		                    </select>
		                </div>
		            </div>

					<div class="col-md-2">
					    <div class="form-check form-switch">
					        <label class="form-check-label" for="dist_h">Distintivo H</label>
					        <input class="form-check-input" type="checkbox" id="dist_h" name="dist_h"<?=(($busqueda['dist_h'] == 1)?' checked':'')?>>
					        <label class="form-check-label" for="tesoros">Tesoros de Guanajuato</label>
					        <input class="form-check-input" type="checkbox" id="tesoros" name="tesoros"<?=(($busqueda['tesoros'] == 1)?' checked':'')?>>
					        <label class="form-check-label" for="iso">Certificado ISO</label>
					        <input class="form-check-input" type="checkbox" id="iso" name="iso"<?=(($busqueda['iso'] == 1)?' checked':'')?>>
					        <label class="form-check-label" for="dist_m">Distintivo M</label>
					        <input class="form-check-input" type="checkbox" id="dist_m" name="dist_m"<?=(($busqueda['dist_m'] == 1)?' checked':'')?>>
					    </div>
					</div>

					<div class="col-md-2">
					    <div class="form-check form-switch">
					        <label class="form-check-label" for="punto_limpio">Punto Limpio</label>
					        <input class="form-check-input" type="checkbox" id="punto_limpio" name="punto_limpio"<?=(($busqueda['punto_limpio'] == 1)?' checked':'')?>>
					        <label class="form-check-label" for="anfitrion">Gran Anfitrión</label>
					        <input class="form-check-input" type="checkbox" id="anfitrion" name="anfitrion"<?=(($busqueda['anfitrion'] == 1)?' checked':'')?>>
					        <label class="form-check-label" for="competencia">Estándares de Competencia Laboral</label>
					        <input class="form-check-input" type="checkbox" id="competencia" name="competencia"<?=(($busqueda['competencia'] == 1)?' checked':'')?>>
					    </div>
					</div>

		            <div class="col-md-2">
		                <button type="submit" class="btn btn-primary mt-4" style="background-color: #004a8b; color: #fff;">
		                    <i class="bi bi-search"></i> Buscar
		                </button>
		            </div>
		        </div>
		    </form>
		</div>



		<br>

	    <div id="data-container" class="row row-cols-1 row-cols-md-2 g-4">

	    </div>
	    <div id="loader" style="display: none;">
	        <img src="<?=BASE_URL?>static/images/spinner.gif" class="mx-auto d-block" alt="Cargando...">
	    </div>
	</div>
</div>