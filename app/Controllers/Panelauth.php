<?php
namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;

class Panelauth extends BaseController {
	use ResponseTrait;

    public function index() 
    {
        if($this->session->get('logged_adm')) 
            return redirect()->to('paneladm/hoy');
        else 
        {
            $data = array('alert' => false);
            return view('panelret/login', $data);
        }
    }

    public function login()
    {
		$url 		= 'https://www.google.com/recaptcha/api/siteverify';
		$secret		=	SECRET_KEY;

		$email 		= $this->request->getVar('clave');
		$password 	= $this->request->getVar('pass');
		$token 		= $this->request->getVar('token');

		if (! $this->validate([
							'clave'		=>	'required',
							'pass'		=>	'required',
							'token'		=>	'required',
							]))
		{
            $data = [
            		'alert' => false,
            		'msg' 	=> 'validation'
            		];

			return $this->respond($data);
		}
		else
		{
			$credential 	= [
								'secret'	=>	$secret,
								'response'	=>	$token
								];

			$verify 		= curl_init();
			curl_setopt($verify, CURLOPT_URL, $url);
			curl_setopt($verify, CURLOPT_POST, true);
			curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
			curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
			$response 		= curl_exec($verify);
			$responseKeys 	= json_decode($response, true);

			if($responseKeys["success"]) 
			{
		    	$session 				= 	\Config\Services::session();
		    	$authentication_model  	= 	new \App\Models\Authentication_model();
		    	$postData				=	[
											'email'		=>	$email,
											'password'	=>	$password
		    								];

		        $validate 				= 	$authentication_model->validate_login($postData);
		        
		        if ($validate)
		        {
		            $newdata = array(
		                'email_adm'    	=> $validate[0]->email,
		                'name_adm'		=> $validate[0]->name,
		                'role_adm'		=> $validate[0]->role,
		                'user_id_adm'	=> $validate[0]->user_id,
		                'logged_adm' 	=> true,
		              
		            );
		            $session->set($newdata);

		            $data = [
		            		'alert' => true
		            		];

		            return $this->respond($data);
		        }
		        else
		        {
		            $data = [
		            		'alert' => false,
		            		'msg' 	=> 'system'
		            		];

		            return $this->respond($data);
		        }
			}
			else
			{
	            $data = [
	            		'alert' => false,
	            		'msg' 	=> 'captcha'
	            		];

	            return $this->respond($data);
			}

		}
    }

    public function logout()
    {
		$this->session->destroy();
		return redirect()->to('panelauth');
    }


}