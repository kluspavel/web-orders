<?php declare(strict_types=1);

use App\Model\Service\UserService;
use Nette\Security\IIdentity;

class Authenticator implements \Nette\Security\Authenticator
{

	public function __construct(private UserService $userService, private \Nette\Security\Passwords $passwords,) {}

	public function authenticate(string $username, string $password): IIdentity
	{
		// 1. podívej se do databáze, existuje záznam pro $username? Pokud ne, vyhoď výjimku.
		$user = $this->userService->findUserByUserName($username);

		if ($user === null)
			throw new \Nette\Security\AuthenticationException('User not found.');

		// 2. zahashuj $password. Odpovídá zahashovanému záznamu v databázi? Pokud ne, vyhoď výjimku.
		if ($this->passwords->verify($password, $user->password) === false)
			throw new \Nette\Security\AuthenticationException('Wrong password.');

		// 3. pokud vše dopadlo dobře, vytvoř a vrať SimpleIdentity
		return new \Nette\Security\SimpleIdentity($user->id, $user->role, ['username' => $user->username]);
	}
}