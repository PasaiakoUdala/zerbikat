<?php

namespace Zerbikat\BackendBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("CLASS")
 */
final class UdalaEgiaztatu
{
    public $userFieldName;
}