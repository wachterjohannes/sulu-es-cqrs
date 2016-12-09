<?php

namespace App\Infrastructure\Repository;

use App\Model\Page\Page;
use App\Model\Page\PageCollection;
use App\Model\Page\PageId;
use Prooph\EventStore\Aggregate\AggregateRepository;

class EventStorePageCollection extends AggregateRepository implements PageCollection
{
    /**
     * {@inheritdoc}
     */
    public function add(Page $page)
    {
        $this->addAggregateRoot($page);
    }

    /**
     * {@inheritdoc}
     */
    public function get(PageId $pageId)
    {
        return $this->getAggregateRoot($pageId->toString());
    }
}
