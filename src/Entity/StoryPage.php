<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="story_page")
 */
class StoryPage
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var Story
     * @ORM\ManyToOne(targetEntity="App\Entity\Story", inversedBy="pages")
     */
    private $story;

    /**
     * @var StoryLink[]
     * @ORM\OneToMany(targetEntity="App\Entity\StoryLink", mappedBy="links")
     */
    private $links;

    /**
     * StoryPage constructor.
     *
     * @param Story $story
     *
     * @throws Exception
     */
    public function __construct(Story $story)
    {
        $this->id = Uuid::uuid4();
        $this->story = $story;
        $this->links = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
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
     * @return Story
     */
    public function getStory(): Story
    {
        return $this->story;
    }

    /**
     * @param Story $story
     */
    public function setStory(Story $story): void
    {
        $this->story = $story;
    }

    /**
     * @return StoryLink[]|Collection
     */
    public function getLinks(): Collection
    {
        return $this->links;
    }
}
