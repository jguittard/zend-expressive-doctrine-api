<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

namespace App\Mapper;

use App\Entity\EntityInterface;

/**
 * Interface MapperInterface
 *
 * @package App\Mapper
 */
interface MapperInterface
{
    /**
     * @param array $params
     * @return array
     */
    public function fetchAll($params = []);

    /**
     * @param string $id
     * @return EntityInterface
     */
    public function fetch($id);

    /**
     * @param array|\stdClass $data
     * @return EntityInterface
     */
    public function create($data);

    /**
     * @param string $id
     * @param array|\stdClass $data
     * @return EntityInterface
     */
    public function update($id, $data);

    /**
     * @param string $id
     * @return bool
     */
    public function delete($id);
}
