<?php


namespace Brabs\AdminShortcuts\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

class Shortcuts extends AbstractFieldArray
{
    /**
     * Prepare rendering the new field by adding all the needed columns
     */
    protected function _prepareToRender()
    {
        $this->addColumn('name', ['label' => 'Name', 'class' => 'required-entry']);
        $this->addColumn('shortcut', ['label' => 'Shortcut', 'class' => 'required-entry']);
        $this->addColumn('id', ['label' => 'UI ID', 'class' => 'required-entry']);
        $this->addColumn('params', ['label' => 'Params']);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add new Shortcut');
    }
}