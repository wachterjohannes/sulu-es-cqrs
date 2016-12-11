<?php

namespace AppBundle\Entity;

use App\Model\Projection\Page\ExcerptInterface;
use App\Model\Projection\Page\ExcerptRepositoryInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Rhumsaa\Uuid\Uuid;

class ExcerptRepository extends EntityRepository implements ExcerptRepositoryInterface
{
    public function findByEntity($entityClass, $entityId, $locale = null)
    {
        try {
            return $this->findOneBy(['entityClass' => $entityClass, 'entityId' => $entityId]);
        } catch (NoResultException $exception) {
            return null;
        }
    }

    public function create($entityClass, $entityId, $locale = null)
    {
        return new Excerpt(Uuid::uuid4()->toString(), $entityClass, $entityId);
    }

    public function save(ExcerptInterface $excerpt)
    {
        $this->_em->persist($excerpt);
        $this->_em->flush($excerpt);
    }
}
