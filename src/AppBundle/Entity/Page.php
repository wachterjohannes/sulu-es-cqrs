<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var Excerpt
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Excerpt")
     * @ORM\JoinColumn(name="excerptId", referencedColumnName="id")
     */
    private $excerpt;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
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

    /**
     * Returns excerpt.
     *
     * @return Excerpt
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }
}
