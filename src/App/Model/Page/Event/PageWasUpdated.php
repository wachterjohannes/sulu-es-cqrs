<?php

namespace App\Model\Page\Event;

use App\Model\Page\PageId;
use Prooph\EventSourcing\AggregateChanged;

class PageWasUpdated extends AggregateChanged
{
    public static function withData(PageId $pageId, $locale, $title, $data)
    {
        $event = self::occur(
            $pageId->toString(),
            [
                'page_id' => $pageId->toString(),
                'title' => $title,
                'locale' => $locale,
                'data' => $data,
            ]
        );

        return $event;
    }

    /**
     * Returns page-id.
     *
     * @return PageId
     */
    public function getPageId()
    {
        return PageId::fromString($this->payload['page_id']);
    }

    /**
     * Returns locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->payload['locale'];
    }

    /**
     * Returns title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->payload['title'];
    }

    /**
     * Returns data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->payload['data'];
    }
}
