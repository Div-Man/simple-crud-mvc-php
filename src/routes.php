<?php
return [
    '~^/main$~' => ['\MyProject\Controllers\MainController', 'main'],
    '~^/articles/page/(\d+)$~' => ['\MyProject\Controllers\MainController', 'main2'],
    '~^/articles/(\d+)$~' => ['\MyProject\Controllers\ArticlesController', 'view'],
    '~^/$~' => ['\MyProject\Controllers\MainController', 'main'],
    '~^/articles/(\d+)/edit$~' => ['\MyProject\Controllers\ArticlesController', 'edit'],
    '~^/articles/(\d+)/delete$~' => ['\MyProject\Controllers\ArticlesController', 'delete'],
    '~^/articles/add$~' => ['\MyProject\Controllers\ArticlesController', 'add'],
    '~^/users/register$~' => ['\MyProject\Controllers\UsersController', 'signUp'],
    '~^/users/(\d+)/activate/(.+)$~' => ['\MyProject\Controllers\UsersController', 'activate'],
    '~^/users/login$~' => ['MyProject\Controllers\UsersController', 'login'],
    '~^/users/logout$~' => ['MyProject\Controllers\UsersController', 'logout'],
    
];
