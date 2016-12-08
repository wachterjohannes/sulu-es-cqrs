<?php

namespace AppBundle\Content\Types;

interface ContentTypeInterface
{
    public function encode($value);

    public function decode($value);
}
