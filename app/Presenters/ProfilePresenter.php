<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Entity\User;
use App\Model\Service\UserService;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

final class ProfilePresenter extends BasePresenter
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
    public function renderShow(int $id = null)
    {
        $this->setLayout('orders');

        $this->oneUser = $this->us->findUserById($id);
        $this->template->profile = $this->oneUser;
    }
    //--------------------------------------------------------------------------------------------------------
    public function actionEdit(int $id = null)
    {
        $this->setLayout('orders');
        $this->oneUser = $this->us->findUserById($id);
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
        $form->addPassword('checkpass', 'Ověřovací heslo');

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
        $this->us->updateUserFromEditForm($this, $values);
    }
}