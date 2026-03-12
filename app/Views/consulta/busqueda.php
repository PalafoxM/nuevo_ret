<table id="tabla_contactos" class="display" style="width:100%">
<thead>
<tr>
   <th><b>NOMBRE</th><th><b>CORREO</th></tr>
</thead>
 <tbody>
<?php

foreach ($result as $row) {
    echo "<tr>";
    echo "<td>".$row['nombre_comercial']."<td>".$row['correo'];
}

?>
 </tbody>
</table>
<br><br><br><br>