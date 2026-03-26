<?php

    if(!function_exists('isMd5')) 
    {
        function isMd5($md5 = '')
        {
            return preg_match('/^[a-f0-9]{32}$/', $md5);
        }
    }

    if(!function_exists('password_generator')) 
    {
        function password_generator($pass_length = 8)
        {
            $str_pwd = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz1234567890-_";
            $str_rnd = "";

            for($i = 0; $i < $pass_length; $i ++) 
            {
                $str_rnd .= substr($str_pwd, rand(0, 57), 1);
            }

            return $str_rnd;

        }
    }

    if(!function_exists('string_generator')) 
    {
        function string_generator($pass_length = 8)
        {
            $str_pwd = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz1234567890";
            $str_rnd = "";

            for($i = 0; $i < $pass_length; $i ++) 
            {
                $str_rnd .= substr($str_pwd, rand(0, 55), 1);
            }

            return $str_rnd;

        }
    }

    if(!function_exists('ret_login')) 
    {
        function ret_login($usuario,$passkey)
        {
            $usuario_model          = new \App\Models\Usuario_model();

            $passkey_bd = $usuario_model->get($usuario,'pass');
            $estatus = $usuario_model->get($usuario,'activo');
            
            if($passkey_bd && $estatus)
            {

                if(isMd5($passkey_bd))
                {
                    return (md5($passkey) == $passkey_bd && $estatus == 1);
                }
                else
                {
                    return (password_verify($passkey, $passkey_bd) && $estatus == 1);
                }
            }
            else
                return false;
        }
    }

    if(!function_exists('field_replace')) 
    {
        function field_replace($cadena)
        {
            $cadena=str_replace('á','a',$cadena);
            $cadena=str_replace('Á','A',$cadena);
            $cadena=str_replace('é','e',$cadena);
            $cadena=str_replace('É','E',$cadena);
            $cadena=str_replace('í','i',$cadena);
            $cadena=str_replace('Í','I',$cadena);
            $cadena=str_replace('ó','o',$cadena);
            $cadena=str_replace('Ó','O',$cadena);
            $cadena=str_replace('ú','u',$cadena);
            $cadena=str_replace('Ú','U',$cadena);
            $cadena=str_replace('ñ','ñ',$cadena);
            $cadena=str_replace('Ñ','Ñ',$cadena);
            $cadena=str_replace('.','',$cadena);
            $cadena=str_replace(',','',$cadena);
            $cadena=str_replace('/','',$cadena);
            $cadena=str_replace('\'','',$cadena);
            $cadena=str_replace('\\','',$cadena);
            $cadena=str_replace('|','',$cadena);
            $cadena=str_replace('"','',$cadena);
            return $cadena;
        }
    }

    if(!function_exists('file_rename')) 
    {
        function file_rename($cadena)
        {
            $cadena=str_replace('á','a',$cadena);
            $cadena=str_replace('Á','A',$cadena);
            $cadena=str_replace('é','e',$cadena);
            $cadena=str_replace('É','E',$cadena);
            $cadena=str_replace('í','i',$cadena);
            $cadena=str_replace('Í','I',$cadena);
            $cadena=str_replace('ó','o',$cadena);
            $cadena=str_replace('Ó','O',$cadena);
            $cadena=str_replace('ú','u',$cadena);
            $cadena=str_replace('Ú','U',$cadena);
            $cadena=str_replace('ñ','n',$cadena);
            $cadena=str_replace('Ñ','N',$cadena);
            $cadena=str_replace('.','',$cadena);
            $cadena=str_replace(',','',$cadena);
            $cadena=str_replace('/','',$cadena);
            $cadena=str_replace('\'','',$cadena);
            $cadena=str_replace('\\','',$cadena);
            $cadena=str_replace('|','',$cadena);
            $cadena=str_replace('"','',$cadena);
            $cadena=str_replace('?','',$cadena);
            $cadena=str_replace('¿','',$cadena);
            $cadena=str_replace('!','',$cadena);
            $cadena=str_replace('¡','',$cadena);
            $cadena=str_replace('%','',$cadena);
            $cadena=str_replace(' ','_',$cadena);
            $cadena=str_replace('   ','_',$cadena);
            $cadena=str_replace('(','_',$cadena);
            $cadena=str_replace(')','_',$cadena);
            return $cadena;
        }
    }

    if(!function_exists('send_email')) 
    {
        function send_email($subject, $recipient_to, $message, $recipient_cc = EMAIL_CC, $recipient_bcc = '', $attach = '')
        {
                $email = \Config\Services::email();

                $config['protocol']         =   PROTOCOL_GMAIL;
                $config['SMTPHost']         =   preg_replace('/^ssl:\/\//', '', SMTPHOST_GMAIL);
                $config['SMTPPort']         =   '465';
                $config['SMTPTimeout']      =   '7';
                $config['SMTPUser']         =   'ret@guanajuato.gob.mx';
                $config['SMTPPass']         =   'rwqxovrdtrzacntx';
                $config['charset']          =   'utf-8';
                $config['SMTPCrypto']       =   'ssl';
                $config['newline']          =   "\r\n";
                $config['CRLF']             =   "\r\n";
                $config['mailType']         =   'html';
                $config['validate']         =   TRUE;

                $email->initialize($config);
                $email->setFrom('ret@guanajuato.gob.mx', 'Notificaciones RET');
                $email->setTo($recipient_to);
                
                if($recipient_cc != '')
                    $email->setCC($recipient_cc);
                
                if($recipient_bcc != '')
                    $email->setBCC($recipient_bcc);

                if($attach != '')
                    $email->attach($attach);
                
                $email->setSubject($subject);
                $email->setMessage($message);

                $success = $email->send();

                if(!$success)
                    log_message('error', 'No se pudo enviar correo "{subject}" a "{recipient}". {debug}', [
                        'subject'   =>  $subject,
                        'recipient' =>  $recipient_to,
                        'debug'     =>  trim(strip_tags($email->printDebugger(['headers']))),
                    ]);

                return $success;
        }
    }

    if(!function_exists('ret_session')) 
    {
        function ret_session($usuario)
        {
            $session                = \Config\Services::session();
            $usuario_model          = new \App\Models\Usuario_model();

            $datos_sesion = array(
                'logged'                =>  true,
                'id'                    =>  $usuario_model->get($usuario,'id'),
                'email'                 =>  $usuario_model->get($usuario,'email'),
                'id_perfil'             =>  $usuario_model->get($usuario,'id_perfil'),
                'giro'                  =>  $usuario_model->get($usuario,'giro'),
                'g_giro'                =>  $usuario_model->get($usuario,'g_giro'),
                'g_resumen'             =>  $usuario_model->get($usuario,'resumen'),
                'icon_bs'               =>  $usuario_model->get($usuario,'icon_bs'),
                'renew_key'             =>  (isMd5($usuario_model->get($usuario,'pass'))),
                'fecha'                 =>  date("Y-m-d H:i:s"),
                'api_logged'            =>  false,
                'api_source'            =>  '',
                'name'                  =>  $usuario_model->get($usuario,'nombre_comercial'),
                );

            $session->set($datos_sesion);
            return;
        }
    }

    if(!function_exists('panel_session')) 
    {
        function panel_session($email, $api_source, $name = '')
        {
            $session                = \Config\Services::session();

            $datos_sesion = array(
                'logged'                =>  false,
                'id'                    =>  '',
                'email'                 =>  $email,
                'id_perfil'             =>  '',
                'giro'                  =>  '',
                'g_giro'                =>  '',
                'g_resumen'             =>  '',
                'icon_bs'               =>  '',
                'renew_key'             =>  false,
                'fecha'                 =>  date("Y-m-d H:i:s"),
                'api_logged'            =>  true,
                'api_source'            =>  $api_source,
                'name'                  =>  $name,
                );

            $session->set($datos_sesion);
            return;
        }
    }

    if(!function_exists('valida_preregistro'))
    {
        function valida_preregistro($idpreregistro, $passkey)
        {
            $usuario_model          = new \App\Models\Usuario_model();


            $passkey_bd = $usuario_model->get_preregistro($idpreregistro, 'verification');
            $email      = $usuario_model->get_preregistro($idpreregistro, 'email');
            $used       = $usuario_model->get_preregistro($idpreregistro, 'used');

            if(password_verify($passkey, $passkey_bd))
            {
                if( $usuario_model->update_preregistro($idpreregistro, ($used == 1)))
                {
                    panel_session($email, 'email');

                    return true;

                }
                else
                    return false;
            }
            else
                return false;
        }
    }

    if(!function_exists('funcionalidad'))
    {
        function funcionalidad($idfuncionalidad)
        {
            $usuario_model          = new \App\Models\Usuario_model();

            if($usuario_model->get_funcionalidad($idfuncionalidad))
                return true;
            else
                return false;
        }
    }
