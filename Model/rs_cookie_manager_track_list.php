<?php

namespace rs\cookiemanager\Model;

class rs_cookie_manager_track_list extends \OxidEsales\Eshop\Core\Model\ListModel
{
    public function __construct()
    {
        parent::__construct(\rs\cookiemanager\Model\rs_cookie_manager_track::class);
    }
    
    public function getListItems($sCookieId)
    {
        $iLang = \OxidEsales\Eshop\Core\Registry::getLang()->getBaseLanguage();
        $iShop = $this->getConfig()->getShopId();
                
        $oListObject = $this->getBaseObject();
        $sFieldList = $oListObject->getSelectFields();
        $sQ = "select $sFieldList from " . $oListObject->getViewName();
        $sQ.= " where rscookie_id='$sCookieId'";
        $sQ.= " and rsshopid='$iShop'";
        //make problem if the user switch the language
        //$sQ.= " and rslanguageid='$iLang'";
        $this->selectString($sQ);

        return $this;
    }
}
