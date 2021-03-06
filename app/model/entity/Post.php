<?php
namespace App\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Model\Entity\Repository\PostRepository")
 * @ORM\Table(name="posts")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    public $id;

    /**
     * @ORM\Column(type="string")
     */
    public $title;

    /**
     * @ORM\Column(type="text")
     */
    public $content;

    /**
     * @ORM\Column(type="datetime")
     */
    public $created_at;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    public $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }
}