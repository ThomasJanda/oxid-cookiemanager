<?php

namespace rs\cookiemanager\Model;

class rs_cookie_manager_item extends \OxidEsales\Eshop\Core\Model\MultiLanguageModel
{
    protected $_sClassName = 'rs_cookie_manager_item';


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
        $this->init('rs_cookie_manager_item');
    }

}
