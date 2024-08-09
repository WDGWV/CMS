<?php

/**
 * WDGWV CMS Required file.
 * Extension: Update
 * Version: 1.0
 * Description: Updates WDGWV CMS
 * Hash: 11c42e0dc55087544c3c68eca7b4d679
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

namespace WDGWV\CMS\Extension; /* Module namespace */

class Update extends \WDGWV\CMS\ExtensionBase
{
    /**
     * @var string
     */
    private $updateURL = "https://www.wdgwv.com/upd/cms/?version=%s&module=%s&modver=%s";

    /**
     * @var array
     */
    private $extensionList = array();

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
            $inst = new \WDGWV\CMS\Extension\update();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        // Read cached Extensions, if they exists, otherwise, skip.
        $this->extensionList = \WDGWV\CMS\Extensions::shared()->displayExtensionList();
        $this->updateURL = '';
        $this->extensionList = $this->updateURL;
    }

    public function reload()
    {
        \WDGWV\CMS\Extensions::shared()->forceReloadExtensions();
        if (!headers_sent()) {
            header("location: /");
        }
        echo "<script>window.location='/';</script>";
        exit;
    }

    /**
     * @return mixed
     */
    public function display()
    {
        $page = array();
        $page[] = array(
            'Test extension: \'update\'.',
            'This is an example of a test extension, which adds an item to the menu, and can display a page.<br />And many more!' .
                'to use localization use \__(\'the string which need to be translated\')'
        );

        if (is_array($this->extensionList)) {
            for ($i = 0; $i < sizeof($this->extensionList); $i++) {
                $page1 = $this->extensionList[$i];
                $page1 .= '<table>';
                foreach (\WDGWV\CMS\Extensions::shared()->information($this->extensionList[$i]) as $info => $value) {
                    $page1 .= sprintf("<tr><td>%s:</td><td>%s</td></tr>", $info, htmlspecialchars($value));
                };
                $page1 .= '</table>';

                $page[] = array($this->extensionList[$i], $page1);
            }
        }

        $page[] = array('reindex', sprintf('<a href=\'/%s/extensions/reindex\'>Force reindex extensions</a>', (new \WDGWV\CMS\Config)->adminURL()));

        return $page;
    }
}

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'administration/ ',
    array(
        'name' => 'Administration/ ',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'administration/update',
    array(
        'name' => 'Administration/Update (1)',
        'icon' => 'cogs',
        'url' => sprintf('/%s/update', (new \WDGWV\CMS\Config)->adminURL()),
        'userlevel' => 'admin',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    sprintf('/%s/update', (new \WDGWV\CMS\Config)->adminURL()),
    /* Supports also /calendar/i*cs and then /calendar/ixcs works also */
    array(update::shared(), 'display')
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    sprintf('/%s/extensions/reindex', (new \WDGWV\CMS\Config)->adminURL()),
    /* Supports also /calendar/i*cs and then /calendar/ixcs works also */
    array(update::shared(), 'reload')
);
