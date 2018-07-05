<?php
/**
 * WDGWV CMS Extension file.
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
-       (c) WDGWV. 2018, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

namespace WDGWV\CMS\Extension; /* Module namespace */

class TodoExtension extends \WDGWV\CMS\ExtensionBase
{
    /**
     * Call the shared
     * @since Version 1.0
     */
    public static function shared()
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

        $items['Administration'] = array(
            'Extensions Administration' => 100,
            'Extensions: Enable Extension' => 100,
            'Extensions: Disable Extension' => 100,
            'Extensions: Install (via webinterface)' => 0,
            'Extensions: Edit (via web)' => 0,
            'Extensions: Search' => 0,
        );

        $items['Databases: MySQLite Database support'] = array(
            'Connection' => 100,
            'Setup database' => 100,
            'function: `\Databases\SQLite::shared()->userExists(...)`' => 100,
            'function: `\Databases\SQLite::shared()->userRegister(...)`' => 100,
            'function: `\Databases\SQLite::shared()->userDelete(...)`' => 100,
            'function: `\Databases\SQLite::shared()->userLogin(...)`' => 100,
            'function: `\Databases\SQLite::shared()->userLoad(...)`' => 100,
            'function: `\Databases\SQLite::shared()->themeSet(...)`' => 100,
            'function: `\Databases\SQLite::shared()->themeGet(...)`' => 100,
            'function: `\Databases\SQLite::shared()->menuLoad(...)`' => 100,
            'function: `\Databases\SQLite::shared()->menuSetItems(...)`' => 100,
            'function: `\Databases\SQLite::shared()->pageLoad(...)`' => 100,
            'function: `\Databases\SQLite::shared()->pageExists(...)`' => 100,
            'function: `\Databases\SQLite::shared()->pageCreate(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postEdit(...)`' => 0,
            'function: `\Databases\SQLite::shared()->postRemove(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postLoad(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postExists(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postCreate(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postGetLast(...)`' => 100,
            'function: `\Databases\SQLite::shared()->query(...)`' => 100,
        );

        $items['Databases: MySQL Database support'] = array(
            'Connection' => 0,
            'Setup database' => 0,
            'function: `\Databases\MySQL::shared()->userExists(...)`' => 0,
            'function: `\Databases\MySQL::shared()->userRegister(...)`' => 0,
            'function: `\Databases\MySQL::shared()->userDelete(...)`' => 0,
            'function: `\Databases\MySQL::shared()->userLogin(...)`' => 0,
            'function: `\Databases\MySQL::shared()->userLoad(...)`' => 0,
            'function: `\Databases\MySQL::shared()->themeSet(...)`' => 0,
            'function: `\Databases\MySQL::shared()->themeGet(...)`' => 0,
            'function: `\Databases\MySQL::shared()->menuLoad(...)`' => 0,
            'function: `\Databases\MySQL::shared()->menuSetItems(...)`' => 0,
            'function: `\Databases\MySQL::shared()->pageLoad(...)`' => 0,
            'function: `\Databases\MySQL::shared()->pageExists(...)`' => 0,
            'function: `\Databases\MySQL::shared()->pageCreate(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postEdit(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postRemove(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postLoad(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postExists(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postCreate(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postGetLast(...)`' => 0,
            'function: `\Databases\MySQL::shared()->query(...)`' => 0,
        );

        $items['Databases: Plain text database support'] = array(
            'Connection' => 100,
            'Setup database' => 100,
            'function: `\Databases\PlainText::shared()->userExists(...)`' => 100,
            'function: `\Databases\PlainText::shared()->userRegister(...)`' => 100,
            'function: `\Databases\PlainText::shared()->userDelete(...)`' => 100,
            'function: `\Databases\PlainText::shared()->userLogin(...)`' => 100,
            'function: `\Databases\PlainText::shared()->userLoad(...)`' => 100,
            'function: `\Databases\PlainText::shared()->themeSet(...)`' => 100,
            'function: `\Databases\PlainText::shared()->themeGet(...)`' => 100,
            'function: `\Databases\PlainText::shared()->menuLoad(...)`' => 100,
            'function: `\Databases\PlainText::shared()->menuSetItems(...)`' => 100,
            'function: `\Databases\PlainText::shared()->pageLoad(...)`' => 100,
            'function: `\Databases\PlainText::shared()->pageExists(...)`' => 100,
            'function: `\Databases\PlainText::shared()->pageCreate(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postEdit(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postRemove(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postLoad(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postExists(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postCreate(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postGetLast(...)`' => 100,
        );

        /**
         * DO NOT CHANGE AFTER THIS LINE
         */

        $page = array();
        $page[] = array(
            'CMS Progress',
            '---<br /><br />This is a todo list (static, for creating/debugging use only atm)',
        );

        $allItemsCount = 0;
        $allItemsProgress = 0;

        foreach ($items as $title => $subitems) {
            $count = 0;
            $c_items = 0;
            $contents = sprintf('---<br />%s<br /><br />', $title);
            $contents .= '<b>**Progress**</b><br /><br /><ul>';

            foreach ($subitems as $key => $value) {
                $allItemsCount++;
                $allItemsProgress = $allItemsProgress + $value;

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

        $calcItems = $allItemsProgress / 100;
        $calcProgress = round(($calcItems / $allItemsCount) * 100);

        $page[0][1] = "---<br /><br />Overall progress: {$calcItems} of {$allItemsCount} items = {$calcProgress}%<br /><br />";

        return $page;
    }
}

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'administration/Todo/Create',
    array(
        'name' => 'administration/Todo/Create',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Todo/Create', ADMIN_URL),
        'userlevel' => '*',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'administration/Todo/Remove',
    array(
        'name' => 'administration/Todo/Remove',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Todo/Remove/*', ADMIN_URL),
        'userlevel' => '*',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'TODO',
    array(
        'name' => 'TODO',
        'icon' => 'pencil',
        'url' => '/dev/TODO',
        'userlevel' => '*',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    '/dev/TODO', // Supports also /calendar/i*cs and then /calendar/ixcs works also
    array(todoExtension::shared(), '_display')
);
