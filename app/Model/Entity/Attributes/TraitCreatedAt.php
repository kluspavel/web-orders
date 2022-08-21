<?php declare(strict_types = 1);

namespace App\Model\Entity\Attributes;

//use App\Model\Utils\DateTime;
use Nette\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;

trait TraitCreatedAt
{
	#[ORM\Column(type: 'datetime', nullable: false)]
	protected $createdAt;

	public function getCreatedAt(): DateTime
	{
		return $this->createdAt;
	}

	#[ORM\PrePersist]
	public function setCreatedAt(): void
	{
		$this->createdAt = new DateTime();
	}
}