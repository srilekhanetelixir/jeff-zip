<?php
namespace Jeff\SimpleNews\Block\Latest;

use Jeff\SimpleNews\Block\Latest;
use Jeff\SimpleNews\Model\System\Config\LatestNews\Position;

class Right extends Latest {
    public function _construct() {
         $position = $this->_dataHelper->getLatestNewsBlockPosition();

         if($position == Position::RIGHT) {
            $this->setTemplate('Jeff_SimpleNews::latest.phtml');
         }
    }
}