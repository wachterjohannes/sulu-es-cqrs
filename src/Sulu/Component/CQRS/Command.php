<?php

namespace Sulu\Component\CQRS;

abstract class Command
{
    /**
     * @var string
     */
    private $entityClass;

    /**
     * @var string
     */
    private $entityId;

    /**
     * @param $entityClass
     * @param $entityId
     */
    public function __construct($entityClass, $entityId)
    {
        $this->entityClass = $entityClass;
        $this->entityId = $entityId;
    }

    /**
     * Returns entity-class.
     *
     * @return mixed
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Returns entity-id.
     *
     * @return mixed
     */
    public function getEntityId()
    {
        return $this->entityId;
    }
}
