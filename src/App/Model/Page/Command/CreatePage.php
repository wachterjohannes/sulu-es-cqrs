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
     * @param string $locale
     * @param array $data
     *
     * @return self
     */
    public static function withData($locale, array $data)
    {
        $title = $data['title'];
        unset($data['title']);

        return new self(
            [
                'page_id' => Uuid::uuid4()->toString(),
                'title' => $title,
                'locale' => $locale,
                'data' => $data,
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

    public function getLocale()
    {
        return $this->payload['locale'];
    }

    public function getData()
    {
        return $this->payload['data'];
    }
}
