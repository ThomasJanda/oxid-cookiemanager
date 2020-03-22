<?php

namespace rs\cookiemanager\Model;

class rs_cookie_manager extends \OxidEsales\EshopCommunity\Core\Model\MultiLanguageModel
{
    protected $_sClassName = 'rs_cookie_manager';
    
    
    public function getSqlActiveSnippet($forceCoreTable = null)
    {
        $query = '';
        $tableName = $this->getViewName($forceCoreTable);

        // has 'active' field ?
        if (isset($this->_aFieldNames['rsactive'])) {
            $query = " $tableName.rsactive = 1 ";
        }

        return $query;
    }
    
    public function __construct()
    {
        parent::__construct();
        $this->init('rs_cookie_manager');
    }
    
    public function getItems()
    {
        $oList = new \rs\cookiemanager\Model\rs_cookie_manager_item_list();
        return $oList->getListItems($this->getId());
    }
    
    public function getGroup()
    {
        $o = new \rs\cookiemanager\Model\rs_cookie_manager_group();
        $o->load($this->rs_cookie_manager__f_rs_cookie_manager_group->value);
        return $o;
    }
}
