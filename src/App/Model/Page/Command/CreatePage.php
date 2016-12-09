<?php

namespace App\Model\Page\Command;

use App\Model\Page\PageId;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;
use Rhumsaa\Uuid\Uuid;

class CreatePage extends Command
{
    use PayloadTrait;

    /**
     * @param string $title
     *
     * @return self
     */
    public static function withData($title)
    {
        return new self(
            [
                'page_id' => Uuid::uuid4()->toString(),
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
