<?php

namespace App\Controllers;

class Inicio extends BaseController
{
    public function index()
    {
        if($this->session->get('logged'))
            return redirect()->to('datos-generales');
        else if($this->session->get('api_logged'))
            return redirect()->to('panel');
        else
        {
            $data['title']              =       'Secretaría de Turismo del Estado de Guanajuato | Registro Estatal de Turismo';
            $data['head_js']            =   array(
                                                BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js'
                                            );
            $data['head_css']           =   array(
                                                BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
                                                BASE_URL.STATIC_CSS.'template.css?v=1.1.2',
                                                BASE_URL.STATIC_CSS.'header.css',
                                                BASE_URL.STATIC_CSS.'inicio.css?v=2.0',
                                                BASE_URL.STATIC_CSS.'footer.css?v=1.1',
                                                BASE_URL.STATIC_CSS.'bootstrap-icons.css',                                          
                                            );
            $data['nav']            =       'public/nav';
            $data['header']         =       'public/header';
            $data['main']           =       'public/inicio';
            $data['footer']         =       'public/footer';

            return view('template', $data);
        }

    }
}
