<div class="container_ret mb-3">
	<div id="container">
		<h5 class="bg-primary" style="text-align: left; color: #FFF; border-bottom-right-radius:40px; border-top-right-radius:40px; padding: 14px 20px; font-family: 'Proxima Nova', 'Helvetica Neue', 'Helvetica', 'Arial', sans-serif; color:#FFF"><i class="bi bi-search"></i> CONSULTA CIUDADANA GUANAJUATO </h5>
		<br>

		<!--  LISTADO GENERAL DE PRESTADORES DE SERVICIOS -->
		<div class="row row-cols-1 row-cols-md-2 g-4">
			<?php foreach($result as $row): ?>
  			<div class="col">
				<div class="card bloq-provedor">
					<div class="card-header bgMarino bg-gradient text-white">
    						<h6> <i class="bi bi-<?php echo $row['icon_bs']; ?>"></i> <?php echo strtoupper($row['giro']); ?> </h6>
  					</div>

 					<ul class="list-group list-group-flush">
    						<li class="list-group-item" style="color:#FF8200"><i class="bi bi-qr-code"></i> <?php echo $row['clave']; ?> </li>
						<li class="list-group-item" style="color:blue"> <?php echo $row['nombre_comercial']; ?> </li> 
    						<li class="list-group-item"><i class="bi bi-geo-alt" style="color:#FF8200"></i> <?php echo ucfirst($row['calle']); echo " # "; echo $row['numero']; echo " Col. "; echo ucfirst($row['colonia']); ?></li>
    						<li class="list-group-item"><i class="bi bi-geo" style="color:#FF8200"></i> <?php echo $row['municipio']; ?></li>
    						<li class="list-group-item"><i class="bi bi-telephone" style="color:#FF8200"></i> <?php echo $row['lada']; echo $row['telefono']; ?></li>    						
    						<li class="list-group-item"><i class="bi bi-link-45deg" style="color:#FF8200"></i> <?php echo strtolower($row['web']); ?></li>
    						<li class="list-group-item"><i class="bi bi-envelope" style="color:#FF8200"></i> <?php echo strtolower($row['correo']); ?> </li>
  					</ul>
				</div>  		
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>