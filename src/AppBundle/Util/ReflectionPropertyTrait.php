<?php

namespace AppBundle\Util;

trait ReflectionPropertyTrait
{
    /**
     * Returns reflection-property by name.
     *
     * @param string $name
     * @param mixed $object
     *
     * @return \ReflectionProperty
     */
    protected function getProperty($name, $object)
    {
        $class = new \ReflectionClass($object);
        $property = $class->getProperty($name);
        $property->setAccessible(true);

        return $property;
    }
}
