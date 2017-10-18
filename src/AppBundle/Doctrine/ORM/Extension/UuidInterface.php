<?php

declare(strict_types=1);

namespace AppBundle\Doctrine\ORM\Extension;

/**
 * Interface UuidInterface.
 */
interface UuidInterface
{
    /**
     * @param string $uuid
     *
     * @return UuidInterface
     */
    public function setUuid($uuid);

    /**
     * @return string
     */
    public function getUuid();
}
