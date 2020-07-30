<?php

namespace rs\cookiemanager\Model;

class rs_cookie_manager_track extends \OxidEsales\Eshop\Core\Model\BaseModel
{
    protected $_sClassName = 'rs_cookie_manager_track';
    
    protected $_aSkipSaveFields = ['rscreated'];
        
    public function __construct()
    {
        parent::__construct();
        $this->init('rs_cookie_manager_track');
    }
}
