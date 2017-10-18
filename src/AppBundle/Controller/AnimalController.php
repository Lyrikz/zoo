<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Animal;
use AppBundle\Entity\Species;
use AppBundle\Form\Type\Animal\AnimalType;
use AppBundle\Form\Type\DeleteType;
use AppBundle\Model\Animal\Manager\AnimalManager;
use AppBundle\Responder\Responder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AnimalController.
 *
 * @Route("/species/{species}/animal")
 */
class AnimalController
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
     * @var AnimalManager
     */
    private $animalManager;

    /**
     * AnimalController constructor.
     *
     * @param Responder            $responder
     * @param FormFactoryInterface $formFactory
     * @param AnimalManager        $animalManager
     */
    public function __construct(Responder $responder, FormFactoryInterface $formFactory, AnimalManager $animalManager)
    {
        $this->responder = $responder;
        $this->formFactory = $formFactory;
        $this->animalManager = $animalManager;
    }

    /**
     * @Route("/", name="app_animal_index", methods={"GET"})
     *
     * @param Species $species
     *
     * @return Response
     */
    public function indexAction(Species $species)
    {
        return $this->responder->render('animal/index.html.twig', [
            'animals' => $species->getAnimals(),
            'species' => $species,
        ]);
    }

    /**
     * @Route("/create", name="app_animal_create", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Species $species
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request, Species $species)
    {
        $animal = $this->animalManager->createAnimal($species);
        $form = $this->formFactory->create(AnimalType::class, $animal);

        if ($form->handleRequest($request)->isValid()) {
            $this->animalManager->save($animal);

            return $this->responder->redirect('app_animal_index', [
                'species' => $species->getUuid(),
            ]);
        }

        return $this->responder->render('animal/create.html.twig', [
            'form'    => $form->createView(),
            'species' => $species,
        ]);
    }

    /**
     * @Route("/{animal}/edit", name="app_animal_edit", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param Animal  $animal
     * @param Species $species
     *
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request, Animal $animal, Species $species)
    {
        $form = $this->formFactory->create(AnimalType::class, $animal);

        if ($form->handleRequest($request)->isValid()) {
            $this->animalManager->edit($animal);

            return $this->responder->redirect('app_animal_index', [
                'species' => $species->getUuid(),
            ]);
        }

        return $this->responder->render('animal/edit.html.twig', [
            'form'    => $form->createView(),
            'species' => $species,
        ]);
    }

    /**
     * @Route("/{animal}/delete", name="app_animal_delete", methods={"DELETE"})
     *
     * @param Request $request
     * @param Animal  $animal
     * @param Species $species
     *
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, Animal $animal, Species $species)
    {
        $form = $this->formFactory->create(DeleteType::class);

        if ($form->handleRequest($request)->isValid()) {
            $this->animalManager->delete($animal);
        }

        return $this->responder->redirect('app_animal_index', [
            'species' => $species->getUuid(),
        ]);
    }
}
