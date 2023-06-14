<?php

declare(strict_types=1);

namespace GymBeam\ProductProtein\Model\Command;

use GymBeam\ProductProtein\Api\Data\UpdateProteinValueResponseContainerInterface as RequestResponseContainer;
use GymBeam\ProductProtein\Api\Data\UpdateProteinValueResponseContainerInterfaceFactory as RequestResponseContainerFactory;
use GymBeam\ProductProtein\Api\UpdateProteinAttributeValueInterface;
use GymBeam\ProductProtein\Setup\Patch\Data\AddProteinAttribute;
use Magento\Catalog\Model\ResourceModel\Product\Action;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Update protein attribute value service
 */
class UpdateProteinAttributeValue implements UpdateProteinAttributeValueInterface
{
    private Action $productAction;
    private StoreManagerInterface $storeManager;
    private RequestResponseContainer $requestResponseContainer;
    private ScopeConfigInterface $scopeConfig;
    private LoggerInterface $logger;

    /**
     * @param Action $productAction
     * @param StoreManagerInterface $storeManager
     * @param RequestResponseContainerFactory $requestResponseContainerFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface $logger
     */
    public function __construct(
        Action $productAction,
        StoreManagerInterface $storeManager,
        RequestResponseContainerFactory $requestResponseContainerFactory,
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger
    ) {
        $this->productAction = $productAction;
        $this->storeManager = $storeManager;
        $this->requestResponseContainer = $requestResponseContainerFactory->create();
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function execute(int $productId, int $value): RequestResponseContainer
    {
        try {
            if (!in_array($value, array_keys(AddProteinAttribute::ALLOWED_VALUES), true)) {
                throw new LocalizedException(__("Unknown attribute value {$value}"));
            }
            $this->productAction->updateAttributes(
                [$productId],
                [AddProteinAttribute::ATTRIBUTE_CODE => $value],
                $this->storeManager->getStore()->getId()
            );

            $this->requestResponseContainer->setIsSuccess(true);

            if ($this->scopeConfig->isSetFlag('gymbeam_product_protein/general/enable_logging')) {
                $newValue = AddProteinAttribute::ALLOWED_VALUES[$value];
                $this->logger->info("Product protein value was changed to {$newValue} for product id {$productId} ");
            }
        } catch (\Throwable $t) {
            $this->logger->error(__("Can't change value for product id {$productId}, value {$value}."));
            $this->requestResponseContainer->setIsSuccess(false);
        }

        return $this->requestResponseContainer;
    }
}
