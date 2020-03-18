<?php

$sMetadataVersion = '2.0';

$aModule = array(
    'id'          => 'rs-cookiemanager',
    'title'       => '*RS Cookie Manager',
    'description' => 'Cookie manager with popup',
    'thumbnail'   => '',
    'version'     => '1.0.0',
    'author'      => 'Thomas Janda',
    'url'         => '',
    'email'       => '',
    
    'extend'      => array(
        \OxidEsales\Eshop\Core\ViewConfig::class => rs\cookiemanager\Core\ViewConfig::class,
        \OxidEsales\Eshop\Core\Language::class => rs\cookiemanager\Core\Language::class,
        \OxidEsales\Eshop\Core\Config::class => rs\cookiemanager\Core\Config::class,
    ),
    'templates' => array(
        'rs/cookiemanager/views/tpl/rs_cookie_manager_popup'     => 'rs/cookiemanager/views/tpl/rs_cookie_manager_popup.tpl',
    ),
   'controllers' => array(
       'rs_cookie_manager_track' => rs\cookiemanager\Model\rs_cookie_manager_track::class,
       'rs_cookie_manager_track_list' => rs\cookiemanager\Model\rs_cookie_manager_track_list::class,
       'rs_cookie_manager' => rs\cookiemanager\Model\rs_cookie_manager::class,
       'rs_cookie_manager_group' => rs\cookiemanager\Model\rs_cookie_manager_group::class,
       'rs_cookie_manager_list' => rs\cookiemanager\Model\rs_cookie_manager_list::class,
       'rs_cookie_manager_item' => rs\cookiemanager\Model\rs_cookie_manager_item::class,
       'rs_cookie_manager_item_list' => rs\cookiemanager\Model\rs_cookie_manager_item_list::class,
       'rs_cookie_manager_widget' => rs\cookiemanager\Application\Component\Widget\rs_cookie_manager_widget::class,
    ),
    'blocks'      => array(
        array(
            'template' => 'layout/base.tpl',
            'block'    => 'base_style',
            'file'     => '/views/blocks/layout/base__base_style.tpl',
        ),
        array(
            'template' => 'layout/base.tpl',
            'block'    => 'base_js',
            'file'     => '/views/blocks/layout/base__base_js.tpl',
        ),
        array(
            'template' => 'layout/base.tpl',
            'block'    => 'rscookiemanager1',
            'file'     => '/views/blocks/layout/base__rscookiemanager1.tpl',
        ),
        array(
            'template' => 'layout/base.tpl',
            'block'    => 'rscookiemanager2',
            'file'     => '/views/blocks/layout/base__rscookiemanager2.tpl',
        ),
        array(
            'template' => 'layout/base.tpl',
            'block'    => 'rscookiemanager3',
            'file'     => '/views/blocks/layout/base__rscookiemanager3.tpl',
        ),
    ),
    'settings'    => array(
        array(
            'group' => 'rs-cookiemanager_main',
            'name'  => 'rs-cookiemanager_days_till_expire',
            'type'  => 'str',
            'value' => 365,
        ),
        array(
            'group' => 'rs-cookiemanager_main',
            'name'  => 'rs-cookiemanager_hide_cms_ident',
            'type'  => 'str',
            'value' => "oximpressum|oxsecurityinfo"
        ),
    ),
);