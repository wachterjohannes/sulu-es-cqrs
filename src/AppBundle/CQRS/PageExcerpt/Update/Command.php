<?php

namespace AppBundle\CQRS\PageExcerpt\Update;

use Sulu\Component\CQRS\Command as BaseCommand;

class Command extends BaseCommand
{
    /**
     * @var array
     */
    private $diffMinus;

    /**
     * @var array
     */
    private $diffPlus;

    /**
     * @param string $entityClass
     * @param string $entityId
     * @param array $diffMinus
     * @param array $diffPlus
     */
    public function __construct($entityClass, $entityId, array $diffMinus, array $diffPlus)
    {
        parent::__construct($entityClass, $entityId);

        $this->diffMinus = $diffMinus;
        $this->diffPlus = $diffPlus;
    }

    /**
     * Returns diffMinus.
     *
     * @return array
     */
    public function getDiffMinus()
    {
        return $this->diffMinus;
    }

    /**
     * Returns diffPlus.
     *
     * @return array
     */
    public function getDiffPlus()
    {
        return $this->diffPlus;
    }
}
