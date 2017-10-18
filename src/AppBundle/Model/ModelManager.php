<?php

declare(strict_types=1);

namespace AppBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Class ModelManager.
 */
class ModelManager
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * ModelManager constructor.
     *
     * @param ObjectManager     $objectManager
     * @param FlashBagInterface $flashBag
     */
    public function __construct(ObjectManager $objectManager, FlashBagInterface $flashBag)
    {
        $this->objectManager = $objectManager;
        $this->flashBag = $flashBag;
    }

    /**
     * @param string $class
     * @param array  $criteria
     *
     * @return null|object
     */
    public function retrieveOne($class, array $criteria = [])
    {
        return $this->objectManager->getRepository($class)->findOneBy($criteria);
    }

    /**
     * @param string $class
     * @param array  $criteria
     *
     * @return array
     */
    public function retrieve($class, array $criteria = []): array
    {
        return $this->objectManager->getRepository($class)->findBy($criteria);
    }

    /**
     * @param object $object
     * @param bool   $andFlush
     *
     * @return bool
     */
    public function save($object, $andFlush = true): bool
    {
        try {
            $this->objectManager->persist($object);
            if ($andFlush) {
                $this->objectManager->flush();
            }
            $this->flashBag->add('success', $this->getName($object) . '.created');

            return true;
        } catch (\Exception $e) {
            $this->handleError($e);
        }

        return false;
    }

    /**
     * @param object $object
     * @param bool   $andFlush
     *
     * @return bool
     */
    public function edit($object, $andFlush = true): bool
    {
        try {
            $this->objectManager->persist($object);
            if ($andFlush) {
                $this->objectManager->flush();
            }
            $this->flashBag->add('success', $this->getName($object) . '.edited');

            return true;
        } catch (\Exception $e) {
            $this->handleError($e);
        }

        return false;
    }

    /**
     * @param object $object
     * @param bool   $andFlush
     *
     * @return bool
     */
    public function delete($object, $andFlush = true): bool
    {
        try {
            $this->objectManager->remove($object);
            if ($andFlush) {
                $this->objectManager->flush();
            }
            $this->flashBag->add('success', $this->getName($object) . '.deleted');

            return true;
        } catch (\Exception $e) {
            $this->handleError($e);
        }

        return false;
    }

    /**
     * @param \Exception $e
     */
    public function handleError(\Exception $e)
    {
        $this->flashBag->add('warning', 'An error occurred');
        $this->flashBag->add('danger',$e->getMessage());
    }

    /**
     * @param object $object
     *
     * @return string
     */
    public function getName($object): string
    {
        return \strtolower((new \ReflectionClass($object))->getShortName());
    }
}
