<?php

namespace rs\cookiemanager\Model;

class rs_cookie_manager_list extends \OxidEsales\Eshop\Core\Model\ListModel
{
    public function __construct()
    {
        parent::__construct(\rs\cookiemanager\Model\rs_cookie_manager::class);
    }
    
    /*
    public function selectString($sql, array $parameters = [])
    {
        echo $sql;
        return parent::selectString($sql, $parameters );
    }
    */
}
