<?php

namespace AppBundle\DependecyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AddModelManagerPass.
 */
class AddModelManagerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('AppBundle\Model\ModelManager')) {
            return;
        }

        $managers = $container->findTaggedServiceIds('model.manager');
        $reference = new Reference('AppBundle\Model\ModelManager');

        foreach ($managers as $id => $manager) {
            $definition = $container->getDefinition($id);
            $definition->addMethodCall('setModelManager', [$reference]);
        }
    }
}
