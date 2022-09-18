<?php declare(strict_types = 1);

namespace App\Model\Entity;

use App\Model\Entity\Attributes\TraitId;
use App\Model\Entity\Attributes\TraitCreatedAt;
use App\Model\Entity\Attributes\TraitLoggedAt;
use App\Model\Entity\Attributes\TraitUpdatedAt;
use DateTime as GlobalDateTime;
use Nette\Security\Passwords;
use Nette\Utils\DateTime;
use Nette\Security\IIdentity;
use Doctrine\ORM\Mapping as ORM;
use Nette\Security\SimpleIdentity;
use Nette\Utils\ArrayList;
use Nette\Utils\Strings;

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
    #[ORM\Column(type: 'string', length: 128, unique: true)]
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
    #[ORM\Column(type: 'integer', length: 10)]
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
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $telephone;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $mobileOne;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 32, nullable: true)]
    private ?string $mobileTwo;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 256, nullable: true)]
    private ?string $workPosition;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'text', length: 2000, nullable: true)]
    private ?string $note;
	//--------------------------------------------------------------------------------------------------------
    #[ORM\Column(type: 'string', length: 256, nullable: true)]
    private ?string $avatar;
	//--------------------------------------------------------------------------------------------------------
	private ArrayList $messages;
    //--------------------------------------------------------------------------------------------------------
    use TraitCreatedAt;
	use TraitUpdatedAt;
	use TraitLoggedAt;
    //--------------------------------------------------------------------------------------------------------
    // CONSTRUCT
    //--------------------------------------------------------------------------------------------------------
	public function __construct(?bool $newUser = false)
	{
		if ($newUser === true) 
		{
			$this->setNewData();
		}
	}
	//--------------------------------------------------------------------------------------------------------
	public function setNewData(): void
	{
		$this->role = self::ROLE_USER;
		$this->state = self::STATE_FRESH;
		$this->types = 'none';

        $this->rights = '00000000000000000001';
		$this->createdAt = new \DateTimeImmutable('now');
		$this->updatedAt = new \DateTimeImmutable('now');
		$this->loggedAt = new \DateTimeImmutable('now');


	}
	//--------------------------------------------------------------------------------------------------------
	public function injectData(string $firstname, string $lastname, string $email, string $username, string $password)
	{
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->email = $email;
		$this->username = Strings::upper($username);
		$this->password = $password !== '' ? (new Passwords)->hash($password) : '---empty-password---';
	}
    //--------------------------------------------------------------------------------------------------------
    // GET SET username
    //--------------------------------------------------------------------------------------------------------
    public function getUserName(): string
    {
        return Strings::upper($this->username);
    }
    //--------------------------------------------------------------------------------------------------------
    public function setUserName(string $username): void
    {
        $this->username = $username;
    }
	//--------------------------------------------------------------------------------------------------------
	public function changeUsername(string $username): void
	{
		$this->setUserName($username);
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
	public function changePassword(string $password): void
	{
		$this->password = $password;
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET email
    //--------------------------------------------------------------------------------------------------------
	public function getEmail(): string
	{
		return $this->email;
	}
	//--------------------------------------------------------------------------------------------------------
	public function setEmail(string $email): void
	{
		$this->email = $email;
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
    // GET SET rights
    //--------------------------------------------------------------------------------------------------------
    public function getRights(): string
    {
        return $this->rights;
    }
    //--------------------------------------------------------------------------------------------------------
    public function setRights(string $rights): void
    {
        $this->rights = $rights;
    }
	//--------------------------------------------------------------------------------------------------------
    // GET SET state
    //--------------------------------------------------------------------------------------------------------
    public function getState(): int
    {
        return $this->state;
    }
	//--------------------------------------------------------------------------------------------------------
	public function getStateText(): string
    {
		$statetext = 'new one';
		if ($this->state === self::STATE_ACTIVATED) 
		{
			$statetext = 'active';
		}
		elseif ($this->state === self::STATE_BLOCKED) 
		{
			$statetext = 'blocked';
		}

        return $statetext;
    }
	//--------------------------------------------------------------------------------------------------------
	public function getStateColor(): string
	{
        $statecolor = 'bg-yellow-500';
		if ($this->state === self::STATE_ACTIVATED) 
		{
			$statecolor = 'bg-blue-500';
		}
		elseif ($this->state === self::STATE_BLOCKED) 
		{
			$statecolor = 'bg-gray-800';
		}

        return $statecolor;
    }
    //--------------------------------------------------------------------------------------------------------
    public function setState(int $state): void
    {
        if (in_array($state, self::STATES)) 
		{
			$this->state = $state;
		}
    }
	//--------------------------------------------------------------------------------------------------------
	public function isActivated(): bool
	{
		return $this->state === self::STATE_ACTIVATED || $this->state === self::STATE_AUTOLOGIN;
	}
	//--------------------------------------------------------------------------------------------------------
	public function doActivate(): void
	{
		$this->state = self::STATE_ACTIVATED;
	}
	//--------------------------------------------------------------------------------------------------------
	public function doBlock(): void
	{
		$this->state = self::STATE_BLOCKED;
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET types
    //--------------------------------------------------------------------------------------------------------
    public function getType(): string
    {
        return $this->types;
    }
    //--------------------------------------------------------------------------------------------------------
    public function setType(string $types): void
    {
        $this->types = $types;
    }
	//--------------------------------------------------------------------------------------------------------
    // GET SET firsname & lastname
    //--------------------------------------------------------------------------------------------------------
	public function getFirstname(): string
	{
		return $this->firstname;
	}
	//--------------------------------------------------------------------------------------------------------
	public function setFirstname(string $firstname): void
	{
		$this->firstname = $firstname;
	}
	//--------------------------------------------------------------------------------------------------------
	public function getLastname(): string
	{
		return $this->lastname;
	}
	//--------------------------------------------------------------------------------------------------------
	public function setLastname(string $lastname): void
	{
		$this->lastname = $lastname;
	}
	//--------------------------------------------------------------------------------------------------------
	public function getFullname(): string
	{
		return $this->firstname . ' ' . $this->lastname;
	}
	//--------------------------------------------------------------------------------------------------------
	public function reName(string $firstname, string $lastname): void
	{
		$this->firstname = $firstname;
		$this->lastname = $lastname;
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET nick
    //--------------------------------------------------------------------------------------------------------
	public function getNick(): string
	{
		return $this->nickname;
	}
	//--------------------------------------------------------------------------------------------------------
	public function setNick(string $nickname): void
	{
		$this->nickname = $nickname;
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET telephone
    //--------------------------------------------------------------------------------------------------------
	public function getTelephone(): string
	{
		return $this->telephone;
	}
	//--------------------------------------------------------------------------------------------------------
	public function setTelephone(string $telephone): void
	{
		$this->telephone = $telephone;
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET mobile one
    //--------------------------------------------------------------------------------------------------------
	public function getMobileOne(): string
	{
		return $this->mobileOne;
	}
	//--------------------------------------------------------------------------------------------------------
	public function setMobileOne(string $mobileOne): void
	{
		$this->mobileOne = $mobileOne;
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET mobile two
    //--------------------------------------------------------------------------------------------------------
	public function getMobileTwo(): string
	{
		return $this->mobileTwo;
	}
	//--------------------------------------------------------------------------------------------------------
	public function setMobileTwo(string $mobileTwo): void
	{
		$this->mobileTwo = $mobileTwo;
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET note
    //--------------------------------------------------------------------------------------------------------
	public function getNote(): string
	{
		return $this->note;
	}
	//--------------------------------------------------------------------------------------------------------
	public function setNote(string $note): void
	{
		$this->note = $note;
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET note
    //--------------------------------------------------------------------------------------------------------
	public function getWorkPosition(): string
	{
		return ($this->workPosition === '') ? 'Bez pracovního zařazení' : $this->workPosition;
	}
	//--------------------------------------------------------------------------------------------------------
	public function setWorkPosition(string $workPosition): void
	{
		$this->workPosition = $workPosition;
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET avater
    //--------------------------------------------------------------------------------------------------------
	public function getGravatar(): string
	{
		return 'https://www.gravatar.com/avatar/' . md5($this->email);
	}
	//--------------------------------------------------------------------------------------------------------
	public function getAvatar(): string
	{	
		$avatar = $this->avatar;
	
		if (is_file($avatar)) 
		{
			return $this->avatar;
		}

		return 'img/avatars/default-avatar.jpg';
	}
	//--------------------------------------------------------------------------------------------------------
	public function setAvatar(string $avatar)
	{
		$this->avatar = $avatar;
	}
	//--------------------------------------------------------------------------------------------------------
    // GET SET messages
    //--------------------------------------------------------------------------------------------------------
	public function getMessages(): ArrayList
	{
		return $this->messages;
	}
	//--------------------------------------------------------------------------------------------------------
	public function addMessage(string $message)
	{
		$this->messages[] = $message;
	}
	//--------------------------------------------------------------------------------------------------------
    // SET identity
    //--------------------------------------------------------------------------------------------------------
	public function toIdentity(): IIdentity
	{
		return new SimpleIdentity($this->getId(), [$this->role], [
			'username' => $this->username,
			'email' => $this->email,
			'firstname' => $this->firstname,
			'lastname' => $this->lastname,
			'state' => $this->state,
			'avatar' => $this->getAvatar(),
		]);
	}
}