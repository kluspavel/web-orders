<?php declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Entity\User;
use App\Model\Service\EntityService;
use Nette\Application\UI\Presenter;
use Nette\Utils\Validators;
use Nettrine\ORM\EntityManagerDecorator;
use Nette\Security\Passwords;
use Nette\Utils\ArrayList;
use Nette\Utils\FileSystem;
use Nette\Utils\Image;
use Nette\Utils\Strings;

class UserService extends EntityService
{
	//--------------------------------------------------------------------------------------------------------
	public function __construct(private EntityManagerDecorator $em, private Passwords $passwords) 
	{
		parent::__construct($em);
	}
	//--------------------------------------------------------------------------------------------------------
	public function findAllUsers()
	{
		$user = $this->getUserRepository()->findAll();
		return $user;
	}
	//--------------------------------------------------------------------------------------------------------
	public function findUserById(int $id): ?User
	{
		$user = $this->getUserRepository()->findOneById($id);
		return $user;
	}
	//--------------------------------------------------------------------------------------------------------
	public function findUserByEmail(string $email): ?User
	{
		$user = $this->em->getRepository(User::class)->findOneByEmail($email);
		return $user;
	}
	//--------------------------------------------------------------------------------------------------------
	public function findUserByUserName(string $username): ?User
	{
		$user = $this->em->getRepository(User::class)->findOneByUsername($username);
		return $user;
	}
	//--------------------------------------------------------------------------------------------------------
	public function updateUserFromEditForm(Presenter $presenter, object $values)
	{
		$message = '';
		$user = $this->findUserById(intval($values->id));

		if ($user !== null) 
		{
			$savepass = $this->wantToChangePassworld($values);

			if ($savepass === true) 
			{
				$message = $this->verifyPasswordEntry($values, $user->getPassword());
			}

			if ($message === '') 
			{
				$this->saveUserFromEditForm($user, $values, $savepass);
				$presenter->redirect('Profile:show', $user->getId());
			}
			else
			{
				$presenter->flashMessage($message, 'info');
				$presenter->redirect('Profile:edit', $user->getId());
			}
		}
	}
	//--------------------------------------------------------------------------------------------------------
	public function wantToChangePassworld(object $values): bool
	{
		return !($values->origpass === '' && $values->newpass === '' && $values->checkpass === '');
	}
	//--------------------------------------------------------------------------------------------------------
	public function verifyPasswordEntry(object $values, string $password): string
	{
		if (!$this->passwords->verify($values->origpass, $password))
		{
			return 'Zadané heslo se neshoduje s původním heslem!';
		}
		else if (strlen($values->newpass) < '5') 
		{
			return 'Nově zadané heslo nesmí mít méně než 5 znaků!';
		}
		else if ($values->newpass !== $values->checkpass) 
		{
			return 'Nové heslo se neshoduje s ověřovacím heslem!';
		}

		return '';
	}
	//--------------------------------------------------------------------------------------------------------
	function getUserAvatar($values, $user): string
	{
		$file = $values->avatar;
		$filepath = 'img/avatars/';
		$filename = 'default-avatar.png';
		$fullfile = $filepath . $filename;

		if ($file->hasFile() && $file->isImage()) 
		{
			$filename = Strings::webalize($values->username) . "-avatar." . $file->getImageFileExtension();
			$image = $file->toImage();

			if ($image->getHeight() > 400) { $image->resize(null, 400); }
            if ($image->getWidth() > 400) { $image->resize(400, null); }

			if ($image->getHeight() > $image->getWidth())
            {
                $image->crop('0%', '50%', $image->getWidth(), $image->getWidth());
            }
            else
            {
                $image->crop('50%', '0%', $image->getHeight(), $image->getHeight());
            }

			$fullfile = $filepath . $filename;
			$image->save($fullfile);
			FileSystem::delete("img/temp/" . $filename);
		}
		else 
		{
			$fullfile = $user->getAvatar();
		}

		return $fullfile;
	}

	//--------------------------------------------------------------------------------------------------------
	public function saveUserFromEditForm(User $user, object $values, bool $savepass)
	{
		$user->setUserName($values->username);
		$user->setNick($values->nickname);
		$user->setEmail($values->email);
		$user->setFirstname($values->firstname);
		$user->setLastname($values->lastname);
		$user->setWorkPosition($values->position);
		$user->setTelephone($values->telephone);
		$user->setMobileOne($values->mobileone);
		$user->setMobileTwo($values->mobiletwo);
		$user->setNote($values->note);
		$user->setAvatar($this->getUserAvatar($values, $user));

		if ($savepass === true) 
		{
			$user->setPassword($values->newpass);
		}

		//dump($user);
		//die;

		$this->persitAndFlusch($user);
	}
	//--------------------------------------------------------------------------------------------------------




	
	













	//----------------------------------------------------------------------------------------------------------------
	public function getUserCount(): int
	{
		$userInActiveCount = $this->getInActiveUserCount();
		$userActiveCount = $this->getActiveUserCount();
		$userCount = $userInActiveCount + $userActiveCount;
		return $userCount;
	}
	//----------------------------------------------------------------------------------------------------------------
	public function getInActiveUserCount(): int
	{
		$userCount = $this->em->getRepository(User::class)->count(array('state' => '1'));

		return $userCount;
	}
	//----------------------------------------------------------------------------------------------------------------
	public function getActiveUserCount(): int
	{
		$userCount = $this->em->getRepository(User::class)->count(array('state' => '2'));

		return $userCount;
	}
	//----------------------------------------------------------------------------------------------------------------
	public function getUserCountText(int $count): string
	{
		$text = '0';

		if ($count === 1) 
        {
            $text = 'uživatel';
        }
        else if ($count >= 2 && $count <= 4) 
        {
            $text = 'uživatelé';
        }
        else 
        {
            $text = 'uživatelů';
        }

		return $text;
	}
	//----------------------------------------------------------------------------------------------------------------
	public function fluschUser($user): void
	{
		$this->em->persist($user);
		$this->em->flush();
	}
	//----------------------------------------------------------------------------------------------------------------
	public function persitAndFlusch($user): void
	{
		$this->em->persist($user);
		$this->em->flush();
	}
	//----------------------------------------------------------------------------------------------------------------
}