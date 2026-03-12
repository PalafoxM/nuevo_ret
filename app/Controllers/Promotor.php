<?php
namespace App\Controllers;

class Promotor extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 4)
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

			$data['controller']		=		'promotor';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_promotor';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['select', '¿Cuenta con instalaciones públicas?', 'licencia', (($this->usuario_model->get($this->session->get('id'), 'licencia', 'ret_frm_promotores', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'licencia', 'ret_frm_promotores', 'clave'):((isset($valueFlashdata['licencia']))?$valueFlashdata['licencia']:'')), '', '', true, false, '', [
																																['value_id' => '0', 'value_name' => 'NO'],
																																['value_id' => '1', 'value_name' => 'SI'],
																															], 'required', '6'],
												['select', 'Tipo de área de Trabajo', 'zona', (($this->usuario_model->get($this->session->get('id'), 'zona', 'ret_frm_promotores', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'zona', 'ret_frm_promotores', 'clave'):((isset($valueFlashdata['zona']))?$valueFlashdata['zona']:'')), '', '', true, false, '', [
																																['value_id' => 'Establecimiento', 'value_name' => 'Establecimiento'],
																																['value_id' => 'Local', 'value_name' => 'Local'],
																																/*['value_id' => 'Aventura', 'value_name' => 'De Aventura'],*/
																																['value_id' => 'Caseta', 'value_name' => 'Caseta'],
																																['value_id' => 'Via', 'value_name' => 'Vía Pública'],
																															], 'required', '6'],
												['hr'],
												['select', '¿Cuenta con convenios de algún otro servicio?', 'convenio', (($this->usuario_model->get($this->session->get('id'), 'convenio', 'ret_frm_promotores', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'convenio', 'ret_frm_promotores', 'clave'):((isset($valueFlashdata['convenio']))?$valueFlashdata['convenio']:'')), '', '', true, false, '', [
																																['value_id' => '0', 'value_name' => 'NO'],
																																['value_id' => '1', 'value_name' => 'SI'],
																														], '','8'],
												['text', '¿Cuál convenio?', 'txt_convenio', (($this->usuario_model->get($this->session->get('id'), 'txt_convenio', 'ret_frm_promotores', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'txt_convenio', 'ret_frm_promotores', 'clave'):(($this->session->getFlashdata('txt_convenio'))?$this->session->getFlashdata('txt_convenio'):'')), '0', '100', false, false, 'En caso de contar con alguno', '', 'min_length[0]|max_length[50]','4'],
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