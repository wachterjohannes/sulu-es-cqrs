<?php

namespace App\Model\Page\Handler;

use App\Model\Page\Command\CreatePage;
use App\Model\Page\Page;
use App\Model\Page\PageCollection;

final class CreatePageHandler
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
     * @param CreatePage $command
     */
    public function __invoke(CreatePage $command)
    {
        $this->pageCollection->add(
            Page::create($command->getPageId(), $command->getLocale(), $command->getTitle(), $command->getData())
        );
    }
}
