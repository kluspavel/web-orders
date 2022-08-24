<?php declare(strict_types=1);

use App\Model\Service\UserService;
use Nette\Security\IIdentity;

class Authenticator implements \Nette\Security\Authenticator
{

	public function __construct(private UserService $userService, private \Nette\Security\Passwords $passwords,) {}

	public function authenticate(string $username, string $password, ?bool $auto = false): IIdentity
	{
		// 1. podívej se do databáze, existuje záznam pro $username? Pokud ne, vyhoď výjimku.
		$user = $this->userService->findUserByUserName($username);

		if ($user === null)
			throw new \Nette\Security\AuthenticationException('Uživatelsé ID se nenachází v databázi.');

		// 2. zahashuj $password. Odpovídá zahashovanému záznamu v databázi? Pokud ne, vyhoď výjimku.
		if ($auto === false)
		{
			if ($this->passwords->verify($password, $user->getPassword()) === false) 
			{
				throw new \Nette\Security\AuthenticationException('Nesprávně zadané heslo.');
			}
		}
			
		// 3. pokud vše dopadlo dobře, vytvoř a vrať SimpleIdentity
		return new \Nette\Security\SimpleIdentity($user->getId(), $user->getRole(), ['username' => $user->getUserName()]);
	}
}