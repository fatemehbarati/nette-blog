<?php
/**
 * Created by PhpStorm.
 * User: Barati
 * Date: 9/26/2017
 * Time: 10:54 AM
 */

namespace App\Presenters;

use App\Forms\CommentForm;
use App\Forms\PostForm;
use App\Model\Entity\Comment;
use App\Model\Entity\Repository\CommentRepository;
use App\Model\Entity\Repository\PostRepository;
use App\Model\PostModel;
use Nette\Application\ForbiddenRequestException;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Database\Context;

class PostPresenter extends Presenter
{

    /** @var  PostForm @inject */
    public $postForm;

    /** @var  PostRepository @inject */
    public $postRepo;

    /** @var CommentRepository @inject  */
    public $commentRepo;

    /** @var CommentForm @inject */
    public $commentForm;

//    public function __construct(PostForm $postForm, PostRepository $postRepo, CommentRepository $commentRepo, CommentForm $commentForm)
//    {
//
//        $this->postForm = $postForm;
//        $this->postRepo = $postRepo;
//        $this->commentRepo = $commentRepo;
//        $this->commentForm = $commentForm;
//    }

    public function renderShow($postId){
        $post = $this->postRepo->find($postId);

        if(!$post){
            $this->error('Post Not Found!');
        }

        $this->template->post = $post;
        $this->template->comments = $post->comments;

    }

    protected function createComponentCommentForm()
    {

        $form = $this->commentForm->create();

        return $form;
    }

    public function actionEdit($postId)
    {
        if(!$this->getUser()->isLoggedIn()){
            $this->redirect('Sign:In');
        }

        $post = $this->postRepo->find($postId);

        if(!$post)
        {
            $this->error('Post not found!');
        }

        $this['postForm']->setDefaults(get_object_vars($post));
    }

    public function actionCreate()
    {
        if(!$this->getUser()->isLoggedIn()){
            $this->redirect('Sign:In');
        }
    }

    public function createComponentPostForm()
    {

        $form = $this->postForm->create();

        return $form;
    }

    /*
    public function postFormSucceeded($form, $values)
    {
        if(!$this->getUser()->isLoggedIn()) {
            $this->error('You need to log in to create or edit posts');
        }

        $postId = $this->getParameter('postId');

        if($postId){
            $post = $this->database->table('posts')->get($postId);
            $post->update($values);
        }
        else
        {
            $post = $this->database->table('posts')->insert($values);
        }


        $this->flashMessage("Post was published", 'success');
        $this->redirect('show', $post->id);
    }
    */


}