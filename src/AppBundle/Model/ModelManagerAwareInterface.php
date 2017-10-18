<?php

namespace AppBundle\Model;

/**
 * Interface ModelManagerAwareInterface.
 */
interface ModelManagerAwareInterface
{
    /**
     * @param ModelManager $modelManager
     */
    public function setModelManager(ModelManager $modelManager);
}
