<?php
/**
 * Created by PhpStorm.
 * User: muhammad
 * Date: 10/6/2017
 * Time: 11:21 AM
 */

namespace App\Forms;


use App\Forms\Interfaces\ICommentFormFactory;
use App\Model\CommentModel;
use App\Model\PostModel;
use Nette\Application\Application;
use Nette\Application\UI\Form;

class CommentForm implements ICommentFormFactory
{

    /**
     * CommentForm constructor.
     * @param Application $application
     * @param CommentModel $commentModel
     * @param PostModel $postModel
     */
    public function __construct(Application $application, CommentModel $commentModel, PostModel $postModel)
    {

        $this->application = $application;
        $this->commentModel = $commentModel;
        $this->postModel = $postModel;
    }

    public function create()
    {
        $form = new Form();

        $form->addText('name', 'Your Name:')->setRequired();
        $form->addText('email', 'Email:');
        $form->addTextArea('content', 'Comment:')->setRequired();
        $form->addSubmit('send', 'Publish Comment');

        $form->onSuccess[] = [$this, 'commentFormSucceeded'];

        return $form;
    }

    public function commentFormSucceeded(Form $form, $values)
    {

        $post_id = $this->application->getPresenter()->getParameter('postId');

        $values['post'] = $this->postModel->getPostById($post_id);

        $this->commentModel->addNewComment($values);

        $this->application->getPresenter()->flashMessage("Thank you for your comment", 'success');
        $this->application->getPresenter()->redirect('Homepage:default');
    }


}