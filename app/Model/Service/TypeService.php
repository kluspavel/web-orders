<?php declare(strict_types=1);

namespace App\Model\Service;

use App\Model\Entity\Type;
use App\Model\Service\EntityService;
use Nette\Application\UI\Presenter;
use Nettrine\ORM\EntityManagerDecorator;


class TypeService extends EntityService
{
	//--------------------------------------------------------------------------------------------------------
	public function __construct(private EntityManagerDecorator $em) 
	{
		parent::__construct($em);
	}
	//--------------------------------------------------------------------------------------------------------
	public function findAllTypes()
	{
		$types = $this->getTypeRepository()->findAll();
		return $types;
	}
}