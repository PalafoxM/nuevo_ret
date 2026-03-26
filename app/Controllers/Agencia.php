<?php
namespace App\Controllers;

class Agencia extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 2)
				return redirect()->to('datos-generales');
			if($this->usuario_model->get($this->session->get('id'), 'porcentaje_registro') < 60 || $this->usuario_model->get($this->session->get('id'), 'concluido') == 1)
				return redirect()->to('empresa-avance');

			$data['title']				=		'Registro Estatal de Turismo | '.$this->session->get('g_resumen');
			$data['head_js']			=	array(
												BASE_URL.STATIC_JS.'jquery.min-3.3.1.js',
												BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js',
											);
			$data['head_css']			=	array(
												BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
												BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
												BASE_URL.STATIC_CSS.'header.css',
												BASE_URL.STATIC_CSS.'registro.css?v=2.2',
												BASE_URL.STATIC_CSS.'form.css?v=2.0',
												BASE_URL.STATIC_CSS.'footer.css?v=1.1',
												BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
											);
			$data['footer_js']			=	array(
												BASE_URL.STATIC_JS.'form-validation.js',
											);

			$valueFlashdata 		= 		[];
			if($this->session->getFlashdata('values'))
				$valueFlashdata 	= 		$this->session->getFlashdata('values');

			$data['nav']			=		'private/nav';
			$data['header']			=		'private/header';
			$data['main']			=		'private/form_template';
			$data['footer']			=		'public/footer';

			$data['controller']		=		'agencia';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_agencia';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['select', 'Segmento de Mercado', 'segmento', (($this->usuario_model->get($this->session->get('id'), 'segmento', 'ret_frm_agencia', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'segmento', 'ret_frm_agencia', 'clave'):((isset($valueFlashdata['segmento']))?$valueFlashdata['segmento']:'')), '', '', false, false, '', [
																																['value_id' => 'Reuniones', 'value_name' => 'Reuniones'],
																																['value_id' => 'Historia y Cultura', 'value_name' => 'Historia y Cultura'],
																																['value_id' => 'Aventura y Naturaleza', 'value_name' => 'Aventura y Naturaleza'],
																																['value_id' => 'Turismo de Negocios', 'value_name' => 'Turismo de Negocios'],
																																['value_id' => 'Turismo Deportivo', 'value_name' => 'Turismo Deportivo'],
																																['value_id' => 'Turismo Cultural', 'value_name' => 'Turismo Cultural'],
																																['value_id' => 'Religioso', 'value_name' => 'Religioso'],
																																['value_id' => 'Gastronómico', 'value_name' => 'Gastronómico'],
																																['value_id' => 'Arqueológico', 'value_name' => 'Arqueológico'],
																																['value_id' => 'Salud', 'value_name' => 'Salud'],
																																['value_id' => 'Rural', 'value_name' => 'Rural'],
																															], '','6'],
												['bar', 'Asociaciones', 'union', '', '', '', '', '', ''],
												['select', '¿Pertenece a alguna asociación?', 'asociacion', (($this->usuario_model->get($this->session->get('id'), 'asociacion', 'ret_frm_agencia', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'asociacion', 'ret_frm_agencia', 'clave'):((isset($valueFlashdata['asociacion']))?$valueFlashdata['asociacion']:'')), '', '', true, false, '', [
																																['value_id' => '0', 'value_name' => 'NO'],
																																['value_id' => '1', 'value_name' => 'SI'],
																														], '','6'],
												['text', '¿Cuál asociación?', 'nombre_asociacion', (($this->usuario_model->get($this->session->get('id'), 'nombre_asociacion', 'ret_frm_agencia', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'nombre_asociacion', 'ret_frm_agencia', 'clave'):(($this->session->getFlashdata('nombre_asociacion'))?$this->session->getFlashdata('nombre_asociacion'):'')), '0', '100', false, false, 'En caso de pertenecer a alguna', '', 'min_length[0]|max_length[100]','6'],
												['hr'],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
											];


			return view('template', $data);
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
