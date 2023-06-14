<?php

declare(strict_types=1);

namespace GymBeam\ProductProtein\Api\Data;

/**
 * Product protein request response container
 */
interface UpdateProteinValueResponseContainerInterface
{
    /**
     * Get request state
     *
     * @return bool
     */
    public function getIsSuccess(): bool;

    /**
     * Set request state
     *
     * @param bool $value
     * @return void
     */
    public function setIsSuccess(bool $value): void;
}
