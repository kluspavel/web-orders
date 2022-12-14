<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Entity\User;
use App\Model\Service\UserService;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

final class HomePresenter extends BasePresenter
{
    //--------------------------------------------------------------------------------------------------------
    public UserService $us;
    //--------------------------------------------------------------------------------------------------------
    public function __construct(UserService $us)
    {
        $this->us = $us;
    }
    //--------------------------------------------------------------------------------------------------------
    public function startup()
    {
        parent::startup();

        //$this->createUser();

        if ($this->getUser()->isLoggedIn() === false) 
        {
            if ($this->getAction() == 'overview') 
            {
                
            }
            else if ($this->getAction() !== 'signIn') 
            {
                $this->flashMessage('Tato sekce není přístupná bez přihlášení!');
                $this->redirect('Auth:signIn');
            }
        } 
    }
    //--------------------------------------------------------------------------------------------------------
    public function createUser()
    {
        $user = new User();
        $user->injectData('Milan', 'Detonator', 'milan.detoantor@continental-corporation.com', 'UIDM2075', 'Jisap.1979');
        $user->setNick('Milouš');
        $this->us->fluschUser($user);

        //$user = $this->us->findUserByEmail('kluspavel@gmail.com');
        //$user = $this->us->findUserById(1);
        //$user->setPassword($user->getPassword());
        //$this->us->fluschUser($user);
        //dump($user);
        //die;
    }
    //--------------------------------------------------------------------------------------------------------
    public function actionOverview()
    {
        $this->setLayout('orders');

        $userCount = $this->us->getUserCount();
        $userOnlineCount = $this->us->getOnlineUserCount();
        $this->template->userCount = $userCount;
        $this->template->userOnlineCount = $userOnlineCount;

        $this->template->sentenceCount = $this->us->getUserCountText($userCount) . ' v databázi';
        $this->template->sentenceOnline = $this->us->getUserCountText($userOnlineCount) . ' online';

        //dump($userCount);
        //dump($userOnlineCount);
        //die;
    }
    //--------------------------------------------------------------------------------------------------------
    public function actionOrders()
    {
        $this->setLayout('orders');
    }
    //--------------------------------------------------------------------------------------------------------
}