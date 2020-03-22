<?php

namespace rs\cookiemanager\Core;

class Language extends Language_parent 
{
    
    public function getMultiLangTables()
    {
        $aTables = parent::getMultiLangTables();
        $aTables[]='rs_cookie_manager';
        $aTables[]='rs_cookie_manager_item';
        $aTables[]='rs_cookie_manager_group';
        return $aTables;
    }
}
