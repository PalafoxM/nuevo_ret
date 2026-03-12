<?php
namespace App\Controllers;

class Datos_legales extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->usuario_model->get($this->session->get('id'), 'porcentaje_registro') < 40 || $this->usuario_model->get($this->session->get('id'), 'concluido') == 1)
				return redirect()->to('empresa-avance');

			$data['title']      = 'Registro Estatal de Turismo | Datos Legales';
			$data['head_js']    = array(
				BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js',
			);
			$data['head_css']   = array(
				BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
				BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
				BASE_URL.STATIC_CSS.'header.css',
				BASE_URL.STATIC_CSS.'registro.css?v=1.1',
				BASE_URL.STATIC_CSS.'form.css',
				BASE_URL.STATIC_CSS.'footer.css?v=1.1',
				BASE_URL.STATIC_CSS.'bootstrap-icons.css',
			);
			$data['footer_js']  = array(
				BASE_URL.STATIC_JS.'form-validation.js',
			);

			$data['nav']        = 'private/nav';
			$data['header']     = 'private/header';
			$data['main']       = 'private/form_template';
			$data['footer']     = 'public/footer';

			$data['controller']   = 'datos-legales';
			$data['next_cont']    = 'imagenes';
			$data['form_pst']     = $this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']    = $this->session->get('icon_bs');
			$data['form_title']   = 'Datos Legales';
			$data['form_percent'] = $this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']    = $this->session->get('g_giro');
			$data['form_action']  = BASE_URL.'guardar-form';
			$data['form_id']      = 'form_al';
			$data['form_field']   = [
				['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'datos-tecnicos', '50', '', 'light', '', ''],
				['button', '<i class="bi-fast-forward icon-bar"></i> Siguiente', '', 'light', '50', '', false, false, ''],
				['button', 'Guardar y Continuar', '', 'primary', '', '', false, false, ''],
				['texto', 'Adjuntar archivos en formato PDF, PNG, JPG con un peso MENOR a 10 MB cada uno.'],
				['link', ' Para reducir el tamaño de tus archivos, te sugerimos la siguiente herramienta gratuita en linea: PDF2Go', '_blank', 'https://www.pdf2go.com/es/comprimir-pdf', '', '', 'warning', '', ''],
				['link', ' Te sugerimos utilizar esta herramienta gratuita en linea: ImageOptimizer', '_blank', 'http://www.imageoptimizer.net/Pages/Home.aspx', '', '', 'warning', '', ''],

				['bar', 'Datos Legales de Organización', 'files', '', '', '', '', '', 'Los datos marcados con * son obligatorios.'],
				['hr'],
				['hidden', 'porcentaje_registro', 'porcentaje_registro', '60', '1', '2', false, true, 'porcentaje_registro', '', 'required'],

				['bar', 'Constancia de Situación Fiscal', 'file-pdf', '', '', '', '', '', 'No mayor a 3 meses de antigüedad.'],
				['file', 'Constancia de Situación Fiscal / RFC', 'rfc', (($this->usuario_model->get($this->session->get('id'), 'a_rfc')) ? $this->usuario_model->get($this->session->get('id'), 'a_rfc') : ''), '3', '200', true, false, 'Constancia de Situación Fiscal / RFC', '', 'uploaded[rfc]|max_size[rfc,10240]|ext_in[rfc,pdf,jpeg,jpg,png]|mime_in[rfc,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]', '', false, 'accept="application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png"'],

				['bar', 'CURP', 'file-pdf', '', '', '', '', '', ''],
				['file', 'CURP', 'curp', (($this->usuario_model->get($this->session->get('id'), 'a_curp')) ? $this->usuario_model->get($this->session->get('id'), 'a_curp') : ''), '3', '200', false, false, 'CURP', '', 'uploaded[curp]|max_size[curp,10240]|ext_in[curp,pdf,jpeg,jpg,png]|mime_in[curp,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]', '', false, 'accept="application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png"'],

				['bar', 'Identificación Oficial con Fotografía', 'file-pdf', '', '', '', '', '', 'Vigente'],
				['file', 'Identificación Oficial con Fotografía / INE', 'ife', (($this->usuario_model->get($this->session->get('id'), 'a_ife')) ? $this->usuario_model->get($this->session->get('id'), 'a_ife') : ''), '3', '200', true, false, 'Identificación Oficial con Fotografía / INE', '', 'uploaded[ife]|max_size[ife,10240]|ext_in[ife,pdf,jpeg,jpg,png]|mime_in[ife,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]', '', false, 'accept="application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png"'],

				['bar', 'Licencia de Uso de Suelo / Constancia de Situación Fiscal', 'file-pdf', '', '', '', '', '', 'No mayor a 3 meses de antigüedad'],
				['file', 'Constancia de Situación Fiscal con actividad económica de acuerdo al giro seleccionado', 'licencia_suelo', (($this->usuario_model->get($this->session->get('id'), 'a_licencia_suelo')) ? $this->usuario_model->get($this->session->get('id'), 'a_licencia_suelo') : ''), '3', '200', true, false, 'Licencia de Uso de Suelo / Constancia de Situación Fiscal', '', 'uploaded[licencia_suelo]|max_size[licencia_suelo,10240]|ext_in[licencia_suelo,pdf,jpeg,jpg,png]|mime_in[licencia_suelo,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]', '', false, 'accept="application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png"'],

				['bar', 'Escritura Pública / Contrato de Arrendamiento', 'file-pdf', '', '', '', '', '', 'Contrato de Comodato'],
				['file', 'El domicilio debe ser del lugar donde presta su servicio, si es contrato de arrendamiento o comodato debe ser vigente', 'escritura_publica', (($this->usuario_model->get($this->session->get('id'), 'a_escritura_publica')) ? $this->usuario_model->get($this->session->get('id'), 'a_escritura_publica') : ''), '3', '200', true, false, 'Escritura Pública / Contrato de Arrendamiento / Contrato de Comodato', '', 'uploaded[escritura_publica]|max_size[escritura_publica,10240]|ext_in[escritura_publica,pdf,jpeg,jpg,png]|mime_in[escritura_publica,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]', '', false, 'accept="application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png"'],

				['bar', 'Acta Constitutiva y carta poder del representante', 'file-pdf', '', '', '', '', '', 'En caso de NO aparecer en Acta Constitutiva el representante legal'],
				['file', 'Obligatorio unicamente para Personas Morales', 'acta_constitutiva', (($this->usuario_model->get($this->session->get('id'), 'a_acta_constitutiva')) ? $this->usuario_model->get($this->session->get('id'), 'a_acta_constitutiva') : ''), '3', '200', false, false, 'Obligatorio unicamente para Personas Morales', '', 'uploaded[acta_constitutiva]|max_size[acta_constitutiva,10240]|ext_in[acta_constitutiva,pdf,jpeg,jpg,png]|mime_in[acta_constitutiva,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]', '', false, 'accept="application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png"'],

				['bar', 'RFC Representante legal', 'file-pdf', '', '', '', '', '', ''],
				['file', 'Obligatorio unicamente para Personas Morales', 'rfc_legal', (($this->usuario_model->get($this->session->get('id'), 'a_rfc_legal')) ? $this->usuario_model->get($this->session->get('id'), 'a_rfc_legal') : ''), '3', '200', false, false, 'Obligatorio unicamente para Personas Morales', '', 'uploaded[rfc_legal]|max_size[rfc_legal,10240]|ext_in[rfc_legal,pdf,jpeg,jpg,png]|mime_in[rfc_legal,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]', '', false, 'accept="application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png"'],

				['bar', 'Comprobante de Domicilio', 'file-pdf', '', '', '', '', '', 'No mayor a 3 meses de antigüedad'],
				['file', 'No mayor a 3 meses de antigüedad y del lugar donde presta su servicio', 'domicilio', (($this->usuario_model->get($this->session->get('id'), 'a_domicilio')) ? $this->usuario_model->get($this->session->get('id'), 'a_domicilio') : ''), '3', '200', true, false, 'No mayor a 3 meses de antigüedad y del lugar donde presta su servicio', '', 'uploaded[domicilio]|max_size[domicilio,10240]|ext_in[domicilio,pdf,jpeg,jpg,png]|mime_in[domicilio,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]', '', false, 'accept="application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png"'],

				['bar', 'Protocolo de Higiene', 'file-pdf', '', '', '', '', '', ''],
				['file', 'Aplica únicamente para el rubro Prestación de Servicios de Hospedaje a través de Plataformas Digitales ', 'protocolo_higiene', (($this->usuario_model->get($this->session->get('id'), 'a_protocolo_higiene')) ? $this->usuario_model->get($this->session->get('id'), 'a_protocolo_higiene') : ''), '3', '200', false, false, 'Aplica únicamente para el rubro Prestación de Servicios de Hospedaje a través de Plataformas Digitales ', '', 'uploaded[protocolo_higiene]|max_size[protocolo_higiene,10240]|ext_in[protocolo_higiene,pdf,jpeg,jpg,png]|mime_in[protocolo_higiene,application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png]', '', false, 'accept="application/pdf,image/jpeg,image/pjpeg,image/png,image/x-png"'],

				// *** Se removió la sección "Carta Bajo Protesta" ***
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
