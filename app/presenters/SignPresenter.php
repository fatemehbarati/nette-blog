<?php
/**
 * Created by PhpStorm.
 * User: muhammad
 * Date: 9/27/2017
 * Time: 1:04 PM
 */

namespace App\Presenters;


use App\Model\UserManager;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Security\AuthenticationException;
use Nette\Utils\ArrayHash;

class SignPresenter extends Presenter
{

    /** @var UserManager @inject*/
    public $userManager;

//    public function __construct(UserManager $userManager)
//    {
//
//        $this->userManager = $userManager;
//    }

    protected function createComponentSignInForm()
    {
        $form = new Form();

        $form->addText('username', 'Username : ')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password : ')
            ->setRequired('Please neter your password.');

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

    public function createComponentRegistrationForm()
    {
        $form = new Form();

        $form->addText('username', 'Username : ')
            ->setRequired('Please enter your username.');

        $form->addPassword('password', 'Password : ')
            ->setRequired('Please enter your password.')
            ->addRule(FORM::MIN_LENGTH, 'Your password has to be at least %s long.', 3);

        $form->addPassword('passwordVerify', 'Password again:')
            ->setRequired('Fill your password again to check for typo')
            ->addRule(Form::EQUAL, 'Password mismatch', $form['password']);

        $form->addSubmit('login', 'Sign Up');

        $form->onSuccess[] = [$this, 'registrationFormSucceeded'];

        return $form;
    }

    public function registrationFormSucceeded(Form $form, $values)
    {
        $this->userManager->signUpUser($values);

        $this->flashMessage('You have successfully signed up.');
        $this->redirect('Homepage:');
    }

}