<?php
namespace App\Controllers;

class Datos_generales extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->usuario_model->get($this->session->get('id'), 'concluido') == 1)
				return redirect()->to('concluir-registro');

			$data['title']				=		'Registro Estatal de Turismo | Datos Generales';
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
												'https://maps.googleapis.com/maps/api/js?key='.GMAPS_ALT,
												BASE_URL.STATIC_JS.'urm2lat.js',
												BASE_URL.STATIC_JS.'ddToDms.js'
											);
			$data['footer_script']		=	['gmaps'];

			$subrubro 		= $this->usuario_model->get_subrubros(true,$this->session->get('giro'));
			$valueFlashdata = [];
			if($this->session->getFlashdata('values'))
				$valueFlashdata = $this->session->getFlashdata('values');


			$data['nav']			=		'private/nav';
			$data['header']			=		'private/header';
			$data['main']			=		'private/form_template';
			$data['footer']			=		'public/footer';

			$data['controller']		=		'datos-generales';
			$data['next_cont']		=		'datos-tecnicos';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Datos Generales';
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_dg';
			$data['form_field']		=		[
												['link', '<i class="bi-list-stars icon-bar"></i> Ir al Panel', '_self', BASE_URL.'panel', '50', '', 'light', '', ''],
												['button', '<i class="bi-fast-forward icon-bar"></i> Siguiente', '', 'light', '50', '', false, false, ''],
												['button', 'Guardar y Continuar', '', 'primary', '', '', false, false, ''],
												['bar', 'Datos Generales', 'info-circle', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['hidden', 'porcentaje_registro', 'porcentaje_registro', '20', '1', '2', false, true, 'porcentaje_registro'],
												['text', 'Nombre comercial', 'nombre_comercial', (($this->usuario_model->get($this->session->get('id'), 'nombre_comercial'))?$this->usuario_model->get($this->session->get('id'), 'nombre_comercial'):(($this->session->getFlashdata('nombre_comercial'))?$this->session->getFlashdata('nombre_comercial'):'')), '3', '200', false, true, 'Nombre comercial de la empresa'],
												['text', 'Persona Responsable', 'contacto', (($this->usuario_model->get($this->session->get('id'), 'contacto'))?$this->usuario_model->get($this->session->get('id'), 'contacto'):(($this->session->getFlashdata('contacto'))?$this->session->getFlashdata('contacto'):'')), '3', '100', true, false, 'Persona de contacto', '', 'required|min_length[3]|max_length[100]'],
												['bar', 'Datos Legales', 'bank', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['select', 'Tipo de persona', 'tipo_persona', (($this->usuario_model->get($this->session->get('id'), 'tipo_persona'))?$this->usuario_model->get($this->session->get('id'), 'tipo_persona'):(($this->session->getFlashdata('tipo_persona'))?$this->session->getFlashdata('tipo_persona'):'')), '', '', true, false, '', [
																																['value_id' => '1', 'value_name' => 'Persona Física'],
																																['value_id' => '2', 'value_name' => 'Persona Moral'],
																															], 'required'],
												['text', 'RFC', 'info_rfc', (($this->usuario_model->get($this->session->get('id'), 'info_rfc'))?$this->usuario_model->get($this->session->get('id'), 'info_rfc'):(($this->session->getFlashdata('info_rfc'))?$this->session->getFlashdata('info_rfc'):'')), '9', '13', false, true, 'Registro Federal de Contribuyentes'],
												['text', 'Razón Social', 'razon_social', (($this->usuario_model->get($this->session->get('id'), 'razon_social'))?$this->usuario_model->get($this->session->get('id'), 'razon_social'):(($this->session->getFlashdata('razon_social'))?$this->session->getFlashdata('razon_social'):'')), '3', '255', true, false, 'Razón Social', '', 'required|min_length[3]|max_length[255]'],
												['text', 'Representante Legal', 'representante_moral', (($this->usuario_model->get($this->session->get('id'), 'representante_moral'))?$this->usuario_model->get($this->session->get('id'), 'representante_moral'):(($this->session->getFlashdata('representante_moral'))?$this->session->getFlashdata('representante_moral'):'')), '0', '60', false, false, 'Representante Legal (Persona Moral)', '', 'min_length[0]|max_length[60]'],
												[(($subrubro)?'bar':'nothing'), 'Sub-Rubro', $this->session->get('icon_bs'), '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												[(($subrubro)?'select':'nothing'), 'Subrubro al que pertenece', 'idgiro_subrubro', (($this->usuario_model->get($this->session->get('id'), 'idgiro_subrubro'))?$this->usuario_model->get($this->session->get('id'), 'idgiro_subrubro'):(($this->session->getFlashdata('idgiro_subrubro'))?$this->session->getFlashdata('idgiro_subrubro'):'')), '', '', true, false, '', $subrubro,'required'],
												['bar', 'Dirección', 'geo', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['text', 'Calle', 'calle', (($this->usuario_model->get($this->session->get('id'), 'calle'))?$this->usuario_model->get($this->session->get('id'), 'calle'):(($this->session->getFlashdata('calle'))?$this->session->getFlashdata('calle'):'')), '3', '120', true, false, 'Calle', '', 'required|min_length[3]|max_length[120]'],
												['text', 'Número Exterior', 'numero', (($this->usuario_model->get($this->session->get('id'), 'numero'))?$this->usuario_model->get($this->session->get('id'), 'numero'):(($this->session->getFlashdata('numero'))?$this->session->getFlashdata('numero'):'')), '1', '10', true, false, 'Número exterior', '', 'required|min_length[1]|max_length[10]'],
												['text', 'Número Interior', 'interior', (($this->usuario_model->get($this->session->get('id'), 'interior'))?$this->usuario_model->get($this->session->get('id'), 'interior'):(($this->session->getFlashdata('interior'))?$this->session->getFlashdata('interior'):'')), '1', '5', false, false, 'Número interior', '', 'min_length[0]|max_length[5]'],
												['text', 'Colonia', 'colonia', (($this->usuario_model->get($this->session->get('id'), 'colonia'))?$this->usuario_model->get($this->session->get('id'), 'colonia'):(($this->session->getFlashdata('colonia'))?$this->session->getFlashdata('colonia'):'')), '3', '50', true, false, 'Colonia', '', 'required|min_length[3]|max_length[50]'],
												['select', 'Municipio', 'municipio', (($this->usuario_model->get($this->session->get('id'), 'municipio'))?$this->usuario_model->get($this->session->get('id'), 'municipio'):(($this->session->getFlashdata('municipio'))?$this->session->getFlashdata('municipio'):'')), '', '', false, true, '', $this->web_model->get_municipios(true)],
												['text', 'Código Postal', 'cp', (($this->usuario_model->get($this->session->get('id'), 'cp'))?$this->usuario_model->get($this->session->get('id'), 'cp'):(($this->session->getFlashdata('cp'))?$this->session->getFlashdata('cp'):'')), '3', '10', true, false, 'Código Postal', '', 'required|min_length[3]|max_length[10]'],
												['bar', 'Teléfonos', 'telephone', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['text', 'Teléfono', 'telefono', (($this->usuario_model->get($this->session->get('id'), 'telefono'))?$this->usuario_model->get($this->session->get('id'), 'telefono'):(($this->session->getFlashdata('telefono'))?$this->session->getFlashdata('telefono'):'')), '10', '10', true, false, 'Teléfono Principal', '', 'required|min_length[3]|max_length[200]'],
												['text', 'Teléfono de Atención al Cliente', 'telefono_comercial', (($this->usuario_model->get($this->session->get('id'), 'telefono_comercial'))?$this->usuario_model->get($this->session->get('id'), 'telefono_comercial'):(($this->session->getFlashdata('telefono_comercial'))?$this->session->getFlashdata('telefono_comercial'):'')), '10', '10', true, false, 'Teléfono de Atención al Cliente', '', 'required|min_length[0]|max_length[10]'],
												['text', 'Teléfono Alternativo', 'telefono2', (($this->usuario_model->get($this->session->get('id'), 'telefono2'))?$this->usuario_model->get($this->session->get('id'), 'telefono2'):(($this->session->getFlashdata('telefono2'))?$this->session->getFlashdata('telefono2'):'')), '10', '10', false, false, 'Teléfono Alternativo', '', 'min_length[0]|max_length[10]'],
												['bar', 'Datos Electrónicos', 'wifi', '', '', '', '', '', 'Los campos marcados con * son obligatorios.'],
												['url', 'Sitio Web (agregar http:// o https://)', 'web', (($this->usuario_model->get($this->session->get('id'), 'web'))?$this->usuario_model->get($this->session->get('id'), 'web'):(($this->session->getFlashdata('web'))?$this->session->getFlashdata('web'):'')), '0', '50', false, false, 'Sitio Web', '', 'min_length[0]|max_length[50]'],
												['email', 'Correo electrónico', 'correo', (($this->usuario_model->get($this->session->get('id'), 'email'))?$this->usuario_model->get($this->session->get('id'), 'email'):(($this->session->getFlashdata('email'))?$this->session->getFlashdata('email'):'')), '7', '50', false, true, 'Correo Electrónico'],
												['email', 'Correo electrónico de Atención al Cliente', 'correo_atncli', (($this->usuario_model->get($this->session->get('id'), 'dg_correo_atncli'))?$this->usuario_model->get($this->session->get('id'), 'dg_correo_atncli'):(($this->session->getFlashdata('dg_correo_atncli'))?$this->session->getFlashdata('dg_correo_atncli'):'')), '7', '50', true, false, 'Correo Electrónico de Atención al Cliente', '', 'required|min_length[6]|max_length[120]|valid_email'],
												['url', 'Facebook Fan Page (agregar http:// o https://)', 'facebook', (($this->usuario_model->get($this->session->get('id'), 'facebook'))?$this->usuario_model->get($this->session->get('id'), 'facebook'):(($this->session->getFlashdata('facebook'))?$this->session->getFlashdata('facebook'):'')), '0', '250', false, false, 'Facebook', '', 'min_length[0]|max_length[250]'],
												['url', 'Twitter (agregar http:// o https://)', 'twitter', (($this->usuario_model->get($this->session->get('id'), 'twitter'))?$this->usuario_model->get($this->session->get('id'), 'twitter'):(($this->session->getFlashdata('twitter'))?$this->session->getFlashdata('twitter'):'')), '0', '250', false, false, 'Twitter', '', 'min_length[0]|max_length[250]'],
												['bar', 'Certificaciones', 'award', '', '', '', '', '', 'Seleccione las certificaciones con las que cuenta el establecimiento.'],
												['checkbox', 'Distintivo H', 'h', (($this->usuario_model->get($this->session->get('id'), 'h') == 1)?'checked':((isset($valueFlashdata['h']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Distintivo M', 'm', (($this->usuario_model->get($this->session->get('id'), 'm') == 1)?'checked':((isset($valueFlashdata['m']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Tesoros de Guanajuato', 'tesoros', (($this->usuario_model->get($this->session->get('id'), 'tesoros') == 1)?'checked':((isset($valueFlashdata['tesoros']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'ISO', 'iso', (($this->usuario_model->get($this->session->get('id'), 'iso') == 1)?'checked':((isset($valueFlashdata['iso']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Punto Limpio', 'punto_limpio', (($this->usuario_model->get($this->session->get('id'), 'punto_limpio') == 1)?'checked':((isset($valueFlashdata['punto_limpio']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Gran Anfitrion', 'anfitrion', (($this->usuario_model->get($this->session->get('id'), 'anfitrion') == 1)?'checked':((isset($valueFlashdata['anfitrion']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Estándares de Competencia Laboral', 'estandares', (($this->usuario_model->get($this->session->get('id'), 'estandares') == 1)?'checked':((isset($valueFlashdata['estandares']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['checkbox', 'Otra', 'otro', (($this->usuario_model->get($this->session->get('id'), 'otro') == 1)?'checked':((isset($valueFlashdata['otro']))?'checked':'')), '', '', false, false, '', '', '','4'],
												['text', 'Otra, ¿Cuál?', 'otrocertificacion', (($this->usuario_model->get($this->session->get('id'), 'otrocertificacion'))?$this->usuario_model->get($this->session->get('id'), 'otrocertificacion'):(($this->session->getFlashdata('otrocertificacion'))?$this->session->getFlashdata('otrocertificacion'):'')), '0', '50', false, false, 'Otra, ¿Cuál?', '', 'min_length[0]|max_length[50]','4'],
												['textarea', 'Descripción', 'descripcion', (($this->usuario_model->get($this->session->get('id'), 'descripcion'))?$this->usuario_model->get($this->session->get('id'), 'descripcion'):(($this->session->getFlashdata('descripcion'))?$this->session->getFlashdata('descripcion'):'')), '10', '400', true, false, 'Redacta una descripción de tu establecimiento con la finalidad de que sea con enfoque promocional', '', 'required'],
												['hr'],
												['map', 'Georeferenciación', 
																			['latitud', 'longitud'], 
																			[
																				(($this->usuario_model->get($this->session->get('id'), 'latitud'))?$this->usuario_model->get($this->session->get('id'), 'latitud'):(($this->session->getFlashdata('latitud'))?$this->session->getFlashdata('latitud'):'20.95621')),
																				(($this->usuario_model->get($this->session->get('id'), 'longitud'))?$this->usuario_model->get($this->session->get('id'), 'longitud'):(($this->session->getFlashdata('longitud'))?$this->session->getFlashdata('longitud'):'-101.35985'))
																			], '5', '30', true, false, 
																			['Ubicación: Latitud', 'Ubicación: Longitud'], 
												'', 'required|min_length[5]|max_length[30]'],
												['hr'],
												['checkbox', 'Declaro bajo protesta de decir verdad que la información y documentación brindada para el presente registro es verídica.', 'protesto_juridico', 'checked', '', '', true, false, '', '', 'required'],
												['checkbox', 'Acepto que mi descripción sea modificada para fines de promoción turística en el portal guanajuato.mx por parte del área comercial de la Secretaría de Turismo del Estado de Guanajuato.', 'aviso_descripcion', 'checked', '', '', true, false, '', '', 'required'],
												['hr'],
												['button', 'Guardar y Continuar', '', 'primary', '', '', false, false, ''],
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
