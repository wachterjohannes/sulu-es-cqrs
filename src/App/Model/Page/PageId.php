<?php

namespace App\Model\Page;

use Rhumsaa\Uuid\Uuid;

final class PageId
{
    /**
     * @var Uuid
     */
    private $uuid;

    /**
     * @return self
     */
    public static function generate()
    {
        return new self(Uuid::uuid4());
    }

    /**
     * @param string $pageId
     *
     * @return self
     */
    public static function fromString($pageId)
    {
        return new self(Uuid::fromString($pageId));
    }

    /**
     * @param Uuid $uuid
     */
    private function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->uuid->toString();
    }

    /**
     * @param PageId $other
     *
     * @return bool
     */
    public function sameValueAs(PageId $other)
    {
        return $this->toString() === $other->toString();
    }
}
