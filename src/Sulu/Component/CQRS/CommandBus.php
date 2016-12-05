<?php

namespace Sulu\Component\CQRS;

use Sulu\Component\EventStore\EventRepositoryInterface;
use Sulu\Component\EventStore\EventStore;

class CommandBus
{
    /**
     * @var HandlerInterface[][]
     */
    private $handlers;

    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * @param array $handlers
     * @param EventRepositoryInterface $eventRepository
     * @param EventStore $eventStore
     */
    public function __construct(EventRepositoryInterface $eventRepository, EventStore $eventStore, array $handlers = [])
    {
        $this->eventRepository = $eventRepository;
        $this->eventStore = $eventStore;
        $this->handlers = $handlers;
    }

    public function register($className, HandlerInterface $handler)
    {
        if (!array_key_exists($className, $this->handlers)) {
            $this->handlers[$className] = [];
        }

        $this->handlers[$className][] = $handler;
    }

    /**
     * @param Command $command
     */
    public function handle(Command $command)
    {
        $event = $this->eventStore->create($command);
        foreach ($this->handlers[get_class($command)] as $handler) {
            try {
                $handler->handle($command, $event);
            } catch (\Exception $ex) {
                // FIXME revert runned handler? database-transactions?
                $this->eventStore->remove($event);
            }
        }
    }
}
