<?php declare(strict_types = 1);

namespace App\Model\Service;

use App\Model\Repository\UserRepository;
use App\Model\Repository\TypeRepository;
use App\Model\Repository\RightRepository;
use Doctrine\Persistence\ObjectRepository;
use Nettrine\ORM\EntityManagerDecorator;

class EntityManager extends EntityManagerDecorator
{
    //--------------------------------------------------------------------------------------------------------
	public function getUserRepository(): UserRepository
	{
		return $this->getRepository(User::class);
	}
	//--------------------------------------------------------------------------------------------------------
	public function getTypeRepository(): TypeRepository
	{
		return $this->getRepository(Type::class);
	}
	//--------------------------------------------------------------------------------------------------------
	public function getRightRepository(): RightRepository
	{
		return $this->getRepository(Right::class);
	}
    //--------------------------------------------------------------------------------------------------------
	public function getRepository($entityName): ObjectRepository
	{
		return parent::getRepository($entityName);
	}
    //--------------------------------------------------------------------------------------------------------
}