<?php

namespace Brabs\AdminShortcuts\Block\Adminhtml;

use Brabs\AdminShortcuts\Helper\Config;
use Magento\Backend\Block\Template;

/**
 * Class Shortcuts
 * @package Brabs\AdminShortcuts\Block\Adminhtml
 */
class Shortcuts extends Template
{
    /**
     * @var Config
     */
    private $config;

    /**
     * Shortcuts constructor.
     * @param \Magento\Backend\Block\Context $context
     * @param array $data
     */
    public function __construct(
        Config $config,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->config = $config;
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function _beforeToHtml()
    {
        if ($this->isEnabled()) {
            $this->initJsLayout();
        } else {
            $this->setTemplate('');
        }

        return parent::_beforeToHtml();
    }

    /**
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function initJsLayout()
    {

        /** @TODO - Make customisable shortcuts per user? */
        $data = [
            'components' => [
                'admin-shortcuts-container' =>
                    [
                        'shortcuts' => $this->config->getShortcuts(),
                        'next' => $this->config->getNext(),
                        'previous' => $this->config->getPrevious()
                    ]
            ]
        ];

        $jsLayout = array_merge_recursive($this->jsLayout, $data);
        $this->jsLayout = $jsLayout;
    }

    /**
     * @param string|null $websiteCode
     * @return bool
     */
    public function isEnabled($websiteCode = null)
    {
        $this->config->isEnabled();
    }

}
