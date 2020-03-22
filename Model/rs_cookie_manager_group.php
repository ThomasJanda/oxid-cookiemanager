<?php

namespace rs\cookiemanager\Model;

class rs_cookie_manager_group extends \OxidEsales\EshopCommunity\Core\Model\MultiLanguageModel
{
    protected $_sClassName = 'rs_cookie_manager_group';
    
    public function __construct()
    {
        parent::__construct();
        $this->init('rs_cookie_manager_group');
    }
}
