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
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Post
 *
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="post")
 * @ORM\HasLifecycleCallbacks
 */
class Post extends AbstractEntity
{
    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     * @Gedmo\Slug(fields={"title"})
     * @var string
     */
    protected $slug;

    /**
     * @ORM\Column(name="body", type="text", nullable=true)
     * @var string
     */
    protected $body;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author")
     * @ORM\JoinColumn(nullable=false)
     * @var Author
     */
    protected $author;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param Author $author
     * @return Post
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        return $this;
    }
}
