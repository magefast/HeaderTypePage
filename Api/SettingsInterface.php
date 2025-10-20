<?php

namespace Strekoza\HeaderTypePage\Api;

interface SettingsInterface
{
    public const HEADER_TYPE = 'X-Type';
    public const TYPE_PAGE_PRODUCT_ARCHIVE = 'ProductArchive';
    public const TYPE_PAGE_PRODUCT_OUT_OF_STOCK = 'ProductOutOfStock';
    public const TYPE_PAGE_PRODUCT = 'Product';
    public const TYPE_PAGE_CATEGORY = 'Category';
    public const TYPE_PAGE_CATEGORY_FILTER = 'CategoryFilter';
    public const TYPE_PAGE_CMS = 'CMS';
    public const TYPE_PAGE_CMS_HOME = 'CMS-Home';
}