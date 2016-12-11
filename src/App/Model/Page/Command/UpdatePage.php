<?php

namespace App\Model\Page\Command;

use App\Model\Page\PageId;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;

class UpdatePage extends Command
{
    use PayloadTrait;

    /**
     * @param string $id
     * @param string $locale
     * @param array $data
     *
     * @return self
     */
    public static function withData($id, $locale, array $data)
    {
        $title = $data['title'];
        unset($data['title']);

        return new self(
            [
                'page_id' => $id,
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
