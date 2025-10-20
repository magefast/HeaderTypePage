<?php

namespace Strekoza\HeaderTypePage\Plugin;

use Magento\Cms\Controller\Page\View;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\Page;
use Strekoza\HeaderTypePage\Api\SettingsInterface;

class CmsHeader
{
    private RequestInterface $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function afterExecute(View $subject, $result)
    {
        if (!$result instanceof Page) {
            return $result;
        }

        if (!empty($this->getPageId())) {
            $subject->getResponse()->setHeader(SettingsInterface::HEADER_TYPE, SettingsInterface::TYPE_PAGE_CMS, true);
        }

        return $result;
    }

    private function getPageId(): ?int
    {
        $id = $this->request->getParam('page_id') ?? $this->request->getParam('id');

        return $id ? (int)$id : null;
    }
}