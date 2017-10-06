<?php
namespace App\Model;

use App\Model\Entity\Comment;
use App\Model\Entity\Post;
use App\Model\Entity\Repository\CommentRepository;
use App\Model\Entity\Repository\PostRepository;

use Kdyby\Doctrine\EntityManager;
use Nette\Database\Context;
use Nette\Utils\DateTime;

class CommentModel
{
    public $database;

    /** @var CommentRepository  */
    public $commentRepo;

    /** @var  EntityManager */
    public $em;

    public function __construct(Context $database, CommentRepository $commentRepo, EntityManager $em)
    {

        $this->database = $database;
        $this->commentRepo = $commentRepo;
        $this->em = $em;
    }

    public function addNewComment($values)
    {

        $comment = new Comment();
        $comment->name = $values['name'];
        $comment->email = $values['email'];
        $comment->content = $values['content'];
        $comment->post = $values['post'];

        $this->em->persist($comment);
        $this->em->flush();

    }
}