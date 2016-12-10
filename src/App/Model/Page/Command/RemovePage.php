<?php

namespace App\Model\Page\Command;

use App\Model\Page\PageId;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;
use Rhumsaa\Uuid\Uuid;

class RemovePage extends Command
{
    use PayloadTrait;

    /**
     * @param string $id
     *
     * @return self
     */
    public static function byId($id)
    {
        return new self(
            [
                'page_id' => $id,
            ]
        );
    }

    public function getPageId()
    {
        return PageId::fromString($this->payload['page_id']);
    }
}
