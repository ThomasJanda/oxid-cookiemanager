<?php

namespace rs\cookiemanager\Core;

class ViewConfig extends ViewConfig_parent
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
    
    
    
    
    protected $_rs_cookiemanager_testShopPopup=null;
    protected function _rs_cookiemanager_testShowPopup()
    {
        if($this->_rs_cookiemanager_testShowPopup===null)
        {
            if (\OxidEsales\Eshop\Core\Registry::getUtils()->isSearchEngine()) {
                $bShow=false;
            }
            else
            {
                $bShow=true;
                
                //test if on defined cms-page
                $sActCl = $this->getTopActiveClassName();
                if($sActCl==="content")
                {
                    $aIdents = explode("|",$this->getConfig()->getConfigParam('rs-cookiemanager_hide_cms_ident'));
                    $oxcid = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('oxcid','');
                    if($oxcid!=="")
                    {
                        $oContent = oxNew(\OxidEsales\Eshop\Application\Model\Content::class);
                        $oContent->load($oxcid);
                        if(in_array($oContent->getLoadId(),$aIdents))
                        {
                            $bShow = false;
                        }
                    }
                }
                
                if($bShow)
                {
                    if($this->_rs_cookiemanager_getCookieId()!==null)
                    {
                        //get all active cookies in this language
                        $aCookiesActive = [];
                        $oList = new \rs\cookiemanager\Model\rs_cookie_manager_list();      
                        $aList = $oList->getList();
                        foreach($aList as $o)
                        {
                            $aCookie = $o->getItems();
                            if(count($aCookie) > 0)
                            {
                                $aCookiesActive[] = $o->getId();
                            }
                        }

                        if(count($aCookiesActive)==0)
                        {
                            //no active cookie present, no popup nesseary
                            //the cookie id is present, means use agree with standard cookies
                            $bShow=false;
                        }
                        else
                        {
                            //get all allowed cookies which the user agree
                            $aCookiesTracked = [];
                            if($aList = $this->_rs_cookiemanager_trackedCookies())
                            {
                                foreach($aList as $o)
                                {
                                    $aCookiesTracked[]=$o->rs_cookie_manager_track__f_rs_cookie_manager->value;
                                }
                            }

                            //test the both list if all ok (all active cookies in the tracked list)
                            $bFound = true;
                            foreach($aCookiesActive as $id)
                            {
                                if(!in_array($id, $aCookiesTracked))
                                {
                                    $bFound = false;
                                    break;
                                }
                            }

                            //test fail if one cookie of the active not int the tracked list
                            //but it is ok if the user has more tracked cookies as we really use
                            $bShow = !$bFound;
                        }
                    }
                }
            }
            $this->_rs_cookiemanager_testShopPopup = $bShow;
        }
        return $this->_rs_cookiemanager_testShopPopup;
    }
    
    protected $_rs_cookiemanager_getActiveCookies=null;
    protected function _rs_cookiemanager_getActiveCookiesOfThisView()
    {
        $sActCl = $this->getTopActiveClassName();
        
        if($this->_rs_cookiemanager_getActiveCookies===null)
        {
            $this->_rs_cookiemanager_getActiveCookies=false;
            
            $oList = new \rs\cookiemanager\Model\rs_cookie_manager_list();      
            $aList = $oList->getList();
            foreach($aList as $o)
            {
                $aCookie = $o->getItems();
                foreach($aCookie as $oCookie)
                {
                    $aViewClasses = explode("\n",$oCookie->rs_cookie_manager_item__rsview_classes->getRawValue());
                    $aViewClasses = array_map('trim',$aViewClasses);
                    $aViewClasses = array_filter($aViewClasses);

                    if(count($aViewClasses)==0 || in_array($sActCl,$aViewClasses))
                    {
                        $this->_rs_cookiemanager_getActiveCookies[]=$oCookie;
                    }
                }
            }
        }
        return $this->_rs_cookiemanager_getActiveCookies;
    }
    
    protected $_rs_cookiemanager_getActiveCookiesGrouped=null;
    protected function _rs_cookiemanager_getActiveCookiesGrouped()
    {
        if($this->_rs_cookiemanager_getActiveCookiesGrouped===null)
        {
            $this->_rs_cookiemanager_getActiveCookiesGrouped=false;
            $oList = new \rs\cookiemanager\Model\rs_cookie_manager_list();      
            $aList = $oList->getList();
            foreach($aList as $o)
            {
                $oGroup = $o->getGroup();
                $sGroupId = $oGroup->rs_cookie_manager_group__rsorder->value."_".$oGroup->getId();
                $this->_rs_cookiemanager_getActiveCookiesGrouped[$sGroupId][]=$o;
            }
            
            uksort($this->_rs_cookiemanager_getActiveCookiesGrouped, function($a, $b) {
                $a = (int) explode("_",$a)[0];
                $b = (int) explode("_",$b)[0];
                
                if ($a == $b) {
                    return 0;
                }
                return ($a < $b) ? -1 : 1;
            });
        }
        return $this->_rs_cookiemanager_getActiveCookiesGrouped;
    }
    
    
    
    
    public function rs_cookiemanager_showPopup()
    {
        return $this->_rs_cookiemanager_testShowPopup();
    }
    public function rs_cookiemanager_getPopupContent()
    {
        return $this->_rs_cookiemanager_getActiveCookiesGrouped();
    }
    
    
    
    
    
    public function rs_cookiemanager_getCode($iPlace)
    {
        $sBaseUrl = $this->getSelfActionLink();
        $sActCl = $this->getTopActiveClassName();
        $iLang = \OxidEsales\Eshop\Core\Registry::getLang()->getBaseLanguage();
        $iShop = $this->getConfig()->getShopId();
        
        $aCookiesTracked = $this->_rs_cookiemanager_trackedCookies();
        $sRet="";

        if (\OxidEsales\Eshop\Core\Registry::getUtils()->isSearchEngine()) {
            return $sRet;
        }
        
        if($aCookie = $this->_rs_cookiemanager_getActiveCookiesOfThisView())
        {
            foreach($aCookie as $oCookie)
            {
                //only add the cookie if allowed
                $bAdd = false;
                foreach($aCookiesTracked as $oCookieTracked)
                {
                    if($oCookieTracked->rs_cookie_manager_track__f_rs_cookie_manager->value==$oCookie->rs_cookie_manager_item__f_rs_cookie_manager->value)
                    {
                        if((bool) $oCookieTracked->rs_cookie_manager_track__rsallow->value)
                        {
                            $bAdd = true;
                            break;
                        }
                    }
                }

                if($bAdd)
                {
                    $sCol = "rs_cookie_manager_item__rsplace".$iPlace;

                    //parse code with smarty
                    $cid = md5(__CLASS__."|".$oCookie->getId()."|".$iPlace."|".$iLang."|".$iShop);
                    $oSmarty = \OxidEsales\Eshop\Core\Registry::getUtilsView()->getSmarty();
                    $oSmarty->oxidcache = clone $oCookie->{$sCol};
                    $oSmarty->compile_check  = true;
                    $sCacheId = $cid;
                    $sCode = $oSmarty->fetch( "ox:".$sCacheId);
                    $oSmarty->compile_check  = $this->getConfig()->getConfigParam( 'blCheckTemplates' );

                    $sRet.=$sCode;                        
                }
            }
        }
        return $sRet;
    }
    
    
    public function getViewThemeParam($sName)
    {
        $sValue = parent::getViewThemeParam($sName);
        
        if($sName=="sGATrackingId" || $sName=="blUseGAEcommerceTracking")
        {
            $aCookiesTracked = $this->_rs_cookiemanager_trackedCookies();
            foreach($aCookiesTracked as $oCookieTracked)
            {
                if($oCookieTracked->rs_cookie_manager_track__f_rs_cookie_manager->value=='rs_google_analytics')
                {
                    if(!(bool) $oCookieTracked->rs_cookie_manager_track__rsallow->value)
                    {
                        $sValue=false;
                        break;
                    }
                }
            }
        }

        return $sValue;
    }
}