<?php

namespace AppBundle\Controller;

use App\Model\Page\Command\CreatePage;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Create a new page and returns it.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        $this->get('prooph_service_bus.page_command_bus')->dispatch(CreatePage::withData($request->get('title')));

        return $this->handleView($this->view());
    }
}
