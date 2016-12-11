<?php

namespace App\Model\Page\Command;

use App\Model\Page\PageId;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadTrait;
use Rhumsaa\Uuid\Uuid;

class CreatePage extends Command
{
    use PayloadTrait;

    public static function withData($locale, array $data)
    {
        $title = $data['title'];
        $template = $data['template'];
        unset($data['title']);
        unset($data['template']);

        return new self(
            [
                'page_id' => Uuid::uuid4()->toString(),
                'title' => $title,
                'template' => $template,
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

    public function getTemplate()
    {
        return $this->payload['template'];
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
