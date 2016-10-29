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
use Doctrine\Common\Persistence\ObjectManager;
use Zend\Hydrator\Doctrine\DoctrineObject;
use Zend\Hydrator\HydratorInterface;

/**
 * Class AbstractDoctrine
 *
 * @package App\Mapper
 */
abstract class AbstractDoctrine implements MapperInterface
{
    /**
     * The object manager
     *
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * The associated entity class name
     * @var string
     */
    protected $entityClass;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    /**
     * Post constructor.
     *
     * @param ObjectManager $objectManager
     * @param string $entityClass
     */
    public function __construct(ObjectManager $objectManager, $entityClass)
    {
        $this->objectManager = $objectManager;
        $this->entityClass = $entityClass;
    }

    /**
     * @return HydratorInterface
     */
    public function getHydrator()
    {
        if (!$this->hydrator) {
            $this->hydrator = new DoctrineObject($this->objectManager, true);
        }
        return $this->hydrator;
    }

    /**
     * @param HydratorInterface $hydrator
     * @return AbstractDoctrine
     */
    public function setHydrator(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
        return $this;
    }

    /**
     * Fetches all entities from entity repository
     *
     * @param array $params
     * @return array
     */
    public function fetchAll($params = [])
    {
        $all = $this->objectManager->getRepository($this->entityClass)->findAll();

        $collection = [];
        /** @var EntityInterface $item */
        foreach ($all as $item) {
            $collection[] = $this->getHydrator()->extract($item);
        }
        return $collection;

        //return $this->objectManager->getRepository($this->entityClass)->findAll();
    }

    /**
     * Fetch a single entity from its repository with its identifier
     *
     * @param string $id
     * @return array
     */
    public function fetch($id)
    {
        $entity = $this->objectManager->getRepository($this->entityClass)->find($id);
        return $this->getHydrator()->extract($entity);
    }

    /**
     * Creates an entity with provided data and persists it
     *
     * @param array|\stdClass $data
     * @throws MapperException
     * @return array
     */
    public function create($data)
    {
        $data = (array)$data;

        /** @var EntityInterface $entity */
        $entity = new $this->entityClass;
        $this->getHydrator()->hydrate($data, $entity);

        try {
            $this->objectManager->persist($entity);
            $this->objectManager->flush();
            return $this->getHydrator()->extract($entity);
        } catch (\Exception $exception) {
            throw new MapperException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Updates an entity with provided data and persists it
     *
     * @param string $id
     * @param array|\stdClass $data
     * @throws MapperException
     * @return array|bool
     */
    public function update($id, $data)
    {
        /** @var EntityInterface $entity */
        $entity = $this->fetch($id);
        if (!$entity) {
            return false;
        }
        $this->getHydrator()->hydrate($data, $entity);
        try {
            $this->objectManager->persist($entity);
            $this->objectManager->flush();
            return $this->getHydrator()->extract($entity);
        } catch (\Exception $exception) {
            throw new MapperException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * Deletes an entity through its repository with its identifier
     *
     * @param string $id
     * @throws MapperException
     * @return bool
     */
    public function delete($id)
    {
        /** @var EntityInterface $entity */
        $entity = $this->objectManager->find($this->entityClass, $id);
        if (!$entity) {
            return false;
        }
        try {
            $this->objectManager->remove($entity);
            $this->objectManager->flush();
            return true;
        } catch (\Exception $exception) {
            throw new MapperException($exception->getMessage(), $exception->getCode());
        }
    }
}
