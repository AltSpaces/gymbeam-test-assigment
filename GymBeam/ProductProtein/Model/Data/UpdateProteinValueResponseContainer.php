<?php

declare(strict_types=1);

namespace GymBeam\ProductProtein\Model\Data;

use GymBeam\ProductProtein\Api\Data\UpdateProteinValueResponseContainerInterface;
use Magento\Framework\DataObject;

/**
 * Protein attribute update response container
 */
class UpdateProteinValueResponseContainer extends DataObject implements UpdateProteinValueResponseContainerInterface
{
    /**
     * @inheritDoc
     */
    public function getIsSuccess(): bool
    {
        return $this->getData('success');
    }

    /**
     * @inheritDoc
     */
    public function setIsSuccess(bool $value): void
    {
        $this->setData('success', $value);
    }
}
