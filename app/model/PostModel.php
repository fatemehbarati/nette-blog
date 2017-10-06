<?php
namespace App\Model;

use App\Model\Entity\Post;
use App\Model\Entity\Repository\PostRepository;

use Kdyby\Doctrine\EntityManager;
use Nette\Database\Context;
use Nette\Utils\DateTime;

class PostModel
{
    public $database;

    /** @var PostRepository  */
    public $postRepo;

    /** @var  EntityManager */
    public $em;

    public function __construct(Context $database, PostRepository $postRepo, EntityManager $em)
    {

        $this->database = $database;
        $this->postRepo = $postRepo;
        $this->em = $em;
    }

    public function getPublicArticles()
    {
        $articles = $this->postRepo->findAll();
        return $articles;
    }

    public function addNewPost($values)
    {

        $post = new Post();
        $post->content = $values['content'];
        $post->title = $values['title'];

        $this->em->persist($post);
        $this->em->flush();

        return $post->id;
    }

    public function getPostById($postId)
    {
        return $this->postRepo->find($postId);
    }

    public function updateWithId($postId, $values)
    {
        $post = $this->postRepo->find($postId);
        $post->title = $values['title'];
        $post->content = $values['content'];

        $this->em->persist($post);
        $this->em->flush();
    }
}