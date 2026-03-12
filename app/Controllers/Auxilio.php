<?php
namespace App\Controllers;

class Auxilio extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 11)
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

			$data['controller']		=		'auxilio';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_auxilio';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],

												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['texto', 'Seleccione los horarios en que opera', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Matutino', 'hora01', (($this->usuario_model->get($this->session->get('id'), 'hora01', 'ret_frm_auxturistico', 'clave') == 1)?'checked':((isset($valueFlashdata['hora01']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Vespertino', 'hora02', (($this->usuario_model->get($this->session->get('id'), 'hora02', 'ret_frm_auxturistico', 'clave') == 1)?'checked':((isset($valueFlashdata['hora02']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Diurno', 'hora03', (($this->usuario_model->get($this->session->get('id'), 'hora03', 'ret_frm_auxturistico', 'clave') == 1)?'checked':((isset($valueFlashdata['hora03']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Nocturno', 'hora04', (($this->usuario_model->get($this->session->get('id'), 'hora04', 'ret_frm_auxturistico', 'clave') == 1)?'checked':((isset($valueFlashdata['hora04']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['hr'],
												['text', 'Indicar el horario', 'horario', (($this->usuario_model->get($this->session->get('id'), 'horario', 'ret_frm_auxturistico', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'horario', 'ret_frm_auxturistico', 'clave'):(($this->session->getFlashdata('horario'))?$this->session->getFlashdata('horario'):'')), '0', '120', true, false, 'Horario', '', 'min_length[0]|max_length[120]','6'],
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