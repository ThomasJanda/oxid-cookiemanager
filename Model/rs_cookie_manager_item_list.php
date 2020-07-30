<?php

namespace rs\cookiemanager\Model;

class rs_cookie_manager_item_list extends \OxidEsales\Eshop\Core\Model\ListModel
{
    
    public function __construct()
    {
        parent::__construct(\rs\cookiemanager\Model\rs_cookie_manager_item::class);
    }
    
    public function getListItems($f_rs_cookie_manager)
    {
        $oListObject = $this->getBaseObject();
        $sFieldList = $oListObject->getSelectFields();
        $sQ = "select $sFieldList from " . $oListObject->getViewName();
        $sQ.= " where f_rs_cookie_manager='".$f_rs_cookie_manager."'";
        if ($sActiveSnippet = $oListObject->getSqlActiveSnippet()) {
            $sQ .= " and $sActiveSnippet ";
        }
        $this->selectString($sQ);

        return $this;
    }
    
    /*
    public function selectString($sql, array $parameters = [])
    {
        echo $sql;
        die("");
        return parent::selectString($sql, $parameters );
    }
    */
    
    
}
