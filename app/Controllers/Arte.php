<?php
namespace App\Controllers;

class Arte extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 7)
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
												BASE_URL.STATIC_CSS.'registro.css?v=1.1',
												BASE_URL.STATIC_CSS.'form.css',
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

			$data['controller']		=		'arte';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_arte';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],

												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['texto', 'Seleccione el tipo de establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Establecimiento de dulces típicos', 'tipo1', (($this->usuario_model->get($this->session->get('id'), 'tipo1', 'ret_frm_arte', 'clave') == 1)?'checked':((isset($valueFlashdata['tipo1']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['checkbox', 'Galerías de arte y salas de exhibición', 'tipo2', (($this->usuario_model->get($this->session->get('id'), 'tipo2', 'ret_frm_arte', 'clave') == 1)?'checked':((isset($valueFlashdata['tipo2']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['checkbox', 'Establecimiento de artesanías', 'tipo3', (($this->usuario_model->get($this->session->get('id'), 'tipo3', 'ret_frm_arte', 'clave') == 1)?'checked':((isset($valueFlashdata['tipo3']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['checkbox', 'Establecimiento de productos típicos', 'tipo4', (($this->usuario_model->get($this->session->get('id'), 'tipo4', 'ret_frm_arte', 'clave') == 1)?'checked':((isset($valueFlashdata['tipo4']))?'checked':'')), '', '', false, false, '', '', '','6'],
												['hr'],
												['textarea', 'Descripción del tipo de arte, dulces o productos típicos y/o artesanías', 'descripcion', (($this->usuario_model->get($this->session->get('id'), 'descripcion', 'ret_frm_arte', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'descripcion', 'ret_frm_arte', 'clave'):(($this->session->getFlashdata('descripcion'))?$this->session->getFlashdata('descripcion'):'')), '10', '500', true, false, 'Descripción del tipo de arte, dulces o productos típicos y/o artesanías', '', 'required'],
												['select', 'Tipo de operación', 'operacion', (($this->usuario_model->get($this->session->get('id'), 'operacion', 'ret_frm_arte', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'operacion', 'ret_frm_arte', 'clave'):((isset($valueFlashdata['operacion']))?$valueFlashdata['operacion']:'')), '', '', true, false, '', [
																																['value_id' => 'Temporal', 'value_name' => 'Temporal'],
																																['value_id' => 'Permanentes', 'value_name' => 'Permanentes'],
																														], 'required'],
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