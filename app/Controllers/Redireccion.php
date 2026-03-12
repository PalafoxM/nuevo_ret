<?php
namespace App\Controllers;

class Redireccion extends BaseController {

	public function index()
	{
		return redirect()->to('inicio');
	}

	public function documento($_iddocumento = 0)
	{
			$data['title']				=		'Registro Estatal de Turismo | ';
			$data['head_js']			=	array(
												BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js'
											);
			$data['head_css']			=	array(
												BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
												BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
												BASE_URL.STATIC_CSS.'header.css',
												BASE_URL.STATIC_CSS.'redireccion.css?v=1.1',
												BASE_URL.STATIC_CSS.'footer.css?v=1.1',
												BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
											);
			if($this->session->get('api_logged') || $this->session->get('logged'))
			{
				$data['nav']			=		'private/nav';
				$data['header']			=		'private/header';
			}
			else
			{
				$data['nav']			=		'public/nav';
				$data['header']			=		'public/header';
			}
			
			$data['main']			=		'public/redireccion';
			$data['footer']			=		'public/footer';

			$data['message']		=		'El archivo se descargará en breve.';
			$data['icon']			=		'file-earmark-pdf';
			$data['time']			=		500;

			switch ($_iddocumento)
			{
				case 1:
					$data['subtitle']		=		'Categorías RET';
					$data['url']			=		BASE_URL.'static/docs/ret/1_RET_17_rubros.pdf';
				break;
				case 2:
					$data['subtitle']		=		'Base Legal del RET';
					$data['url']			=		BASE_URL.'static/docs/ret/LEY_DE TURISMO_DEL_ESTADO_DE_GUANAJUATO_Y_SUS_MUNICIPIOS.pdf';
				break;
				case 3:
					//$data['icon']			=		'filetype-jpg';
					$data['subtitle']		=		'Beneficios del RET';
					$data['url']			=		BASE_URL.'static/docs/ret/Beneficios_RET.pdf';
				break;
				case 4:
					$data['subtitle']		=		'Requisitos del RET';
					$data['url']			=		BASE_URL.'static/docs/ret/Requisitos_RET.pdf';
				break;
				case 5:
					$data['subtitle']		=		'¿A qué giro pertenezco del RET?';
					$data['url']			=		BASE_URL.'static/docs/ret/Catalogo_de_Prestadores_de_Servicios.pdf';
				break;
				case 6:
					$data['subtitle']		=		'Preguntas Frecuentes del RET';
					$data['url']			=		BASE_URL.'static/docs/ret/Preguntas-Frecuentes-RET.pdf';
				break;
				case 7:
					$data['subtitle']		=		'Categorías del RNT';
					$data['url']			=		BASE_URL.'static/docs/rnt/3._Que_es_RNT_y_Rubros.pdf';
				break;
				case 8:
					$data['subtitle']		=		'Base Legal del RNT';
					$data['url']			=		BASE_URL.'static/docs/rnt/Ley_General_de_Turismo.pdf';
				break;
				case 9:
					$data['subtitle']		=		'Formato Único del RNT';
					$data['url']			=		BASE_URL.'static/docs/rnt/Formato_Unico.pdf';
				break;
				case 10:
					$data['subtitle']		=		'Beneficios del RNT';
					$data['url']			=		'https://rnt.sectur.gob.mx/';
				break;
				case 11:
					$data['subtitle']		=		'Beneficios del SCH';
					$data['url']			=		BASE_URL.'static/docs/sch/5._SCH_y_beneficios.pdf';
				break;
				case 12:
					$data['subtitle']		=		'Base Legal del SCH';
					$data['url']			=		BASE_URL.'static/docs/sch/LINEAMIENTOS-SCH_DOF.pdf';
				break;
				case 13:
					$data['icon']			=		'file-earmark-spreadsheet';
					$data['subtitle']		=		'Simulador del SCH';
					$data['url']			=		BASE_URL.'static/docs/sch/Simulador_SCH.xlsx';
				break;
				case 14:
					$data['subtitle']		=		'Lineamientos de los Guías de Turistas';
					$data['url']			=		BASE_URL.'static/docs/guias/Lineamientos_para_la_Acreditacion_de_Guias_de_Turistas.pdf';
				break;
				case 15:
					$data['subtitle']		=		'Trámite de Acreditación de Guía';
					$data['url']			=		'https://guiadeturistas.sectur.gob.mx/';
				break;
				case 16:
					$data['subtitle']		=		'Consulta de Guías';
					$data['url']			=		'https://guiadeturistas.sectur.gob.mx/';
				break;
				case 17:
					$data['subtitle']		=		'Manual del RET';
					$data['url']			=		BASE_URL.'static/docs/ayuda/Manual-RET.pdf';
				break;
				case 18:
					$data['subtitle']		=		'Manual del RNT';
					$data['url']			=		BASE_URL.'static/docs/ayuda/Manual_RNT.pdf';
				break;
				case 19:
					$data['subtitle']		=		'Manual del SCH';
					$data['url']			=		BASE_URL.'static/docs/ayuda/Manual_SCH.pdf';
				break;
				case 20:
					$data['subtitle']		=		'Aviso Legal';
					$data['url']			=		BASE_URL.'static/docs/informativo/aviso_legal.pdf';
				break;
				case 21:
					$data['subtitle']		=		'Aviso de Privacidad Integral RET';
					$data['url']			=		BASE_URL.'static/docs/informativo/aviso_de_privacidad_integral_ret.pdf';
				break;
				
				default:
					return redirect()->to('redireccion/enlace/15');
			}


			$data['title']			.=		$data['subtitle'];
			
			return view('template', $data);

	}

	public function enlace($_idenlace = 0)
	{
			$data['title']				=		'Registro Estatal de Turismo | ';
			$data['head_js']			=	array(
												BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js'
											);
			$data['head_css']			=	array(
												BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
												BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
												BASE_URL.STATIC_CSS.'header.css',
												BASE_URL.STATIC_CSS.'redireccion.css?v=1.1',
												BASE_URL.STATIC_CSS.'footer.css?v=1.1',
												BASE_URL.STATIC_CSS.'bootstrap-icons.css',											
											);
			if($this->session->get('api_logged') || $this->session->get('logged'))
			{
				$data['nav']			=		'private/nav';
				$data['header']			=		'private/header';
			}
			else
			{
				$data['nav']			=		'public/nav';
				$data['header']			=		'public/header';
			}
			
			$data['main']			=		'public/redireccion';
			$data['footer']			=		'public/footer';

			$data['message']		=		'Estás siendo redirigido, gracias por la espera.';
			$data['icon']			=		'box-arrow-up-right';
			$data['time']			=		500;

			switch ($_idenlace)
			{
				case 0:
		            $data['subtitle']       =       'Página no encontrada';
		            $data['url']            =       BASE_URL;
				break;
				case 1:
					$data['subtitle']		=		'Llámanos';
					$data['url']			=		'tel:+5214721039900';
				break;
				case 2:
					$data['subtitle']		=		'Escríbenos';
					$data['url']			=		'mailto:ret@guanajuato.gob.mx';
				break;
				case 3:
					$data['subtitle']		=		'Registro Nacional de Turismo';
					$data['url']			=		'https://www.gob.mx/sectur/articulos/registro-nacional-de-turismo-25058';
				break;
				case 4:
					$data['subtitle']		=		'Sistema de Clasificación Hotelera';
					$data['url']			=		'https://www.gob.mx/sectur/acciones-y-programas/sistema-de-clasificacion-hotelera';
				break;
				case 5:
					$data['subtitle']		=		'Consulta Ciudadana';
					$data['url']			=		BASE_URL.'consulta-ciudadana/';
				break;
				case 6:
					$data['subtitle']		=		'Consulta Turística MX';
					$data['url']			=		'https://rnt.sectur.gob.mx/consulta';
				break;
				case 7:
					$data['subtitle']		=		'Protocolo Alba';
					$data['url']			=		'https://imug.guanajuato.gob.mx/index.php/Protocolo-ALBA-guanajuato/';
				break;
				case 8:
					$data['subtitle']		=		'Secretaría de Turismo del Estado de Guanajuato';
					$data['url']			=		'https://sectur.guanajuato.gob.mx/';
				break;
				case 9:
					$data['subtitle']		=		'Observatorio Turístico del Estado de Guanajuato';
					$data['url']			=		'http://www.observatorioturistico.org/';
				break;
				case 10:
					$data['subtitle']		=		'Guanajuato MX';
					$data['url']			=		'http://www.guanajuato.mx/';
				break;
				case 11:
					$data['subtitle']		=		'Secretaría de Turismo';
					$data['url']			=		'http://www.sectur.gob.mx/';
				break;
				case 12:
					$data['subtitle']		=		'Facebook';
					$data['url']			=		'https://www.facebook.com/Sectur.Guanajuato';
				break;
				case 13:
					$data['subtitle']		=		'Twitter';
					$data['url']			=		'https://twitter.com/SECTURGTO';
				break;
				case 14:
					$data['subtitle']		=		'Consulta Pública de Trámites y Servicios';
					$data['url']			=		'https://docs.google.com/forms/d/e/1FAIpQLSdDq7ThITsO8SebSY71Q3jtoZqJKVjQpgSq44usg-n9YACkCA/viewform';
				break;
				default:
		            $data['subtitle']       =       'Página no encontrada';
		            $data['url']            =       BASE_URL;
			}


			$data['title']			.=		$data['subtitle'];
			//var_dump($data); die;
			return view('template', $data);

	}
}
