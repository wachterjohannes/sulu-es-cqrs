<?php

namespace App\Model\Projection\Page;

use App\Model\Page\Event\PageWasCreated;

final class PageProjector
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @param PageRepositoryInterface $pageRepository
     */
    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function onPageWasCreated(PageWasCreated $event)
    {
        $page = $this->pageRepository->create($event->getPageId()->toString(), $event->getTitle());
        $this->pageRepository->save($page);
    }
}
