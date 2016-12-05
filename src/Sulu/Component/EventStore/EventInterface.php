<?php

namespace Sulu\Component\EventStore;

interface EventInterface
{
    /**
     * Returns id.
     *
     * @return string
     */
    public function getId();

    /**
     * Returns stream.
     *
     * @return string
     */
    public function getStream();

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
