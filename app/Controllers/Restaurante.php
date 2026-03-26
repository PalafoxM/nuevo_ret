<?php
namespace App\Controllers;

class Restaurante extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 5)
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

			$data['controller']		=		'restaurante';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_restaurante';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['select', '¿Cuenta con licencia de funcionamiento emitido por la Secretaría de Salud del Estado?', 'licencia', (($this->usuario_model->get($this->session->get('id'), 'licencia', 'ret_frm_restaurantes', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'licencia', 'ret_frm_restaurantes', 'clave'):((isset($valueFlashdata['licencia']))?$valueFlashdata['licencia']:'')), '', '', true, false, '', [
																																['value_id' => 'No', 'value_name' => 'NO'],
																																['value_id' => 'Si', 'value_name' => 'SI'],
																														], '','12'],
												['text', 'Número de Licencia', 'num_licencia', (($this->usuario_model->get($this->session->get('id'), 'num_licencia', 'ret_frm_restaurantes', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'num_licencia', 'ret_frm_restaurantes', 'clave'):(($this->session->getFlashdata('num_licencia'))?$this->session->getFlashdata('num_licencia'):'')), '0', '40', false, false, 'En caso de contar con licencia', '', 'min_length[0]|max_length[40]','12'],
												['select', '¿Cuenta con permisos municipales?', 'permiso', (($this->usuario_model->get($this->session->get('id'), 'permiso', 'ret_frm_restaurantes', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'permiso', 'ret_frm_restaurantes', 'clave'):((isset($valueFlashdata['permiso']))?$valueFlashdata['permiso']:'')), '', '', true, false, '', [
																																['value_id' => 'No', 'value_name' => 'NO'],
																																['value_id' => 'Si', 'value_name' => 'SI'],
																														], '','12'],
												['select', 'Seleccione el tipo de servicios', 'tipo_servicio', (($this->usuario_model->get($this->session->get('id'), 'tipo_servicio', 'ret_frm_restaurantes', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'tipo_servicio', 'ret_frm_restaurantes', 'clave'):((isset($valueFlashdata['tipo_servicio']))?$valueFlashdata['tipo_servicio']:'')), '', '', true, false, '', [
																																['value_id' => '0', 'value_name' => 'ALIMENTOS Y BEBIDAS'],
																																['value_id' => '1', 'value_name' => 'SOLO ALIMENTOS'],
																																['value_id' => '2', 'value_name' => 'SOLO BEBIDAS'],
																														], '','8'],
												['text', 'Número de Permiso de Bebidas', 'num_bebidas', (($this->usuario_model->get($this->session->get('id'), 'num_bebidas', 'ret_frm_restaurantes', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'num_bebidas', 'ret_frm_restaurantes', 'clave'):(($this->session->getFlashdata('num_bebidas'))?$this->session->getFlashdata('num_bebidas'):'')), '0', '40', false, false, 'En caso de contar con permiso', '', 'min_length[0]|max_length[40]','4'],
												['bar', 'Horarios y Capacidades', 'clock-fill', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['texto', 'Seleccione los horarios en que opera el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Matutino', 'hro_matutino', (($this->usuario_model->get($this->session->get('id'), 'hro_matutino', 'ret_frm_restaurantes', 'clave') == 1)?'checked':((isset($valueFlashdata['hro_matutino']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Vespertino', 'hro_vespertino', (($this->usuario_model->get($this->session->get('id'), 'hro_vespertino', 'ret_frm_restaurantes', 'clave') == 1)?'checked':((isset($valueFlashdata['hro_vespertino']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Diurno', 'hro_diurno', (($this->usuario_model->get($this->session->get('id'), 'hro_diurno', 'ret_frm_restaurantes', 'clave') == 1)?'checked':((isset($valueFlashdata['hro_diurno']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Nocturno', 'hro_nocturno', (($this->usuario_model->get($this->session->get('id'), 'hro_nocturno', 'ret_frm_restaurantes', 'clave') == 1)?'checked':((isset($valueFlashdata['hro_nocturno']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['hr'],
												['number', 'Número de Comensales Potenciales', 'num_potenciales', (($this->usuario_model->get($this->session->get('id'), 'num_potenciales', 'ret_frm_restaurantes', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'num_potenciales', 'ret_frm_restaurantes', 'clave'):((isset($valueFlashdata['num_potenciales']))?$valueFlashdata['num_potenciales']:'')), '1', '9999', true, false, 'Número de Comensales', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['number', 'Número de Mesas', 'num_mesas', (($this->usuario_model->get($this->session->get('id'), 'num_mesas', 'ret_frm_restaurantes', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'num_mesas', 'ret_frm_restaurantes', 'clave'):((isset($valueFlashdata['num_mesas']))?$valueFlashdata['num_mesas']:'')), '1', '9999', true, false, 'Número de Mesas', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['bar', 'Servicios', 'record-circle', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['texto', 'Seleccione el tipo de operación de servicios', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'A la mesa', 'op_mesa', (($this->usuario_model->get($this->session->get('id'), 'op_mesa', 'ret_frm_restaurantes', 'clave') == 1)?'checked':((isset($valueFlashdata['op_mesa']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Autoservicio', 'op_autoservicio', (($this->usuario_model->get($this->session->get('id'), 'op_autoservicio', 'ret_frm_restaurantes', 'clave') == 1)?'checked':((isset($valueFlashdata['op_autoservicio']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Buffete', 'op_buffete', (($this->usuario_model->get($this->session->get('id'), 'op_buffete', 'ret_frm_restaurantes', 'clave') == 1)?'checked':((isset($valueFlashdata['op_buffete']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'A la carta', 'op_alacarta', (($this->usuario_model->get($this->session->get('id'), 'op_alacarta', 'ret_frm_restaurantes', 'clave') == 1)?'checked':((isset($valueFlashdata['op_alacarta']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['hr'],
												['select', 'Tipo de Cocina que se ofrece', 'tipo_cocina', (($this->usuario_model->get($this->session->get('id'), 'tipo_cocina', 'ret_frm_restaurantes', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'tipo_cocina', 'ret_frm_restaurantes', 'clave'):((isset($valueFlashdata['tipo_cocina']))?$valueFlashdata['tipo_cocina']:'')), '', '', true, false, '', [
																																['value_id' => 'Mexicana', 'value_name' => 'Mexicana'],
																																['value_id' => 'Internacional', 'value_name' => 'Internacional'],
																																['value_id' => 'Italiana', 'value_name' => 'Italiana'],
																																['value_id' => 'Asiática', 'value_name' => 'Asiática'],
																																['value_id' => 'Carnes', 'value_name' => 'Carnes'],
																																['value_id' => 'Del_Mar', 'value_name' => 'Del Mar'],
																																['value_id' => 'Cocina_Verde', 'value_name' => 'Cocina Verde'],
																																['value_id' => 'Otros', 'value_name' => 'Otros'],
																														], ''],
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
