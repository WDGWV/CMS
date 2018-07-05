<?php
/**
 * WDGWV CMS System file.
 * Extension: Theme Managament System
 * Version: 1.0
 * Description: This manages all your Themes.
 * Hash: a509791e7ac25d047a3fc43b063615d3
 * Integrity check: Required
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
-       (c) WDGWV. 2018, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

namespace WDGWV\CMS\Extension; /* Extension namespace */

class ThemeMananagamentSystem extends \WDGWV\CMS\ExtensionBase
{
    /**
     * @var array
     */
    private $ThemeList = array();
    /**
     * @var mixed
     */
    private $ThemeCtrl;

    /**
     * Call the shared
     * @since Version 1.0
     */
    public static function shared()
    {
        /**
         * @var mixed
         */
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
        // $this->ThemeCtrl = \WDGWV\CMS\Themes::shared();
        // $this->ThemeList = \WDGWV\CMS\Themes::shared()->displayThemeList();
    }

    /**
     * Get theme information
     *
     * @param $themePath
     */
    private function themeInfo($themePath)
    {
        $screenshot = false;
        $found = false;

        $table = '<table>';
        if ($screenshot = file_exists($themePath . '/screenshot.png')) {
            $table .= sprintf(
                '<tr><td><img src=\'/%s\'></td><td>%s</td><td><table>',
                $themePath . '/screenshot.png',
                '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
            );
        } else {
            // $table .= '<td>';
        }

        if (file_exists($themePath)) {
            if (file_exists($themePath . '/INFO')) {
                $fgc = file_get_contents($themePath . '/INFO');

                $exploded = explode("\n", $fgc);

                for ($i = 0; $i < sizeof($exploded); $i++) {
                    $extract = explode(':', $exploded[$i]);

                    if (isset($extract[2])) {
                        $extract[1] = sprintf(
                            '<a href=\'%s:%s\' target=\'_blank\'>%s:%s</a>',
                            $extract[1],
                            $extract[2],
                            $extract[1],
                            $extract[2]
                        );
                    }

                    $table .= sprintf(
                        '<tr><td>%s</td><td>&nbsp;</td><td>%s</td></tr>',
                        ucfirst(strtolower($extract[0])),
                        ucwords($extract[1])
                    );
                }

                $found = true;
                // ...
            }

            if (file_exists($themePath . '/LICENSE')) {
                // ...
            }
        }

        if ($screenshot) {
            $table .= '</td></tr></table>';
        }

        $table .= '</tr></table>';

        return $found ? $table : 'Could not load information';
    }

    public function displayList()
    {
        $list = array();
        // only Name.

        $tableHeader = '%s';
        $tableHeader .= '<span class=\'right\'>';
        $tableHeader .= '<button onClick="window.location=\'/%s/%s/List?activateTheme=%s\'">%s \'%s\' Theme</button>';
        $tableHeader .= '</span>';

        // return array("Title", "Contents");
        $d = opendir('./Data/Themes/');
        while (false !== ($file = readdir($d))) {
            if (($file != '.' && $file != '..') &&
                is_dir('./Data/Themes/' . $file)
            ) {
                $list[] = array(
                    sprintf(
                        $tableHeader,
                        $file,
                        (new \WDGWV\CMS\Config)->adminURL(),
                        'Themes',
                        $file,
                        'Activate',
                        $file
                    ),
                    $this->themeInfo('./Data/Themes/' . $file),
                );
            }
        }

        \WDGWV\CMS\Hooks::shared()->createHook(
            'script',
            'Resize classes',
            "$('.col-lg-12').attr('class', 'col-lg-5');"
        );

        return (
            sizeof($list) > 0
            ? $list
            : array('Error', 'Error while loading')
        );
    }

    public function displaySearch()
    {
        return array("Title", "Contents");
    }
}

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'administration/Themes/List',
    array(
        'name' => 'administration/Themes/List',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Themes/List', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'administration/Themes/Search',
    array(
        'name' => 'administration/Themes/Search',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Themes/Search', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    sprintf('/%s/Themes/Activate/*', (new \WDGWV\CMS\Config)->adminURL()),
    array(ThemeMananagamentSystem::shared(), 'activateTheme')
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    sprintf('/%s/Themes/Search', (new \WDGWV\CMS\Config)->adminURL()),
    array(ThemeMananagamentSystem::shared(), 'displaySearch')
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    sprintf('/%s/Themes/List', (new \WDGWV\CMS\Config)->adminURL()),
    array(ThemeMananagamentSystem::shared(), 'displayList')
);

//TODO: REMOVE ME
\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    '/themeSet/portal',
    array(
        \WDGWV\CMS\Controllers\Databases\Controller::shared(),
        'themeSet',
    ),
    array(
        'portal',
    )
);

//TODO: REMOVE ME
\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    '/themeSet/admin',
    array(
        \WDGWV\CMS\Controllers\Databases\Controller::shared(),
        'themeSet',
    ),
    array(
        'admin',
    )
);
