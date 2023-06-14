<?php

declare(strict_types=1);

namespace GymBeam\ProductProtein\Api;

use GymBeam\ProductProtein\Api\Data\UpdateProteinValueResponseContainerInterface;

/**
 * Set product protein attribute value command
 */
interface UpdateProteinAttributeValueInterface
{
    /**
     * Execute the command
     *
     * @param int $productId
     * @param int $value
     * @return UpdateProteinValueResponseContainerInterface
     */
    public function execute(int $productId, int $value): UpdateProteinValueResponseContainerInterface;
}
