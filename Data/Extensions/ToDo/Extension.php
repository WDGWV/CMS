<?php
/**
 * WDGWV CMS Extension file.
 * Full access: false
 * Extension: TODO Extension
 * Version: 1.0
 * Description: This is a simple test for a static TODO Extension.
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

namespace WDGWV\CMS\Extension; /* Module namespace */

class TodoExtension extends \WDGWV\CMS\ExtensionBase
{
    /**
     * Call the sharedInstance
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Extension\todoExtension();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
    }

    public function _display()
    {
        $items = array();

        $items['Extensibility'] = array(
            'Page extensions' => 100,
            'Menu extensions' => 100,
            'URL-extensions (override)' => 100,
            'before-content (one item only)' => 100,
            'after-content (one item only)' => 100,
            'Specific $_POST extensions' => 100,
            'Specific $_GET extensions' => 100,
            'Partial: UBB code extensions' => 25,
        );

        $items['Extension: demo mode'] = array(
            'Strip $_POST' => 100,
            'Strip $_GET' => 100,
            'Warning if $_GET or $_POST (before-content)' => 100,
            'Extra footer notice (after-content)' => 100,
        );

        $items['Databases: MySQLite Database support'] = array(
            'Connection' => 100,
            'Setup database' => 100,
            'function: userExists' => 100,
            'function: userRegister' => 100,
            'function: userDelete' => 100,
            'function: userLogin' => 0,
            'function: userLoad' => 0,
            'function: setTheme' => 100,
            'function: getTheme' => 100,
            'function: loadMenu' => 100,
            'function: setMenuItems' => 100,
            'function: loadPage' => 100,
            'function: pageExists' => 100,
            'function: createPage' => 100,
            'function: editPost' => 0,
            'function: editPost' => 0,
            'function: postRemove' => 0,
            'function: postLoad' => 0,
            'function: postExists' => 0,
            'function: postCreate' => 0,
            'function: postGetLast' => 0,
            'function: query' => 100,
        );

        $items['Databases: MySQL Database support'] = array(
            'Connection' => 0,
            'Setup database' => 0,
            'function: userExists' => 0,
            'function: userRegister' => 0,
            'function: userDelete' => 0,
            'function: userLogin' => 0,
            'function: userLoad' => 0,
            'function: setTheme' => 0,
            'function: getTheme' => 0,
            'function: loadMenu' => 0,
            'function: setMenuItems' => 0,
            'function: loadPage' => 0,
            'function: pageExists' => 0,
            'function: createPage' => 0,
            'function: editPost' => 0,
            'function: editPost' => 0,
            'function: postRemove' => 0,
            'function: postLoad' => 0,
            'function: postExists' => 0,
            'function: postCreate' => 0,
            'function: postGetLast' => 0,
            'function: query' => 0,
        );

        $items['Databases: Plain text database support'] = array(
            'Connection' => 100,
            'Setup database' => 100,
            'function: userExists' => 100,
            'function: userRegister' => 100,
            'function: userDelete' => 100,
            'function: userLogin' => 100,
            'function: userLoad' => 100,
            'function: setTheme' => 100,
            'function: getTheme' => 100,
            'function: loadMenu' => 100,
            'function: setMenuItems' => 100,
            'function: loadPage' => 100,
            'function: pageExists' => 100,
            'function: createPage' => 100,
            'function: editPost' => 100,
            'function: editPost' => 100,
            'function: postRemove' => 100,
            'function: postLoad' => 100,
            'function: postExists' => 100,
            'function: postCreate' => 100,
            'function: postGetLast' => 100,
            'function: query' => 100,
        );
        /**
         * DO NOT CHANGE AFTER THIS LINE
         */

        $page = array();
        $page[] = array(
            'Todo list.',
            'This is a todo list (static, for creating/debugging use only atm)',
        );

        foreach ($items as $title => $subitems) {
            $count = 0;
            $c_items = 0;
            $contents = sprintf('---<br />%s<br /><br />', $title);
            $contents .= '<b>**Progress**</b><br /><br /><ul>';

            foreach ($subitems as $key => $value) {
                $count = $count + $value;
                $c_items++;

                $contents .= sprintf(
                    '<li>*<progress min=0 max=100 value=%s></progress> %s%% | %s</li>',
                    $value,
                    $value,
                    $key
                );
            }

            $contents .= sprintf(
                '</ul><br />Overall progress: <progress min=0 max=%s value=%s></progress> %s/%s<br /><br />',
                $c_items * 100,
                $count,
                $count / 100,
                $c_items
            );

            $page[] = array($title, $contents);
        }

        return $page;
    }
}

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'menu',
    'TODO',
    array(
        'name' => 'TODO',
        'icon' => 'pencil',
        'url' => '/dev/TODO',
        'userlevel' => '*',
    )
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'url',
    '/dev/TODO', // Supports also /calendar/i*cs and then /calendar/ixcs works also
    array(todoExtension::sharedInstance(), '_display')
);
