<?php

namespace AppBundle\Entity;

use AppBundle\Model\ExcerptRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class ExcerptRepository extends EntityRepository implements ExcerptRepositoryInterface
{
    public function findById($id)
    {
        return $this->find($id);
    }

    public function save(Excerpt $excerpt)
    {
        $this->_em->persist($excerpt);
        $this->_em->flush($excerpt);
    }

    public function remove(Excerpt $excerpt)
    {
        $this->_em->remove($excerpt);
        $this->_em->flush($excerpt);
    }

    public function create($uuid)
    {
        return new Excerpt($uuid);
    }
}
