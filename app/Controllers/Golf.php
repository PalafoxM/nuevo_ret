<?php
namespace App\Controllers;

class Golf extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 6)
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

			$data['controller']		=		'golf';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_golf';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],

												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['select', 'El campo es', 'turistico', (($this->usuario_model->get($this->session->get('id'), 'turistico', 'ret_frm_golf', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'turistico', 'ret_frm_golf', 'clave'):((isset($valueFlashdata['turistico']))?$valueFlashdata['turistico']:'')), '', '', true, false, '', [
																																['value_id' => 'privado', 'value_name' => 'Privado'],
																																['value_id' => 'publico', 'value_name' => 'Público'],
																															], 'required','6'],
												['number', 'Número de Hoyos', 'hoyos', (($this->usuario_model->get($this->session->get('id'), 'hoyos', 'ret_frm_golf', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'hoyos', 'ret_frm_golf', 'clave'):((isset($valueFlashdata['hoyos']))?$valueFlashdata['hoyos']:'')), '1', '9999', true, false, 'Número de Hoyos', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['text', 'Par', 'par', (($this->usuario_model->get($this->session->get('id'), 'par', 'ret_frm_golf', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'par', 'ret_frm_golf', 'clave'):(($this->session->getFlashdata('par'))?$this->session->getFlashdata('par'):'')), '0', '10', true, false, 'Par', '', 'required|min_length[0]|max_length[10]','6'],
												['number', 'Longitud en Yardas', 'longitud', (($this->usuario_model->get($this->session->get('id'), 'longitud', 'ret_frm_golf', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'longitud', 'ret_frm_golf', 'clave'):((isset($valueFlashdata['longitud']))?$valueFlashdata['longitud']:'')), '1', '9999', true, false, 'Longitud en Yardas', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['select', 'Uso obligatorio de carrito', 'carrito', (($this->usuario_model->get($this->session->get('id'), 'carrito', 'ret_frm_golf', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'carrito', 'ret_frm_golf', 'clave'):((isset($valueFlashdata['carrito']))?$valueFlashdata['carrito']:'')), '', '', false, false, '', [
																																['value_id' => 'No', 'value_name' => 'NO'],
																																['value_id' => 'Si', 'value_name' => 'SI'],
																														], '','6'],
												['select', 'Privado con facilidades', 'privado', (($this->usuario_model->get($this->session->get('id'), 'privado', 'ret_frm_golf', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'privado', 'ret_frm_golf', 'clave'):((isset($valueFlashdata['privado']))?$valueFlashdata['privado']:'')), '', '', false, false, '', [
																																['value_id' => 'No', 'value_name' => 'NO'],
																																['value_id' => 'Si', 'value_name' => 'SI'],
																														], '','6'],
												['hr'],
												['texto', 'Seleccione el tipo de campo', '', '', '', '', '', '', '', '', '', '3'],
												['checkbox', 'Plano', 'plano', (($this->usuario_model->get($this->session->get('id'), 'plano', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['plano']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Semiplano', 'semiplano', (($this->usuario_model->get($this->session->get('id'), 'semiplano', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['semiplano']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Ondulado', 'ondulado', (($this->usuario_model->get($this->session->get('id'), 'ondulado', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['ondulado']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['hr'],
												['text', 'Diseñador del campo', 'disenado', (($this->usuario_model->get($this->session->get('id'), 'disenado', 'ret_frm_golf', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'disenado', 'ret_frm_golf', 'clave'):(($this->session->getFlashdata('disenado'))?$this->session->getFlashdata('disenado'):'')), '0', '120', false, false, 'Diseñador del campo', '', 'min_length[0]|max_length[120]'],
												['text', 'Tipo de pasto (Fairways)', 'fairways', (($this->usuario_model->get($this->session->get('id'), 'fairways', 'ret_frm_golf', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'fairways', 'ret_frm_golf', 'clave'):(($this->session->getFlashdata('fairways'))?$this->session->getFlashdata('fairways'):'')), '0', '120', false, false, 'Fairways', '', 'min_length[0]|max_length[120]', '6'],
												['text', 'Tipo de pasto (Greens)', 'greens', (($this->usuario_model->get($this->session->get('id'), 'greens', 'ret_frm_golf', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'greens', 'ret_frm_golf', 'clave'):(($this->session->getFlashdata('greens'))?$this->session->getFlashdata('greens'):'')), '0', '120', false, false, 'Greens', '', 'min_length[0]|max_length[120]', '6'],
												['bar', 'Servicios', 'record-circle', '', '', '', '', '', 'Seleccione los servicios adicionales que ofrece el establecimiento.'],
												['checkbox', 'Casa Club', 'serv01', (($this->usuario_model->get($this->session->get('id'), 'serv01', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['serv01']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Putting Green', 'serv02', (($this->usuario_model->get($this->session->get('id'), 'serv02', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['serv02']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Marcas de Yardas', 'serv03', (($this->usuario_model->get($this->session->get('id'), 'serv03', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['serv03']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Clases de Golf', 'serv04', (($this->usuario_model->get($this->session->get('id'), 'serv04', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['serv04']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Restaurante', 'serv05', (($this->usuario_model->get($this->session->get('id'), 'serv05', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['serv05']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Reservación de Salidas', 'serv06', (($this->usuario_model->get($this->session->get('id'), 'serv06', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['serv06']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Teen de Práctica', 'serv07', (($this->usuario_model->get($this->session->get('id'), 'serv07', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['serv07']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Renta de Autos', 'serv08', (($this->usuario_model->get($this->session->get('id'), 'serv08', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['serv08']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Tienda Profesional', 'serv09', (($this->usuario_model->get($this->session->get('id'), 'serv09', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['serv09']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['bar', 'Formas de Pago', 'credit-card', '', '', '', '', '', ''],
												['checkbox', 'American Express', 'tc01', (($this->usuario_model->get($this->session->get('id'), 'tc01', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['tc01']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Visa', 'tc02', (($this->usuario_model->get($this->session->get('id'), 'tc02', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['tc02']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Master Card', 'tc03', (($this->usuario_model->get($this->session->get('id'), 'tc03', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['tc03']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Efectivo', 'tc04', (($this->usuario_model->get($this->session->get('id'), 'tc04', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['tc04']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Cheque de Viajero', 'tc05', (($this->usuario_model->get($this->session->get('id'), 'tc05', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['tc05']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Otra', 'tc06', (($this->usuario_model->get($this->session->get('id'), 'tc06', 'ret_frm_golf', 'clave') == 1)?'checked':((isset($valueFlashdata['tc06']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['text', 'Otra, ¿Cuál?', 'otra_tc', (($this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_golf', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_golf', 'clave'):(($this->session->getFlashdata('otra_tc'))?$this->session->getFlashdata('otra_tc'):'')), '0', '120', false, false, 'Otra, ¿Cuál?', '', 'min_length[0]|max_length[120]','3'],
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
