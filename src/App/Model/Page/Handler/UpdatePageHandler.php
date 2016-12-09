<?php

namespace App\Model\Page\Handler;

use App\Model\Page\Command\UpdatePage;
use App\Model\Page\PageCollection;

final class UpdatePageHandler
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
     * @param UpdatePage $command
     */
    public function __invoke(UpdatePage $command)
    {
        $page = $this->pageCollection->get($command->getPageId());
        $page->update($command->getTitle());
    }
}
