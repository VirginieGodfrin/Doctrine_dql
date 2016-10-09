<?php

namespace AppBundle\Doctrine;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;

class DiscontinuedFilter extends SQLFilter
{
	public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias){
		/*var_dump($targetEntity);die;*/
		if (!$targetEntity->getReflectionClass()->name!='AppBundle\Entity\FortuneCookie') {
            return "";
        }
        return sprintf('%s.discontinued = %s', $targetTableAlias, $this->getRarameter('discontinued'));
	}

}
