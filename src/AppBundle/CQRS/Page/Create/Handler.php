<?php

namespace AppBundle\CQRS\Page\Create;

use AppBundle\Model\PageRepositoryInterface;
use AppBundle\Util\ReflectionPropertyTrait;
use Sulu\Component\CQRS\Command;
use Sulu\Component\CQRS\HandlerInterface;
use Sulu\Component\EventStore\EventInterface;

class Handler implements HandlerInterface
{
    use ReflectionPropertyTrait;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @param PageRepositoryInterface $pageRepository
     */
    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * {@inheritdoc}
     *
     * @param Command $command
     */
    public function handle(Command $command, EventInterface $event)
    {
        $page = $this->pageRepository->create($command->getEntityId());
        $this->getProperty('title', $page)->setValue($page, $command->getData()['title']);
        $this->getProperty('offset', $page)->setValue($page, $event->getIndex());
        $this->pageRepository->save($page);
    }
}
