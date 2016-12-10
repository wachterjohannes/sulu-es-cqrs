<?php

namespace App\Model\Projection\Page;

interface PageInterface
{
    /**
     * Returns id.
     *
     * @return string
     */
    public function getId();

    /**
     * Returns title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * @return ExcerptInterface
     */
    public function getExcerpt();
}
