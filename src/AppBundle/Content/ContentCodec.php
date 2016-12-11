<?php

namespace AppBundle\Content;

use AppBundle\Content\Types\ContentTypePool;
use Sulu\Component\Content\Metadata\Factory\StructureMetadataFactoryInterface;
use Sulu\Component\Content\Metadata\PropertyMetadata;

class ContentCodec
{
    /**
     * @var StructureMetadataFactoryInterface
     */
    private $metadataFactory;

    /**
     * @var ContentTypePool
     */
    private $contentTypePool;

    /**
     * @param StructureMetadataFactoryInterface $metadataFactory
     * @param ContentTypePool $contentTypePool
     */
    public function __construct(StructureMetadataFactoryInterface $metadataFactory, ContentTypePool $contentTypePool)
    {
        $this->metadataFactory = $metadataFactory;
        $this->contentTypePool = $contentTypePool;
    }

    public function encode($template, array $data)
    {
        $metadata = $this->metadataFactory->getStructureMetadata('app_page', $template);
        $result = [];

        /** @var PropertyMetadata $property */
        foreach ($metadata->properties as $property) {
            if (!array_key_exists($property->getName(), $data)) {
                continue;
            }

            $contentType = $this->contentTypePool->get($property->getType());
            $value = $data[$property->getName()];

            if (!$contentType->validate($value)) {
                throw new \InvalidArgumentException();
            }

            $result[$property->getName()] = $contentType->encode($value);
        }

        return $result;
    }
}
