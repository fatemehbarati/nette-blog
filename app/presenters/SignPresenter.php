<?php
/**
 * Created by PhpStorm.
 * User: muhammad
 * Date: 9/27/2017
 * Time: 1:04 PM
 */

namespace App\Presenters;


use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Security\AuthenticationException;
use Nette\Utils\ArrayHash;

class SignPresenter extends Presenter
{

    protected function createComponentSignInForm()
    {
        $form = new Form();

        $form->addText('username', 'Username : ')->setRequired('Please enter your username.');
        $form->addPassword('password', 'Password : ')->setRequired('Please neter your password.');

        $form->addSubmit('send', 'Sign In');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];

        return $form;
    }

    public function signInFormSucceeded(Form $form, ArrayHash $values)
    {
        try{
            $this->getUser()->login($values->username, $values->password);
            $this->redirect('Homepage:default');
        }catch (AuthenticationException $exception){
            $form->addError($exception->getMessage());
//            $form->addError('Username or Password is not correct!');
        }
    }

    public function actionOut(){
        $this->getUser()->logout();
        $this->flashMessage('You have been signed out.');
        $this->redirect('Homepage:default');
    }

}