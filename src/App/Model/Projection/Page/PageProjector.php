<?php

namespace App\Model\Projection\Page;

use App\Model\Page\Event\ExcerptWasUpdated;
use App\Model\Page\Event\PageWasCreated;
use App\Model\Page\Event\PageWasRemoved;
use App\Model\Page\Event\PageWasUpdated;

final class PageProjector
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var ExcerptRepositoryInterface
     */
    private $excerptRepository;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param ExcerptRepositoryInterface $excerptRepository
     */
    public function __construct(PageRepositoryInterface $pageRepository, ExcerptRepositoryInterface $excerptRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->excerptRepository = $excerptRepository;
    }

    public function onPageWasCreated(PageWasCreated $event)
    {
        $page = $this->pageRepository->create($event->getPageId()->toString(), $event->getTitle());
        $this->pageRepository->save($page);
    }

    public function onPageWasUpdated(PageWasUpdated $event)
    {
        $page = $this->pageRepository->findById($event->getPageId()->toString());
        $this->getProperty('title', $page)->setValue($page, $event->getTitle());

        $this->pageRepository->save($page);
    }

    public function onPageWasRemoved(PageWasRemoved $event)
    {
        $page = $this->pageRepository->findById($event->getPageId()->toString());
        $this->pageRepository->remove($page);
    }

    public function onExcerptWasUpdated(ExcerptWasUpdated $event)
    {
        $page = $this->pageRepository->findById($event->getPageId()->toString());
        $excerpt = $this->excerptRepository->findByEntity(get_class($page), $page->getId());

        if (!$excerpt) {
            $excerpt = $this->excerptRepository->create(get_class($page), $page->getId());
            $this->getProperty('excerpt', $page)->setValue($page, $excerpt);
        }

        $this->getProperty('title', $excerpt)->setValue($excerpt, $event->getTitle());

        $this->excerptRepository->save($excerpt);
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
