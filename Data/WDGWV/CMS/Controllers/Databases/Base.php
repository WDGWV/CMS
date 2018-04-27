<?php
namespace WDGWV\CMS\Controllers\Databases;

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

class Base
{
    private $CMSConfig = null;
    public static $baseInit = false;

    protected function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->CMSConfig = (new \WDGWV\CMS\Config());

        if (isset($_GET['resetDatabase']) && $this->CMSConfig->debug) {
            echo "Resetting database";
            $adminURL = $this->CMSConfig->adminURL();
            array_map('unlink', glob('./Data/Database/*.PTdb'));

            if (!headers_sent()) {
                header(sprintf('location: /%s/?db=clean&debug=true', $adminURL));
            }

            echo sprintf('<script>window.location=\'/%s/?db=clean&debug=true\';</script>', $adminURL);
        }
    }

    protected function noop()
    {
        return;
    }

    protected function generateUserDB()
    {
        return array(array(
            'username' => 'System', /* Dummy account. impossible to login to it. */
            'password' => hash('sha256', 'System@' . time() . '@' . uniqid()),
            'userlevel' => 'system',
            'is_activated' => false,
            'email' => 'CMS@wdgwv.com',
        ));
    }

    protected function generateSystemDB()
    {
        return array(
            'installed' => time(),
            'theme' => 'admin',
            'language' => 'en_US',
            'userlevels' => array(
                'guest',
                'member',
                'vip',
                'moderator',
                'writer',
                'custom',
                'developer',
                'admin',
                'root',
                'system',
            ),
        );
    }

    protected function generateMenuDB()
    {
        if (!isset($this->CMSConfig)) {
            $this->CMSConfig = (new \WDGWV\CMS\Config());
        }

        return array(
            array(
                'name' => 'Home',
                'icon' => 'home',
                'url' => '/Home',
                'userlevel' => '*',
                'submenu' => null,
            ),
            array(
                'name' => 'Blog',
                'icon' => 'pencil',
                'url' => '/blog',
                'userlevel' => '*',
                'submenu' => array(
                    array(
                        'name' => 'Blog',
                        'url' => '/blog',
                        'icon' => 'pencil',
                    ),
                    array(
                        'name' => 'Last post',
                        'url' => '/blog/last',
                        'icon' => 'rss',
                    ),
                ),
            ),
            array(
                'name' => 'Administration',
                'url' => '#',
                'icon' => 'cogs',
                'userlevel' => 'moderator',
                'submenu' => array(
                    ($this->CMSConfig->debug) ? array(
                        'name' => 'reset DB',
                        'url' => sprintf('/%s/resetDatabase?resetDatabase', $this->CMSConfig->adminURL()),
                    ) : $this->noop(),

                    array(
                        'name' => ' ',
                    ),

                    ($this->CMSConfig->debug) ? array(
                        'name' => 'Theme = portal',
                        'url' => sprintf('/%s/setTheme/portal', $this->CMSConfig->adminURL()),
                    ) : $this->noop(),
                    ($this->CMSConfig->debug) ? array(
                        'name' => 'Theme = admin',
                        'url' => sprintf('/%s/setTheme/admin', $this->CMSConfig->adminURL()),
                    ) : $this->noop(),
                ), //.. later
            ),
            array(
                'name' => 'About',
                'url' => '/about',
                'icon' => 'address-card',
            ),
        );
    }
}
