<?php declare(strict_types = 1);

namespace App\Model\Repository;

use App\Model\Entity\Right;

class RightRepository extends Repository
{
	//--------------------------------------------------------------------------------------------------------
	public function findAll()
	{
		return $this->findAll();
	}
	//--------------------------------------------------------------------------------------------------------
	public function findOneById(int $id): ?Right
	{
		return $this->findOneBy(['id' => $id]);
	}
	//--------------------------------------------------------------------------------------------------------
	public function findOneByType(string $right): ?Right
	{
		return $this->findOneBy(['right' => $right]);
	}
	//--------------------------------------------------------------------------------------------------------
	public function findOneByName(string $name): ?Right
	{
		return $this->findOneBy(['name' => $name]);
	}
	//--------------------------------------------------------------------------------------------------------
}