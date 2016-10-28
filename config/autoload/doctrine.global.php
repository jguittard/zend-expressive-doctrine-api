<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

use Doctrine\DBAL\Driver as DoctrineDBALDriver;
use Doctrine\Common\Persistence\Mapping\Driver as DoctrineCommonDriver;
use Doctrine\ORM\Mapping\Driver as DoctrineORMDriver;
use Doctrine\Common\Cache as DoctrineCache;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url' => 'sqlite:////' . __DIR__ . '/../../data/db/blog.db',
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => DoctrineCommonDriver\MappingDriverChain::class,
                'drivers' => [
                    'App\Entity' => 'app_entity',
                ],
            ],
            'app_entity' => [
                'class' => DoctrineORMDriver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => __DIR__ . '/../../src/App/Entity',
            ],
        ],
        'event_manager' => [
            'orm_default' => [
                'subscribers' => [
                    Gedmo\Sluggable\SluggableListener::class,
                ],
            ],
        ],
        'cache' => [
            'array' => [
                'class' => DoctrineCache\ArrayCache::class,
                'namespace' => 'container-interop-doctrine',
            ],
        ],
    ],
];
