<?php

namespace AppBundle\Serializer;

use AppBundle\Entity\Page;
use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\JsonSerializationVisitor;

class PageSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            [
                'event' => Events::POST_SERIALIZE,
                'method' => 'onPostSerialize',
                'class' => Page::class,
                'format' => 'json',
            ],
        ];
    }

    public function onPostSerialize(ObjectEvent $event)
    {
        /** @var JsonSerializationVisitor $visitor */
        $visitor = $event->getVisitor();
        /** @var Page $object */
        $object = $event->getObject();

        $context = $event->getContext();
        $locale = $context->attributes->get('locale')->get();
        $translation = $object->getTranslation($locale);

        $visitor->addData('title', $translation->getTitle());
        $visitor->addData('excerpt', $context->accept($translation->getExcerpt()));
    }
}
