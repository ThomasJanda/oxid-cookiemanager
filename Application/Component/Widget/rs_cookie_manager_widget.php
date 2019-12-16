<?php

namespace rs\cookiemanager\Application\Component\Widget;

use oxdb;
use OxidEsales\Eshop\Core\Request;

class rs_cookie_manager_widget extends \OxidEsales\EshopCommunity\Application\Component\Widget\WidgetController
{

    protected $_rs_cookiemanager_cookieName="rs_cookie_manager";
    
    public function accept()
    {
        //set cookie
        $sName = $this->_rs_cookiemanager_cookieName;
        $sCookieValue = uniqid();
        $iTime = time() + 365*24*60*60;
        \OxidEsales\Eshop\Core\Registry::getUtilsServer()->setOxCookie($sName, $sCookieValue, $iTime);

        //save to the database
        $request = oxNew(Request::class);
        $aGroups=$request->getRequestParameter("rs_cookie_groups");
        $aGroupKeys = [];
        if(is_array($aGroups))
        {
            $aGroupKeys = array_keys($aGroups);
            
            //fix because jquery
            $aGroupNew = [];
            foreach($aGroups as $sKey => $sValue)
            {
                if(is_array($sValue))
                    $sValue = end($sValue);
                    
                $aGroupNew[$sKey] = $sValue;
            }
            $aGroup = $aGroupNew;
        }

        $iLang = \OxidEsales\Eshop\Core\Registry::getLang()->getBaseLanguage();
        $iShop = $this->getConfig()->getShopId();
        
        $oList = new \rs\cookiemanager\Model\rs_cookie_manager_list();      
        $aList = $oList->getList();
        foreach($aList as $o)
        {
            $bAllow=false;
            $oGroup = $o->getGroup();
            if($oGroup)
            {
                if(in_array($oGroup->getId(),$aGroupKeys) && $aGroups[$oGroup->getId()]!=0)
                    $bAllow=true;
                if((bool) $oGroup->rs_cookie_manager_group__rsrequired->value)
                    $bAllow=true;

                $aData = [];
                $aData['rs_cookie_manager_track__oxid']=null;
                $aData['rs_cookie_manager_track__rscookie_id']=$sCookieValue;
                $aData['rs_cookie_manager_track__rsshopid']=$iShop;
                $aData['rs_cookie_manager_track__rslanguageid']=$iLang;
                $aData['rs_cookie_manager_track__f_rs_cookie_manager']=$o->getId();
                $aData['rs_cookie_manager_track__rsallow']=($bAllow?1:0);

                $oTrack = oxNew(\rs\cookiemanager\Model\rs_cookie_manager_track::class);
                $oTrack->assign($aData);
                $oTrack->save();
            }
        }
        
        header("HTTP/1.0 200 Ok", true, 200);
        die("");
    }
}