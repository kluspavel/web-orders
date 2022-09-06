<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Model\Service\UserService;

class BasePresenter extends Nette\Application\UI\Presenter
{
    private UserService $us;

    public function injectBase(UserService $us): void
	{
		$this->us = $us;
	}

    public function startup()
    {
        parent::startup();

        $logintext = 'Přihlášení';
        $loginavatar = 'img/avatars/default-avatar.jpg';
        $loginlink = 'Auth:SignIn';

        if ($this->getUser()->isLoggedIn()) 
        {
            $user = $this->us->findUserById($this->getUser()->getId());
            $logintext = 'Odhlásit se';
            $loginavatar = $user->getAvatar();
            $loginlink = 'Auth:SignOut';
        }

        $usercount = $this->us->getUserCount();

        $this->template->logintext = $logintext;
        $this->template->loginavatar = $loginavatar;
        $this->template->loginlink = $loginlink;
        $this->template->usercount = $usercount;
    }
}