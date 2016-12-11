<?php

namespace App\Model\Projection\Page;

use App\Model\Page\Event\ExcerptWasUpdated;
use AppBundle\Entity\Excerpt;
use AppBundle\Entity\Page;
use Doctrine\ORM\EntityManager;

class ExcerptProjector
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
}
