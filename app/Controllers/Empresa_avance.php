<?php
namespace App\Controllers;

class Empresa_avance extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			$porcentaje_registro = $this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');

			if($porcentaje_registro >= 0 && $porcentaje_registro <= 10)
				return redirect()->to('datos-generales');
			else if($porcentaje_registro >= 20 && $porcentaje_registro < 40)
				return redirect()->to('datos-tecnicos');
			else if($porcentaje_registro >= 40 && $porcentaje_registro < 60)
				return redirect()->to('datos-legales');
			else if($porcentaje_registro >= 60 && $porcentaje_registro < 80)
				return redirect()->to('imagenes');
			else if($porcentaje_registro >= 80 && $porcentaje_registro < 100)
				return redirect()->to('giro');
			else
				return redirect()->to('concluir-registro');
		}
		else if($this->session->get('api_logged'))
			if($this->usuario_model->get_list_by_email($this->session->get('email'), 'api'))
				return redirect()->to('panel');
			else
				return redirect()->to('registro/nuevo');
		else
			return redirect()->to('ingresar');
	}


} 