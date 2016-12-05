<?php

namespace Sulu\Component\EventStore;

class EventStore
{
    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    /**
     * @param EventRepositoryInterface $eventRepository
     */
    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param EventInterface $event
     *
     * @return EventInterface
     */
    public function store(EventInterface $event)
    {
        $this->eventRepository->save($event);

        return $event;
    }

    /**
     * @param mixed $data
     *
     * @return EventInterface
     */
    public function create($data)
    {
        return $this->store($this->eventRepository->create($data));
    }

    /**
     * @param EventInterface $event
     */
    public function remove(EventInterface $event)
    {
        $this->eventRepository->remove($event);
    }
}
