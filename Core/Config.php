<?php

namespace rs\cookiemanager\Core;

use OxidEsales\EshopCommunity\Core\Registry;

class Config extends Config_parent
{
    /**
     * overload oxid function
     *
     * @param $sParamName
     *
     * @return array
     */
    public function getConfigParam( $sParamName, $default = null )
    {
        $Ret = parent::getConfigParam( $sParamName, $default );
        if($sParamName=="blShowCookiesNotification")
        {
            $sRet = 0;
        }
        return $Ret;
    }

}