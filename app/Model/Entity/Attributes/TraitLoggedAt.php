<?php declare(strict_types = 1);

namespace App\Model\Entity\Attributes;

//use App\Model\Utils\DateTime;
use Nette\Utils\DateTime;
use DateTime as GlobalDateTime;
use Doctrine\ORM\Mapping as ORM;

trait TraitLoggedAt
{
	//--------------------------------------------------------------------------------------------------------
	#[ORM\Column(type: 'datetime', nullable: false)]
	protected $loggedAt;
	//--------------------------------------------------------------------------------------------------------
	public function getLoggedAt(): ?GlobalDateTime
	{
		return $this->loggedAt;
	}
	//--------------------------------------------------------------------------------------------------------
	#[ORM\PreUpdate]
	public function setLoggedAt(): void
	{
		$this->loggedAt = new DateTime();
	}
	//--------------------------------------------------------------------------------------------------------
	public function changeLoggedAt(): void
	{
		$this->setLoggedAt(new DateTime());
	}
	//--------------------------------------------------------------------------------------------------------
}