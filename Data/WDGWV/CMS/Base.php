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
-       (c) WDGWV. 2018, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

class Base extends \WDGWV\General\WDGWV
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
    public static function shared()
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
        /**
         * Load the emulators in memory.
         * @var array emulation
         */
        $this->emulation = array(
            /* initialize Blogger emulation engine */
            'Blogger' => new \WDGWV\CMS\Emulation\Blogger(),
            /* initialize WordPress emulation engine */
            'WordPress' => new \WDGWV\CMS\Emulation\WordPress(),
        );

        /**
         * Do we have a custom configuration
         */
        if ($customConfiguration != false) {
            /**
             * Use custom configuration
             */
            $this->config = $customConfiguration;
        } else {
            /**
             * Use default configuration
             */
            $this->config = new \WDGWV\CMS\Config();
        }

        /**
         * Init hooks, and walk trough the hooks
         */
        \WDGWV\CMS\Hooks::shared()->loopHooks(
            array(
                /* Walk trough $_GET */
                'get',
                /* Walk trough $_POST */
                'post',
                /* Walk trough $_SERVER */
                'url',
            )
        );
    }

    /**
     * Database
     * @since Version 1.0
     * @return Object Database
     */
    public function database()
    {
        /**
         * Inifialize the database controller
         */
        return \WDGWV\CMS\Controllers\Databases\Controller::shared();
    }

    /**
     * Menu
     * @since Version 1.0
     * @return array menu
     */
    public function menu()
    {
        /**
         * Get menu values
         */
        return $this->config->menu();
    }

    /**
     * themeGet
     * @since Version 1.0
     * @return string theme
     */
    public function themeGet()
    {
        /**
         * get current theme
         */
        return $this->config->theme();
    }

    /**
     * getPageName
     * @since Version 1.0
     * @return string page name
     */
    public function getPageName()
    {
        /**
         * Get page name (not used, only for WordPress emulation)
         */
        return $this->config->pagename();
    }

    /**
     * getTitle
     * @since Version 1.0
     * @return string 'WDGWV CMS'
     */
    public function getTitle()
    {
        /**
         * Get page title (not used, only for WordPress emulation)
         */
        return 'WDGWV CMS'; // Wordpress....
    }

    /**
     * maintenanceMode
     * @since Version 1.0
     * @return bool false (needs to be database powered)
     */
    public function maintenanceMode()
    {
        /**
         * Is Maintenance mode enabled?
         */
        return false; //TODO: From database
    }

    /**
     * singlePage
     * @since Version 1.0
     * @return bool false (needs to be database powered)
     */
    public function singlePage()
    {
        /**
         * Is single page mode enabled?
         */
        return false; //TODO: From database
    }

    /**
     * getDescription
     * @since Version 1.0
     * @return string 'testing!'
     */
    public function getDescription()
    {
        /**
         * Get page description (not used, only for WordPress emulation)
         */
        return 'testing!'; //TODO: From database
    }

    /**
     * getSlogan
     * @since Version 1.0
     * @return string 'test'
     */
    public function getSlogan()
    {
        /**
         * Get page slogan (not used, only for WordPress emulation)
         */
        return 'test'; //TODO: From database
    }

    /**
     * getContent
     * @since Version 1.0
     * @return string 'Page'
     */
    public function getContent()
    {
        /**
         * Get page contents (not used, only for WordPress emulation)
         */
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
            /* Copyright © YEAR SITENAME */
            '%s&#32;&#169;&#32;%s&#32;%s&#32;%s&#32;' .

            /* Powered by WDGWV CMS */
            '<a href=\'&#104;&#116;&#116;&#112;&#115;&#58;&#47;&#47;&#119;&#119;&#119;&#46;&#119;&#100;' .
            '&#103;&#119;&#118;&#46;&#99;&#111;&#109;&#47;&#112;&#114;&#111;&#100;&#117;&#99;&#116;&#115;' .
            '&#47;&#99;&#109;&#115;\' target=\'_blank\'>' .
            '&#87;&#68;&#71;&#87;&#86;&#32;&#67;&#77;&#83;</a>,&#32;' .

            /* All Rights reserved */
            '%s&#46;',
            /* Copyright */
            $this->h(function_exists('__') ? \__('Copyright') : ('Copyright')),
            /* YEAR */
            $this->h(@date('Y')),
            /* Title */
            $this->h($this->getTitle()),
            /* Powered by */
            $this->h(function_exists('__') ? \__('Powered by') : ('Powered by')),
            /* All rights reserved */
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
        /**
         * Load global database
         */
        global $database;

        /**
         * Check if current theme is an ... theme
         */
        if ($this->emulation['Blogger']->isBlogger($this->themeGet())) {
            /**
             * Check if current theme is an Blogger theme,
             * then parse the theme with a Blogger emulation engine
             */
            $this->emulation['Blogger']->blogger(
                /**
                 * Current theme
                 */
                $this->themeGet()
            );
        } elseif ($this->emulation['WordPress']->isWordpress($this->themeGet())) {
            /**
             * Check if theme is a WordPress theme,
             * then parse it with a WordPress emulation engine.
             */
            $this->emulation['WordPress']->wordpress(
                /**
                 * Current theme
                 */
                $this->themeGet()
            );
        } else {
            /**
             * Check if the theme is a WDGWV CMS theme,
             * then parse it with the WDGWV CMS template parser
             */

            /**
             * Templateparser
             * @var class
             */
            $parser = new \WDGWV\General\TemplateParser(
                /* debug mode */
                $this->config->debug,
                /* CDN */
                null,
                /* CMS Template directory */
                CMS_TEMPLATE_DIR
            );

            /**
             * Initialize pageController
             * @var class
             */
            $pageController = new \WDGWV\CMS\Controllers\Page(
                /* Template Parser Class */
                $parser,
                /* parent class ($this) */
                $this,
                /* database class */
                $database
            );

            /**
             * Set parameters to '{ITEM:' and '}'
             * e.g. {ITEM:testItem}
             */
            $parser->setParameter(
                '{ITEM:',
                '}'
            );

            /**
             * Set the current theme.
             */
            $parser->setTemplate(
                /* Get current theme */
                $this->themeGet(),
                /* template extension (html) */
                'html',
                /* Data container for files */
                '/Data/Themes/' . $this->themeGet() . '/'
            );

            /**
             * Bind parameter {ITEM:year} to the current year
             */
            $parser->bindParameter(
                'year',
                @date('Y')
            );

            /**
             * Bind parameter {ITEM:SITE_TITLE} to the current site title
             */
            $parser->bindParameter(
                'SITE_TITLE',
                $this->getTitle()
            );

            /**
             * Bind parameter {ITEM:copyright} to the copyright string
             */
            $parser->bindParameter(
                'copyright',
                $this->getFooter()
            );

            /**
             * Set menu contents
             */
            $parser->setMenuContents(
                /* load menu from database */
                $database->menuLoad()
            );

            /**
             * Display the page (to the parser)
             */
            $pageController->displayPage();

            /**
             * Parser display to the screen please!
             */
            $parser->display();

            /**
             * Walk trough the last hooks (script)
             */
            if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('script')) {
                /**
                 * Walk trough the script hooks
                 */
                foreach (\WDGWV\CMS\Hooks::shared()->loopHooks('script') as $script) {
                    /**
                     * Print them to the page!
                     */
                    echo sprintf(
                        '<script type=\'text/javascript\'>%s</script>',
                        $script
                    );
                }
            }

            /**
             * Did the parser display?
             */
            if ($parser->didDisplay()) {
                /**
                 * Nothing displayed, theme does not exists.
                 */
                echo "THEME " . $this->themeGet() . " Does not exists!";
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
        /**
         * Create a temporary out string
         * @var string
         */
        $out = '';

        /**
         * Walk trough the string
         */
        for ($i = 0; isset($s[$i]); $i++) {
            /**
             * Append to the temporary string
             */
            $out .= sprintf(
                '&#%s;',
                ord($s[$i])
            );
        }

        /**
         * Return encoded string.
         */
        return $out;
    }
}
