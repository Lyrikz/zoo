<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Form\Type\DeleteType;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class FormExtension.
 */
class FormExtension extends \Twig_Extension
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * FormExtension constructor.
     *
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('renderDeleteForm',
                [$this, 'renderDeleteForm'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    /**
     * @param \Twig_Environment $env
     * @param string            $path
     *
     * @return string
     */
    public function renderDeleteForm(\Twig_Environment $env, string $path): string
    {
        $form = $this->formFactory->create(DeleteType::class, null, [
            'action' => $path
        ]);

        return $env->render('form/delete.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
