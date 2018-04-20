<?php
/**
 * WDGWV CMS System file.
 * Full access: true
 * Extension: Theme Managament System
 * Version: 1.0
 * Description: This manages all your Themes.
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

class ThemeMananagamentSystem extends \WDGWV\CMS\ExtensionBase
{
    private $ThemeList = array();
    private $ThemeCtrl;

    /**
     * Call the sharedInstance
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Extension\ThemeMananagamentSystem();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        // $this->ThemeCtrl = \WDGWV\CMS\Themes::sharedInstance();
        // $this->ThemeList = \WDGWV\CMS\Themes::sharedInstance()->displayThemeList();
    }

    public function displayList()
    {
        return array("Title", "Contents");
    }

    public function displaySearch()
    {
        return array("Title", "Contents");
    }
}

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'menu',
    'administration/Themes/List',
    array(
        'name' => 'administration/Themes/List',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Themes/List', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'menu',
    'administration/Themes/Search',
    array(
        'name' => 'administration/Themes/Search',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Themes/Search', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'url',
    sprintf('/%s/Themes/Search', (new \WDGWV\CMS\Config)->adminURL()),
    array(ThemeMananagamentSystem::sharedInstance(), 'displaySearch')
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'url',
    sprintf('/%s/Themes/List', (new \WDGWV\CMS\Config)->adminURL()),
    array(ThemeMananagamentSystem::sharedInstance(), 'displayList')
);
