# Oxid Cookie Manager

## Description

Implement the cookie manager solution with popup.
Manage all cookies you need in the oxid admin. Add code snippets simply without template changes.
Enable/Disable cookies based on the language the user select in the shop frontend.
Goup cookies, define required cookies. The system create a popup automaticly.

For the legal security we do not take over guarantee!

![](shop1.png)

This extension was created for Oxid 6.x.

## Requirements

"oxid-formedit" module required.

## Install

1. Copy module into following directory
        
        source/modules/rs/cookiemanager
        
2. Add following to composer.json on the shop root

        "autoload": {
            "psr-4": {
                "rs\\cookiemanager\\": "./source/modules/rs/cookiemanager"
            }
        },
    
3. Refresh autoloader files with composer in the oxid root directory.

        composer dump-autoload

4. Execute following statments on the database

        CREATE TABLE `rs_cookie_manager` (
        `oxid` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
        `f_rs_cookie_manager_group` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
        `rsactive` tinyint(1) NOT NULL DEFAULT '0',
        `rsident` varchar(250) DEFAULT NULL,
        `rstitle` varchar(250) DEFAULT NULL,
        `rstitle_1` varchar(250) DEFAULT NULL,
        `rstitle_2` varchar(250) DEFAULT NULL,
        `rsdescription` varchar(2000) DEFAULT NULL,
        `rsdescription_1` varchar(2000) DEFAULT NULL,
        `rsdescription_2` text,
        PRIMARY KEY (`oxid`),
        KEY `f_rs_cookie_manager_group` (`f_rs_cookie_manager_group`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `rs_cookie_manager_group` (
        `oxid` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
        `rsident` varchar(250) DEFAULT NULL,
        `rstitle` varchar(250) DEFAULT NULL,
        `rstitle_1` varchar(250) DEFAULT NULL,
        `rsdescription` text,
        `rsdescription_1` text,
        PRIMARY KEY (`oxid`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `rs_cookie_manager_item` (
        `oxid` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
        `f_rs_cookie_manager` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
        `rsactive` tinyint(1) DEFAULT '0',
        `rsactive_1` tinyint(1) NOT NULL DEFAULT '0',
        `rsactive_2` tinyint(1) NOT NULL DEFAULT '0',
        `rsview_classes` text,
        `rsplace1` text,
        `rsplace3` text,
        `rsplace2` text,
        PRIMARY KEY (`oxid`),
        KEY `f_rs_cookie_manager` (`f_rs_cookie_manager`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        CREATE TABLE `rs_cookie_manager_track` (
        `oxid` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
        `rscreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `rscookie_id` char(50) DEFAULT NULL,
        `f_rs_cookie_manager` char(32) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
        `rsshopid` int(11) NOT NULL DEFAULT '0',
        `rslanguageid` int(11) NOT NULL DEFAULT '0',
        `rsallow` tinyint(1) NOT NULL DEFAULT '0',
        PRIMARY KEY (`oxid`),
        KEY `f_rs_cookie_manager` (`f_rs_cookie_manager`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        INSERT INTO `rs_cookie_manager` 
        (`oxid`, `f_rs_cookie_manager_group`, `rsactive`, `rsident`, `rstitle`, `rstitle_1`, `rstitle_2`, `rsdescription`, `rsdescription_1`, `rsdescription_2`) 
        VALUES 
        ('rs_shop', NULL, '0', 'Shop', NULL, NULL, NULL, NULL, NULL, NULL), 
        ('rs_google_analytics', NULL, '0', 'Google analytics', NULL, NULL, NULL, NULL, NULL, NULL);
        
5. Enable module in the oxid admin area, Extensions => Modules

6. Rebuild views, clear complete cache.