<?php

namespace AppBundle\Content\Types;

interface ContentTypeInterface
{
    public function validate($value);

    public function encode($value);

    public function decode($value);
}
