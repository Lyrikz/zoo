<?php

namespace AppBundle\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class Responder.
 */
class Responder
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * Responder constructor.
     *
     * @param EngineInterface $templating
     * @param RouterInterface $router
     */
    public function __construct(EngineInterface $templating, RouterInterface $router)
    {
        $this->templating = $templating;
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function response(string $content): Response
    {
        return new Response($content);
    }

    /**
     * {@inheritdoc}
     */
    public function render(string $template, array $params = []): Response
    {
        return $this->response($this->templating->render($template, $params));
    }

    /**
     * {@inheritdoc}
     */
    public function redirect(string $route, array $params = []): RedirectResponse
    {
        return new RedirectResponse($this->generate($route, $params));
    }

    /**
     * {@inheritdoc}
     */
    public function json($data): JsonResponse
    {
        return new JsonResponse($data, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }

    /**
     * {@inheritdoc]
     */
    public function generate(string $route, array $params = []): string
    {
        return $this->router->generate($route, $params);
    }
}
