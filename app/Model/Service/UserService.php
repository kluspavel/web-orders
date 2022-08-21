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
		$user = $this->em->getRepository(User::class)->findOneByUserName($username);
		return $user;
	}

	public function fluschUser($user): void
	{
		$this->em->persist($user);
		$this->em->flush();
	}
}