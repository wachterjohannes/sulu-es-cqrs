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
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint", name="event_index")
     */
    private $index;

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
     * @param int $index
     * @param mixed $data
     */
    public function __construct($index, $data)
    {
        $this->index = $index;
        $this->data = $data;

        $this->id = Uuid::uuid4();
        $this->createdAt = new \DateTime();
    }

    /**
     * Returns id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
     * Set data.
     *
     * @param mixed $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
