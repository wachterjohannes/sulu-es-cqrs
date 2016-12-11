<?php

namespace App\Model\Page\Handler;

use App\Model\Page\Command\UpdatePage;
use App\Model\Page\PageCollection;
use AppBundle\Content\ContentCodec;

final class UpdatePageHandler
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
     * @param UpdatePage $command
     */
    public function __invoke(UpdatePage $command)
    {
        $data = $this->codec->encode($command->getTemplate(), $command->getData());

        $page = $this->pageCollection->get($command->getPageId());
        $page->update($command->getLocale(), $command->getTitle(), $data);
    }
}
