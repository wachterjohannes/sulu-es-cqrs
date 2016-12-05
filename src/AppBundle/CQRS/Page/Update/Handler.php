<?php

namespace AppBundle\CQRS\Page\Update;

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
        $page = $this->pageRepository->findById($command->getEntityId());
        $this->getProperty('title')->setValue($page, $command->getDiffPlus()['title']);
        $this->getProperty('offset')->setValue($page, $event->getIndex());

        $this->pageRepository->save($page);
    }
}
