<?php
defined('COOKIELOCAL')
    || define('COOKIELOCAL', str_replace('\\', '/', realpath('./')).'/');
    
defined('BASE_PATH')
    || define('BASE_PATH', realpath(dirname(__FILE__)));

defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', BASE_PATH . '/../application');

defined('LIBRARY_PATH')
    || define('LIBRARY_PATH', BASE_PATH . '/../library');

/*defined('APP_NAME')
    || define('APP_NAME', 'saneabc');
*/
/*
defined('_MPDF_PATH')
    || define('_MPDF_PATH', LIBRARY_PATH . '/SC/Plugins/pdf/');

defined('_MPDF_URI')
    || define('_MPDF_URI', _MPDF_PATH);*/

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', getenv('APPLICATION_ENVIROMENT') ? getenv('APPLICATION_ENVIROMENT') : 'development');

set_include_path(
    BASE_PATH . '/../library'
    . PATH_SEPARATOR . APPLICATION_PATH . '/models'
    . PATH_SEPARATOR . get_include_path()
    . PATH_SEPARATOR . '.'
);

require_once 'Zend/Application.php';
require_once 'Zend/Db.php';

$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');

$application->bootstrap()->run();

?>