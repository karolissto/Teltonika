
<?php

include 'core/autoload.php';

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('VIEW', ROOT . 'teltonika' . DIRECTORY_SEPARATOR .  'views'. DIRECTORY_SEPARATOR);
define('MODEL', ROOT . 'teltonika' . DIRECTORY_SEPARATOR . 'models'. DIRECTORY_SEPARATOR);
define('CONTROLLER', ROOT . 'teltonika' . DIRECTORY_SEPARATOR. 'controllers'. DIRECTORY_SEPARATOR);
define('DATA', ROOT . 'teltonika' . DIRECTORY_SEPARATOR . 'data'. DIRECTORY_SEPARATOR);
define('CORE', ROOT . 'teltonika' . DIRECTORY_SEPARATOR . 'core'. DIRECTORY_SEPARATOR);

$modules = [ROOT,VIEW,MODEL,CONTROLLER,DATA,CORE];

set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR,$modules));

new application;




