<?php

namespace App\Model\Page\Command;

use App\Model\Page\PageId;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

class UpdateExcerpt extends Command
{
    use PayloadTrait;

    /**
     * @param string $pageId
     * @param string $locale
     * @param array $data
     *
     * @return UpdateExcerpt
     */
    public static function withData($pageId, $locale, array $data)
    {
        return new self(
            [
                'page_id' => $pageId,
                'locale' => $locale,
                'title' => $data['title'],
            ]
        );
    }

    public function getPageId()
    {
        return PageId::fromString($this->payload['page_id']);
    }

    public function getLocale()
    {
        return $this->payload['locale'];
    }

    public function getTitle()
    {
        return $this->payload['title'];
    }
}
