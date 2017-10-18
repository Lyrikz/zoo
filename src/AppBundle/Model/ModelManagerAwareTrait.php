<?php

namespace AppBundle\Model;

/**
 * Trait ModelManagerAwareTrait.
 */
trait ModelManagerAwareTrait
{
    /**
     * @var ModelManager
     */
    protected $modelManager;

    /**
     * @param ModelManager $modelManager
     */
    public function setModelManager(ModelManager $modelManager)
    {
        $this->modelManager = $modelManager;
    }

    /**
     * @param string $class
     * @param array  $criteria
     *
     * @return object
     */
    public function retrieveOne(string $class, array $criteria = [])
    {
        return $this->modelManager->retrieveOne($class, $criteria);
    }

    /**
     * @param string $class
     * @param array  $criteria
     *
     * @return array
     */
    public function retrieve(string $class, array $criteria = []): array
    {
        return $this->modelManager->retrieve($class, $criteria);
    }

    /**
     * @param object $object
     * @param bool   $andFlush
     *
     * @return bool
     */
    public function save(object $object, bool $andFlush = true): bool
    {
        return $this->modelManager->save($object, $andFlush);
    }

    /**
     * @param object $object
     * @param bool   $andFlush
     *
     * @return bool
     */
    public function edit($object, bool $andFlush = true): bool
    {
        return $this->modelManager->edit($object, $andFlush);
    }

    /**
     * @param object $object
     * @param bool   $andFlush
     *
     * @return bool
     */
    public function delete($object, bool $andFlush = true): bool
    {
        return $this->modelManager->delete($object, $andFlush);
    }
}
