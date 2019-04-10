<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="blog_post")
 */
class BlogPost
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="current_place", type="string", nullable=true)
     */
    public $currentPlace;

    /**
     * @var string
     * @ORM\Column(name="author_id", type="string", nullable=true)
     */
    public $author;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    public $title;

    /**
     * @var string
     * @ORM\Column(name="intro", type="text", nullable=true)
     */
    public $intro;

    /**
     * @var string
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    public $content;

    /**
     * @var string
     * @ORM\Column(name="image_url", type="string", nullable=true)
     */
    public $imageUrl;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $createdAt;
    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    public $updatedAt;

    public function __construct(string $author)
    {
        $this->id = Uuid::uuid4();
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCurrentPlace()
    {
        return $this->currentPlace;
    }

    /**
     * @param string $currentPlace
     */
    public function setCurrentPlace(string $currentPlace): void
    {
        $this->currentPlace = $currentPlace;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getIntro()
    {
        return $this->intro;
    }

    /**
     * @param string $intro
     */
    public function setIntro(string $intro): void
    {
        $this->intro = $intro;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl): void
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = new DateTime();
    }
}
