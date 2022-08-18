<?php

namespace MyProject\Views;
use MyProject\Models\Users\UsersAuthService as UsersAuthService;

    
class View {
    public $path;
    public $user;


    public function __construct()
    {
        $this->path = __DIR__ . '/../../template';
     $this->user = UsersAuthService::getUserByToken();
    }

    
    public function render($template, $array = [], int $code = 200)
    {
        
        http_response_code($code);
        extract($array);
         
       $user = $this->user; //имя в шапке
        require $this->path . $template;
        
    }
}