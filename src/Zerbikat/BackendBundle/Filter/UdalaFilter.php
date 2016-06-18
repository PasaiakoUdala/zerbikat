<?php

namespace Zerbikat\BackendBundle\Filter;

use Doctrine\ORM\Mapping\ClassMetaData;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\Common\Annotations\Reader;

class UdalaFilter extends SQLFilter
{
    protected $reader;

    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (empty($this->reader)) {
            return '';
        }

        // The Doctrine filter is called for any query on any entity
        // Check if the current entity is "user aware" (marked with an annotation)
        $udalaEgiaztatu = $this->reader->getClassAnnotation(
            $targetEntity->getReflectionClass(),
            'Zerbikat\\BackendBundle\\Annotation\\UdalaEgiaztatu'
        );

        if (!$udalaEgiaztatu) {
            return '';
        }

        $fieldName = $udalaEgiaztatu->userFieldName;

        try {
            // Don't worry, getParameter automatically quotes parameters
            $udalaId = $this->getParameter('udala_id');
        } catch (\InvalidArgumentException $e) {
            // No user id has been defined
            return '';
        }

        if (empty($fieldName) || empty($udalaId)) {
//        if (empty($fieldName) || ($udalaId=='138')) {
            return '';
        }

        $query = sprintf('%s.%s = %s', $targetTableAlias, $fieldName, $udalaId);

        return $query;
    }

    public function setAnnotationReader(Reader $reader)
    {
        $this->reader = $reader;
    }
}