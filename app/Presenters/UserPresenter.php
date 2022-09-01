<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Entity\User;
use App\Model\Service\UserService;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

final class UserPresenter extends BasePresenter
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
    public function actionProfile(int $id = null)
    {
        $this->setLayout('orders');

        $user = $this->us->findUserById($id);
        $this->template->profile = $user;

        //$userCount = $this->us->getUserCount();
        //$userOnlineCount = $this->us->getOnlineUserCount();
        //$this->template->userCount = $userCount;
        //$this->template->userOnlineCount = $userOnlineCount;

        //$this->template->sentenceCount = $this->us->getUserCountText($userCount) . ' v databázi';
        //$this->template->sentenceOnline = $this->us->getUserCountText($userOnlineCount) . ' online';

        //dump($userCount);
        //dump($user);
        //die;
    }
    //--------------------------------------------------------------------------------------------------------
    public function actionEdit(int $id = null)
    {
        $this->setLayout('orders');

        $user = $this->us->findUserById($id);

        //dump($userek);
        //dump(array($userek));
        //die;


        //$this['userEditForm']->setDefaults(['nick' => 'Palisko']);
        $this->template->profile = $user;

        //$this->getComponent('userEditForm')->setDefaults($user->toArray());

        $row = ['username' => $user->getUserName(), 'nickname' => $user->getNick()];
        $this['userEditForm']->setDefaults([$row]);
        //$this->getComponent('userEditForm')->setDefaults();

        
    }
    //-------------------------------------------------------------------------------------------------------
    protected function createComponentUserEditForm(): Form
    {
        $form = new Form();
        $form->addHidden('id');
        $form->addText('username', 'UID')->setRequired();
        $form->addText('nickname', 'Nick');
        $form->addText('firstname', 'Jméno');
        $form->addText('lastname', 'Příjmení');
        $form->addText('position', 'Pracovní zařazení');
        $form->addEmail('email', 'Email');
        $form->addText('telephone', 'Telefon');
        $form->addText('mobileone', 'Mobil');
        $form->addText('mobiletwo', 'Mobil 2');
        $form->addTextArea('note', 'Poznámka')->setHtmlAttribute('rows', 4);
        //$form->addPassword('password', 'Vaše heslo');
        $form->addSubmit('send', 'Uložit');
        $form->onSuccess[] = [$this, 'userEditFormSuccess'];
        return $form;
    }
    //--------------------------------------------------------------------------------------------------------
    public function userEditFormSuccess(Form $form)
    {
        $values = $form->getValues();
        $this->us->editUser($values);

        $this->flashMessage('Uživatel byl uložen.', 'danger');

        $this->redirect('Home:overview');
    }
}