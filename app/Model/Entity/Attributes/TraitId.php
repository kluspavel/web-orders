<?php declare(strict_types = 1);

namespace App\Model\Entity\Attributes;

use Doctrine\ORM\Mapping as ORM;

trait TraitId
{
	#[ORM\Id]
	#[ORM\Column(type: 'integer', unique: true, options: ['unsigned' => true])]
	#[ORM\GeneratedValue]
	private ?int $id = null;

	public function getId(): int
	{
		return $this->id;
	}

	public function __clone()
	{
		$this->id = null;
	}
}