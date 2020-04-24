<?php

/**
* Sets template name to passed reference, returns true.
*
* @param string $sTplName    name of template
* @param string &$sTplSource Template source
* @param object $oSmarty     not used here
*
* @return bool
*/
function rscookie_get_template($sTplName, &$sTplSource, $oSmarty)
{
$sTplSource = $oSmarty->oxidcache->rawValue;
if (oxRegistry::getConfig()->isDemoShop()) {
$oSmarty->security = true;
}

return true;
}

/**
* Sets timestamt to passed timestamp object, returns true.
*
* @param string $sTplName       name of template
* @param string &$iTplTimestamp template timestamp referense
* @param object $oSmarty        not used here
*
* @return bool
*/
function rscookie_get_timestamp($sTplName, &$iTplTimestamp, $oSmarty)
{
if (isset($oSmarty->oxidtimecache->value)) {
// use stored timestamp
$iTplTimestamp = $oSmarty->oxidtimecache->value;
} else {
// always compile
$iTplTimestamp = time();
}

return true;
}

/**
* Assumes all templates are secure, returns true.
*
* @param string $sTplName not used here
* @param object $oSmarty  not used here
*
* @return bool
*/
function rscookie_get_secure($sTplName, $oSmarty)
{
// assume all templates are secure
return true;
}

/**
* Does nothing.
*
* @param string $sTplName not used here
* @param object $oSmarty  not used here
*/
function rscookie_get_trusted($sTplName, $oSmarty)
{
// not used for templates
}
