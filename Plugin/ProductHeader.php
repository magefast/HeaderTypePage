<?php

namespace Strekoza\HeaderTypePage\Plugin;

use Magento\Catalog\Controller\Product\View;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Strekoza\ArchiveVisibility\Model\Product\ArchiveVisibility;
use Strekoza\HeaderTypePage\Api\SettingsInterface;

class ProductHeader
{
    private Registry $registry;

    public function __construct(Registry $registry)
    {
        $this->registry = $registry;
    }

    public function afterExecute(View $subject, $result)
    {
        if (!$result instanceof Page) {
            return $result;
        }

        if ($currentProductData = $this->registry->registry('current_product')) {
            $subject->getResponse()->setHeader(SettingsInterface::HEADER_TYPE, SettingsInterface::TYPE_PAGE_PRODUCT, true);

            if ($currentProductData->getVisibility() && $currentProductData->getVisibility() == ArchiveVisibility::VISIBILITY_ARCHIVE) {
                $subject->getResponse()->setHeader(SettingsInterface::HEADER_TYPE, SettingsInterface::TYPE_PAGE_PRODUCT_ARCHIVE, true);
                return $result;
            }

            if ($currentProductData->isAvailable() === false) {
                $subject->getResponse()->setHeader(SettingsInterface::HEADER_TYPE, SettingsInterface::TYPE_PAGE_PRODUCT_OUT_OF_STOCK, true);
                return $result;
            }
        }

        return $result;
    }
}