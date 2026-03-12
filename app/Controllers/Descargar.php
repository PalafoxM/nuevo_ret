<?php
namespace App\Controllers;
use CodeIgniter\HTTP\Response;

class Descargar extends BaseController {

	public function index()
	{
		return redirect()->to('panel');
	}

	public function rfc()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_rfc'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_RFC.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function curp()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_curp'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_CURP.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function ife()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_ife'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_INE.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function licencia_suelo()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_licencia_suelo'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Licencia_Suelo.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function escritura_publica()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_escritura_publica'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Escritura_Publica.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function acta_constitutiva()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_acta_constitutiva'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Acta_Constitutiva.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}
	}

	public function rfc_legal()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_rfc_legal'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_RFC_Legal.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function domicilio()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_domicilio'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Domicilio.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function protocolo_higiene()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_protocolo_higiene'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Protocolo_Higiene.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}
	}

	public function carta_protesta()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_carta_protesta'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Carta_Protesta.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function imagen_promocional()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_imagen_promocional'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Imagen_Promocional.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function logo()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_logo'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Logo.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function imagen1()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_imagen1'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Imagen1.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}
	}

	public function imagen2()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_imagen2'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Imagen2.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}

	public function imagen3()
	{
		if(! $this->session->get('logged'))
			return redirect()->to('panel');
		else if(! $file = $this->usuario_model->get($this->session->get('id'), 'a_imagen3'))
			return redirect()->to('redireccion/enlace/15');
		else
		{
			try{
				$fileInstance	= 	new \CodeIgniter\Files\File(WRITEPATH.'uploads/'.$file, true);

				$ext 			= 	$fileInstance->guessExtension();
				
				return $this->response->download(WRITEPATH.'uploads/'.$file, null)->setFileName($this->session->get('id').'_Imagen3.'.$ext);

			}
			catch( \Exception $e){
				return redirect()->to('redireccion/enlace/15');
			}

		}


	}


} 