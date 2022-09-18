<?php declare(strict_types = 1);

namespace App\Model\Repository;

use App\Model\Entity\Type;

class TypeRepository extends Repository
{
	//--------------------------------------------------------------------------------------------------------
	public function findAll()
	{
		return $this->findAll();
	}
	//--------------------------------------------------------------------------------------------------------
	public function findOneById(int $id): ?Type
	{
		return $this->findOneBy(['id' => $id]);
	}
	//--------------------------------------------------------------------------------------------------------
	public function findOneByType(string $type): ?Type
	{
		return $this->findOneBy(['type' => $type]);
	}
	//--------------------------------------------------------------------------------------------------------
	public function findOneByName(string $name): ?Type
	{
		return $this->findOneBy(['name' => $name]);
	}
	//--------------------------------------------------------------------------------------------------------
}