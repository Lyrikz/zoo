<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Species;
use AppBundle\Form\Type\DeleteType;
use AppBundle\Form\Type\Species\SpeciesType;
use AppBundle\Model\ModelManager;
use AppBundle\Responder\Responder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SpeciesController.
 *
 * @Route("/species")
 */
class SpeciesController
{
    /**
     * @var Responder
     */
    private $responder;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var ModelManager
     */
    private $modelManager;

    /**
     * SpeciesController constructor.
     *
     * @param Responder            $responder
     * @param FormFactoryInterface $formFactory
     * @param ModelManager         $modelManager
     */
    public function __construct(Responder $responder, FormFactoryInterface $formFactory, ModelManager $modelManager)
    {
        $this->responder = $responder;
        $this->formFactory = $formFactory;
        $this->modelManager = $modelManager;
    }

    /**
     * @Route("/", name="app_species_index", methods={"GET"})
     *
     * @return Response
     */
    public function indexAction()
    {
        $species = $this->modelManager->retrieve(Species::class);

        return $this->responder->render('species/index.html.twig', [
            'species' => $species,
        ]);
    }

    /**
     * @Route("/create", name="app_species_create", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $species = new Species();
        $form = $this->formFactory->create(SpeciesType::class, $species);

        if ($form->handleRequest($request)->isValid()) {
            $this->modelManager->save($species);

            return $this->responder->redirect('app_species_index');
        }

        return $this->responder->render('species/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{species}/edit", name="app_species_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Species $species
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Species $species)
    {
        $form = $this->formFactory->create(SpeciesType::class, $species);

        if ($form->handleRequest($request)->isValid()) {
            $this->modelManager->edit($species);

            return $this->responder->redirect('app_species_index');
        }

        return $this->responder->render('species/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{species}/delete", name="app_species_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param Species $species
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Species $species)
    {
        $form = $this->formFactory->create(DeleteType::class);
        if ($form->handleRequest($request)->isValid()) {
            $this->modelManager->delete($species);
        }

        return $this->responder->redirect('app_species_index');
    }
}
