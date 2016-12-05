<?php

namespace AppBundle\Entity;

use AppBundle\Model\PageRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository implements PageRepositoryInterface
{
    public function findById($id)
    {
        return $this->find($id);
    }

    public function save(Page $page)
    {
        $this->_em->persist($page);
        $this->_em->flush($page);
    }

    public function remove(Page $page)
    {
        $this->_em->remove($page);
        $this->_em->flush($page);
    }

    public function create($uuid)
    {
        return new Page($uuid);
    }
}
