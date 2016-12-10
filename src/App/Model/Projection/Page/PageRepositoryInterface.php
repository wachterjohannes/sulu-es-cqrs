<?php

namespace App\Model\Projection\Page;

interface PageRepositoryInterface
{
    public function create($id, $title);

    public function save(PageInterface $page);

    public function remove(PageInterface $page);

    /**
     * @param string $id
     *
     * @return PageInterface
     */
    public function findById($id);
}
