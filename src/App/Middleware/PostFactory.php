<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

namespace App\Middleware;

use App\Mapper\Post as PostMapper;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Container\Exception\NotFoundException;
use Zend\Expressive\Helper\UrlHelper;

/**
 * Class PostFactory
 *
 * @package App\Middleware
 */
class PostFactory
{
    /**
     * @param ContainerInterface $container
     * @throws NotFoundException
     * @return Post
     */
    public function __invoke(ContainerInterface $container)
    {
        if (!$container->has(PostMapper::class)) {
            throw new NotFoundException(sprintf('%s service could not be retrieved', PostMapper::class));
        }
        $mapper = $container->get(PostMapper::class);

        if (!$container->has(UrlHelper::class)) {
            throw new NotFoundException(sprintf('%s helper could not be retrieved', UrlHelper::class));
        }
        $urlHelper = $container->get(UrlHelper::class);

        $resource = new Post($mapper, $urlHelper);
        $resource->setCollectionName('posts')
                 ->setResourceName('post')
                 ->setRouteName('api.post')
                 ->setRouteIdentifier('id');

        return $resource;
    }
}
