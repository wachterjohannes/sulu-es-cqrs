<?php

namespace App\Model\Page\Command;

use App\Model\Page\PageId;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

class UpdatePage extends Command
{
    use PayloadTrait;

    /**
     * @param string $title
     *
     * @return self
     */
    public static function withData($id, $title)
    {
        return new self(
            [
                'page_id' => $id,
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
