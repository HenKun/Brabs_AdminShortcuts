<?php


namespace Brabs\AdminShortcuts\Helper;

use Brabs\AdminShortcuts\Model\Shortcut;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    const PATH = 'brabs_adminshortcuts/general/';
    const FIELD_SHORTCUT = 'shortcuts';
    const FIELD_ENABLED = 'enabled';
    const FIELD_NEXT = 'next';
    const FIELD_PREVIOUS = 'previous';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    public function isEnabled() : bool
    {
        return $this->scopeConfig->isSetFlag(self::PATH . self::FIELD_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     *
     */
    public function getShortcuts()
    {
        $shortcuts = [];
        $shortcutsRaw = json_decode($this->scopeConfig->getValue(self::PATH . self::FIELD_SHORTCUT, ScopeInterface::SCOPE_STORE));

        foreach($shortcutsRaw as $shortcut)
        {
            $shortcuts[] = [
                'name' => $shortcut->name,
                'id' => $shortcut->id,
                'shortcut' => $shortcut->shortcut,
                'params' => $shortcut->params
            ];
        }

        return $shortcuts;
    }

    public function getPrevious() : string
    {
        return $this->scopeConfig->getValue(self::PATH . self::FIELD_PREVIOUS, ScopeInterface::SCOPE_STORE);
    }

    public function getNext() : string
    {
        return $this->scopeConfig->getValue(self::PATH . self::FIELD_NEXT, ScopeInterface::SCOPE_STORE);
    }
}