<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

namespace App\Hydrator\Strategy;

use App\Entity\EntityInterface;
use Zend\Hydrator\Strategy\StrategyInterface;

/**
 * Class Association
 *
 * @package App\Hydrator\Strategy
 */
class Association implements StrategyInterface
{
    /**
     * @inheritDoc
     */
    public function extract($value)
    {
        if ($value instanceof EntityInterface) {
            return $value->getId();
        }
        return $value;
    }

    /**
     * @inheritDoc
     */
    public function hydrate($value)
    {
        return $value;
    }
}
