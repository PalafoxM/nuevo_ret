<?php
/*
|--------------------------------------------------------------------------
| Constantes del proyecto
|--------------------------------------------------------------------------
*/
/* Development */
define('BASE_ROOT', '/laragon/www/ret/');
define('BASE_URL', 'https://127.0.0.1/ret/public/');
define('BD_USER', 'root');
define('BD_PASS', 's3d3turgt0');
define('BD_NAME', 'sectur_ret');
define('EMAIL_CC', 'conectimx@gmail.com');
define('EMAIL_BCC', 'mgmankel@gmail.com');
define('PROTOCOL_GMAIL', 'smtp');
define('SMTPHOST_GMAIL', 'ssl://smtp.gmail.com');
// Google reCAPTCHA
define('SITE_KEY', '6LfPBZwcAAAAAOWI-4G4JU5iAsD4TeFfTxrvRQTE');
define('SECRET_KEY', '6LfPBZwcAAAAAJbrwQz7xKy56rQwwpCuG5hR5jjA');
// Google OAuth
define('GOOGLE_ID', '456360067698-f67k8urgv2riigh5oeoq4g1777obijap.apps.googleusercontent.com');
define('GOOGLE_SECRET', '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');
// Microsoft OAuth
define('MICROSOFT_ID', '5978c835-2e37-4b9a-9e5f-62618a53c92d');
define('MICROSOFT_SECRET', '3527Q~2R4kKytKiCTLsaGUCcJuuPBZ6AfPDWM');
// Facebook OAuth
define('FACEBOOK_ID', '685989632411440');
define('FACEBOOK_SECRET', 'd07ba3c99d180a847c1ef1e392695933');

/* Production 
define('BASE_ROOT', '/var/www/html/ret/');
define('BASE_URL', 'https://registroestataldeturismo.guanajuato.gob.mx/');
define('BD_USER', 'root');
define('BD_PASS', '1deA&3FeCT1v@S');
define('BD_NAME', 'gto_ret');
define('EMAIL_CC', 'conectimx@gmail.com');
define('EMAIL_BCC', 'ret@guanajuato.gob.mx');
define('PROTOCOL_GMAIL', 'smtp');
define('SMTPHOST_GMAIL', 'ssl://smtp.gmail.com');
// Google reCAPTCHA
define('SITE_KEY', '6LexgVkgAAAAAFEwUI6ZUOq_rmNd3cs2BDC6lCTQ');
define('SECRET_KEY', '6LfPBZwcAAAAAJbrwQz7xKy56rQwwpCuG5hR5jjA');
// Google OAuth
define('GOOGLE_ID', '460048895404-4uag379t8jb6kliak4a9bodr5en9o8f8.apps.googleusercontent.com');
define('GOOGLE_SECRET', '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');
// Microsoft OAuth
define('MICROSOFT_ID', 'd62d5e1e-81f0-44f7-9d6e-2fa5831a83d4');
define('MICROSOFT_SECRET', 'vFE8Q~5ZutZlIUM3n66VCE6EBsRc7LK~VmevUdl9');
// Facebook OAuth
define('FACEBOOK_ID', '1455395174913405');
define('FACEBOOK_SECRET', 'd07ba3c99d180a847c1ef1e392695933');*/

/* Static path */
define('STATIC_CSS', 'static/css/');
define('STATIC_JS', 'static/js/');
define('STATIC_IMG', 'static/images/');
define('STATIC_ICO', 'static/ico/');

/* Google Maps */
define('GOOGLE_MAPS', 'AIzaSyDfryN_Ua60Q9kEDkr1q63NaoSyNQdGngA');


/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');

/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
