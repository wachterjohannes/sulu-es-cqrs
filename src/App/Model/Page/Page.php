<?php

namespace App\Model\Page;

use App\Model\Page\Event\PageWasCreated;
use Assert\Assert;
use Prooph\EventSourcing\AggregateRoot;

class Page extends AggregateRoot
{
    /**
     * @var PageId
     */
    private $pageId;

    private $title;

    public static function create($title, PageId $pageId)
    {
        Assert::that($title)->string()->notBlank();

        $self = new self();
        $self->recordThat(PageWasCreated::byTitle($pageId, $title));

        return $self;
    }

    protected function whenPageWasCreated(PageWasCreated $event)
    {
        $this->pageId = $event->getPageId();
        $this->title = $event->getTitle();
    }

    protected function aggregateId()
    {
        return $this->pageId->toString();
    }
}
