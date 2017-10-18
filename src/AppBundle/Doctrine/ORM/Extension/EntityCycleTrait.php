<?php

declare(strict_types=1);

namespace AppBundle\Doctrine\ORM\Extension;

/**
 * Trait EntityCycleTrait.
 */
trait EntityCycleTrait
{
    use UuidTrait;
    use DatetimeCycleTrait;
}
