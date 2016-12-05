<?php

namespace AppBundle\Util;

use AppBundle\Entity\Page;

trait ReflectionPropertyTrait
{
    /**
     * Returns reflection-property by name.
     *
     * @param string $name
     *
     * @return \ReflectionProperty
     */
    protected function getProperty($name)
    {
        $class = new \ReflectionClass(Page::class);
        $property = $class->getProperty($name);
        $property->setAccessible(true);

        return $property;
    }
}
