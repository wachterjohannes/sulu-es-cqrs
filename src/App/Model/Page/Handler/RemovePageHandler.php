<?php

namespace App\Model\Page\Handler;

use App\Model\Page\Command\RemovePage;
use App\Model\Page\PageCollection;

final class RemovePageHandler
{
    /**
     * @var PageCollection
     */
    private $pageCollection;

    /**
     * @param PageCollection $pageCollection
     */
    public function __construct(PageCollection $pageCollection)
    {
        $this->pageCollection = $pageCollection;
    }

    /**
     * @param RemovePage $command
     */
    public function __invoke(RemovePage $command)
    {
        $page = $this->pageCollection->get($command->getPageId());
        $page->remove();
    }
}
