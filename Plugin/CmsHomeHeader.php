<?php

namespace Strekoza\HeaderTypePage\Plugin;

use Magento\Cms\Controller\Index\Index;
use Magento\Framework\View\Result\Page;
use Strekoza\HeaderTypePage\Api\SettingsInterface;

class CmsHomeHeader
{
    public function afterExecute(Index $subject, $result)
    {
        if (!$result instanceof Page) {
            return $result;
        }

        $subject->getResponse()->setHeader(SettingsInterface::HEADER_TYPE, SettingsInterface::TYPE_PAGE_CMS_HOME, true);

        return $result;
    }
}