<?php

namespace App\Model\Page;

class PageTranslation
{
    /**
     * @var string
     */
    private $locale;

    /**
     * @var string
     */
    private $title;

    /**
     * @var array
     */
    private $data;

    /**
     * @var Excerpt
     */
    private $excerpt;

    /**
     * @param string $locale
     * @param string $title
     */
    public function __construct($locale, $title)
    {
        $this->locale = $locale;
        $this->title = $title;
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
     * Returns data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set data.
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

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
