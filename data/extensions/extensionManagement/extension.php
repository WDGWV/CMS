<?php
/**
 * WDGWV CMS System file.
 * Full access: true
 * Extension: Extension Managament System
 * Version: 1.0
 * Description: This manages all your extensions.
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

class ExtensionMananagamentSystem extends \WDGWV\CMS\ExtensionBase
{
    private $extensionList = array();
    private $extensionCtrl;

    /**
     * Call the sharedInstance
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Extension\ExtensionMananagamentSystem();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        $this->extensionCtrl = \WDGWV\CMS\Extensions::sharedInstance();
        $this->extensionList = \WDGWV\CMS\Extensions::sharedInstance()->_displayExtensionList();
    }

    public function display()
    {
        if (isset($_GET['reIndex'])) {
            \WDGWV\CMS\Extensions::sharedInstance()->forceReloadExtensions();

            if (!headers_sent()) {
                header(
                    sprintf(
                        "location: %s",
                        sprintf('/%s/extensions/list', (new \WDGWV\CMS\Config)->adminURL())
                    )
                );
            }
            echo sprintf(
                "<script>window.location='%s';</script>",
                sprintf('/%s/extensions/list', (new \WDGWV\CMS\Config)->adminURL())
            );
            exit;
        }

        if (isset($_GET['enableExtension'])) {
            $this->extensionCtrl->enableExtension($_GET['enableExtension']);
        }

        if (isset($_GET['disableExtension'])) {
            $this->extensionCtrl->disableExtension($_GET['disableExtension']);
        }

        \WDGWV\CMS\Hooks::sharedInstance()->createHook(
            'script',
            'Resize classes',
            "$('.col-lg-12').attr('class', 'col-lg-5');"
        );

        $page = array();
        $page[] = array(
            'Extensions list',
            'This is an extension what list all loaded extensions, ' .
            'it also offers a force-reload option in the bottom of the page',
        );

        for ($i = 0; $i < sizeof($this->extensionList); $i++) {
            $name = explode('/', $this->extensionList[$i]);
            $name = $name[sizeof(explode('/', $this->extensionList[$i])) - 2];

            $page1 = $this->extensionList[$i];

            $page1 .= '<table>';
            foreach ($this->extensionCtrl->information($this->extensionList[$i]) as $info => $value) {
                if ($info === 'extension') {
                    $name = $value;
                }

                $page1 .= sprintf(
                    "<tr><td>%s:</td><td>%s</td></tr>",
                    $info,
                    htmlspecialchars($value)
                );
            };
            $page1 .= '</table>';

            $page[] = array(
                sprintf(
                    '%s<span class=\'right\'>' .
                    '<button onClick="window.location=\'/%s/%s/list?%sExtension=%s\'"%s>%s \'%s\'</button></span>',
                    $name,
                    (new \WDGWV\CMS\Config)->adminURL(),
                    'extensions',
                    ($this->extensionCtrl->isActive($this->extensionList[$i])
                        ? 'disable'
                        : 'enable'
                    ),
                    $this->extensionList[$i],
                    ($this->extensionCtrl->isSystem($this->extensionList[$i])
                        ? 'disabled'
                        : ''
                    ),
                    ($this->extensionCtrl->isActive($this->extensionList[$i])
                        ? 'Disable'
                        : 'Enable'
                    ),
                    $name
                ),
                $page1,
            );
        }

        $page[] = array(
            'Reindex extensions',
            sprintf(
                '<a href=\'/%s/extensions/list?reIndex=now\'>Force reindex extensions</a>',
                (new \WDGWV\CMS\Config)->adminURL()
            ),
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
    sprintf('/%s/extensions/list', (new \WDGWV\CMS\Config)->adminURL()),
    array(ExtensionMananagamentSystem::sharedInstance(), 'display')
);
