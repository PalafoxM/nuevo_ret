<div id="container">
<center>Buscador RET</center>
	<div id="body">
		<form action="" method="post" class="form">
			<input style="background-color: " type="text" name="Busqueda RET">
			<input style="background-color: " type="submit" value="Buscar">
		</form>
		<br>
		<br>
		<table class="Datosbusqueda">
			<thead>
				<tr>
					<th>Clave</th>
					<th>Nombre_comercial</th>
					<th>Correo</th>
					<th>Web</th>
					<th>Lada</th>
					<th>Telefono</th>
					<th>Municipio</th>
					<th>Giro</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($ret_datos_generales as $datos): ?>
				<tr>
					<td>clave</td>
					<td>nombre_comercial</td>
					<td>correo</td>
					<td>web</td>
					<td>lada</td>
					<td>telefono</td>
					<td>municipio</td>
					<td>giro</td>
			    	</tr>
				<?php endforeach ?>
			</tbody>
			
		</table>

	</div>
</div>