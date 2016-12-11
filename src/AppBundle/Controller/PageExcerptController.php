<?php

namespace AppBundle\Controller;

use App\Model\Page\Command\UpdateExcerpt;
use AppBundle\Entity\Page;
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
        $command = UpdateExcerpt::withData($pageId, $request->get('locale'), $request->request->all());
        $this->get('prooph_service_bus.page_command_bus')->dispatch($command);

        return $this->handleView($this->view($this->get('app.repository.excerpt')->findByEntity(Page::class, $pageId)));
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
        $command = UpdateExcerpt::withData($pageId, $request->get('locale'), $request->request->all());
        $this->get('prooph_service_bus.page_command_bus')->dispatch($command);

        return $this->handleView($this->view($this->get('app.repository.excerpt')->findByEntity(Page::class, $pageId)));
    }
}
