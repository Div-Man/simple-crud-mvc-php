<?php

namespace MyProject\Controllers;

use MyProject\Models\Articles\Article as Article;
use MyProject\Models\Users\User as User;
use MyProject\Exceptions\UnauthorizedException as UnauthorizedException;
use MyProject\Exceptions\InvalidArgumentException as InvalidArgumentException;

class ArticlesController extends MainController {

     public function view(int $articleId)
    {
       
        $article = new Article();
        $article = $article->getById($articleId);

        if (empty($article)) {
            $this->view->render('/errors/404.php', [], 404);
            return;
        }

          $this->view->render('/articles/view.php', [
            'article' => $article  
        ]);
    }

    public function edit(int $articleId): void
    {

        $article = new Article();
        $article = $article->getById($articleId);

       
        if ($article === null) {
            throw new \Exception('Страница не найдена.');
            return;
        }

        if ($this->user === null) { 
            throw new UnauthorizedException();
        }

        if($this->user->getRoleUser() === 'user'){
            throw new \Exception('Только администатору можно редактировать статьи');
            return;
        }
        

   
        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->render('/articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
                 
                return;
            }
            
            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }
        $this->view->render('/articles/edit.php', ['article' => $article]);
     
       
    }

    public function add(): void
    {     
           if ($this->user === null) {
               throw new UnauthorizedException();
           }

          
           if (!empty($_POST)) {
               try {
                   $article = Article::createFromArray($_POST, $this->user);
               } catch (InvalidArgumentException $e) {
                   $this->view->render('/articles/add.php', ['error' => $e->getMessage()]);
                   return;
               }
               
               header('Location: /articles/' . $article->db->getLastInsertId(), true, 302);
               exit();
           }
           
        $this->view->render('/articles/add.php', []);
    }

    public function delete(int $articleId): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if($this->user->getRoleUser() === 'user'){
            throw new \Exception('Только администатору можно удалять статьи');
            return;
        }
         $article = new Article();
         $article->delete($articleId);
         header('Location: /');
        
    }
}