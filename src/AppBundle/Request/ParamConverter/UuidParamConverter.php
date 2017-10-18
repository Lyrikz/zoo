<?php

declare(strict_types=1);

namespace AppBundle\Request\ParamConverter;

use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\DoctrineParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UuidParamConverter.
 */
class UuidParamConverter implements ParamConverterInterface
{
    /**
     * @var DoctrineParamConverter
     */
    private $decorated;

    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * UuidParamConverter constructor.
     *
     * @param DoctrineParamConverter $decorated
     * @param ManagerRegistry        $registry
     */
    public function __construct(DoctrineParamConverter $decorated, ManagerRegistry $registry)
    {
        $this->decorated = $decorated;
        $this->registry = $registry;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $class = $configuration->getClass();
        $em = $this->registry->getManagerForClass($class);
        $metadata = $em->getClassMetadata($class);
        if (!$metadata->hasField('uuid')) {
            return $this->decorated->apply($request, $configuration);
        }

        $name = $configuration->getName();
        $uuid = $request->attributes->get($name);
        $data = $em->getRepository($class)->findOneBy(['uuid' => $uuid]);
        if (null === $data) {
            throw new NotFoundHttpException(\sprintf('%s object not found.', $class));
        }

        $request->attributes->set($name, $data);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        return $this->decorated->supports($configuration);
    }
}
