<?php

namespace AppBundle\Model;

use AppBundle\Entity\Excerpt;

interface ExcerptRepositoryInterface
{
    /**
     * @param string $id
     *
     * @return Excerpt
     */
    public function findById($id);

    /**
     * @param string $uuid
     *
     * @return Excerpt
     */
    public function create($uuid);

    /**
     * @param Excerpt $excerpt
     */
    public function save(Excerpt $excerpt);

    /**
     * @param Excerpt $excerpt
     */
    public function remove(Excerpt $excerpt);

    /**
     * @return Excerpt[]
     */
    public function findAll();
}
