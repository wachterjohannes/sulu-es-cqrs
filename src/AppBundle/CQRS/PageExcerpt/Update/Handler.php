<?php

namespace AppBundle\CQRS\PageExcerpt\Update;

use AppBundle\Model\ExcerptRepositoryInterface;
use AppBundle\Model\PageRepositoryInterface;
use AppBundle\Util\ReflectionPropertyTrait;
use Sulu\Component\CQRS\Command as BaseCommand;
use Sulu\Component\CQRS\HandlerInterface;
use Sulu\Component\EventStore\EventInterface;

class Handler implements HandlerInterface
{
    use ReflectionPropertyTrait;

    /**
     * @var ExcerptRepositoryInterface
     */
    private $excerptRepository;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @param ExcerptRepositoryInterface $excerptRepository
     * @param PageRepositoryInterface $pageRepository
     */
    public function __construct(ExcerptRepositoryInterface $excerptRepository, PageRepositoryInterface $pageRepository)
    {
        $this->excerptRepository = $excerptRepository;
        $this->pageRepository = $pageRepository;
    }

    /**
     * {@inheritdoc}
     *
     * @param Command $command
     */
    public function handle(BaseCommand $command, EventInterface $event)
    {
        $excerpt = $this->excerptRepository->findById($command->getEntityId());
        $this->getProperty('title', $excerpt)->setValue($excerpt, $command->getDiffPlus()['title']);
        $this->getProperty('offset', $excerpt)->setValue($excerpt, $event->getIndex());
        $this->excerptRepository->save($excerpt);

        $page = $this->pageRepository->findById($excerpt->getEntityId());
        $this->getProperty('offset', $page)->setValue($page, $event->getIndex());
        $this->pageRepository->save($page);
    }
}
