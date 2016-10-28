<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

namespace App\Middleware;

use App\Mapper\Author as AuthorMapper;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Container\Exception\NotFoundException;
use Zend\Expressive\Helper\UrlHelper;

/**
 * Class AuthorFactory
 *
 * @package App\Middleware
 */
class AuthorFactory
{
    /**
     * @param ContainerInterface $container
     * @throws NotFoundException
     * @return Author
     */
    public function __invoke(ContainerInterface $container)
    {
        if (!$container->has(AuthorMapper::class)) {
            throw new NotFoundException(sprintf('%s service could not be retrieved', AuthorMapper::class));
        }
        $mapper = $container->get(AuthorMapper::class);

        if (!$container->has(UrlHelper::class)) {
            throw new NotFoundException(sprintf('%s helper could not be retrieved', UrlHelper::class));
        }
        $urlHelper = $container->get(UrlHelper::class);

        $resource = new Author($mapper, $urlHelper);
        $resource->setCollectionName('authors')
            ->setResourceName('author')
            ->setRouteName('api.author')
            ->setRouteIdentifier('id');

        return $resource;
    }
}