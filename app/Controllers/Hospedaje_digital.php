<?php
namespace App\Controllers;

class Hospedaje_digital extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->session->get('giro') != 17)
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

			$data['controller']		=		'hospedaje-digital';
			$data['next_cont']		=		'concluir-registro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Formulario de '.$this->session->get('g_resumen');
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_hospedaje_digital';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'imagenes', '50', '', 'light', '', ''],
												['button', '<i class="bi-send icon-bar"></i> Concluir Registro', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Concluir Registro', '', 'success', '', '', false, false, ''],
												['bar', $this->session->get('g_resumen'), $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['hidden', 'porcentaje_registro', 'porcentaje_registro', '100', '1', '2', false, true, 'porcentaje_registro'],
												['select', 'Tipo de Alojamiento', 'categoria', (($this->usuario_model->get($this->session->get('id'), 'categoria', 'ret_frm_hospedaje-digitales', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'categoria', 'ret_frm_hospedaje-digitales', 'clave'):((isset($valueFlashdata['categoria']))?$valueFlashdata['categoria']:'')), '', '', true, false, '', [
																																['value_id' => '0', 'value_name' => 'Departamento'],
																																['value_id' => '1', 'value_name' => 'Casa'],
																																['value_id' => '2', 'value_name' => 'Vivienda Anexa'],
																																['value_id' => '3', 'value_name' => 'Hotel'],
																															], 'required','6'],
												['select', 'Alojamiento que se ofrece', 'establecimiento', (($this->usuario_model->get($this->session->get('id'), 'establecimiento', 'ret_frm_hospedaje-digitales', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'establecimiento', 'ret_frm_hospedaje-digitales', 'clave'):((isset($valueFlashdata['establecimiento']))?$valueFlashdata['establecimiento']:'')), '', '', true, false, '', [
																																['value_id' => 'Alojamiento Completo', 'value_name' => 'Alojamiento Completo'],
																																['value_id' => 'Habitación Privada', 'value_name' => 'Habitación Privada'],
																																['value_id' => 'Habitación Compartida', 'value_name' => 'Habitación Compartida'],
																															], 'required','6'],
												['number', 'Número de Habitaciones', 'cuartos', (($this->usuario_model->get($this->session->get('id'), 'cuartos', 'ret_frm_hospedaje-digitales', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'cuartos', 'ret_frm_hospedaje-digitales', 'clave'):((isset($valueFlashdata['cuartos']))?$valueFlashdata['cuartos']:'')), '0', '999', true, false, 'Número de Habitaciones', '', 'required|min_length[1]|max_length[3]|numeric', '6'],
												['number', 'Número de camas que pueden utilizar los huéspedes', 'pisos', (($this->usuario_model->get($this->session->get('id'), 'pisos', 'ret_frm_hospedaje-digitales', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'pisos', 'ret_frm_hospedaje-digitales', 'clave'):((isset($valueFlashdata['pisos']))?$valueFlashdata['pisos']:'')), '0', '99', true, false, 'Número de camas que pueden utilizar los huéspedes', '', 'required|min_length[1]|max_length[2]|numeric', '6'],
												


												//Propuesta Original
												['bar', 'Plataformas Digitales', 'award', '', '', '', '', '', 'Seleccione las Plataformas Digitales en las que a registrado el establecimiento.'],
												['checkbox', 'AirBnB', 'airbnb', (($this->usuario_model->get($this->session->get('id'), 'airbnb', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['airbnb']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Kayak', 'kayak', (($this->usuario_model->get($this->session->get('id'), 'kayak', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['kayak']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Booking', 'booking', (($this->usuario_model->get($this->session->get('id'), 'booking', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['booking']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tripadvisor', 'tripadvisor', (($this->usuario_model->get($this->session->get('id'), 'tripadvisor', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['tripadvisor']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Trivago', 'trivago', (($this->usuario_model->get($this->session->get('id'), 'trivago', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['trivago']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Otra', 'otrap', (($this->usuario_model->get($this->session->get('id'), 'otrap', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['otrap']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['text', 'Otra, ¿Cuál?', 'otradigital', (($this->usuario_model->get($this->session->get('id'), 'otradigital', 'ret_frm_hospedaje-digitales', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'otradigital', 'ret_frm_hospedaje-digitales', 'clave'):(($this->session->getFlashdata('otradigital'))?$this->session->getFlashdata('otradigital'):'')), '0', '50', false, false, 'Otra, ¿Cuál?', '', 'min_length[0]|max_length[50]','4'],
												
												

												['bar', 'Servicio en las Habitaciones', 'door-closed', '', '', '', '', '', 'Seleccione los servicios con los que cuentan las habitaciones del establecimiento.'],
												['checkbox', 'Cocineta', 'cocineta', (($this->usuario_model->get($this->session->get('id'), 'cocineta', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['cocineta']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Televisión', 'tv', (($this->usuario_model->get($this->session->get('id'), 'tv', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['tv']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Caja Fuerte', 'cajafuerte', (($this->usuario_model->get($this->session->get('id'), 'cajafuerte', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['cajafuerte']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Cocineta Parcial', 'cocinetaparcial', (($this->usuario_model->get($this->session->get('id'), 'cocinetaparcial', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['cocinetaparcial']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Cable', 'cable', (($this->usuario_model->get($this->session->get('id'), 'cable', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['cable']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Jacuzzi', 'jacuzzi', (($this->usuario_model->get($this->session->get('id'), 'jacuzzi', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['jacuzzi']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Aire Acondicionado', 'aireacondicionado', (($this->usuario_model->get($this->session->get('id'), 'aireacondicionado', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['aireacondicionado']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Teléfono', 'telefono', (($this->usuario_model->get($this->session->get('id'), 'telefono', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['telefono']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Agua Caliente', 'aguacaliente', (($this->usuario_model->get($this->session->get('id'), 'aguacaliente', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['aguacaliente']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Ventilador', 'ventilador', (($this->usuario_model->get($this->session->get('id'), 'ventilador', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['ventilador']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['checkbox', 'Minibar', 'minibar', (($this->usuario_model->get($this->session->get('id'), 'minibar', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['minibar']))?'checked':'')), '', '', false, false, '', '', '','3'],
												['bar', 'Servicios Comunes', 'record-circle', '', '', '', '', '', 'Seleccione los servicios comunes con los que cuenta el establecimiento.'],
												['checkbox', 'Cafetería', 'cafeteria', (($this->usuario_model->get($this->session->get('id'), 'cafeteria', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['cafeteria']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Bar', 'bar', (($this->usuario_model->get($this->session->get('id'), 'bar', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['bar']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Acceso para personas con capacidades diferentes', 'acceso', (($this->usuario_model->get($this->session->get('id'), 'acceso', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['acceso']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Restaurante', 'restaurante', (($this->usuario_model->get($this->session->get('id'), 'restaurante', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['restaurante']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Boutique', 'boutique', (($this->usuario_model->get($this->session->get('id'), 'boutique', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['boutique']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Agencia de Viajes', 'agencia', (($this->usuario_model->get($this->session->get('id'), 'agencia', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['agencia']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Cocina Industrial', 'cocinaindustrial', (($this->usuario_model->get($this->session->get('id'), 'cocinaindustrial', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['cocinaindustrial']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Regalos', 'regalo', (($this->usuario_model->get($this->session->get('id'), 'regalo', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['regalo']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Spa', 'spa', (($this->usuario_model->get($this->session->get('id'), 'spa', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['spa']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Banquetes y Convenciones', 'banquete', (($this->usuario_model->get($this->session->get('id'), 'banquete', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['banquete']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tabaquería', 'tabaqueria', (($this->usuario_model->get($this->session->get('id'), 'tabaqueria', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['tabaqueria']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Room Service', 'room', (($this->usuario_model->get($this->session->get('id'), 'room', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['room']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Salones de Eventos', 'salon', (($this->usuario_model->get($this->session->get('id'), 'salon', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['salon']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Internet', 'internet', (($this->usuario_model->get($this->session->get('id'), 'internet', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['internet']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Florería', 'floreria', (($this->usuario_model->get($this->session->get('id'), 'floreria', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['floreria']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Alberca', 'alberca', (($this->usuario_model->get($this->session->get('id'), 'alberca', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['alberca']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Sala de Belleza y Peluquería', 'sala', (($this->usuario_model->get($this->session->get('id'), 'sala', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['sala']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Arrendadora de Vehículos', 'arrendadora', (($this->usuario_model->get($this->session->get('id'), 'arrendadora', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['arrendadora']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Chapoteadero', 'chapoteadero', (($this->usuario_model->get($this->session->get('id'), 'chapoteadero', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['chapoteadero']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Gimnasio', 'gimnasio', (($this->usuario_model->get($this->session->get('id'), 'gimnasio', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['gimnasio']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Campo de Golf', 'golf', (($this->usuario_model->get($this->session->get('id'), 'golf', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['golf']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Áreas Verdes', 'area', (($this->usuario_model->get($this->session->get('id'), 'area', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['area']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Lavandería', 'lavanderia', (($this->usuario_model->get($this->session->get('id'), 'lavanderia', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['lavanderia']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Cancha de Tenis', 'tenis', (($this->usuario_model->get($this->session->get('id'), 'tenis', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['tenis']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Juegos Infantiles', 'juego', (($this->usuario_model->get($this->session->get('id'), 'juego', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['juego']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tintorería', 'tintoreria', (($this->usuario_model->get($this->session->get('id'), 'tintoreria', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['tintoreria']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Centro Ejecutivo', 'ejecutivo', (($this->usuario_model->get($this->session->get('id'), 'ejecutivo', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['ejecutivo']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Actividades Recreativas', 'actividad', (($this->usuario_model->get($this->session->get('id'), 'actividad', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['actividad']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Elevador', 'elevador', (($this->usuario_model->get($this->session->get('id'), 'elevador', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['elevador']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Estacionamiento', 'estacionamiento', (($this->usuario_model->get($this->session->get('id'), 'estacionamiento', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['estacionamiento']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['bar', 'Certificaciones', 'award', '', '', '', '', '', 'Seleccione las certificaciones con las que cuenta el establecimiento.'],
												['checkbox', 'Distintivo H', 'h', (($this->usuario_model->get($this->session->get('id'), 'h', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['h']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Distintivo M', 'm', (($this->usuario_model->get($this->session->get('id'), 'm', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['m']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tesoros de Guanajuato', 'tesoros', (($this->usuario_model->get($this->session->get('id'), 'tesoros', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['tesoros']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'ISO', 'iso', (($this->usuario_model->get($this->session->get('id'), 'iso', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['iso']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Punto Limpio', 'puntolimpio', (($this->usuario_model->get($this->session->get('id'), 'puntolimpio', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['puntolimpio']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Gran Anfitrion', 'anfitrion', (($this->usuario_model->get($this->session->get('id'), 'anfitrion', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['anfitrion']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Estándares de Competencia Laboral', 'estandares', (($this->usuario_model->get($this->session->get('id'), 'estandares', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['estandares']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Otra', 'otro', (($this->usuario_model->get($this->session->get('id'), 'otro', 'ret_frm_hospedaje-digitales', 'clave') == 1)?'checked':((isset($valueFlashdata['otro']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['text', 'Otra, ¿Cuál?', 'otracertificacion', (($this->usuario_model->get($this->session->get('id'), 'otracertificacion', 'ret_frm_hospedaje-digitales', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'otracertificacion', 'ret_frm_hospedaje-digitales', 'clave'):(($this->session->getFlashdata('otracertificacion'))?$this->session->getFlashdata('otracertificacion'):'')), '0', '50', false, false, 'Otra, ¿Cuál?', '', 'min_length[0]|max_length[50]','4'],
												['bar', 'Estacionamiento', 'cone', '', '', '', '', '', 'Indique la información solicitada.'],
												['number', 'Número de Cajones', 'nocajon', (($this->usuario_model->get($this->session->get('id'), 'nocajon','ret_frm_hospedaje-digitales', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'nocajon','ret_frm_hospedaje-digitales', 'clave'):((isset($valueFlashdata['nocajon']))?$valueFlashdata['nocajon']:'0')), '0', '9999', false, false, 'Cajones de Estacionamiento', '', 'required|min_length[1]|max_length[4]|numeric', '6'],
												['select', 'Tipo de Estacionamiento', 'tipocajon', (($this->usuario_model->get($this->session->get('id'), 'tipocajon', 'ret_frm_hospedaje-digitales', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'tipocajon', 'ret_frm_hospedaje-digitales', 'clave'):((isset($valueFlashdata['tipocajon']))?$valueFlashdata['tipocajon']:'')), '', '', false, false, '', [
																																['value_id' => 'Interno', 'value_name' => 'Interno'],
																																['value_id' => 'Externo', 'value_name' => 'Externo'],
																														], '','6'],
												['hr'],
												['select', '¿Cuenta de con seguro de responsabilidad?', 'seguro', (($this->usuario_model->get($this->session->get('id'), 'seguro', 'ret_frm_hospedaje-digitales', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'seguro', 'ret_frm_hospedaje-digitales', 'clave'):((isset($valueFlashdata['seguro']))?$valueFlashdata['seguro']:'')), '', '', true, false, '', [
																																['value_id' => '0', 'value_name' => 'NO'],
																																['value_id' => '1', 'value_name' => 'SI'],
																														], 'required','6'],
												['text', '¿Cuál asegurdora?', 'aseguradora', (($this->usuario_model->get($this->session->get('id'), 'aseguradora', 'ret_frm_hospedaje-digitales', 'clave'))?$this->usuario_model->get($this->session->get('id'), 'aseguradora', 'ret_frm_hospedaje-digitales', 'clave'):(($this->session->getFlashdata('aseguradora'))?$this->session->getFlashdata('aseguradora'):'')), '0', '50', false, false, 'En caso de contar con aseguradora', '', 'min_length[0]|max_length[50]','6'],
												['select', '¿Cuenta con unidades y espacios para paraderos?', 'unidad', (($this->usuario_model->get($this->session->get('id'), 'unidad', 'ret_frm_hospedaje-digitales', 'clave') != NULL)?$this->usuario_model->get($this->session->get('id'), 'unidad', 'ret_frm_hospedaje-digitales', 'clave'):((isset($valueFlashdata['unidad']))?$valueFlashdata['unidad']:'')), '', '', false, false, '', [
																																['value_id' => '0', 'value_name' => 'NO'],
																																['value_id' => '1', 'value_name' => 'SI'],
																														], '','6'],

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
