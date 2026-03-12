<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Inicio');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(
        function()
        {
            $this->session          = \Config\Services::session();
            $data['title']              =       'Registro Estatal de Turismo | ';
            $data['head_js']            =   array(
                                                BASE_URL.STATIC_JS.'bootstrap.bundle.min.5.1.0.js'
                                            );
            $data['head_css']           =   array(
                                                BASE_URL.STATIC_CSS.'bootstrap.min.5.1.0.css',
                                                BASE_URL.STATIC_CSS.'template.css?v=1.1.1',
                                                BASE_URL.STATIC_CSS.'header.css',
                                                BASE_URL.STATIC_CSS.'redireccion.css?v=1.1',
                                                BASE_URL.STATIC_CSS.'footer.css?v=1.1',
                                                BASE_URL.STATIC_CSS.'bootstrap-icons.css',                                          
                                            );
            if($this->session->get('api_logged') || $this->session->get('logged'))
            {
                $data['nav']            =       'private/nav';
                $data['header']         =       'private/header';
            }
            else
            {
                $data['nav']            =       'public/nav';
                $data['header']         =       'public/header';
            }
            
            $data['main']           =       'public/redireccion';
            $data['footer']         =       'public/footer';

            $data['message']        =       'Error 404';
            $data['icon']           =       'bug';
            $data['time']           =       5000;

            $data['subtitle']       =       'Página no encontrada';
            $data['url']            =       BASE_URL;
            $data['title']          .=      $data['subtitle'];
            
            return view('template', $data);
        });
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Inicio::index');

//Sitio Público
$routes->get('telefono', 'Redireccion::enlace/1');
$routes->get('email', 'Redireccion::enlace/2');
$routes->get('categorias-ret', 'Redireccion::documento/1');
$routes->get('base-legal', 'Redireccion::documento/2');
$routes->get('beneficios', 'Redireccion::documento/3');
$routes->get('requisitos', 'Redireccion::documento/4');
$routes->get('que-giro', 'Redireccion::documento/5');
$routes->get('preguntas-frecuentes', 'Redireccion::documento/6');
$routes->get('rnt', 'Redireccion::enlace/3');
$routes->get('categorias-rnt', 'Redireccion::documento/7');
$routes->get('base-legal-rnt', 'Redireccion::documento/8');
$routes->get('formato-unico-rnt', 'Redireccion::documento/9');
$routes->get('beneficios-rnt', 'Redireccion::documento/10');
$routes->get('schgobmx', 'Redireccion::enlace/4');
$routes->get('sch', 'Redireccion::documento/11');
$routes->get('base-legal-sch', 'Redireccion::documento/12');
$routes->get('simulador', 'Redireccion::documento/13');
$routes->get('lineamientos', 'Redireccion::documento/14');
$routes->get('tramite-acreditacion-guias', 'Redireccion::documento/15');
$routes->get('consulta-guias', 'Redireccion::documento/16');
$routes->get('consulta-turistica', 'Redireccion::enlace/6');
$routes->get('manual-ret', 'Redireccion::documento/17');
$routes->get('manual-rnt', 'Redireccion::documento/18');
$routes->get('manual-sch', 'Redireccion::documento/19');
$routes->get('protocolo-alba', 'Redireccion::enlace/7');
$routes->get('secturgto', 'Redireccion::enlace/8');
$routes->get('oteg', 'Redireccion::enlace/9');
$routes->get('gtomx', 'Redireccion::enlace/10');
$routes->get('secturmx', 'Redireccion::enlace/11');
$routes->get('facebook', 'Redireccion::enlace/12');
$routes->get('twitter', 'Redireccion::enlace/13');
$routes->get('consulta-publica', 'Redireccion::enlace/14');
$routes->get('aviso-legal', 'Redireccion::documento/20');
$routes->get('aviso-privacidad', 'Redireccion::documento/21');
$routes->get('error404', 'Redireccion::enlace/15');

//Sesión de Usuarios
$routes->post('pre-registro', 'Registro::recaptcha');
$routes->post('registro-guardar', 'Registro::guardar');
$routes->post('sesion', 'Ingresar::recaptcha');
$routes->post('actualizar-contrasena', 'Contrasena::actualizar');
$routes->post('guardar-form', 'Guardar_form');
$routes->get('cambiar-contrasena', 'Contrasena');
$routes->get('registro/google-signin', 'Registro::google_signin');
$routes->get('registro/microsoft-signin', 'Registro::microsoft_signin');
$routes->get('registro/facebook-signin', 'Registro::facebook_signin');
$routes->get('ingresar/google-login', 'Ingresar::google_login');
$routes->get('ingresar/microsoft-login', 'Ingresar::microsoft_login');
$routes->get('ingresar/facebook-login', 'Ingresar::facebook_login');

//Registro de PST
$routes->get('datos-generales', 'Datos_generales');
$routes->get('datos-tecnicos', 'Datos_tecnicos');
$routes->get('datos-legales', 'Datos_legales');
$routes->get('concluir-registro', 'Concluir_registro');
$routes->get('empresa-avance', 'Empresa_avance');
$routes->get('hospedaje-digital', 'Hospedaje_digital');
$routes->get('panel/enviar-cedula/(:any)', 'Panel::enviar_cedula/$1');
$routes->get('panel/eliminar-empresa/(:any)', 'Panel::eliminar_empresa/$1');

//Administrador
$routes->post('paneladm/enviar-observaciones', 'Paneladm::enviar_observaciones');
$routes->get('paneladm/eliminar-todos', 'Paneladm::eliminar_todos');
$routes->get('paneladm/reminder-ret', 'Paneladm::reminder');

// Consulta Ciudadana
$routes->post('consulta-ciudadana', 'Consulta_ciudadana');
$routes->get('consulta-ciudadana', 'Consulta_ciudadana');
$routes->get('consulta-ciudadana/ver', 'Consulta_ciudadana::ver');
$routes->get('consulta-ciudadana/ver/(:any)', 'Consulta_ciudadana::ver/$1');
$routes->post('consulta-ciudadana/listado', 'Consulta_ciudadana::listado');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
