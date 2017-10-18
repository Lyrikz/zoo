<?php

declare(strict_types=1);

namespace AppBundle\Doctrine\ORM\Extension;

/**
 * Interface DatetimeCycleInterface.
 */
interface DatetimeCycleInterface
{
    /**
     * @param \DateTimeInterface $createdAt
     *
     * @return DatetimeCycleInterface
     */
    public function setCreatedAt(\DateTimeInterface $createdAt);

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt();

    /**
     * @param \DateTimeInterface $updatedAt
     *
     * @return DatetimeCycleInterface
     */
    public function setUpdatedAt(\DateTimeInterface $updatedAt);

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt();
}
