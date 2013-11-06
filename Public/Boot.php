<?php 
/*Define some path*/
define('DIR_PUBLIC', $_SERVER['DOCUMENT_ROOT']);
define('DIR_ROOT', dirname(__DIR__));

/*Init enviroment for system*/
include_once DIR_ROOT.'/Library/Framework/Environment.php';
try
{
    System\Environment::InitSystem(dirname(__DIR__), '/Framework');
} 
catch (Exception $Ex) 
{
    echo 'Can not init environment for system <br>';
    echo 'Exception: '.$Ex->getMessage().'<br>';
    echo 'Booter will exit now';
    exit();
}
/*Startup a MVCM application follow path*/
\System\Console::BootMvcm(DIR_ROOT.'/Application', '\Application');

/*Show time process*/
//echo '<br><br><br>';
//echo 'Create page about: '.\System\Time\Now::Gone('SYS_INIT');
//echo '<br> Memory usage: '.  number_format(memory_get_usage(TRUE), 0, 0, ' ').' bytes';
