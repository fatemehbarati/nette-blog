<?php
/**
 * Created by PhpStorm.
 * User: muhammad
 * Date: 9/27/2017
 * Time: 6:38 PM
 */
namespace App\Model;



use App\Model\Entity\Article;
use App\Model\Entity\Repository\ArticleRepository;
use Nette\Database\Context;
use Nette\Utils\DateTime;

class ArticleManager
{
    private $database;
    private $articleRepo;

    public function __construct(Context $database, ArticleRepository $articleRepo)
//    public function __construct(Context $database)
    {
        $this->database = $database;
        $this->articleRepo = $articleRepo;
    }

    public function getPublicArticles()
    {
        $articles = $this->articleRepo->findAll();
        return $articles;
        var_dump($articles);exit;
//        $this->getDoctrine()->getRepository(Article::class);
//        return $this->articleRepo->findAll();

        return $this->database->table('posts')
            ->where('created_at <' , new \DateTime())
            ->order('created_at');
    }
}