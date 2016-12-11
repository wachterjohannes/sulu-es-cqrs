<?php

namespace App\Model\Page\Handler;

use App\Model\Page\Command\CreatePage;
use App\Model\Page\Command\UpdateExcerpt;
use App\Model\Page\Page;
use App\Model\Page\PageCollection;

final class UpdateExcerptHandler
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
     * @param UpdateExcerpt $command
     */
    public function __invoke(UpdateExcerpt $command)
    {
        $page = $this->pageCollection->get($command->getPageId());
        $page->updateExcerpt($command->getLocale(), $command->getTitle());
    }
}
