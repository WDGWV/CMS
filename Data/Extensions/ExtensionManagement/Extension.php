<?php
/**
 * WDGWV CMS System file.
 * Extension: Extension Management
 * Version: 1.0
 * Description: This manages all your extensions.
 * Hash: 315157b3e590bb069aba2e62eb71773a
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

class ExtensionMananagament extends \WDGWV\CMS\ExtensionBase
{
    private $extensionList = array();
    private $extensionCtrl;

    /**
     * Call the shared
     * @since Version 1.0
     */
    public static function shared()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Extension\ExtensionMananagament();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        $this->extensionCtrl = \WDGWV\CMS\Extensions::shared();
        $this->extensionList = \WDGWV\CMS\Extensions::shared()->displayExtensionList();
    }

    public function displayList()
    {
        if (isset($_GET['reIndex'])) {
            \WDGWV\CMS\Extensions::shared()->forceReloadExtensions();

            if (!headers_sent()) {
                header(
                    sprintf(
                        "location: %s",
                        sprintf('/%s/Extensions/List', (new \WDGWV\CMS\Config)->adminURL())
                    )
                );
            }
            echo sprintf(
                "<script>window.location='%s';</script>",
                sprintf('/%s/Extensions/List', (new \WDGWV\CMS\Config)->adminURL())
            );
            exit;
        }

        if (isset($_GET['enableExtension'])) {
            $this->extensionCtrl->enableExtension($_GET['enableExtension']);
        }

        if (isset($_GET['disableExtension'])) {
            $this->extensionCtrl->disableExtension($_GET['disableExtension']);
        }

        \WDGWV\CMS\Hooks::shared()->createHook(
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
                $extra_begin = '';
                $extra_end = '';

                if ($info === 'hash') {
                    if ($this->extensionCtrl->checkHash($this->extensionList[$i], $value)) {
                        $info = 'Hash<sup>✅</sup>';
                        $value = 'Correct hash';
                    } else {
                        $info = 'Hash<sup>⚠️</sup>';
                        $value = 'Incorrect hash';

                        $extra_end .= '<hr />⚠️ Warning this module is potential unsafe,<br />Please click \'reinstall\' to reinstall the module from the gallery';
                    }
                }

                if ($info === 'integrity_check') {
                    $value = '';
                    if ($this->extensionCtrl->integrityCheck($name)) {
                        $info = 'Integrity check<sup>✅</sup>';
                        $extra_begin .= '✅';
                    } else {
                        $info = 'Integrity check<sup>🚫</sup>';
                        if (\WDGWV\CMS\Config::shared()->debug()) {
                            $extra_begin .= '<b>Debugmode activated</b>,&nbsp;if you know what you\'re doing,&nbsp;ignore this message';
                        } else {
                            $extra_begin .= '⚠️ Warning this module is unsafe,<br /><b>for security reasons it\'s disabled now</b><br />Please click \'reinstall\' to reinstall the module from the gallery';
                            $this->extensionCtrl->disableExtension($this->extensionList[$i]);
                        }
                        $extra_end .= '';
                    }

                    $extra_begin .= '&nbsp;';
                }

                $page1 .= sprintf(
                    "<tr><td>%s:</td><td>%s%s%s</td></tr>",
                    $info,
                    $extra_begin,
                    htmlspecialchars($value),
                    $extra_end
                );
            };
            $page1 .= '</table>';

            $page[] = array(
                sprintf(
                    '%s<span class=\'right\'>' .
                    '<button onClick="window.location=\'/%s/%s/List?%sExtension=%s\'"%s>%s \'%s\'</button></span>',
                    $name,
                    (new \WDGWV\CMS\Config)->adminURL(),
                    'Extensions',
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
                '<a href=\'/%s/Extensions/List?reIndex=now\'>Force reindex extensions</a>',
                (new \WDGWV\CMS\Config)->adminURL()
            ),
        );

        return $page;
    }

    public function displaySearch()
    {
        return array("TITLE", 'CONTENTS');
    }

    public function install($url)
    {
        return array("TITLE", 'CONTENTS ' . var_dump($url));
    }
}

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'administration/Extensions/List',
    array(
        'name' => 'administration/Extensions/List',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Extensions/List', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'administration/Extensions/Search',
    array(
        'name' => 'administration/Extensions/Search',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Extensions/Search', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    sprintf('/%s/Extensions/List', (new \WDGWV\CMS\Config)->adminURL()),
    array(ExtensionMananagament::shared(), 'displayList')
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    sprintf('/%s/Extensions/Search', (new \WDGWV\CMS\Config)->adminURL()),
    array(ExtensionMananagament::shared(), 'displaySearch')
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    sprintf('/%s/Extensions/Install/*', (new \WDGWV\CMS\Config)->adminURL()),
    array(ExtensionMananagament::shared(), 'install')
);
