<?php

namespace Bold\ModelTimemachine;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    /**
     * @var ScopeConfigInterface
     */
    private $config;

    public function __construct(
        ScopeConfigInterface $config
    ) {
        $this->config = $config;
    }

    public function isEnabled()
    {
        return $this->config->isSetFlag('bold_modeltimemachine/general/enabled');
    }
}