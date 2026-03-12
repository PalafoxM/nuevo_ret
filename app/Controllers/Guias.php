<?php
namespace App\Controllers;

class Guias extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 3)
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

			$data['controller']		=		'guias';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_guias';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['hr'],
												['texto', 'Seleccione los tipos de recorridos que ofrece', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Historia', 'tip_historia', (($this->usuario_model->get($this->session->get('id'), 'tip_historia', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['tip_historia']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Arte', 'tip_arte', (($this->usuario_model->get($this->session->get('id'), 'tip_arte', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['tip_arte']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Cultura', 'tip_cultura', (($this->usuario_model->get($this->session->get('id'), 'tip_cultura', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['tip_cultura']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Museos', 'tip_museos', (($this->usuario_model->get($this->session->get('id'), 'tip_museos', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['tip_museos']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Religiosos', 'tip_religiosos', (($this->usuario_model->get($this->session->get('id'), 'tip_religiosos', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['tip_religiosos']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Compras', 'tip_compras', (($this->usuario_model->get($this->session->get('id'), 'tip_compras', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['tip_compras']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'De aventura', 'tip_aventura', (($this->usuario_model->get($this->session->get('id'), 'tip_aventura', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['tip_aventura']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['bar', 'Acreditaciones', 'person-bounding-box', '', '', '', '', '', 'Si cuenta con alguna acreditación como Guía, proporcionar la siguiente información.'],
												['text', 'Número de credenciales como guía', 'num_credencial', (($this->usuario_model->get($this->session->get('id'), 'num_credencial', 'ret_frm_guia', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'num_credencial', 'ret_frm_guia', 'clave'):(($this->session->getFlashdata('num_credencial'))?$this->session->getFlashdata('num_credencial'):'')), '0', '50', true, false, 'Credenciales como guía', '', 'required|min_length[0]|max_length[50]','6'],
												['text', 'Asociación a la que pertenece', 'nombre_asociacion', (($this->usuario_model->get($this->session->get('id'), 'nombre_asociacion', 'ret_frm_guia', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'nombre_asociacion', 'ret_frm_guia', 'clave'):(($this->session->getFlashdata('nombre_asociacion'))?$this->session->getFlashdata('nombre_asociacion'):'')), '0', '10', false, false, 'Nombre de la asociación a la cual pertenece', '', 'min_length[0]|max_length[100]','6'],
												['bar', 'Idiomas', 'person-bounding-box', '', '', '', '', '', 'Seleccione los idiomas que domina el personal del establecimiento.'],
												['checkbox', 'Español', 'esp', (($this->usuario_model->get($this->session->get('id'), 'esp', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['esp']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Francés', 'fra', (($this->usuario_model->get($this->session->get('id'), 'fra', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['fra']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Inglés', 'eng', (($this->usuario_model->get($this->session->get('id'), 'eng', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['eng']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Italiano', 'ita', (($this->usuario_model->get($this->session->get('id'), 'ita', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['ita']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Alemán', 'ale', (($this->usuario_model->get($this->session->get('id'), 'ale', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['ale']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Coreano', 'cor', (($this->usuario_model->get($this->session->get('id'), 'cor', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['cor']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Portugués', 'por', (($this->usuario_model->get($this->session->get('id'), 'por', 'ret_frm_guia', 'clave') == 1)?'checked':((isset($valueFlashdata['por']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['text', 'Otro Idioma', 'otro_idioma', (($this->usuario_model->get($this->session->get('id'), 'otro_idioma', 'ret_frm_guia', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'otro_idioma', 'ret_frm_guia', 'clave'):(($this->session->getFlashdata('otro_idioma'))?$this->session->getFlashdata('otro_idioma'):'')), '0', '50', false, false, 'Otro idioma que dominen', '', 'min_length[0]|max_length[50]','6'],
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