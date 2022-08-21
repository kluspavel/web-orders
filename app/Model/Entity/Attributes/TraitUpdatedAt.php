<?php declare(strict_types = 1);

namespace App\Model\Entity\Attributes;

//use App\Model\Utils\DateTime;
use Nette\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;

trait TraitUpdatedAt
{
	#[ORM\Column(type: 'datetime', nullable: true)]
	protected $updatedAt;

	public function getUpdatedAt(): ?DateTime
	{
		return $this->updatedAt;
	}

	#[ORM\PreUpdate]
	public function setUpdatedAt(): void
	{
		$this->updatedAt = new DateTime();
	}
}