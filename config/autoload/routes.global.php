<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
        ],
        'factories' => [
            App\Middleware\Post::class => App\Middleware\PostFactory::class,
            App\Middleware\Author::class => App\Middleware\AuthorFactory::class,
            App\Mapper\Post::class => App\Mapper\PostFactory::class,
            App\Mapper\Author::class => App\Mapper\AuthorFactory::class,
        ],
    ],
];