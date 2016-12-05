<?php

namespace AppBundle\Model;

use AppBundle\Entity\Page;

interface PageRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return Page
     */
    public function findById($id);

    /**
     * @param string $uuid
     *
     * @return Page
     */
    public function create($uuid);

    /**
     * @param Page $page
     */
    public function save(Page $page);

    /**
     * @param Page $page
     */
    public function remove(Page $page);

    /**
     * @return Page[]
     */
    public function findAll();
}
