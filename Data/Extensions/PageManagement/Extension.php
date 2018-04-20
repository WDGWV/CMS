<?php
/**
 * WDGWV CMS System file.
 * Full access: true
 * Extension: Page Managament System
 * Version: 1.0
 * Description: This manages all your pages.
 * SystemFile: true
 * Hash: * INSERT HASH HERE *
 */

/*
------------------------------------------------------------
-                :....................,:,                  -
-              ,.`,,,::;;;;;;;;;;;;;;;;:;`                 -
-            `...`,::;:::::;;;;;;;;;;;;;::'                -
-           ,..``,,,::::::::::::::::;:;;:::;               -
-          :.,,``..::;;,,,,,,,,,,,,,:;;;;;::;`             -
-         ,.,,,`...,:.:,,,,,,,,,,,,,:;:;;;;:;;             -
-        `..,,``...;;,;::::::::::::::'';';';:''            -
-        ,,,,,``..:;,;;:::::::::::::;';;';';;'';           -
-       ,,,,,``....;,,:::::::;;;;;;;;':'''';''+;           -
-       :,::```....,,,:;;;;;;;;;;;;;;;''''';';';;          -
-      `,,::``.....,,,;;;;;;;;;;;;;;;;'''''';';;;'         -
-      :;:::``......,;;;;;;;;:::::;;;;'''''';;;;:-         -
-      ;;;::,`.....,::;;::::::;;;;;;;;'''''';;,;;,         -
-      ;:;;:;`....,:::::::::::::::::;;;;'''':;,;;;         -
-      ';;;;;.,,,,::::::::::::::::::;;;;;''':::;;'         -
-      ;';;;;.;,,,,::::::::::::::::;;;;;;;''::;;;'         -
-      ;'';;:;..,,,;;;:;;:::;;;;;;;;;;;;;;;':::;;'         -
-      ;'';;;;;.,,;:;;;;;;;;;;;;;;;;;;;;;;;;;:;':;         -
-      ;''';;:;;.;;;;;;;;;;;;;;;;;;;;;;;;;;;''';:.         -
-      :';';;;;;;::,,,,,,,,,,,,,,:;;;;;;;;;;'''';          -
-       '';;;;:;;;.,,,,,,,,,,,,,,,,:;;;;;;;;'''''          -
-       '''';;;;;:..,,,,,,,,,,,,,,,,,;;;;;;;''':,          -
-       .'''';;;;....,,,,,,,,,,,,,,,,,,,:;;;''''           -
-        ''''';;;;....,,,,,,,,,,,,,,,,,,;;;''';.           -
-         '''';;;::.......,,,,,,,,,,,,,:;;;''''            -
-         `''';;;;:,......,,,,,,,,,,,,,;;;;;''             -
-          .'';;;;;:.....,,,,,,,,,,,,,,:;;;;'              -
-           `;;;;;:,....,,,,,,,,,,,,,,,:;;''               -
-             ;';;,,..,.,,,,,,,,,,,,,,,;;',                -
-               '';:,,,,,,,,,,,,,,,::;;;:                  -
-                 `:;'''''''''''''''';:.                   -
-                                                          -
- ,,,::::::::::::::::::::::::;;;;,:::::::::::::::::::::::: -
- ,::::::::::::::::::::::::::;;;;,:::::::::::::::::::::::: -
- ,:; ## ## ##  #####     ####      ## ## ##  ##   ##  ;:: -
- ,,; ## ## ##  ## ##    ##         ## ## ##  ##   ##  ;:: -
- ,,; ## ## ##  ##  ##  ##   ####   ## ## ##   ## ##   ;:: -
- ,,' ## ## ##  ## ##    ##    ##   ## ## ##   ## ##   ::: -
- ,:: ########  ####      ######    ########    ###    ::: -
- ,,,:,,:,,:::,,,:;:::::::::::::::;;;:::;:;::::::::::::::: -
- ,,,,,,,,,,,,,,,,,,,,,,,,:,::::::;;;;:::::;;;;::::;;;;::: -
-                                                          -
-       (c) WDGWV. 2013, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

namespace WDGWV\CMS\Extension; /* Extension namespace */

class PageMananagamentSystem extends \WDGWV\CMS\ExtensionBase
{
    private $pageList = array();
    private $pageCtrl;

    /**
     * Call the sharedInstance
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Extension\PageMananagamentSystem();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        // $this->pageCtrl = \WDGWV\CMS\Pages::sharedInstance();
        // $this->pageList = \WDGWV\CMS\Pages::sharedInstance()->displayPageList();
    }

    public function displayList()
    {
        return array("Title", "Contents");
    }

    public function displayNew()
    {
        return array("Title", "Contents");
    }
}

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'menu',
    'administration/Pages/List',
    array(
        'name' => 'administration/Pages/List',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Pages/List', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'menu',
    'administration/Pages/New',
    array(
        'name' => 'administration/Pages/New',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Pages/New', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'url',
    sprintf('/%s/Pages/New', (new \WDGWV\CMS\Config)->adminURL()),
    array(PageMananagamentSystem::sharedInstance(), 'displayNew')
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'url',
    sprintf('/%s/Pages/List', (new \WDGWV\CMS\Config)->adminURL()),
    array(PageMananagamentSystem::sharedInstance(), 'displayList')
);
