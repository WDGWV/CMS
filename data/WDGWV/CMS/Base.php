<?php
namespace WDGWV\CMS;

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

class Base extends \WDGWV\General\WDGWVFramework
{
    /**
     * The configuration
     * @global
     * @access private
     * @var mixed[] The configuration
     * @since Version 1.0
     */
    private $config;

    /**
     * The emulation controllers
     * @global
     * @access private
     * @var object[] Emulation controllers
     * @since Version 1.0
     */
    private $emulation;

    /**
     * Call the database
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Base();
        }
        return $inst;
    }

    /**
     * Construct
     * @param array $customConfiguration CustomConfiguration
     * @since Version 1.0
     * @return void
     */
    public function __construct($customConfiguration = false)
    {
        $this->emulation = array(
            'Blogger' => new \WDGWV\CMS\Emulation\Blogger(),
            'WordPress' => new \WDGWV\CMS\Emulation\WordPress(),
        );

        if ($customConfiguration != false) {
            $this->config = $customConfiguration;
        } else {
            $this->config = new \WDGWV\CMS\Config();
        }

        \WDGWV\CMS\Hooks::sharedInstance()->loopHooks(array('get', 'post', 'url'));
    }

    /**
     * Database
     * @since Version 1.0
     * @return Object Database
     */
    public function database()
    {
        return \WDGWV\CMS\Controllers\Databases\Controller::sharedInstance();
    }

    /**
     * Menu
     * @since Version 1.0
     * @return array menu
     */
    public function menu()
    {
        return $this->config->menu();
    }

    /**
     * getTheme
     * @since Version 1.0
     * @return string theme
     */
    public function getTheme()
    {
        return $this->config->theme();
    }

    /**
     * getPageName
     * @since Version 1.0
     * @return string page name
     */
    public function getPageName()
    {
        return $this->config->pagename();
    }

    /**
     * getTitle
     * @since Version 1.0
     * @return string 'WDGWV CMS'
     */
    public function getTitle()
    {
        return 'WDGWV CMS'; // Wordpress....
    }

    /**
     * maintenanceMode
     * @since Version 1.0
     * @return bool false (needs to be database powered)
     */
    public function maintenanceMode()
    {
        return false; //TODO: From database
    }

    /**
     * singlePage
     * @since Version 1.0
     * @return bool false (needs to be database powered)
     */
    public function singlePage()
    {
        return false; //TODO: From database
    }

    /**
     * getDescription
     * @since Version 1.0
     * @return string 'testing!'
     */
    public function getDescription()
    {
        return 'testing!'; //TODO: From database
    }

    /**
     * getSlogan
     * @since Version 1.0
     * @return string 'test'
     */
    public function getSlogan()
    {
        return 'test'; //TODO: From database
    }

    /**
     * getContent
     * @since Version 1.0
     * @return string 'Page'
     */
    public function getContent()
    {
        //TODO: From Controllers/page
        return 'Sorry, i will come later';
    }

    /**
     * getFooter
     * @since Version 1.0
     * @return string 'Copyright YEAR PAGENAME, Powered by WDGWV CMS. All rights reserved'
     */
    public function getFooter()
    {
        return sprintf(
            '%s&#32;&#169;&#32;%s&#32;%s&#32;%s&#32;<a href=\'https://www.wdgwv.com/products/cms\' target=\'_blank\'>&#87;&#68;&#71;&#87;&#86;&#32;&#67;&#77;&#83;</a>,&#32;%s&#46;',
            $this->h(function_exists('__') ? \__('Copyright') : ('Copyright')),
            $this->h(@date('Y')),
            $this->h($this->getTitle()),
            $this->h(function_exists('__') ? \__('Powered by') : ('Powered by')),
            $this->h(function_exists('__') ? \__('All rights reserved') : ('All rights reserved'))
        );
    }

    /**
     * Serve
     * Serve the page
     *
     * @since Version 1.0
     * @return void
     */
    public function serve()
    {
        global $database;
        if ($this->emulation['Blogger']->isBlogger($this->getTheme())) {
            $this->emulation['Blogger']->blogger(
                $this->getTheme()
            );
        } elseif ($this->emulation['WordPress']->isWordpress($this->getTheme())) {
            $this->emulation['WordPress']->wordpress(
                $this->getTheme()
            );
        } else {
            $parser = new \WDGWV\General\TemplateParser(
                $this->config->debug,
                null,
                CMS_TEMPLATE_DIR
            );

            $pageController = new \WDGWV\CMS\Controllers\Page(
                $parser,
                $this,
                $database
            );

            $parser->setParameter(
                '{ITEM:',
                '}'
            );

            $parser->setTemplate(
                $this->getTheme(),
                'html',
                '/data/themes/' . $this->getTheme() . '/'
            );

            $parser->bindParameter('year', @date('Y'));

            $parser->bindParameter('SITE_TITLE', $this->getTitle());

            $parser->bindParameter('copyright', $this->getFooter());

            $parser->setMenuContents($database->loadMenu());

            $pageController->displayPage();

            $parser->display();

            if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('script')) {
                foreach (\WDGWV\CMS\Hooks::sharedInstance()->loopHooks('script') as $script) {
                    echo sprintf(
                        '<script type=\'text/javascript\'>%s</script>',
                        $script
                    );
                }
            }

            if ($parser->didDisplay()) {
                echo "THEME " . $this->getTheme() . " Does not exists!";
            }
        }
    }

    /**
     * h
     * CHR to ORD. (&#ORD;) for HTML-encoded messages.
     * @param string $s String to encode
     * @since Version 1.0
     * @return string encoded string
     */
    private function h($s)
    {
        $out = '';
        for ($i = 0;isset($s[$i]); $i++) {
            $x = ord($s[$i]);
            $out .= '&#' . $x . ';';
        }
        return $out;
    }
}
