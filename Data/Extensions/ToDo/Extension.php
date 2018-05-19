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
            'function: `\Databases\SQLite::sharedInstance()->userExists(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->userRegister(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->userDelete(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->userLogin(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->userLoad(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->themeSet(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->themeGet(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->menuLoad(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->menuSetItems(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->pageLoad(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->pageExists(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->pageCreate(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->postEdit(...)`' => 0,
            'function: `\Databases\SQLite::sharedInstance()->postRemove(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->postLoad(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->postExists(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->postCreate(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->postGetLast(...)`' => 100,
            'function: `\Databases\SQLite::sharedInstance()->query(...)`' => 100,
        );

        $items['Databases: MySQL Database support'] = array(
            'Connection' => 0,
            'Setup database' => 0,
            'function: `\Databases\MySQL::sharedInstance()->userExists(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->userRegister(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->userDelete(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->userLogin(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->userLoad(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->themeSet(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->themeGet(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->menuLoad(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->menuSetItems(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->pageLoad(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->pageExists(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->pageCreate(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->postEdit(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->postRemove(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->postLoad(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->postExists(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->postCreate(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->postGetLast(...)`' => 0,
            'function: `\Databases\MySQL::sharedInstance()->query(...)`' => 0,
        );

        $items['Databases: Plain text database support'] = array(
            'Connection' => 100,
            'Setup database' => 100,
            'function: `\Databases\PlainText::sharedInstance()->userExists(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->userRegister(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->userDelete(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->userLogin(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->userLoad(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->themeSet(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->themeGet(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->menuLoad(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->menuSetItems(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->pageLoad(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->pageExists(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->pageCreate(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->postEdit(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->postRemove(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->postLoad(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->postExists(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->postCreate(...)`' => 100,
            'function: `\Databases\PlainText::sharedInstance()->postGetLast(...)`' => 100,
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

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'menu',
    'administration/Todo/Create',
    array(
        'name' => 'administration/Todo/Create',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Todo/Create', ADMIN_URL),
        'userlevel' => '*',
    )
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'menu',
    'administration/Todo/Remove',
    array(
        'name' => 'administration/Todo/Remove',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Todo/Remove/*', ADMIN_URL),
        'userlevel' => '*',
    )
);

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
