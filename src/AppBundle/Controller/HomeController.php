<?php

namespace AppBundle\Controller;

use AppBundle\Responder\Responder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @var Responder
     */
    private $responder;

    /**
     * HomeController constructor.
     *
     * @param Responder $responder
     */
    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * @Route("/", name="homepage", methods={"GET"})
     *
     * @return RedirectResponse
     */
    public function indexAction()
    {
        return $this->responder->redirect('app_species_index');
    }
}
