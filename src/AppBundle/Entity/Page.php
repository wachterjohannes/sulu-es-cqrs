<?php

namespace AppBundle\Entity;

use App\Model\Projection\Page\PageInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\PageRepository")
 * @ORM\Table(name="app_page")
 */
class Page implements PageInterface
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
     * @var Collection|PageTranslation[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PageTranslation", mappedBy="page", indexBy="locale", cascade={"all"})
     * @Serializer\Exclude
     */
    private $translations;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTranslation($locale)
    {
        if (!isset($this->translations[$locale])) {
            throw new \InvalidArgumentException(sprintf('Translation for "%s" does not exists.', $locale));
        }

        return $this->translations[$locale];
    }

    public function addTranslation(PageTranslation $translation)
    {
        $this->translations[$translation->getLocale()] = $translation;
    }

    public function hasTranslation($locale)
    {
        return isset($this->translations[$locale]);
    }
}
