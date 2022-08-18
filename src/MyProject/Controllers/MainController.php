<?php

namespace MyProject\Controllers;

use  MyProject\Views\View as View;
use  MyProject\Services\Db as Db;
use MyProject\Models\Articles\Article as Article;
use MyProject\Services\Pagination as Pagination;

use MyProject\Models\Users\UsersAuthService as UsersAuthService;

class MainController {
    
    public $view;
    public $db;
    public $user;
    
    public function __construct(View $view, Db $db)
    {
        $this->view = $view;
        $this->db = $db;
        $this->user = UsersAuthService::getUserByToken();
        
    }
    
    public function main()
    {

        $articles = new Article;
         $total = $articles->count();
         $pagination = new Pagination($total);
         
         $currentPage = 1;
         $articles = $articles->findPart($currentPage);
         $this->view->render('/main/main.php', ['articles' => $articles, 'pagination' => $pagination]);
    }

    public function main2()
    {
        $articles = new Article;
        $total = $articles->count();
        $pagination = new Pagination($total);

        preg_match('~^/articles/page/(\d+)$~', $_SERVER["REQUEST_URI"], $matches);

       $currentPage = $matches[1];
        
        $articles = $articles->findPart($currentPage);
        
        
        $this->view->render('/main/main.php', ['articles' => $articles, 'pagination' => $pagination]);
    }
}