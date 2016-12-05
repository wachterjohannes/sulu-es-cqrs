<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Sulu\Component\EventStore\EventInterface;
use Sulu\Component\EventStore\EventRepositoryInterface;

class EventRepository extends EntityRepository implements EventRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create($data)
    {
        // TODO lock-handling?

        $query = $this->createQueryBuilder('event')
            ->select('event.index')
            ->orderBy('event.index', 'desc')
            ->setMaxResults(1)
            ->getQuery();

        try {
            $index = $query->getSingleScalarResult();
        } catch (NoResultException $exception) {
            $index = 0;
        }

        return new Event($index + 1, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function save(EventInterface $event)
    {
        $this->_em->persist($event);
        $this->_em->flush($event);
    }

    /**
     * {@inheritdoc}
     */
    public function remove(EventInterface $event)
    {
        $this->_em->remove($event);
        $this->_em->flush($event);
    }
}
