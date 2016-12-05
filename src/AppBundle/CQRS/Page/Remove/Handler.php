<?php

namespace AppBundle\CQRS\Page\Remove;

use AppBundle\Model\PageRepositoryInterface;
use Sulu\Component\CQRS\Command;
use Sulu\Component\CQRS\HandlerInterface;
use Sulu\Component\EventStore\EventInterface;

class Handler implements HandlerInterface
{
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
        $page = $this->pageRepository->findById($command->getEntityId());
        $this->pageRepository->remove($page);
    }
}
