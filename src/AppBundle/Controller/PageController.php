<?php

namespace AppBundle\Controller;

use App\Model\Page\Command\CreatePage;
use App\Model\Page\Command\RemovePage;
use App\Model\Page\Command\UpdatePage;
use AppBundle\Entity\Page;
use AppBundle\Entity\PageTranslation;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use JMS\Serializer\SerializationContext;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineFieldDescriptor;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineJoinDescriptor;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PageController extends FOSRestController implements ClassResourceInterface
{
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
     * @param string $id
     * @param Request $request
     *
     * @return Response
     */
    public function getAction($id, Request $request)
    {
        $page = $this->get('app.repository.page')->find($id);

        return $this->handleView(
            $this->view($page)->setSerializationContext(
                SerializationContext::create()->setAttribute('locale', $request->get('locale'))
            )
        );
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
        $command = CreatePage::withData($request->get('locale'), $request->request->all());
        $this->get('prooph_service_bus.page_command_bus')->dispatch($command);
        $page = $this->get('app.repository.page')->find($command->getPageId()->toString());

        return $this->handleView(
            $this->view($page)->setSerializationContext(
                SerializationContext::create()->setAttribute('locale', $request->get('locale'))
            )
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
        $command = UpdatePage::withData($id, $request->get('locale'), $request->request->all());
        $this->get('prooph_service_bus.page_command_bus')->dispatch($command);
        $page = $this->get('app.repository.page')->find($command->getPageId()->toString());

        return $this->handleView(
            $this->view($page)->setSerializationContext(
                SerializationContext::create()->setAttribute('locale', $request->get('locale'))
            )
        );
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
        $command = RemovePage::byId($id);
        $this->get('prooph_service_bus.page_command_bus')->dispatch($command);

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

        $listBuilder = $factory->create(Page::class);
        $restHelper->initializeListBuilder($listBuilder, $this->getFieldDescriptors($request->get('locale')));
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
     * Returns array of existing field-descriptors.
     *
     * @param string $locale
     *
     * @return array
     */
    private function getFieldDescriptors($locale = null)
    {
        return [
            'id' => new DoctrineFieldDescriptor(
                'id', 'id', Page::class, 'public.id', [], true
            ),
            'title' => new DoctrineFieldDescriptor(
                'title', 'title', PageTranslation::class, 'public.title', [
                    PageTranslation::class => new DoctrineJoinDescriptor(
                        PageTranslation::class,
                        Page::class . '.translations',
                        $locale ? PageTranslation::class . '.locale = \'' . $locale . '\'' : ''
                    ),
                ]
            ),
        ];
    }
}
