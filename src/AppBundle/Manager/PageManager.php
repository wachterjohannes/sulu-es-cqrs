<?php

namespace AppBundle\Manager;

use AppBundle\CQRS\Page\Create\Command as CreateCommand;
use AppBundle\CQRS\Page\Remove\Command as RemoveCommand;
use AppBundle\CQRS\Page\Update\Command as UpdateCommand;
use AppBundle\Entity\Page;
use AppBundle\Model\PageRepositoryInterface;
use Rhumsaa\Uuid\Uuid;
use Sulu\Component\CQRS\CommandBus;

class PageManager
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param PageRepositoryInterface $pageRepository
     * @param CommandBus $commandBus
     */
    public function __construct(PageRepositoryInterface $pageRepository, CommandBus $commandBus)
    {
        $this->pageRepository = $pageRepository;
        $this->commandBus = $commandBus;
    }

    public function find($id)
    {
        return $this->pageRepository->findById($id);
    }

    public function create($data)
    {
        $id = Uuid::uuid4()->toString();
        $this->commandBus->handle(new CreateCommand(Page::class, $id, $data));

        return $this->pageRepository->findById($id);
    }

    public function update($id, $data)
    {
        $this->commandBus->handle(new UpdateCommand(Page::class, $id, $data));

        return $this->pageRepository->findById($id);
    }

    public function remove($id)
    {
        $this->commandBus->handle(new RemoveCommand(Page::class, $id));
    }
}
