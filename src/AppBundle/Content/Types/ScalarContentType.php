<?php

namespace AppBundle\Content\Types;

class ScalarContentType implements ContentTypeInterface
{
    public function encode($value)
    {
        return $value;
    }

    public function decode($value)
    {
        return $value;
    }
}
