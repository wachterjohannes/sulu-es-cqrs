<?php

namespace AppBundle\Entity;

use App\Model\Projection\Page\ExcerptInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\ExcerptRepository")
 * @ORM\Table(name="app_excerpt")
 */
class Excerpt implements ExcerptInterface
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
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $entityClass;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $entityId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @param string $id
     * @param string $entityClass
     * @param string $entityId
     */
    public function __construct($id, $entityClass, $entityId)
    {
        $this->id = $id;
        $this->entityClass = $entityClass;
        $this->entityId = $entityId;
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
     * Returns entityClass.
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Returns entityId.
     *
     * @return string
     */
    public function getEntityId()
    {
        return $this->entityId;
    }

    /**
     * Returns title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
