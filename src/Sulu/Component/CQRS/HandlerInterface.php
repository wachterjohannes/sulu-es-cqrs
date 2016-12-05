<?php

namespace Sulu\Component\CQRS;

use Sulu\Component\EventStore\EventInterface;

interface HandlerInterface
{
    public function handle(Command $command, EventInterface $event);
}
