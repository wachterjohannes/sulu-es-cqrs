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
     * @param string $title
     *
     * @return UpdateExcerpt
     */
    public static function withData($pageId, $title)
    {
        return new self(
            [
                'page_id' => $pageId,
                'title' => $title,
            ]
        );
    }

    public function getPageId()
    {
        return PageId::fromString($this->payload['page_id']);
    }

    public function getTitle()
    {
        return $this->payload['title'];
    }
}
