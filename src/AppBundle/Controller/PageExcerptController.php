<?php

namespace AppBundle\Controller;

use AppBundle\Manager\ExcerptManager;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageExcerptController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Create a new excerpt and returns it.
     *
     * @param string $pageId
     * @param Request $request
     *
     * @Post("/pages/{pageId}/excerpt")
     *
     * @return Response
     */
    public function postAction($pageId, Request $request)
    {
        $excerpt = $this->getManager()->create($pageId, $request->request->all());

        return $this->handleView($this->view($excerpt));
    }

    /**
     * Update a excerpt with given id and returns it.
     *
     * @param string $pageId
     * @param Request $request
     *
     * @return Response
     */
    public function putAction($pageId, Request $request)
    {
        $excerpt = $this->getManager()->update($pageId, $request->request->all());

        return $this->handleView($this->view($excerpt));
    }

    /**
     * Returns service for page.
     *
     * @return ExcerptManager
     */
    private function getManager()
    {
        return $this->get('app.manager.excerpt');
    }
}
