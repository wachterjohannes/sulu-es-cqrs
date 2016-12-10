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
     * @var string
     */
    private $title;

    /**
     * @var Excerpt
     */
    private $excerpt;

    public static function create($title, PageId $pageId)
    {
        Assert::that($title)->string()->notBlank();

        $self = new self();
        $self->recordThat(PageWasCreated::byTitle($pageId, $title));

        return $self;
    }

    public function update($title)
    {
        Assert::that($title)->string()->notBlank();

        $this->recordThat(PageWasUpdated::byTitle($this->pageId, $title));
    }

    public function remove()
    {
        $this->recordThat(PageWasRemoved::byId($this->pageId));
    }

    public function updateExcerpt($title)
    {
        Assert::that($title)->string()->notBlank();

        $this->recordThat(ExcerptWasUpdated::byTitle($this->pageId, $title));
    }

    protected function whenPageWasCreated(PageWasCreated $event)
    {
        $this->pageId = $event->getPageId();
        $this->title = $event->getTitle();
    }

    protected function whenPageWasUpdated(PageWasUpdated $event)
    {
        $this->title = $event->getTitle();
    }

    protected function whenPageWasRemoved(PageWasRemoved $event)
    {
    }

    protected function whenExcerptWasUpdated(ExcerptWasUpdated $event)
    {
        if (!$this->excerpt) {
            $this->excerpt = new Excerpt();
        }

        $this->excerpt->setTitle($event->getTitle());
    }

    protected function aggregateId()
    {
        return $this->pageId->toString();
    }
}
