<?php
namespace App\Controllers;

class Arrendadora extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 9)
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

			$data['controller']		=		'arrendadora';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_arrendadora';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],

												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['texto', 'Tipo de Permiso / Concesión', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Municipal', 'perm1', (($this->usuario_model->get($this->session->get('id'), 'perm1', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['perm1']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Estatal', 'perm2', (($this->usuario_model->get($this->session->get('id'), 'perm2', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['perm2']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Federal', 'perm3', (($this->usuario_model->get($this->session->get('id'), 'perm3', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['perm3']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['hr'],
												['number', 'Número de Unidades', 'novehiculos', (($this->usuario_model->get($this->session->get('id'), 'novehiculos', 'ret_frm_arrendadora', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'novehiculos', 'ret_frm_arrendadora', 'clave'):((isset($valueFlashdata['novehiculos']))?$valueFlashdata['novehiculos']:'')), '1', '9999999', true, false, 'Número de Unidades', '', 'required|min_length[1]|max_length[7]|numeric', '6'],
												['text', 'Tipo de unidades', 'tipovehiculos', (($this->usuario_model->get($this->session->get('id'), 'tipovehiculos', 'ret_frm_arrendadora', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'tipovehiculos', 'ret_frm_arrendadora', 'clave'):(($this->session->getFlashdata('tipovehiculos'))?$this->session->getFlashdata('tipovehiculos'):'')), '0', '120', true, false, 'Tipo de unidades', '', 'min_length[0]|max_length[120]','6'],
												['text', 'Capacidad de unidades', 'capavehiculos', (($this->usuario_model->get($this->session->get('id'), 'capavehiculos', 'ret_frm_arrendadora', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'capavehiculos', 'ret_frm_arrendadora', 'clave'):(($this->session->getFlashdata('capavehiculos'))?$this->session->getFlashdata('capavehiculos'):'')), '0', '120', true, false, 'Capacidad de unidades', '', 'min_length[0]|max_length[120]','6'],
												['bar', 'Servicios', 'record-circle', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['texto', 'Seleccione las características del servicio que ofrece el establecimiento', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Aire Acondicionado', 'caract1', (($this->usuario_model->get($this->session->get('id'), 'caract1', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract1']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Cafetería a Bordo', 'caract2', (($this->usuario_model->get($this->session->get('id'), 'caract2', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract2']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Servicio de Edecanes', 'caract3', (($this->usuario_model->get($this->session->get('id'), 'caract3', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract3']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Primeros Auxilios', 'caract4', (($this->usuario_model->get($this->session->get('id'), 'caract4', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract4']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Transporte de Equipo Especial', 'caract5', (($this->usuario_model->get($this->session->get('id'), 'caract5', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract5']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Bar a Bordo', 'caract6', (($this->usuario_model->get($this->session->get('id'), 'caract6', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract6']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Restaurante a Bordo', 'caract7', (($this->usuario_model->get($this->session->get('id'), 'caract7', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract7']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Tours Guiados', 'caract8', (($this->usuario_model->get($this->session->get('id'), 'caract8', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract8']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Guía', 'caract9', (($this->usuario_model->get($this->session->get('id'), 'caract9', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract9']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Paquetes Promocionales', 'caract10', (($this->usuario_model->get($this->session->get('id'), 'caract10', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract10']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Abordaje a Domicilio', 'caract11', (($this->usuario_model->get($this->session->get('id'), 'caract11', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract11']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Salón VIP', 'caract12', (($this->usuario_model->get($this->session->get('id'), 'caract12', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract12']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Transporte de Menaje', 'caract13', (($this->usuario_model->get($this->session->get('id'), 'caract13', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract13']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Transporte de Vehículos', 'caract14', (($this->usuario_model->get($this->session->get('id'), 'caract14', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['caract14']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['hr'],
												['texto', 'Modalidad', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Vuelos Comerciales', 'mod01', (($this->usuario_model->get($this->session->get('id'), 'mod01', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['mod01']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Vuelos Charters', 'mod02', (($this->usuario_model->get($this->session->get('id'), 'mod02', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['mod02']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Autobuses Comerciales', 'mod03', (($this->usuario_model->get($this->session->get('id'), 'mod03', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['mod03']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Autobuses Especiales de Turismo', 'mod04', (($this->usuario_model->get($this->session->get('id'), 'mod04', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['mod04']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Taxis', 'mod05', (($this->usuario_model->get($this->session->get('id'), 'mod05', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['mod05']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['hr'],
												['texto', 'Modalidad', '', '', '', '', '', '', '', '', ''],
												['checkbox', 'Automóviles', 'serv01', (($this->usuario_model->get($this->session->get('id'), 'serv01', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv01']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Bicicletas y Motocicletas', 'serv02', (($this->usuario_model->get($this->session->get('id'), 'serv02', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv02']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Combis y Vans', 'serv03', (($this->usuario_model->get($this->session->get('id'), 'serv03', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv03']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Limousines', 'serv04', (($this->usuario_model->get($this->session->get('id'), 'serv04', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv04']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Autobuses', 'serv05', (($this->usuario_model->get($this->session->get('id'), 'serv05', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv05']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Campers', 'serv06', (($this->usuario_model->get($this->session->get('id'), 'serv06', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv06']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Vehículos para Carretera', 'serv07', (($this->usuario_model->get($this->session->get('id'), 'serv07', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv07']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Motocicletas', 'serv08', (($this->usuario_model->get($this->session->get('id'), 'serv08', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv08']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Bicicletas', 'serv09', (($this->usuario_model->get($this->session->get('id'), 'serv09', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv09']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Aviones', 'serv10', (($this->usuario_model->get($this->session->get('id'), 'serv10', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv10']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Ultraligeros', 'serv11', (($this->usuario_model->get($this->session->get('id'), 'serv11', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv11']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Planeadores', 'serv12', (($this->usuario_model->get($this->session->get('id'), 'serv12', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['serv12']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['bar', 'Formas de Pago', 'credit-card', '', '', '', '', '', ''],
												['checkbox', 'American Express', 'tc01', (($this->usuario_model->get($this->session->get('id'), 'tc01', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['tc01']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Visa', 'tc02', (($this->usuario_model->get($this->session->get('id'), 'tc02', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['tc02']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Master Card', 'tc03', (($this->usuario_model->get($this->session->get('id'), 'tc03', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['tc03']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Efectivo', 'tc04', (($this->usuario_model->get($this->session->get('id'), 'tc04', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['tc04']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Cheque de Viajero', 'tc05', (($this->usuario_model->get($this->session->get('id'), 'tc05', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['tc05']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Otra', 'tc06', (($this->usuario_model->get($this->session->get('id'), 'tc06', 'ret_frm_arrendadora', 'clave') == 1)?'checked':((isset($valueFlashdata['tc06']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['text', 'Otra, ¿Cuál?', 'otra_tc', (($this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_arrendadora', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'otra_tc', 'ret_frm_arrendadora', 'clave'):(($this->session->getFlashdata('otra_tc'))?$this->session->getFlashdata('otra_tc'):'')), '0', '120', false, false, 'Otra, ¿Cuál?', '', 'min_length[0]|max_length[120]','3'],
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