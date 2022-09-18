<?php declare(strict_types = 1);

namespace App\Model\Entity\Attributes;

//use App\Model\Utils\DateTime;
use Nette\Utils\DateTime;
use DateTime as GlobalDateTime;
use Doctrine\ORM\Mapping as ORM;

trait TraitCreatedAt
{
	//--------------------------------------------------------------------------------------------------------
	#[ORM\Column(type: 'datetime', nullable: true)]
	protected $createdAt;
	//--------------------------------------------------------------------------------------------------------
	public function getCreatedAt(): GlobalDateTime
	{
		return $this->createdAt;
	}
	//--------------------------------------------------------------------------------------------------------
	#[ORM\PrePersist]
	public function setCreatedAt(): void
	{
		$this->createdAt = new DateTime();
	}
	//--------------------------------------------------------------------------------------------------------
}