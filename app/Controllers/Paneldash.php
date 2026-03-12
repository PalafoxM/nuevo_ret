<?php
namespace App\Controllers;

class Paneldash extends BaseController {

    public function index() 
    {
    	if($this->session->get('logged_adm')) 
    	{
    		$data 		=	[
    						'main'		=>		'panelret/section/dashboard',
    						'name'		=>		ucfirst($this->session->get('name_adm')),
    						'email'		=>		$this->session->get('email_adm'),
    						];
	        return view('panelret/template', $data);
    	}
    	else
    		return redirect()->to('panelauth');
    }



}