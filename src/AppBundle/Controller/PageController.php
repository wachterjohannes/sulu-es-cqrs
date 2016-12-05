<?php

namespace AppBundle\Controller;

use AppBundle\Manager\PageManager;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineFieldDescriptor;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends FOSRestController implements ClassResourceInterface
{
    const ENTITY_NAME = 'AppBundle:Page';

    /**
     * Returns all fields that can be used by list.
     *
     * @Get("pages/fields")
     *
     * @return Response
     */
    public function getFieldsAction()
    {
        return $this->handleView($this->view(array_values($this->getFieldDescriptors())));
    }

    /**
     * Returns a single page identified by id.
     *
     * @param int $id
     *
     * @return Response
     */
    public function getAction($id)
    {
        $page = $this->getManager()->find($id);

        return $this->handleView($this->view($page));
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
        $page = $this->getManager()->create($request->request->all());

        return $this->handleView($this->view($page));
    }

    /**
     * Update a page with given id and returns it.
     *
     * @param string $id
     * @param Request $request
     *
     * @return Response
     */
    public function putAction($id, Request $request)
    {
        $page = $this->getManager()->update($id, $request->request->all());

        return $this->handleView($this->view($page));
    }

    /**
     * Delete page.
     *
     * @param string $id
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        $this->getManager()->remove($id);

        return $this->handleView($this->view());
    }


    /**
     * Shows all pages.
     *
     * @param Request $request
     *
     * @Get("pages")
     *
     * @return Response
     */
    public function cgetAction(Request $request)
    {
        $restHelper = $this->get('sulu_core.doctrine_rest_helper');
        $factory = $this->get('sulu_core.doctrine_list_builder_factory');

        $listBuilder = $factory->create(self::ENTITY_NAME);
        $restHelper->initializeListBuilder($listBuilder, $this->getFieldDescriptors());
        $results = $listBuilder->execute();

        $list = new ListRepresentation(
            $results,
            'pages',
            'get_pages',
            $request->query->all(),
            $listBuilder->getCurrentPage(),
            $listBuilder->getLimit(),
            $listBuilder->count()
        );

        return $this->handleView($this->view($list));
    }

    /**
     * Returns service for page.
     *
     * @return PageManager
     */
    private function getManager()
    {
        return $this->get('app.manager.page');
    }

    /**
     * Returns array of existing field-descriptors.
     *
     * @return array
     */
    private function getFieldDescriptors()
    {
        return [
            'id' => new DoctrineFieldDescriptor(
                'id', 'id', self::ENTITY_NAME, 'public.id', [], true
            ),
            'title' => new DoctrineFieldDescriptor(
                'title', 'title', self::ENTITY_NAME, 'public.title'
            ),
        ];
    }
}