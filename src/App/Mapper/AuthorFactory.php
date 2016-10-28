<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

namespace App\Mapper;

use App\Entity\Author as AuthorEntity;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Container\Exception\NotFoundException;

/**
 * Class AuthorFactory
 *
 * @package App\Mapper
 */
class AuthorFactory
{
    public function __invoke(ContainerInterface $container)
    {
        if (!$container->has(EntityManagerInterface::class)) {
            throw new NotFoundException(sprintf('%s service could not be retrieved', EntityManagerInterface::class));
        }
        $om = $container->get(EntityManagerInterface::class);

        return new Post($om, AuthorEntity::class);
    }
}
