<?php 

namespace MyProject\Models\Articles;

use MyProject\Services\Db as Db;
use MyProject\Models\Users\User as User;
use MyProject\Exceptions\InvalidArgumentException as InvalidArgumentException;

class Article{
    private $id;
    private $name;
    private $text;
    public $author_id;
    public $created_at;

    public $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    public function getAuthor(): User //имя автора
    {
       return User::getById($this->author_id);
    }

    public function getData()
    {
        return $this->created_at;
    }


    public function setName($name)
    {
        $this->name = $name;
    }

    public function setText($text)
    {
        $this->text = $text;
    }
    public function setAuthor($author)
    {
        $this->author_id = $author;
    }

    public function save()
    {
        if(empty($this->id)){
           $sql = 'INSERT INTO articles (author_id, name, text) VALUES
            (' . $this->getAuthorId() . ',\'' . $this->getName() . '\', \'' . $this->getText() . '\');';

           $this->db->query($sql, [], self::class);
            
        }
        else {
            $sql = 'UPDATE articles SET (name, text) =
            (\'' . $this->getName() . '\', \'' . $this->getText() . '\')
            WHERE id = ' . $this->id;
            
            $this->db->query($sql, [], self::class);
        }  
    }

    public function updateFromArray(array $fields): Article
    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }
        
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }
        
        $this->setName($fields['name']);
        $this->setText($fields['text']);
        
        $this->save();
        
        return $this;
    }

    public function delete($articleId)
    {
        $sql = 'DELETE FROM articles WHERE id=:id';
        return $this->db->query($sql, [':id' => $articleId],  self::class);

    }
    
     public function findAll(): array
    {
        return $this->db->query('SELECT * FROM articles;', [], self::class);
    }
    
    public function findPart($page = 0, $limit = 10)
    {
        $offset = ($page-1) * $limit;
        $sql = "SELECT * FROM articles ORDER BY created_at DESC LIMIT " . $limit . " OFFSET " . $offset;

        
       return $this->db->query($sql, [], self::class);
    }

    public function count(): int
    {
        $sql = 'select count(*) from articles;';

    $result = $this->db->query($sql); 

    return $result[0]->count;
       
    }
    
      public function getById(int $id)
    {
        
        $entities = $this->db->query(
            'SELECT * FROM articles WHERE id=:id;',
            [':id' => $id],
           self::class
        
        );

        return $entities ? $entities[0] : null;
    }
    
     public function getAuthorId(): int
    {
        return (int) $this->author_id;
    }

    public static function createFromArray(array $fields, User $author): Article

    {
        if (empty($fields['name'])) {
            throw new InvalidArgumentException('Не передано название статьи');
        }
        
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст статьи');
        }
        
        $article = new Article();

    
        $article->setAuthor($author->getId());
        $article->setName($fields['name']);
        $article->setText($fields['text']);

        $article->save();
        
        return $article;
    }
}