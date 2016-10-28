<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * Class AbstractEntity
 *
 * @package App\Entity
 */
abstract class AbstractEntity implements EntityInterface
{
    /**
     * Unique identifier
     *
     * @ORM\Id
     * @ORM\Column(type="string", name="id", length=36, options={"fixed": true})
     * @ORM\GeneratedValue(strategy="NONE")
     * @var string
     */
    protected $id;

    /**
     *
     * @ORM\Column(name="created_time", type="datetime", nullable=false)
     * @var \DateTime
     */
    protected $createdTime;

    /**
     * Entity constructor.
     */
    public function __construct()
    {
        $this->createdTime = new \DateTime();
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedTime()
    {
        return $this->createdTime->format('u');
    }

    /**
     * Called on PostLoad Event
     *
     * @ORM\PrePersist
     * @return void
     */
    public function onPrePersist()
    {
        $this->id = Uuid::uuid4()->toString();
    }
}
