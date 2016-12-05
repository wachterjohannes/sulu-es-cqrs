<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rhumsaa\Uuid\Uuid;
use Sulu\Component\EventStore\EventInterface;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\EventRepository")
 * @ORM\Table(name="es_event")
 */
class Event implements EventInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $eventId;

    /**
     * @var string
     *
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint", name="event_index")
     */
    private $index;

    /**
     * @var string
     *
     * @ORM\Column(type="guid")
     */
    private $stream;

    /**
     * @var mixed
     *
     * @ORM\Column(type="object")
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @param string $id
     * @param string $stream
     * @param int $index
     * @param mixed $data
     */
    public function __construct($id, $stream, $index, $data)
    {
        $this->id = $id;
        $this->stream = $stream;
        $this->index = $index;
        $this->data = $data;

        $this->eventId = Uuid::uuid4()->toString();
        $this->createdAt = new \DateTime();
    }

    /**
     * Returns eventId.
     *
     * @return string
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * {@inheritdoc}
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
