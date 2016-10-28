<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

namespace App\Mapper;

use App\Entity\Post as PostEntity;
use App\Hydrator\Strategy\Association;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Container\Exception\NotFoundException;
use Zend\Hydrator\Doctrine\DoctrineObject;

/**
 * Class PostFactory
 *
 * @package App\Mapper
 */
class PostFactory
{
    public function __invoke(ContainerInterface $container)
    {
        if (!$container->has(EntityManagerInterface::class)) {
            throw new NotFoundException(sprintf('%s service could not be retrieved', EntityManagerInterface::class));
        }
        $om = $container->get(EntityManagerInterface::class);

        $hydrator = new DoctrineObject($om, true);
        $hydrator->addStrategy('author', $container->get(Association::class));
        $mapper = new Post($om, PostEntity::class);
        $mapper->setHydrator($hydrator);

        return $mapper;
    }
}
