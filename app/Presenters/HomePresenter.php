<?php declare(strict_types=1);

namespace App\Presenters;

use Nette\Security\AuthenticationException;
use App\Model\Entity\User;
use App\Model\Service\UserService;
use Nette\Application\UI\Form;

final class HomePresenter extends BasePresenter
{
    public UserService $us;

    public function __construct(UserService $us)
    {
        $this->us = $us;
    }

    public function startup()
    {
        parent::startup();

        if ($this->getUser()->isLoggedIn() === false && $this->getAction() !== 'signIn') 
        {
            $this->flashMessage('Tato sekce není přístupná bez přihlášení!');
            $this->redirect('signIn');
        } 
    }

    public function actionDefault()
    {
        //$user = new User('Pavel', 'Klus', 'pavel.klus@continental-corporation.com', 'UIDM2061', 'Jisap.1979');
        //$user->nickname = 'Pavlik';
        //$this->us->fluschUser($user);

        //$user = $this->us->findUserByEmail('kluspavel@gmail.com');
        //$user = $this->us->findUserById(2);

        //dump($user);
    }

    public function actionOrders()
    {
        $this->setLayout('orders');
    }

    public function actionSignIn()
    {
        $this->setLayout('orders');
    }

    public function actionSignOut()
    {
        $this->getUser()->logout(true);
    }

    protected function createComponentSignInForm(): Form
    {
        $form = new Form();
        $form->addText('username', 'Uživatelské ID');
        $form->addPassword('password', 'Vaše heslo');
        $form->addSubmit('send', 'Přihlásit se');
        $form->onSuccess[] = [$this, 'signInFormSuccess'];
        return $form;
    }

    public function signInFormSuccess(Form $form)
    {
        $values = $form->getValues();

        try 
        {
            $this->getUser()->login($values->username, $values->password);
        } 
        catch (AuthenticationException $e) 
        {
            $this->flashMessage($e->getMessage(), 'danger');
            $this->redirect('signIn');
        }

        $this->redirect('orders');
    }
}