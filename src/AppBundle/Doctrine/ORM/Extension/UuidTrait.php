<?php

declare(strict_types=1);

namespace AppBundle\Doctrine\ORM\Extension;

/**
 * Trait UuidTrait.
 */
trait UuidTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="uuid", type="string", length=255)
     */
    protected $uuid;

    /**
     * Set uuid.
     *
     * @param string $uuid
     *
     * @return $this
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }
}
