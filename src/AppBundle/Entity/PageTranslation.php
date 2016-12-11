<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="app_page_translation")
 */
class PageTranslation
{
    /**
     * @var string
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $locale;

    /**
     * @var Page
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Page", cascade={"all"})
     */
    private $page;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var Excerpt
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Excerpt")
     */
    private $excerpt;

    /**
     * @param string $locale
     * @param string $title
     * @param Page $page
     */
    public function __construct($locale, $title, Page $page)
    {
        $this->locale = $locale;
        $this->title = $title;
        $this->page = $page;
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
     * Returns locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Returns page.
     *
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Returns title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
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

    /**
     * Set excerpt.
     *
     * @param Excerpt $excerpt
     *
     * @return $this
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;

        return $this;
    }
}
