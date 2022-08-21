<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Entity\User;
use App\Model\Service\UserService;

final class HomepagePresenter extends BasePresenter
{
    public UserService $us;

    public function __construct(UserService $us)
    {
        $this->us = $us;
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
}
