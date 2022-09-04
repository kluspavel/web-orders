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
    public User $oneUser;
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

        $this->oneUser = $this->us->findUserById($id);
        $this->template->profile = $this->oneUser;

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

        $this->oneUser = $this->us->findUserById($id);

        //dump($userek);
        //dump(array($userek));
        //die;

        $this->template->profile = $this->oneUser;
    }
    //-------------------------------------------------------------------------------------------------------
    protected function createComponentUserEditForm(): Form
    {
        $form = new Form();
        $form->addHidden('id')->setDefaultValue($this->oneUser->getId());
        $form->addText('username', 'UID')->setRequired()->setDefaultValue($this->oneUser->getUserName());
        $form->addText('nickname', 'Nick')->setDefaultValue($this->oneUser->getNick());
        $form->addText('firstname', 'Jméno')->setDefaultValue($this->oneUser->getFirstname());
        $form->addText('lastname', 'Příjmení')->setDefaultValue($this->oneUser->getLastname());
        $form->addText('position', 'Pracovní zařazení')->setDefaultValue($this->oneUser->getWorkPosition());

        $form->addPassword('origpass', 'Původní heslo');
        $form->addPassword('newpass', 'Nové heslo');
        $form->addPassword('checkpass', 'Znovu heslo');

        $form->addEmail('email', 'Email')->setDefaultValue($this->oneUser->getEmail());
        $form->addText('telephone', 'Telefon')->setDefaultValue($this->oneUser->getTelephone());
        $form->addText('mobileone', 'Mobil')->setDefaultValue($this->oneUser->getMobileOne());
        $form->addText('mobiletwo', 'Mobil 2')->setDefaultValue($this->oneUser->getMobileTwo());
        $form->addTextArea('note', 'Poznámka')->setHtmlAttribute('rows', 4)->setDefaultValue($this->oneUser->getNote());
        //$form->addPassword('password', 'Vaše heslo');
        $form->addUpload('avatar', 'Avatar');
        $form->addSubmit('send', 'Uložit');
        $form->onSuccess[] = [$this, 'userEditFormSuccess'];
        return $form;
    }
    //--------------------------------------------------------------------------------------------------------
    public function userEditFormSuccess(Form $form)
    {
        $values = $form->getValues();

            dump($values);
            die;

        $message = $this->us->editUser($values);

        if ($message !== '') 
        {
            $this->flashMessage($message);
            $this->redirect('User:edit', $values->id);
        }
        else 
        {
            $this->us->editUser($values);
            $this->flashMessage('Uživatel byl uložen.', 'danger');
            $this->redirect('Home:overview');
        }
    }
}