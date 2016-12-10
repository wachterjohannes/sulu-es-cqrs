<?php

namespace App\Model\Page;

interface PageCollection
{
    /**
     * @param Page $page
     */
    public function add(Page $page);

    /**
     * @param PageId $pageId
     *
     * @return Page
     */
    public function get(PageId $pageId);
}
