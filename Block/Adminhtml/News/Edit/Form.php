<?php
namespace Jeff\SimpleNews\Block\Adminhtml\News\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

/** This file will declare form information */
class Form extends Generic {
    protected function _prepareForm() {
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id' => 'edit_form',
                    'action' => $this->getData('action'),
                    'method' => 'post'
                ]
            ]
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
