<?php

namespace App\Model\Page\Event;

use App\Model\Page\PageId;
use Prooph\EventSourcing\AggregateChanged;

class ExcerptWasUpdated extends AggregateChanged
{
    public static function byTitle(PageId $pageId, $title)
    {
        $event = self::occur(
            $pageId->toString(),
            [
                'page_id' => $pageId->toString(),
                'title' => $title,
            ]
        );

        $event->pageId = $pageId;
        $event->title = $title;

        return $event;
    }

    /**
     * @var PageId
     */
    private $pageId;

    /**
     * @var string
     */
    private $title;

    /**
     * Returns pageId.
     *
     * @return PageId
     */
    public function getPageId()
    {
        if (!$this->pageId) {
            $this->pageId = PageId::fromString($this->payload['page_id']);
        }

        return $this->pageId;
    }

    /**
     * Returns title.
     *
     * @return string
     */
    public function getTitle()
    {
        if (!$this->title) {
            $this->title = $this->payload['title'];
        }

        return $this->title;
    }
}
