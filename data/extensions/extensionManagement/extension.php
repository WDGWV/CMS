<?php
/**
 * WDGWV CMS System file.
 * Full access: true
 * Extension: Extension Managament
 * Version: 1.0
 * Description: This manages all your extensions.
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

class ExtensionList extends \WDGWV\CMS\ExtensionBase
{
    private $extensionList = array();
    /**
     * Call the sharedInstance
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Extension\extensionList();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        $this->extensionList = \WDGWV\CMS\Extensions::sharedInstance()->_displayExtensionList();
    }

    public function _forceReload()
    {
        \WDGWV\CMS\Extensions::sharedInstance()->_forceReloadExtensions();
        if (!headers_sent()) {
            header("location: /");
        }
        echo "<script>window.location='/';</script>";
        exit;
    }

    public function _display()
    {
        if (isset($_GET['reIndex'])) {
            $this->_forceReload();
        }

        \WDGWV\CMS\Hooks::sharedInstance()->createHook(
            'script',
            'Resize classes',
            "$('.col-lg-12').attr('class', 'col-lg-5');"
        );

        $page = array();
        $page[] = array(
            'Extensions list',
            'This is an extension what list all loaded extensions, it also offers a force-reload option in the bottom of the page',
        );

        for ($i = 0; $i < sizeof($this->extensionList); $i++) {
            $name = explode('/', $this->extensionList[$i])[sizeof(explode('/', $this->extensionList[$i])) - 2];

            $page1 = $this->extensionList[$i];

            $page1 .= '<table>';
            foreach (\WDGWV\CMS\Extensions::sharedInstance()->information($this->extensionList[$i]) as $info => $value) {
                if ($info === 'extension') {$name = $value;}
                $page1 .= sprintf(
                    "<tr><td>%s:</td><td>%s</td></tr>",
                    $info, htmlspecialchars($value)
                );
            };
            $page1 .= '</table>';

            $page[] = array(
                sprintf('%s extension<span class=\'right\'><button onClick="window.location=\'/%s/extensions/list?%sExtension=%s\'"%s>%s \'%s\'</button></span>',
                    $name,
                    (new \WDGWV\CMS\Config)->adminURL(),
                    (\WDGWV\CMS\Extensions::sharedInstance()->isActive($this->extensionList[$i]) ? 'disable' : 'enable'),
                    $name,
                    (\WDGWV\CMS\Extensions::sharedInstance()->isSystem($this->extensionList[$i]) ? 'disabled' : ''),
                    (\WDGWV\CMS\Extensions::sharedInstance()->isActive($this->extensionList[$i]) ? 'Disable' : 'Enable'),
                    $name
                ),
                $page1,
            );
        }

        $page[] = array(
            'Reindex extensions',
            sprintf('<a href=\'/%s/extensions/list?reIndex=now\'>Force reindex extensions</a>', (new \WDGWV\CMS\Config)->adminURL()),
        );

        return $page;
    }
}

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'menu',
    'administration/Extensions/Extension list',
    array(
        'name' => 'administration/Extensions/Extension list',
        'icon' => 'pencil',
        'url' => sprintf('/%s/extensions/list', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'menu',
    'administration/Extensions/Extension search',
    array(
        'name' => 'administration/Extensions/Extension search',
        'icon' => 'pencil',
        'url' => sprintf('/%s/extensions/search', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'url',
    sprintf('/%s/extensions/list', (new \WDGWV\CMS\Config)->adminURL()), // Supports also /calendar/i*cs and then /calendar/ixcs works also
    array(extensionList::sharedInstance(), '_display')
);

// \WDGWV\CMS\Hooks::sharedInstance()->createHook(
//     'url',
//     sprintf('/%s/extensions/reindex', (new \WDGWV\CMS\Config)->adminURL()), // Supports also /calendar/i*cs and then /calendar/ixcs works also
//     array(extensionList::sharedInstance(), '_forceReload')
// );
