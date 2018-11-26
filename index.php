<?php
/*
require_once('vendor/autoload.php');
$f3 = Base::instance();
$f3->config('App/Config/setup.cfg');
$f3->config('App/Config/routes.cfg');
new Session();

$f3->run();
*/


//session_start();
require_once("vendor/autoload.php");

$f3 = Base::instance();

$f3->config('App/Config/setup.cfg');
$f3->config('App/Config/routes.cfg');

new Session();
// 
//$cache=Cache::instance(); // Default cache (the one defined by the CACHE variable)
//$sessionCache=new Cache('folder=App/sessions/'); // Session cache
//new Session(NULL,NULL,$sessionCache);
// echo session_save_path();

$f3->run();
