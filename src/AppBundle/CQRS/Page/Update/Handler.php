<?php

namespace AppBundle\CQRS\Page\Update;

use AppBundle\Content\Codec;
use AppBundle\Model\PageRepositoryInterface;
use AppBundle\Util\ReflectionPropertyTrait;
use Sulu\Component\CQRS\Command as BaseCommand;
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
    public function handle(BaseCommand $command, EventInterface $event)
    {
        $page = $this->pageRepository->findById($command->getEntityId());
        $this->getProperty('title', $page)->setValue($page, $command->getValue('title'));
        $this->getProperty('template', $page)->setValue($page, $command->getValue('template'));
        $this->getProperty('offset', $page)->setValue($page, $event->getIndex());
        $this->pageRepository->save($page);
    }
}
