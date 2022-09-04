<?php declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Entity\User;
use App\Model\Service\EntityService;
use Nette\Utils\Validators;
use Nettrine\ORM\EntityManagerDecorator;
use Nette\Security\Passwords;
use Nette\Utils\ArrayList;

class UserService extends EntityService
{
	//--------------------------------------------------------------------------------------------------------
	public function __construct(private EntityManagerDecorator $em, private Passwords $passwords) 
	{
		parent::__construct($em);
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
	public function editUser(object $values): string
	{
		$user = $this->findUserById(intval($values->id));

		if ($user === null) 
		{
			return 'Uživatel nenalezen v databázi!';
		}
		else 
		{
			$saveuser = false;
			$savepass = false;

			if ($values->origpass === '' && $values->newpass === '' && $values->checkpass === '') 
			{
				$saveuser = true;
			}
			else 
			{
				if (!$this->passwords->verify($values->origpass, $user->getPassword())) 
				{
					return 'Zadané heslo se neshoduje s původním heslem!';
				}
				else if ($values->newpass !== $values->checkpass) 
				{
					return 'Zadané nové hesla se neshodují!';
				}
				else if (strlen($values->newpass) < '5') 
				{
					return 'Nově zadané heslo nesmí mít méně než 5 znaků!';
				}
				else 
				{
					$saveuser = true;
					$savepass = true;
				}
			}

			if ($saveuser === true)
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

				if ($savepass === true) 
				{
					$user->setPassword($values->newpass);
				}

				//dump($user);
				//die;

				$this->persitAndFlusch($user);
			}
		}

		return '';
	}

	public function checkEditProfileUser(object $values): ArrayList
	{
		$messages = new ArrayList();
		
		$user = $this->findUserById(intval($values->id));
		
		if ($values->origpass !== '' || $values->newpass !== '' || $values->checkpass !== '') 
		{
			if (!$this->passwords->verify($values->origpass, $user->getPassword())) 
			{
				$messages[] = 'Zadané heslo se neshoduje s původním heslem!';
			}
			else if ($values->newpass !== $values->checkpass) 
			{
				$messages[] = 'Zadané nové hesla se neshodují!';
			}
			else if (strlen($values->newpass) < '5') 
			{
				$messages[] = 'Nově zadané heslo nesmí mít méně než 5 znaků!';
			}
		}

		return $messages;
	}

	public function getUserFromEditProfile(object $values): User
	{
		$user = $this->findUserById(intval($values->id));




		return $user;
	}

	public function getMessages()
	{
		# code...
	}


















	//----------------------------------------------------------------------------------------------------------------
	public function getUserCount(): int
	{
		$userOnlineCount = $this->getOnlineUserCount();
		$userOfflineCount = $this->getOfflineUserCount();
		$userCount = $userOnlineCount + $userOfflineCount;
		return $userCount;
	}
	//----------------------------------------------------------------------------------------------------------------
	public function getOnlineUserCount(): int
	{
		$userCount = $this->em->getRepository(User::class)->count(array('online' => '1'));

		return $userCount;
	}
	//----------------------------------------------------------------------------------------------------------------
	public function getOfflineUserCount(): int
	{
		$userCount = $this->em->getRepository(User::class)->count(array('online' => '0'));

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