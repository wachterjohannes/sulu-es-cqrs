<?php

namespace App\Model\Page\Event;

use App\Model\Page\PageId;
use Prooph\EventSourcing\AggregateChanged;

class ExcerptWasUpdated extends AggregateChanged
{
    public static function withData(PageId $pageId, $locale, $title)
    {
        $event = self::occur(
            $pageId->toString(),
            [
                'page_id' => $pageId->toString(),
                'locale' => $locale,
                'title' => $title,
            ]
        );

        return $event;
    }

    /**
     * Returns pageId.
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
}
