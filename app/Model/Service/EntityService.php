<?php declare(strict_types = 1);

namespace App\Model\Service;

use Doctrine\ORM\Decorator\EntityManagerDecorator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Model\Entity\User;
use Doctrine\Persistence\ObjectRepository;

class EntityService
{
	//--------------------------------------------------------------------------------------------------------
	public function __construct(private EntityManagerDecorator $emd) {}
	//--------------------------------------------------------------------------------------------------------
	public function getRepository($className)
	{
		return $this->emd->getRepository($className);
	}
	//--------------------------------------------------------------------------------------------------------
	public function getUserRepository()
	{
		return $this->emd->getRepository(User::class);
	}
	//--------------------------------------------------------------------------------------------------------
}