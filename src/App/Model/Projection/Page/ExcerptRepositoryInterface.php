<?php

namespace App\Model\Projection\Page;

interface ExcerptRepositoryInterface
{
    /**
     * @param string $entityClass
     * @param string $entityId
     * @param string $locale
     *
     * @return ExcerptInterface
     */
    public function findByEntity($entityClass, $entityId, $locale = null);

    /**
     * @param string $entityClass
     * @param string $entityId
     * @param string $locale
     *
     * @return ExcerptInterface
     */
    public function create($entityClass, $entityId, $locale = null);

    public function save(ExcerptInterface $excerpt);
}
