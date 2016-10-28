<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

use ContainerInteropDoctrine\EntityManagerFactory;
use ContainerInteropDoctrine\EventManagerFactory;
use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    // Provides application-wide services.
    // We recommend using fully-qualified class names whenever possible as
    // service names.
    'dependencies' => [
        // Use 'factories' for services provided by callbacks/factory classes.
        'factories' => [
            Application::class => ApplicationFactory::class,
            Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
            Helper\UrlHelperMiddleware::class => Helper\UrlHelperMiddlewareFactory::class,
            Doctrine\ORM\EntityManagerInterface::class => EntityManagerFactory::class,
            Doctrine\Common\EventManager::class => EventManagerFactory::class,
            Gedmo\Sluggable\SluggableListener::class => InvokableFactory::class,
            App\Hydrator\Strategy\Association::class => InvokableFactory::class,
        ],
    ],
];