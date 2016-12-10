<?php

namespace AppBundle\Entity;

use App\Model\Projection\Page\PageInterface;
use App\Model\Projection\Page\PageRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class PageRepository extends EntityRepository implements PageRepositoryInterface
{
    public function findById($id)
    {
        $query = $this->createQueryBuilder('page')
            ->addSelect('excerpt')
            ->leftJoin('page.excerpt', 'excerpt')
            ->where('page.id = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getSingleResult();
    }

    public function create($id, $title)
    {
        return new Page($id, $title);
    }

    public function save(PageInterface $page)
    {
        $this->_em->persist($page);
        $this->_em->flush($page);
    }

    public function remove(PageInterface $page)
    {
        $this->_em->remove($page);
        $this->_em->flush($page);
    }
}
