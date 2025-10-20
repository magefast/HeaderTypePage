<?php

namespace Strekoza\HeaderTypePage\Plugin;

use Magento\Catalog\Controller\Category\View;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Strekoza\HeaderTypePage\Api\SettingsInterface;

class CategoryHeader
{
    private Registry $registry;
    private HttpRequest $request;
    private $layerResolver;

    public function __construct(Registry $registry, HttpRequest $httpRequest, Resolver $layerResolver)
    {
        $this->registry = $registry;
        $this->request = $httpRequest;
        $this->layerResolver = $layerResolver;
    }

    /**
     * @throws LocalizedException
     */
    public function afterExecute(View $subject, $result)
    {
        if (!$result instanceof Page) {
            return $result;
        }

        if ($this->request->isAjax()) {
            return $result;
        }

        if ($currentCategoryData = $this->registry->registry('current_category')) {
            $subject->getResponse()->setHeader(SettingsInterface::HEADER_TYPE, SettingsInterface::TYPE_PAGE_CATEGORY, true);

            $filters = $this->layerResolver->get()->getState()->getFilters();

            if (count($filters) > 1) {
                $subject->getResponse()->setHeader(SettingsInterface::HEADER_TYPE, SettingsInterface::TYPE_PAGE_CATEGORY_FILTER, true);
                return $result;
            }

            try {
                if (count($filters) > 0) {
                    foreach ($filters as $filter) {
                        if ($filter->getFilter() && $filter->getFilter()->getAttributeModel()) {
                            if ($filter->getFilter()->getAttributeModel()->getAttributeCode()) {
                                $code = $filter->getFilter()->getAttributeModel()->getAttributeCode();
                                if ($code == 'price') {
                                    $subject->getResponse()->setHeader(SettingsInterface::HEADER_TYPE, SettingsInterface::TYPE_PAGE_CATEGORY_FILTER, true);
                                    return $result;
                                }
                            }
                        }
                    }
                }
            } catch (LocalizedException $e) {

            }
        }

        return $result;
    }
}