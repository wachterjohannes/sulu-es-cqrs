<?php

namespace App\Model\Page;

use App\Model\Page\Event\ExcerptWasUpdated;
use App\Model\Page\Event\PageWasCreated;
use App\Model\Page\Event\PageWasRemoved;
use App\Model\Page\Event\PageWasUpdated;
use Assert\Assert;
use Prooph\EventSourcing\AggregateRoot;

class Page extends AggregateRoot
{
    /**
     * @var PageId
     */
    private $pageId;

    /**
     * @var PageTranslation[]
     */
    private $translations = [];

    public static function create(PageId $pageId, $locale, $title, $data)
    {
        Assert::that($title)->string()->notBlank();

        $self = new self();
        $self->recordThat(PageWasCreated::withData($pageId, $locale, $title, $data));

        return $self;
    }

    public function update($locale, $title, $data)
    {
        Assert::that($title)->string()->notBlank();

        $this->recordThat(PageWasUpdated::withData($this->pageId, $locale, $title, $data));
    }

    public function remove()
    {
        $this->recordThat(PageWasRemoved::byId($this->pageId));
    }

    public function updateExcerpt($locale, $title)
    {
        Assert::that($title)->string()->notBlank();

        $this->recordThat(ExcerptWasUpdated::withData($this->pageId, $locale, $title));
    }

    protected function whenPageWasCreated(PageWasCreated $event)
    {
        $this->pageId = $event->getPageId();
        $this->translations[$event->getLocale()] = new PageTranslation($event->getLocale(), $event->getTitle());
    }

    protected function whenPageWasUpdated(PageWasUpdated $event)
    {
        if (!array_key_exists($event->getLocale(), $this->translations)) {
            $this->translations[$event->getLocale()] = new PageTranslation($event->getLocale(), $event->getTitle());
        }

        $translation = $this->translations[$event->getLocale()];
        $translation->setTitle($event->getTitle());
        $translation->setData($event->getData());
    }

    protected function whenPageWasRemoved(PageWasRemoved $event)
    {
    }

    protected function whenExcerptWasUpdated(ExcerptWasUpdated $event)
    {
        if (!$this->translations[$event->getLocale()]->getExcerpt()) {
            $this->translations[$event->getLocale()]->setExcerpt(new Excerpt());
        }

        $this->translations[$event->getLocale()]->getExcerpt()->setTitle($event->getTitle());
    }

    protected function aggregateId()
    {
        return $this->pageId->toString();
    }
}
