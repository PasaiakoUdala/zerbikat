<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('WhiteOctober', __DIR__.'/../vendor/bundles');

AnnotationRegistry::registerLoader([$loader, 'loadClass']);

return $loader;
