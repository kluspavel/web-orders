<?php declare(strict_types = 1);

namespace App\Model\Entity\Attributes;

//use App\Model\Utils\DateTime;
use Nette\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;

trait TraitLoggedAt
{
	#[ORM\Column(type: 'datetime', nullable: false)]
	protected $loggedAt;

	public function getLoggedAt(): ?DateTime
	{
		return $this->loggedAt;
	}

	#[ORM\PreUpdate]
	public function setLoggedAt(): void
	{
		$this->loggedAt = new DateTime();
	}
}