<?php

namespace App\Model\Projection\Page;

use App\Model\Page\Event\PageWasCreated;
use App\Model\Page\Event\PageWasUpdated;
use AppBundle\Entity\Page;

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

    public function onPageWasUpdated(PageWasUpdated $event)
    {
        /** @var Page $page */
        $page = $this->pageRepository->find($event->getPageId()->toString());
        $this->getProperty('title', $page)->setValue($page, $event->getTitle());

        $this->pageRepository->save($page);
    }

    /**
     * Returns reflection-property by name.
     *
     * @param string $name
     * @param mixed $object
     *
     * @return \ReflectionProperty
     */
    protected function getProperty($name, $object)
    {
        $class = new \ReflectionClass($object);
        $property = $class->getProperty($name);
        $property->setAccessible(true);

        return $property;
    }
}
