<?php

namespace AppBundle\Controller;

use App\Model\Page\Command\CreatePage;
use App\Model\Page\Command\UpdatePage;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends FOSRestController implements ClassResourceInterface
{
    /**
     * Returns a single page identified by id.
     *
     * @param string $id
     *
     * @return Response
     */
    public function getAction($id)
    {
        return $this->handleView($this->view($this->get('app.repository.page')->find($id)));
    }

    /**
     * Create a new page and returns it.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postAction(Request $request)
    {
        $command = CreatePage::withData($request->get('title'));
        $this->get('prooph_service_bus.page_command_bus')->dispatch($command);

        return $this->handleView(
            $this->view($this->get('app.repository.page')->find($command->getPageId()->toString()))
        );
    }

    /**
     * Update page and returns it.
     *
     * @param string $id
     * @param Request $request
     *
     * @return Response
     */
    public function putAction($id, Request $request)
    {
        $command = UpdatePage::withData($id, $request->get('title'));
        $this->get('prooph_service_bus.page_command_bus')->dispatch($command);

        return $this->handleView(
            $this->view($this->get('app.repository.page')->find($command->getPageId()->toString()))
        );
    }
}
