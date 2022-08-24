<?php declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Entity\User;
use Nettrine\ORM\EntityManagerDecorator;

class UserService
{
	public function __construct(private EntityManagerDecorator $em) {}

	public function findUserById(int $id): ?User
	{
		//$user = $this->em->getUserRepository()->findOneBy(['id' => $id]);
		//$user = $this->em->getRepository(User::class)->findOneBy(['id' => $id]);
		$user = $this->em->getRepository(User::class)->findOneById($id);
		return $user;
	}

	public function findUserByEmail(string $email): ?User
	{
		//$user = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
		$user = $this->em->getRepository(User::class)->findOneByEmail($email);
		return $user;
	}


	public function findUserByUserName(string $username): ?User
	{
		//$user = $this->em->getRepository(User::class)->findOneBy(['username' => $username]);
		$user = $this->em->getRepository(User::class)->findOneByUsername($username);
		return $user;
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
}