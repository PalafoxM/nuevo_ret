<?php
namespace App\Controllers;

class Imagenes extends BaseController {

	public function index()
	{
		if($this->session->get('logged'))
		{
			if($this->usuario_model->get($this->session->get('id'), 'porcentaje_registro') < 60 || $this->usuario_model->get($this->session->get('id'), 'concluido') == 1)
				return redirect()->to('empresa-avance');

			$data['title']				=		'Registro Estatal de Turismo | Imágenes';
			$data['head_js']			=	array(
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

			$data['nav']			=		'private/nav';
			$data['header']			=		'private/header';
			$data['main']			=		'private/form_template';
			$data['footer']			=		'public/footer';

			$data['controller']		=		'imagenes';
			$data['next_cont']		=		'giro';
			$data['form_pst']		=		$this->session->get('id').' - '.$this->session->get('name');
			$data['form_icon']		=		$this->session->get('icon_bs');
			$data['form_title']		=		'Imágenes';
			$data['form_percent']	=		$this->usuario_model->get($this->session->get('id'), 'porcentaje_registro');
			$data['form_giro']		=		$this->session->get('g_giro');
			$data['form_action']	=		BASE_URL.'guardar-form';
			$data['form_id']		=		'form_img';
			$data['form_field']		=		[
												['link', '<i class="bi-rewind icon-bar"></i> Anterior', '_self', BASE_URL.'datos-legales', '50', '', 'light', '', ''],
												['link', '<i class="bi-fast-forward icon-bar"></i> Siguiente', '_self', BASE_URL.'giro', '50', '', 'light', '', ''],
												['texto', 'Es importante e indispensable adjuntar archivos (5000 x 5000 pixeles de resolución máxima) en formato PNG o JPG con un peso MENOR a 10 MB cada uno.'],
												['link', ' Te sugerimos utilizar esta herramienta gratuita en linea: ImageOptimizer', '_blank', 'http://www.imageoptimizer.net/Pages/Home.aspx', '', '', 'warning', '', ''],
												['button', 'Guardar y Continuar', '', 'primary', '', '', false, false, ''],
												['bar', 'Documentación Gráfica', 'images', '', '', '', '', '', 'Los datos marcados con * son obligatorios.'],
												['hr'],
												['hidden', 'porcentaje_registro', 'porcentaje_registro', (($this->session->get('giro') == 8)?'100':'80'), '1', '2', false, true, 'porcentaje_registro'],
												['bar', 'Imagen Promocional', 'image', '', '', '', '', '', 'Imagen Promocional en guanajuato.mx'],
												['file', 'Imagen Promocional', 'imagen_promocional', (($this->usuario_model->get($this->session->get('id'), 'a_imagen_promocional'))?$this->usuario_model->get($this->session->get('id'), 'a_imagen_promocional'):''), '3', '200', true, false, 'Imagen Promocional', '', 'uploaded[imagen_promocional]|max_size[imagen_promocional,10240]|ext_in[imagen_promocional,jpeg,jpg,png]|mime_in[imagen_promocional,image/jpeg,image/pjpeg,image/png,image/x-png]|max_dims[imagen_promocional,5000,5000]|is_image[imagen_promocional]','',false,'accept="image/jpeg,image/pjpeg,image/png,image/x-png"'],
												['checkbox', 'Acepto que la imagen promocional adjunta, será validada para fines de promoción turística en el portal guanajuato.mx por parte del área comercial de la Secretaría de Turismo del Estado de Guanajuato.', 'promocion_gtomx', 'checked', '', '', true, false, '', '', 'required'],

												['bar', 'Logotipo y Fotografías del Establecimiento', 'image', '', '', '', '', '', ''],
												['file', 'Logotipo', 'logo', (($this->usuario_model->get($this->session->get('id'), 'a_logo'))?$this->usuario_model->get($this->session->get('id'), 'a_logo'):''), '3', '200', true, false, 'Logotipo del Establecimiento', '', 'uploaded[logo]|max_size[logo,10240]|ext_in[logo,jpeg,jpg,png]|mime_in[logo,image/jpeg,image/pjpeg,image/png,image/x-png]|max_dims[logo,5000,5000]|is_image[logo]','',false,'accept="image/jpeg,image/pjpeg,image/png,image/x-png"'],
												['hr'],
												['file', 'Fotografía del exterior del Establecimiento', 'imagen1', (($this->usuario_model->get($this->session->get('id'), 'a_imagen1'))?$this->usuario_model->get($this->session->get('id'), 'a_imagen1'):''), '3', '200', true, false, 'Fotografía del exterior del Establecimiento', '', 'uploaded[imagen1]|max_size[imagen1,10240]|ext_in[imagen1,jpeg,jpg,png]|mime_in[imagen1,image/jpeg,image/pjpeg,image/png,image/x-png]|max_dims[imagen1,5000,5000]|is_image[imagen1]','',false,'accept="image/jpeg,image/pjpeg,image/png,image/x-png"'],
												['hr'],
												['file', 'Fotografía del interior del Establecimiento', 'imagen2', (($this->usuario_model->get($this->session->get('id'), 'a_imagen2'))?$this->usuario_model->get($this->session->get('id'), 'a_imagen2'):''), '3', '200', true, false, 'Fotografía del interior del Establecimiento', '', 'uploaded[imagen2]|max_size[imagen2,10240]|ext_in[imagen2,jpeg,jpg,png]|mime_in[imagen2,image/jpeg,image/pjpeg,image/png,image/x-png]|max_dims[imagen2,5000,5000]|is_image[imagen2]','',false,'accept="image/jpeg,image/pjpeg,image/png,image/x-png"'],
												['hr'],
												['file', 'Imagen de las instalaciones', 'imagen3', (($this->usuario_model->get($this->session->get('id'), 'a_imagen3'))?$this->usuario_model->get($this->session->get('id'), 'a_imagen3'):''), '3', '200', false, false, 'Imagen de las instalaciones', '', 'uploaded[imagen3]|max_size[imagen3,10240]|ext_in[imagen3,jpeg,jpg,png]|mime_in[imagen3,image/jpeg,image/pjpeg,image/png,image/x-png]|max_dims[imagen3,5000,5000]|is_image[imagen3]','',false,'accept="image/jpeg,image/pjpeg,image/png,image/x-png"'],
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
