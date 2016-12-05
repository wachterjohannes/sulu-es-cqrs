<?php

namespace Sulu\Component\EventStore;

interface EventRepositoryInterface
{
    /**
     * @param mixed $data
     *
     * @return EventInterface
     */
    public function create($data);

    /**
     * @param EventInterface $event
     */
    public function save(EventInterface $event);

    /**
     * @param EventInterface $event
     *
     * @return mixed
     */
    public function remove(EventInterface $event);
}
