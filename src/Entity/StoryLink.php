<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="story_link")
 */
class StoryLink
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
     * @var StoryPage
     * @ORM\ManyToOne(targetEntity="App\Entity\StoryPage", inversedBy="links")
     */
    private $storyPage;

    /**
     * @var StoryPage
     * @ORM\OneToOne(targetEntity="App\Entity\StoryPage")
     */
    private $storyPageTo;

    /**
     * StoryPage constructor.
     *
     * @param StoryPage $storyPage
     *
     * @throws Exception
     */
    public function __construct(StoryPage $storyPage)
    {
        $this->id = Uuid::uuid4();
        $this->storyPage = $storyPage;
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
     * @return StoryPage
     */
    public function getStoryPage(): StoryPage
    {
        return $this->storyPage;
    }

    /**
     * @param StoryPage $storyPage
     */
    public function setStoryPage(StoryPage $storyPage): void
    {
        $this->storyPage = $storyPage;
    }

    /**
     * @return StoryPage
     */
    public function getStoryPageTo(): ?StoryPage
    {
        return $this->storyPageTo;
    }

    /**
     * @param StoryPage $storyPageTo
     */
    public function setStoryPageTo(StoryPage $storyPageTo): void
    {
        $this->storyPageTo = $storyPageTo;
    }
}
