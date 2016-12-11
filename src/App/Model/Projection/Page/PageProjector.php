<?php

namespace App\Model\Projection\Page;

use App\Model\Page\Event\ExcerptWasUpdated;
use App\Model\Page\Event\PageWasCreated;
use App\Model\Page\Event\PageWasRemoved;
use App\Model\Page\Event\PageWasUpdated;
use AppBundle\Entity\Excerpt;
use AppBundle\Entity\Page;
use AppBundle\Entity\PageTranslation;
use Doctrine\ORM\EntityManager;

final class PageProjector
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onPageWasCreated(PageWasCreated $event)
    {
        $translation = new PageTranslation(
            $event->getLocale(), $event->getTitle(), new Page($event->getPageId()->toString())
        );
        $translation->getPage()->addTranslation($translation);

        $this->entityManager->persist($translation);
        $this->entityManager->flush($translation);
    }

    public function onPageWasUpdated(PageWasUpdated $event)
    {
        $page = $this->entityManager->find(Page::class, $event->getPageId()->toString());
        if (!$page->hasTranslation($event->getLocale())) {
            $page->addTranslation(new PageTranslation($event->getLocale(), $event->getTitle(), $page));
        }

        $translation = $page->getTranslation($event->getLocale());
        $translation->setTitle($event->getTitle());

        $this->entityManager->persist($page);
        $this->entityManager->flush($translation);
        $this->entityManager->flush($page);
    }

    public function onPageWasRemoved(PageWasRemoved $event)
    {
        $page = $this->entityManager->find(Page::class, $event->getPageId()->toString());

        $this->entityManager->remove($page);
        $this->entityManager->flush($page);
    }

    public function onExcerptWasUpdated(ExcerptWasUpdated $event)
    {
        $page = $this->entityManager->find(Page::class, $event->getPageId()->toString());
        $translation = $page->getTranslation($event->getLocale());

        if (!$translation->getExcerpt()) {
            $excerpt = new Excerpt($event->getPageId()->toString(), Page::class, $event->getPageId()->toString());

            $translation->setExcerpt($excerpt);
            $this->entityManager->persist($excerpt);
        }

        $excerpt = $translation->getExcerpt();
        $excerpt->setTitle($event->getTitle());

        $this->entityManager->flush($excerpt);
        $this->entityManager->flush($translation);
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
