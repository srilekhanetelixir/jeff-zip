<?php
namespace Jeff\SimpleNews\Block\Latest;

use Jeff\SimpleNews\Block\Latest;
use Jeff\SimpleNews\Model\System\Config\LatestNews\Position;

class Left extends Latest {
    public function _construct() {
         $position = $this->_dataHelper->getLatestNewsBlockPosition();

         if($position == Position::LEFT) {
            $this->setTemplate('Jeff_SimpleNews::latest.phtml');
         }
    }
}