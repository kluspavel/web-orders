<?php declare(strict_types = 1);

namespace App\Model\Entity;

use App\Model\Entity\Attributes\TraitCreatedAt;
use App\Model\Entity\Attributes\TraitId;
use App\Model\Entity\Attributes\TraitUpdatedAt;
use DateTime as GlobalDateTime;
use Nette\Security\Passwords;
use Nette\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User extends Entity
{
    //--------------------------------------------------------------------------------------------------------
	public const ROLE_ADMIN = 'admin';
	public const ROLE_USER = 'user';
    //--------------------------------------------------------------------------------------------------------
	public const STATE_FRESH = 1;
	public const STATE_ACTIVATED = 2;
	public const STATE_AUTOLOGIN = 3;
	public const STATE_BLOCKED = 4;
    //--------------------------------------------------------------------------------------------------------
	public const STATES = [self::STATE_FRESH, self::STATE_BLOCKED, self::STATE_ACTIVATED, self::STATE_AUTOLOGIN];
    //--------------------------------------------------------------------------------------------------------
	use TraitId;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 16, unique: true)]
	private $username;
    //--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 60)]
	private $password;
    //--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 128, nullable: false, unique: true)]
	private $email;
    //--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 32)]
	private $role;
    //--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 20)]
    private string $rights;
    //--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 32)]
    private string $types;
    //--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'integer', length: 10, nullable: false)]
	private $state;
    //--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $firstname;
    //--------------------------------------------------------------------------------------------------------
	#[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $lastname;
    //--------------------------------------------------------------------------------------------------------
	#[ORM\Column(type: 'string', length: 32, unique: true, nullable: true)]
    private ?string $nickname;
    //--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'boolean')]
    private bool $online = false;
    //--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'datetime', nullable: true)]
	private $lastLoggedAt;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private string $telephone;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private string $mobileOne;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private string $mobileTwo;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 256, nullable: true)]
    private string $workPosition;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'text', length: 2000, nullable: true)]
    private string $note;
    //--------------------------------------------------------------------------------------------------------
    use TraitCreatedAt;
	use TraitUpdatedAt;
    //--------------------------------------------------------------------------------------------------------
    // CONSTRUCT
    //--------------------------------------------------------------------------------------------------------
	public function __construct(string $firstname, string $lastname, string $email, string $username, string $password)
	{
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->email = $email;
		$this->username = $username;
		$this->password = $password !== '' ? (new Passwords)->hash($password) : '---empty-password---';

		$this->role = self::ROLE_USER;
		$this->state = self::STATE_FRESH;
		$this->types = 'none';

        $this->rights = '00000000000000000001';
		$this->createdAt = new \DateTimeImmutable('now');
		$this->updatedAt = new \DateTimeImmutable('now');
	}
    //--------------------------------------------------------------------------------------------------------
    // GET SET username
    //--------------------------------------------------------------------------------------------------------
    public function getUserName(): string
    {
        return $this->username;
    }
    //--------------------------------------------------------------------------------------------------------
    public function setUserName(string $username): void
    {
        $this->username = $username;
    }
    //--------------------------------------------------------------------------------------------------------
    // GET SET password
    //--------------------------------------------------------------------------------------------------------
	public function getPassword(): string
	{
		return $this->password;
	}
	//--------------------------------------------------------------------------------------------------------
	public function setPassword(string $password): void
	{
		$this->password = $password !== '' ? (new Passwords)->hash($password) : '---empty-password---';
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET role
    //--------------------------------------------------------------------------------------------------------
    public function getRole(): string
    {
        return $this->role;
    }
    //--------------------------------------------------------------------------------------------------------
    public function setRole(string $role): void
    {
        $this->role = $role;
    }
	//--------------------------------------------------------------------------------------------------------
    // GET SET state
    //--------------------------------------------------------------------------------------------------------
    public function getState(): int
    {
        return $this->state;
    }
    //--------------------------------------------------------------------------------------------------------
    public function setState(int $state): void
    {
        if (in_array($state, self::STATES)) 
		{
			$this->state = $state;
		}
    }








	public function changeLoggedAt(): void
	{
		$this->lastLoggedAt = new DateTime();
	}

	public function getLastLoggedAt(): GlobalDateTime
	{
		return $this->lastLoggedAt;
	}

	public function isActivated(): bool
	{
		return $this->state === self::STATE_ACTIVATED || $this->state === self::STATE_AUTOLOGIN;
	}

	public function activate(): void
	{
		$this->state = self::STATE_ACTIVATED;
	}

	public function reName(string $firstname, string $lastname): void
	{
		$this->firstname = $firstname;
		$this->lastname = $lastname;
	}




//--------------------------------------------------------------------------------------------------------
	public function getFullname(): string
	{
		return $this->firstname . ' ' . $this->lastname;
	}
	//--------------------------------------------------------------------------------------------------------
	public function getEmail(): string
	{
		return $this->email;
	}
	//--------------------------------------------------------------------------------------------------------
	public function getTelephone(): string
	{
		return $this->telephone;
	}
	//--------------------------------------------------------------------------------------------------------
	public function getMobileOne(): string
	{
		return $this->mobileOne;
	}
	//--------------------------------------------------------------------------------------------------------
	public function getMobileTwo(): string
	{
		return $this->mobileTwo;
	}
	//--------------------------------------------------------------------------------------------------------
	public function getNick(): string
	{
		return $this->nickname;
	}












    /*
    //--------------------------------------------------------------------------------------------------------
	public function changeLoggedAt(): void
	{
		$this->lastLoggedAt = new DateTime();
	}
    
    
    //--------------------------------------------------------------------------------------------------------
	public function changeUsername(string $username): void
	{
		$this->username = $username;
	}
    //--------------------------------------------------------------------------------------------------------
	public function getLastLoggedAt(): ?DateTime
	{
		return $this->lastLoggedAt;
	}
    //--------------------------------------------------------------------------------------------------------
	public function getRole(): string
	{
		return $this->role;
	}
    //--------------------------------------------------------------------------------------------------------
	public function setRole(string $role): void
	{
		$this->role = $role;
	}
    //--------------------------------------------------------------------------------------------------------
	public function getPasswordHash(): string
	{
		return $this->password;
	}
    //--------------------------------------------------------------------------------------------------------
	public function changePasswordHash(string $password): void
	{
		$this->password = $password;
	}
    //--------------------------------------------------------------------------------------------------------
	public function block(): void
	{
		$this->state = self::STATE_BLOCKED;
	}
    //--------------------------------------------------------------------------------------------------------
	public function activate(): void
	{
		$this->state = self::STATE_ACTIVATED;
	}
    //--------------------------------------------------------------------------------------------------------
	public function isActivated(): bool
	{
		return $this->state === self::STATE_ACTIVATED;
	}
    //--------------------------------------------------------------------------------------------------------
	public function getFirstName(): string
	{
		return $this->firstname;
	}
    //--------------------------------------------------------------------------------------------------------
	public function getLastName(): string
	{
		return $this->lastname;
	}
    //--------------------------------------------------------------------------------------------------------
	public function getFullname(): string
	{
		return $this->firstname . ' ' . $this->lastname;
	}
    //--------------------------------------------------------------------------------------------------------
	public function rename(string $firstname, string $lastname): void
	{
		$this->firstname = $firstname;
		$this->lastname = $lastname;
	}
    //--------------------------------------------------------------------------------------------------------
	public function getState(): int
	{
		return $this->state;
	}
    //--------------------------------------------------------------------------------------------------------
	public function setState(int $state): void
	{
		if (!in_array($state, self::STATES)) 
        {
			//throw new InvalidArgumentException(sprintf('Unsupported state %s', $state));
		}

		$this->state = $state;
	}
    //--------------------------------------------------------------------------------------------------------
	public function getGravatar(): string
	{
		return 'https://www.gravatar.com/avatar/' . md5($this->email);
	}
    //--------------------------------------------------------------------------------------------------------
	public function toIdentity(): Identity
	{
		return new Identity($this->getId(), [$this->role], [
			'email' => $this->email,
			'firstname' => $this->firstname,
			'lastname' => $this->lastname,
			'state' => $this->state,
			'gravatar' => $this->getGravatar(),
		]);
	}
    //--------------------------------------------------------------------------------------------------------
    */
}