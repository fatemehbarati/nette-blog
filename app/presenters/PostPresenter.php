<?php
/**
 * Created by PhpStorm.
 * User: Barati
 * Date: 9/26/2017
 * Time: 10:54 AM
 */

namespace App\Presenters;

use Nette\Application\ForbiddenRequestException;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Database\Context;

class PostPresenter extends Presenter
{

    /** @var  Context */
    private $database;

    public function __construct(Context $database)
    {
        $this->database = $database;
    }

    public function renderShow($postId){
        $post = $this->database->table('posts')->get($postId);

        if(!$post){
            $this->error('Post Not Found!');
        }

        $this->template->post = $post;
        $this->template->comments = $post->related('comments')->order('created_at');
    }

    protected function createComponentCommentForm()
    {
        $form = new Form;

        $form->addText('name', 'Your Name:')->setRequired();
        $form->addText('email', 'Email:');
        $form->addTextArea('content', 'Comment:')->setRequired();
        $form->addSubmit('send', 'Publish Comment');

        $form->onSuccess[] = [$this, 'commentFormSucceeded'];

        return $form;
    }

    public function commentFormSucceeded($form, $value)
    {
        $postId = $this->getParameter('postId');

        $this->database->table('comments')->insert(
            array(
                'post_id' => $postId,
                'name' => $value->name,
                'email' => $value->email,
                'content' => $value->content
            )
        );

        $this->flashMessage('Thank you for your comment', 'success');
        $this->redirect('this');
    }

    protected function createComponentPostForm()
    {
        $form = new Form();

        $form->addText('title', 'Title : ')->setRequired();
        $form->addTextArea('content', 'Content : ')->setRequired();

        $form->addSubmit('save', 'Publish and Save');
        $form->onSuccess[] = [$this , 'postFormSucceeded'];

        return $form;
    }

    public function postFormSucceeded($form, $values)
    {
        $post = $this->database->table('posts')->insert($values);

        $this->flashMessage("Post was published", 'success');
        $this->redirect('show', $post->id);
    }
}