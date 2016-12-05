<?php

namespace AppBundle\Manager;

use AppBundle\CQRS\PageExcerpt\Create\Command as CreateCommand;
use AppBundle\CQRS\PageExcerpt\Update\Command as UpdateCommand;
use AppBundle\Entity\Page;
use AppBundle\Model\ExcerptRepositoryInterface;
use Rhumsaa\Uuid\Uuid;
use Sulu\Component\CQRS\CommandBus;

class ExcerptManager
{
    /**
     * @var ExcerptRepositoryInterface
     */
    private $excerptRepository;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param ExcerptRepositoryInterface $excerptRepository
     * @param CommandBus $commandBus
     */
    public function __construct(ExcerptRepositoryInterface $excerptRepository, CommandBus $commandBus)
    {
        $this->excerptRepository = $excerptRepository;
        $this->commandBus = $commandBus;
    }

    public function find($id)
    {
        return $this->excerptRepository->findById($id);
    }

    public function create($pageId, $data)
    {
        $this->commandBus->handle(new CreateCommand(Page::class, $pageId, $data));

        return $this->excerptRepository->findById($pageId);
    }

    public function update($id, $data)
    {
        $page = $this->excerptRepository->findById($id);
        $this->commandBus->handle(new UpdateCommand(Page::class, $id, [$page->getTitle()], $data));

        return $this->excerptRepository->findById($id);
    }
}
