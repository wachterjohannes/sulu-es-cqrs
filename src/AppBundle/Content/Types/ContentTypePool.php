<?php

namespace AppBundle\Content\Types;

class ContentTypePool
{
    /**
     * @var ContentTypeInterface[]
     */
    private $contentTypes;

    public function addType($alias, ContentTypeInterface $contentType)
    {
        $this->contentTypes[$alias] = $contentType;
    }

    public function get($alias)
    {
        return $this->contentTypes[$alias];
    }
}
