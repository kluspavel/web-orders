<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Entity\User;
use App\Model\Service\UserService;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

final class AuthPresenter extends BasePresenter
{
    public UserService $us;

    public function __construct(UserService $us)
    {
        $this->us = $us;
    }

    public function startup()
    {
        parent::startup();

        if ($this->getUser()->isLoggedIn() === false && $this->getAction() == 'signOut') 
        {
            $this->flashMessage('Nepřihlášený uživatel nemá přístup k odlašovací stránce!');
            $this->redirect('signIn');
        } 

        if ($this->getUser()->isLoggedIn() === false && $this->getAction() !== 'signIn') 
        {
            $this->flashMessage('Tato sekce není přístupná bez přihlášení!');
            $this->redirect('signIn');
        } 
    }

    /*public function actionOrders()
    {
        $this->setLayout('orders');
    }*/

    public function actionSignIn()
    {
        if ($this->getUser()->isLoggedIn() === true) 
        {
            $this->redirect('Home:overview');
        }
        else 
        {
            $username = getenv('USERNAME');
            $user = $this->us->findUserByUserName($username);

            if ($user !== null) 
            {
                if ($user->getState() == $user::STATE_AUTOLOGIN) 
                {
                    $this->getUser()->login($user->getUserName(), $user->getPassword(), true);
                    $this->redirect('Home:overview');
                }
            }
        }

        $this->setLayout('orders');
    }

    public function actionSignOut()
    {
        $this->setLayout('orders');
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

        $this->redirect('Home:overview');
    }
}