<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Animal;
use AppBundle\Entity\Species;
use AppBundle\Form\Type\Animal\AnimalType;
use AppBundle\Form\Type\DeleteType;
use AppBundle\Responder\Responder;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * AnimalController constructor.
     *
     * @param Responder            $responder
     * @param FormFactoryInterface $formFactory
     * @param ObjectManager        $objectManager
     */
    public function __construct(Responder $responder, FormFactoryInterface $formFactory, ObjectManager $objectManager)
    {
        $this->responder = $responder;
        $this->formFactory = $formFactory;
        $this->objectManager = $objectManager;
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
        $repository = $this->objectManager->getRepository(Animal::class);
        $animals = $repository->findBy([
            'species' => $species,
        ]);

        return $this->responder->render('animal/index.html.twig', [
            'animals' => $animals,
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
        $animal = new Animal();
        $form = $this->formFactory->create(AnimalType::class, $animal);

        if ($form->handleRequest($request)->isValid()) {
            $this->objectManager->persist($animal);
            $this->objectManager->flush();

            return $this->responder->redirect('app_animal_index', [
                'species' => $species->getId(),
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
            $this->objectManager->flush();

            return $this->responder->redirect('app_animal_index', [
                'species' => $species->getId(),
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
            $this->objectManager->remove($animal);
            $this->objectManager->flush();
        }

        return $this->responder->redirect('app_animal_index', [
            'species' => $species->getId(),
        ]);
    }
}
