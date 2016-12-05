<?php

namespace Sulu\Component\EventStore;

interface EventRepositoryInterface
{
    /**
     * @param string $id
     * @param string $stream
     * @param mixed $data
     *
     * @return EventInterface
     */
    public function create($id, $stream, $data);

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
