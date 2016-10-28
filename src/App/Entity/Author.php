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

/**
 * Class Author
 *
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="author")
 * @ORM\HasLifecycleCallbacks
 */
class Author extends AbstractEntity
{
    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     * @var string
     */
    protected $twitter;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     * @return Author
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
        return $this;
    }
}
