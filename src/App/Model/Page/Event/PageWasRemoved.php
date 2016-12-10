<?php

namespace App\Model\Page\Event;

use App\Model\Page\PageId;
use Prooph\EventSourcing\AggregateChanged;

class PageWasRemoved extends AggregateChanged
{
    public static function byId(PageId $pageId)
    {
        $event = self::occur(
            $pageId->toString(),
            [
                'page_id' => $pageId->toString(),
            ]
        );

        $event->pageId = $pageId;

        return $event;
    }

    /**
     * @var PageId
     */
    private $pageId;

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
}
