<?php

namespace AppBundle\CQRS\Page\Create;

use Sulu\Component\CQRS\Command as BaseCommand;

class Command extends BaseCommand
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param string $entityClass
     * @param string $entityId
     * @param array $data
     */
    public function __construct($entityClass, $entityId, array $data)
    {
        parent::__construct($entityClass, $entityId);

        $this->data = $data;
    }

    /**
     * Returns data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}
