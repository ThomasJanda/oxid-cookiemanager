<?php

namespace rs\cookiemanager\Core;

use OxidEsales\Eshop\Core\Registry;

class rs_cookie_manager
{
    protected $_rs_cookiemanager_cookieName="rs_cookie_manager";
    
    protected function _rs_cookiemanager_getCookieId()
    {
        $sId = \OxidEsales\Eshop\Core\Registry::getUtilsServer()->getOxCookie($this->_rs_cookiemanager_cookieName);
        return $sId;
    }
    protected function _rs_cookiemanager_trackedCookies()
    {
        $aItems = [];
        $id = $this->_rs_cookiemanager_getCookieId();
        if($id!="")
        {
            $oList = new \rs\cookiemanager\Model\rs_cookie_manager_track_list();
            $aItems = $oList->getListItems($id);
        }
        return $aItems;
    }
    public function rs_cookiemanager_checkAgree($customerid)
    {
        $ret = false;
        $aList = $this->_rs_cookiemanager_trackedCookies();
        
        $ids=[];
        foreach($aList as $o)
        {
            $ids[]=$o->rs_cookie_manager_track__f_rs_cookie_manager->getRawValue();
        }
        
        if(count($ids)>0)
        {
            $sSql="SELECT 
            count(*) 
            FROM `rs_cookie_manager`
            join rs_cookie_manager_group on rs_cookie_manager_group.oxid=rs_cookie_manager.f_rs_cookie_manager_group
            where rs_cookie_manager.oxid in ('".implode("','",$ids)."')
            and rs_cookie_manager_group.rscustomer_id='$customerid'";
            if(\oxDb::getDb()->getOne($sSql)!="0")
            {
                $ret = true;
            }
        }

        return $ret;
    }
    

    /**
     * test if a cookie group accept by the customer
     * 
     * @param string $sCustomerId
     * @return bool
     */
    public static function userAcceptCookieGroup(string $sCustomerId):bool
    {
        $o = new \rs\cookiemanager\Core\rs_cookie_manager();
        return $o->rs_cookiemanager_checkAgree($sCustomerId);
    }
}

