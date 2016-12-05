<?php

namespace Sulu\Component\EventStore;

interface EventInterface
{
    /**
     * Returns index.
     *
     * @return int
     */
    public function getIndex();

    /**
     * Returns data.
     *
     * @return mixed
     */
    public function getData();

    /**
     * Returns created-at.
     *
     * @return \DateTime
     */
    public function getCreatedAt();
}
