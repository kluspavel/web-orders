<?php declare(strict_types=1);

use App\Model\Service\UserService;
use Nette\Security\IIdentity;
use App\Model\Entity\User;

class Authenticator implements \Nette\Security\Authenticator
{

	public function __construct(private UserService $userService, private \Nette\Security\Passwords $passwords,) {}

	public function authenticate(string $username, string $password, ?bool $auto = false): IIdentity
	{
		// 1. podívej se do databáze, existuje záznam pro $username? Pokud ne, vyhoď výjimku.
		$user = $this->userService->findUserByUserName($username);

		// 2. zkontroluj zda existuje záznam o uživateli v databázi
		if ($user === null)
		{
			throw new \Nette\Security\AuthenticationException('Uživatelsé ID se nenachází v databázi.');
		}

		// 3. zkontroluj jestli má uživatel aktivovaný účet.
		if (!$user->isActivated()) 
		{
			throw new \Nette\Security\AuthenticationException('Uživatel ještě není ověřen a aktivován!');
		}
			
		// 4. zahashuj $password. Odpovídá zahashovanému záznamu v databázi? Pokud ne, vyhoď výjimku.
		if ($auto === false)
		{
			if ($this->passwords->verify($password, $user->getPassword()) === false) 
			{
				throw new \Nette\Security\AuthenticationException('Nesprávně zadané heslo.');
			}
		}

		// 5. Změn datum a čas posledního přihlášení.
		$user->changeLoggedAt();
		$this->userService->fluschUser($user);
			
		// 5. pokud vše dopadlo dobře, vytvoř a vrať SimpleIdentity
		return $this->createIdentity($user);
	}

	protected function createIdentity(User $user): IIdentity
	{
		//$this->em->flush();
		return new \Nette\Security\SimpleIdentity($user->getId(), $user->getRole(), ['username' => $user->getUserName()]);
	}
}