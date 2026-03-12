<?php
namespace App\Controllers;

class Consulta_ciudadana extends BaseController {
	public function index()
	{	
		//$datos['giros'] = $this->web_model->get_giros();
		//$datos['municipios'] = $this->web_model->get_municipios();						

		$datos['result'] = $this->admin_model->get_data('vw_usr_datos', 'clave, lada, nombre_comercial, correo, calle, numero, colonia, municipio_nombre AS municipio, telefono, web, g_giro AS giro, icon_bs', ['visible' => 1, 'concluido' => 1, 'aprobado' => 1, 'giro <>' => 0, 'municipio <>' => 0], true, [], '', '', true);

    	echo view('consulta/directorio', $datos);
	}

	public function ver($_clave = '')
	{
		if($_clave == '')
		{
			return redirect()->to('consulta-ciudadana');
		}

		else
		{
			$datos['result'] = $this->admin_model->get_data('vw_usr_datos', 'clave, lada, nombre_comercial, correo, calle, numero, colonia, municipio_nombre AS municipio, telefono, web, g_giro AS giro, icon_bs', ['clave' => $_clave, 'visible' => 1, 'concluido' => 1, 'aprobado' => 1, 'giro <>' => 0, 'municipio <>' => 0], true, [], '', '', true);

       		echo view('consulta/directorio', $datos);
		}
	}

	public function buscador()
	{
		echo view('consulta/buscador');
	}

	public function buscar()
	{
		/*		
		$datos['result'] = $this->admin_model->get_data('vw_usr_datos', 'clave, lada, nombre_comercial, correo, calle, numero, colonia, municipio_nombre AS municipio, telefono, web, g_giro AS giro, icon_bs', ['nombre_comercial' => $criterio, 'visible' => 1, 'concluido' => 1, 'aprobado' => 1, 'giro <>' => 0, 'municipio <>' => 0], true, [], '', '', true);
		echo view('consulta/directorio', $datos);
		*/

		$criterio = htmlspecialchars($_POST["criterio"]);
		$builder = $this->db->table('ret_datos_generales');

		$builder->select('nombre_comercial, correo, web, lada, telefono');
		/*$builder->select('nombre_comercial, correo, municipio, giro');*/
		$builder->like('nombre_comercial', $criterio, 'both');
		$query = $builder->get();
		$resultados = $query->getResult();

		$html_resultado = '<table border="1">';
		foreach ( $resultados as $row ) {
				$html_resultado .= '<tr>';
				foreach ( $row as $registro ) {
					$html_resultado .= '<td>'.$registro.'</td>';
				}
				$html_resultado .= '</tr>';
		}
		$html_resultado .= '</table>';

		echo $html_resultado;		
		
		/*
		echo "<pre>";
		print_r($query->getResult());
		echo "</pre>";
		echo json_encode($query->getResult());
		*/
	}
}