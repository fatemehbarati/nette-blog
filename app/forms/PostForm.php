<?php
namespace App\Forms;

use App\Forms\Interfaces\IPostFormFactory;
use App\Model\PostModel;
use Nette\Application\Application;
use Nette\Application\UI\Form;

class PostForm implements IPostFormFactory
{

    /**
     * PostForm constructor.
     * @param PostModel $postModel
     * @param Application $application
     */
    public function __construct(PostModel $postModel, Application $application)
    {

        $this->postModel = $postModel;
        $this->application = $application;
    }

    public function create()
    {
        $form = new Form();

        $form->addText('title', 'Title : ')->setRequired();
        $form->addTextArea('content', 'Content : ')->setRequired();

        $form->addSubmit('save', 'Publish and Save');
        $form->onSuccess[] = [$this , 'postFormSucceeded'];

        return $form;
    }

    public function postFormSucceeded(Form $form, $values)
    {

        if(!$this->application->getPresenter()->getUser()->isLoggedIn()) {
            $this->application->getPresenter()->error('You need to log in to create or edit posts');
        }

        $postId = $this->application->getPresenter()->getParameter('postId');

        if($postId){
//            $post = $this->postModel->getPostById($postId);
            $this->postModel->updateWithId($postId, $values);
        }
        else
        {

            $postId = $this->postModel->addNewPost($values);
        }


        $this->application->getPresenter()->flashMessage("Post was published", 'success');
        $this->application->getPresenter()->redirect('show', $postId);
    }
}