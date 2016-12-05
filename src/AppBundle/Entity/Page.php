<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rhumsaa\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PageRepository")
 * @ORM\Table(name="app_page")
 */
class Page
{
    /**
     * @var string
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint")
     */
    private $offset;

    /**
     * @var int
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @param string $uuid
     */
    public function __construct($uuid)
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * Returns id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns offset.
     *
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Returns title.
     *
     * @return int
     */
    public function getTitle()
    {
        return $this->title;
    }
}
