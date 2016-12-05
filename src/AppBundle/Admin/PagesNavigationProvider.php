<?php

namespace AppBundle\Admin;

use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationItem;
use Sulu\Bundle\AdminBundle\Navigation\ContentNavigationProviderInterface;

class PagesNavigationProvider implements ContentNavigationProviderInterface
{
    public function getNavigationItems(array $options = [])
    {
        $details = new ContentNavigationItem('app.pages');
        $details->setAction('details');
        $details->setPosition(10);
        $details->setComponent('page/edit/details@app');

        $excerpt = new ContentNavigationItem('app.excerpt');
        $excerpt->setAction('excerpt');
        $excerpt->setPosition(20);
        $excerpt->setComponent('page/edit/excerpt@app');
        $excerpt->setDisplay(['edit']);

        return [$details, $excerpt];
    }
}
