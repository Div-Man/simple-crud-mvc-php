<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require __DIR__ . '/src/helpers.php';
require __DIR__ . '/vendor/autoload.php'; //композер


function myAutoload($class){
      require __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php' ;
}

try{
    spl_autoload_register('myAutoload');

$view = new MyProject\Views\View; //для DI
$db = new MyProject\Services\Db;


$routes = require __DIR__ . '/src/routes.php';

$currentRoute = $_SERVER['REQUEST_URI'];

$routeFound = false;

foreach($routes as $url => $classAndMethod){
    preg_match($url, $currentRoute, $matches);
    if(!empty($matches)){
        $routeFound = true;
        break;
    }
}


if(!$routeFound) {
    throw new \Exception('Страница не найдена.');
    return;
}

unset($matches[0]);
    
$controllerName = $classAndMethod[0];
$classMethod = $classAndMethod[1];

$controller = new $controllerName($view, $db);
echo $controller->$classMethod(...$matches);


} 

catch (\MyProject\Exceptions\UnauthorizedException $e) {
     $view->render('/errors/401.php', ['error' => $e->getMessage()], 401);    
}

catch (\Exception $e) {
     echo $e->getMessage();
}


//var_dump(\MyProject\Services\Db::getInstancesCount()); количество подключений к базе
