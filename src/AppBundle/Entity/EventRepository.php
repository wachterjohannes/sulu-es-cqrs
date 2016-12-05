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
    public function create($id, $stream, $data)
    {
        // TODO lock-handling?

        $query = $this->createQueryBuilder('event')
            ->select('event.index')
            ->where('event.stream = :stream')
            ->andWhere('event.id = :id')
            ->orderBy('event.index', 'desc')
            ->setMaxResults(1)
            ->setParameter('stream', $stream)
            ->setParameter('id', $id)
            ->getQuery();

        try {
            $index = $query->getSingleScalarResult();
        } catch (NoResultException $exception) {
            $index = 0;
        }

        return new Event($id, $stream, $index + 1, $data);
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
