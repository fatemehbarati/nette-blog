<?php
/**
 * Created by PhpStorm.
 * User: muhammad
 * Date: 9/27/2017
 * Time: 6:38 PM
 */
namespace App\Model;



use Nette\Database\Context;
use Nette\Utils\DateTime;

class ArticleManager
{
    private $database;

    public function __construct(Context $database)
    {
        $this->database = $database;
    }

    public function getPublicArticles()
    {
        return $this->database->table('posts')
            ->where('created_at <' , new \DateTime())
            ->order('created_at');
    }
}