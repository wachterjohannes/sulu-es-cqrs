<?php

namespace App\Model\Page\Handler;

use App\Model\Page\Command\CreatePage;
use App\Model\Page\Page;
use App\Model\Page\PageCollection;
use AppBundle\Content\ContentCodec;

final class CreatePageHandler
{
    /**
     * @var PageCollection
     */
    private $pageCollection;

    /**
     * @var ContentCodec
     */
    private $codec;

    /**
     * @param PageCollection $pageCollection
     * @param ContentCodec $codec
     */
    public function __construct(PageCollection $pageCollection, ContentCodec $codec)
    {
        $this->pageCollection = $pageCollection;
        $this->codec = $codec;
    }

    /**
     * @param CreatePage $command
     */
    public function __invoke(CreatePage $command)
    {
        $data = $this->codec->encode($command->getTemplate(), $command->getData());

        $this->pageCollection->add(
            Page::create($command->getPageId(), $command->getLocale(), $command->getTitle(), $data)
        );
    }
}
