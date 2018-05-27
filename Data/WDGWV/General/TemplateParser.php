<?php
/**
 * WDGWV Template Parser
 */

namespace WDGWV\General;

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

/**
 * WDGWV Template Parser
 *
 * This is the WDGWV Template Parser class
 *
 * @version Version 2.0
 * @author Wesley de Groot / WDGWV
 * @copyright 2017 Wesley de Groot / WDGWV
 * @package WDGWV
 * @subpackage General
 * @link http://www.wesleydegroot.nl © Wesley de Groot
 * @link https://www.wdgwv.com © WDGWV
 */
class TemplateParser extends WDGWV
{
    /**
     * Version number
     * @var string version The version number
     */
    const VERSION = "2.0";

    /**
     * The configuration
     * @global
     * @access private
     * @var string[] The configuration
     * @since Version 1.0
     */
    private $config;

    /**
     * The current file
     * @global
     * @access private
     * @var string[] The current file info
     * @since Version 2.0
     */
    private $file;

    /**
     * The Parameters
     *
     * @global
     * @access private
     * @since Version 1.0
     * @var string[] parameters[array]
     */
    private $parameters;

    /**
     * Temporary Parameters
     *
     * @global
     * @access private
     * @since Version 1.0
     * @var string[] tParameters[array]
     */
    private $tParameters;

    /**
     * The unique identifier
     *
     * @global
     * @access private
     * @since Version 1.0
     * @var int Unique identifier
     */
    private $uniid;

    /**
     * Construct the class
     * @param string $debug Debug&Minify the output
     * @param string $CDN If you use a CDN put the full url to the files here.
     * @param string $templateDirectory The template directory
     * @since Version 2.0 (Improved)
     */
    public function __construct($debug = false, $CDN = null, $templateDirectory = "./Data/Template/")
    {
        $this->ready = false;
        $this->file = array();
        $this->config = array();
        $this->config['CDN'] = $CDN; // By default Content Delivery Network = off.
        $this->config['templateDirectory'] = $templateDirectory;
        $this->config['external'] = !class_exists("WDGWV") ? true : false;
        $this->config['hidecomments'] = !$debug;
        $this->config['minify'] = !$debug;
        $this->config['debug'] = $debug;
        $this->parameters = array();

        /**
         * If class \WDGWV\CMS\Debugger exists.
         * set $this->debugger
         */
        if (class_exists("\WDGWV\CMS\Debugger")) {
            /**
             * Debugger
             * @var class debugger class
             */
            $this->debugger = \WDGWV\CMS\Debugger::sharedInstance();
        }
    }

    /**
     * Desctruct the class
     * @since Version 1.0
     * @internal
     */
    public function __destruct()
    {
    }

    /**
     * Set the template.
     *
     * @param string $templateFile The template directory
     * @param string $TemplateFileExtension The extension
     * @access public
     * @since Version 2.0 (Improved)
     */
    public function setTemplate($templateFile = 'default', $TemplateFileExtension = 'tpl', $fileURL = "/assets/")
    {
        if (file_exists(
            $f = $this->config['templateDirectory'] . $templateFile . "/theme." . $TemplateFileExtension
        )
        ) {
            $this->config['theme'] = $templateFile;
            $this->config['themeExtension'] = $TemplateFileExtension;
            $this->config['templateFiles'] = $fileURL;
            $this->ready = true;
        } else {
            $this->fatalError('The template file ' . $f . ' does not exists');
            $this->ready = false;
        }
    }

    /**
     * Set Right Column value
     *
     * @param string[] $menuContents The template directory
     * @access public
     * @since Version 2.0
     */
    public function setRightColumn($columnContents)
    {
        /**
         * If got some column contents.
         */
        if (is_array($columnContents)) {
            /**
             * If not exists $this->config['columnContents']
             * then create it
             */
            if (!isset($this->config['columnContents'])) {
                /**
                 * Create $this->config['columnContents']
                 * @var [string] column contents
                 */
                $this->config['columnContents'] = array();
            }

            /**
             * Set right column contents
             */
            $this->config['columnContents']['right'] = $columnContents;
        }
    }

    /**
     * Set Left Column value
     *
     * @param string[] $menuContents The template directory
     * @access public
     * @since Version 2.0
     */
    public function setLeftColumn($columnContents)
    {
        /**
         * If got some column contents.
         */
        if (is_array($columnContents)) {
            /**
             * If not exists $this->config['columnContents']
             * then create it
             */
            if (!isset($this->config['columnContents'])) {
                /**
                 * Create $this->config['columnContents']
                 * @var [string] column contents
                 */
                $this->config['columnContents'] = array();
            }

            /**
             * Set right column contents
             */
            $this->config['columnContents']['left'] = $columnContents;
        }
    }

    /**
     * Set Menu Contents
     *
     * @param string[] $menuContents The template directory
     * @access public
     * @since Version 2.0
     */
    public function setMenuContents($menuContents)
    {
        /**
         * If $menuContents is an array then set it.
         */
        if (is_array($menuContents)) {
            /**
             * Set $this->config['menuContents']
             * @var string menu contents
             */
            $this->config['menuContents'] = $menuContents;
        }
    }

    /**
     * Set parameter config.
     *
     * @param string $parameterStart The starting parameter
     * @param string $parameterEnd The ending parameter
     * @access public
     * @since Version 2.0
     */
    public function setParameter($parameterStart = "\{WDGWV:", $parameterEnd = "\}")
    {
        /**
         * Set the parsing parameter
         * @var [string] parsing parameter
         */
        $this->config['parameter'] = array($parameterStart, $parameterEnd);
    }

    /**
     * Set parameter config.
     *
     * @param string $parameterStart The starting parameter
     * @param string $parameterEnd The ending parameter
     * @deprecated 2.0
     * @access public
     * @since Version 1.0
     */
    public function setParameterStart($parameterStart = "\{WDGWV:", $parameterEnd = "\}")
    {
        /**
         * Deprecated do not use anymore
         */
        \E_USER_ERROR('setParameterStart is deprecated. use setParameter');

        /**
         * Set the parsing parameter
         * @var [string] parsing parameter
         */
        $this->config['parameter'] = array($parameterStart, $parameterEnd);
    }

    /**
     * Bind a parameter.
     *
     * @param string $parameter What parameter to replace
     * @param string $replaceWith Replace with this
     * @access public
     * @since Version 2.0
     */
    public function bindParameter($parameter, $replaceWith)
    {
        /**
         * If isset $this debugger...
         */
        if (isset($this->debugger)) {
            /**
             * Checks if $replaceWith is an array.
             */
            if (!is_array($replaceWith)) {
                /**
                 * Log default parameter
                 */
                $this->debugger->log(
                    sprintf(
                        'Adding parameter \'%s\' => \'%s\'.',
                        $parameter,
                        $replaceWith
                    )
                );
            } else {
                /**
                 * Log JSON parameter
                 */
                $this->debugger->log(
                    sprintf(
                        'Adding JSON parameter \'%s\' => \'%s\'.',
                        $parameter,
                        json_encode($replaceWith)
                    )
                );
            }
        }

        /**
         * Append parameter.
         */
        $this->parameters[] = array($parameter, $replaceWith);
    }

    /**
     * Parses the template.
     *
     * @since Version 2.0 (Improved)
     * @access private
     * @param string $data Optional data to parse, default null
     * @param string[] $withParameters Optional parameters to parse (array), default null
     */
    private function parseTemplate($data = null, $withParameters = null)
    {
        /**
         * Unique ID
         * @var string
         */
        $this->uniid = $uniid = uniqid();

        /**
         * If not ready, return.
         */
        if (!$this->ready) {
            return;
        }

        if (!isset($this->config['theme'])) {
            /**
             * No theme defined, falling back to 'default'
             */
            $this->config['theme'] = 'default';
        }

        if (!in_array('TEMPLATE_DIR', $this->parameters)) {
            /**
             * Add TEMPLATE_DIR to parameters
             */
            $this->parameters[] = array(
                'TEMPLATE_DIR',
                sprintf('%s', $this->config['templateFiles']),
            );
        }

        /**
         * Template file contents
         * @var string
         */
        $template = ($data === null) ? file_get_contents(
            sprintf(
                '%s%s/theme.%s',
                $this->config['templateDirectory'],
                $this->config['theme'],
                $this->config['themeExtension']
            )
        ) : $data;

        /**
         * If no data then check for a 'theme.x' file
         */
        if ($data === null) {
            $this->file['filename'] = sprintf(
                '%s%s/theme.%s',
                $this->config['templateDirectory'],
                $this->config['theme'],
                $this->config['themeExtension']
            );
        }

        /**
         * Support for "{if X}"
         */
        $template = preg_replace(
            '/\{if (.*)\}/',
            '<?php if (\\1) { ?>',
            $template
        );

        /**
         * Support for "{else}"
         */
        $template = preg_replace(
            '/\{else\}/',
            '<?php }else{ ?>',
            $template
        );

        /**
         * Support for "{/if}"
         */
        $template = preg_replace(
            '/\{\/if\}/',
            '<?php } ?>',
            $template
        );

        /**
         * Support for "{/endif}"
         */
        $template = preg_replace(
            '/\{endif\}/',
            '<?php } ?>',
            $template
        );

        /**
         * Support for "{elseif}"
         */
        $template = preg_replace(
            '/\{elseif (.*)\}/',
            '<?php } elseif (\\1) { ?>',
            $template
        );

        /**
         * Support for "{debug}X{/debug}"
         */
        $template = preg_replace(
            '/\{debug}(.*)\{\/debug\}/s',
            $this->config['debug'] ? '\\1' : '',
            $template
        );

        /**
         * Support for "{!debug}X{/!debug}"
         */
        $template = preg_replace(
            '/\{\!debug}(.*)\{\/\!debug\}/s',
            !$this->config['debug'] ? '\\1' : '',
            $template
        );

        /**
         * Support for "{for X}X{/for}"
         */
        $template = preg_replace_callback(
            '/\{for (\w+)\}(.*)\{\/for\}/s',
            array($this, 'parseArray'),
            $template
        );

        /**
         * Support for "{while X}X{/while}"
         * Support for "{while X}X{/wend}"
         */
        $template = preg_replace_callback(
            '/\{while (\w+)\}(.*)\{\/(while|wend)\}/s',
            array($this, 'parseWhile'),
            $template
        );

        /**
         * Support for "{TEMPLATE LOAD:X CONFIG:X}"
         */
        $template = preg_replace_callback(
            '/\{TEMPLATE LOAD:\'(.*)\' CONFIG:\'(.*)\'\}/',
            array($this, 'parseSubTemplate'),
            $template
        );

        /**
         * Support for "{TEMPLATE LOAD:X}"
         */
        $template = preg_replace_callback(
            "/\{TEMPLATE LOAD:'(.*)'\}/",
            array($this, 'parseSubTemplate'),
            $template
        );

        /**
         * Support for "{GENERATE menu}x{/GENERATE}"
         */
        $template = preg_replace_callback(
            "/\{GENERATE menu\}(.*)\{\/(GENERATE)\}/s",
            array($this, 'parseMenu'),
            $template
        );

        /**
         * Support for "{PHP command}"
         */
        $template = preg_replace(
            '/\{PHP (.*)\}/', //Dangerous, do not use if you don't know what you are doing
            '<?php \\1 ?>',
            $template
        );

        /**
         * Support for "{PHP}x{/PHP}"
         */
        $template = preg_replace(
            '/\{PHP\}(.*)\{\/PHP\}/s', //Dangerous, do not use if you don't know what you are doing
            '<?php \\1 ?>',
            $template
        );

        /**
         * Support for "{DECODE:x}"
         */
        $template = preg_replace(
            '/\{DECODE:(.*?)\}/',
            '<?php echo base64_decode(\'\\1\'); ?>',
            $template
        );

        /**
         * Support for "{#x#}"
         */
        $template = preg_replace(
            '/\{#(.*?)#\}/',
            '<?php if(function_exists(\'__\')) { echo __(\'\\1\'); }else{ echo \'\\1\'; } ?>',
            $template
        );

        /*
         * script src="./" support
         */
        if ($this->config['CDN'] === null) {
            /**
             * script src="./" support without CDN
             * @var string
             */
            $template = preg_replace(
                '/<script(.*)src=("|\')\.\//',
                '<script\\1src=\\2' . $this->config['templateFiles'],
                $template
            );
        } else {
            /**
             * script src="./" support with CDN
             * @var string
             */
            $template = preg_replace(
                '/<script(.*)src=("|\')\.\//',
                '<script\\1src=\\2' . $this->config['CDN'],
                $template
            );
        }

        /*
         * link href="./" support
         */
        if ($this->config['CDN'] === null) {
            /**
             * link href="./" support without CDN
             * @var string
             */
            $template = preg_replace(
                '/<link(.*)href=("|\')\.\//',
                '<link\\1href=\\2' . $this->config['templateFiles'],
                $template
            );
        } else {
            /**
             * link href="./" support with CDN
             * @var string
             */
            $template = preg_replace(
                '/<link(.*)href=("|\')\.\//',
                '<link\\1href=\\2' . $this->config['CDN'],
                $template
            );
        }

        /**
         * Support for "{ISSET ITEM:X}X{/ISSET}"
         */
        $template = preg_replace_callback(
            '/\{ISSET ITEM:(\w+)\}(.*)\{\/ISSET\}/',
            array($this, 'isSetItem'),
            $template
        );

        /**
         * checks if got custom parameters in function call.
         * If custom parameters are not present, then use the parameters
         * wich are made using the template engine, otherwise,
         * load the custom parameters
         */
        if ($withParameters === null) {
            /**
             * Parse the template engine parameters
             */

            /**
             * Counter
             * @var integer $i Counter
             */
            for ($i = 0; $i < sizeof($this->parameters); $i++) {
                if (!is_array($this->parameters[$i][1])) {
                    $template = preg_replace(
                        '/' .
                        $this->config['parameter'][0] .
                        $this->parameters[$i][0] .
                        $this->config['parameter'][1] .
                        '/',
                        $this->parameters[$i][1],
                        $template
                    );
                }
            }
        } else {
            /**
             * Parse the custom parameters,
             * ignoring the template engine ones.
             */

            /**
             * Counter
             * @var integer $i Counter
             */
            for ($i = 0; $i < sizeof($withParameters); $i++) {
                if (!is_array($withParameters[$i][1])) {
                    $template = preg_replace(
                        '/' .
                        $this->config['parameter'][0] .
                        $withParameters[$i][0] .
                        $this->config['parameter'][1] .
                        '/',
                        $withParameters[$i][1],
                        $template
                    );
                }
            }
        }

        /**
         * Checks if 'Data' folder exists, otherwise try to create one.
         */
        if (!file_exists('./Data')) {
            @mkdir('./Data');
        }

        /**
         * Checks if Data is writeable, and if Data/Temp Exists.
         * Otherwise it try's to create it.
         */
        if (is_writable('./Data/') && !file_exists('./Data/Temp')) {
            @mkdir('./Data/Temp/');
        }

        /**
         * If ./Data/Temp is writeable we'll use a 'bin' file for parsing the template
         * Otherwise we'll parse it in memory and `eval` the code.
         */
        if (is_writable('./Data/Temp/')) {
            $fh = @fopen('./Data/Temp/tmp_tpl_' . $uniid . '.bin', 'w');
            @fwrite($fh, $template);
            @fclose($fh);
        }

        /**
         * Checks if we have our binary file.
         */
        if (!file_exists('./Data/Temp/tmp_tpl_' . $uniid . '.bin')) {
            /**
             * Binary file not found.
             * Parsing template in memory, and eval the code.
             */

            /**
             * Start the object
             */
            @ob_start();

            /**
             * If not defined LEFT_COLUMN, define it.
             */
            if (!defined('LEFT_COLUMN')) {
                define(
                    'LEFT_COLUMN',
                    isset($this->config['columnContents']['left'])
                );
            }

            /**
             * If not defined RIGHT_COLUMN, define it.
             */
            if (!defined('RIGHT_COLUMN')) {
                define(
                    'RIGHT_COLUMN',
                    isset($this->config['columnContents']['right'])
                );
            }

            /**
             * We'll use a hack for eval
             * @var string
             */
            $parsedTemplate = @eval(
                sprintf(
                    '%s%s%s%s%s',
                    '/* ! */',
                    ' ?>',
                    $template,
                    '<?php ',
                    '/* ! */'
                )
            );

            /**
             * Get object contents
             */
            $parsedTemplate = ob_get_contents();

            /**
             * Clean, and end object.
             */
            @ob_end_clean();

            /**
             * What ever if is exists, try to remove our temporary file.
             * Using @ to supress any errors.
             */
            @unlink('./Data/Temp/tmp_tpl_' . $uniid . '.bin');

            /**
             * Check if the template is parsed correctly
             */
            if (!$parsedTemplate) {
                /**
                 * Failed to parse the template, fatal error.
                 */
                $this->fatalError('Failed to parse the template.');
            } else {
                /**
                 * Return the template, and if minify is set minify it.
                 */
                return $this->config['minify'] ? $this->minify($parsedTemplate) : $parsedTemplate;
            }
        } else {
            /**
             * Binary file found.
             * Parsing template on the best possible way.
             */

            /**
             * Start the object
             */
            @ob_start();

            /**
             * If not defined LEFT_COLUMN, define it.
             */
            if (!defined('LEFT_COLUMN')) {
                define('LEFT_COLUMN', isset($this->config['columnContents']['left']));
            }

            /**
             * If not defined RIGHT_COLUMN, define it.
             */
            if (!defined('RIGHT_COLUMN')) {
                define('RIGHT_COLUMN', isset($this->config['columnContents']['right']));
            }

            /**
             * Include the template file.
             * @var string
             */
            $parsedTemplate = include './Data/Temp/tmp_tpl_' . $uniid . '.bin';

            /**
             * Get object contents
             */
            $parsedTemplate = ob_get_contents();

            /**
             * Clean, and end object.
             */
            @ob_end_clean();

            /**
             * What ever if is exists, try to remove our temporary file.
             * Using @ to supress any errors.
             */
            @unlink('./Data/Temp/tmp_tpl_' . $uniid . '.bin');

            /**
             * Check if the template is parsed correctly
             */
            if (!$parsedTemplate) {
                /**
                 * Failed to parse the template, fatal error.
                 */
                $this->fatalError('Failed to parse the template.');
            } else {
                /**
                 * Return the template, and if minify is set minify it.
                 */
                return $this->config['minify'] ? $this->minify($parsedTemplate) : $parsedTemplate;
            }
        }
    }

    /**
     * Parse a {while} loop in the template.
     *
     * @since Version 2.0
     * @access private
     * @param string[] $d Data/Template to parse
     * @internal
     */
    public function parseWhile($d)
    {
        /**
         * Return string
         * @var string returning to parent command
         */
        $returning = '';

        /**
         * Temporary Parameters initializer
         * @var array Temporary Parameters
         */
        $this->tParameters = array();

        /**
         * Loop trough parameters
         */
        for ($i = 0; $i < sizeof($this->parameters); $i++) {
            /**
             * If parameter[0] matches with $d[1]
             * Then cool, parse
             */
            if ($this->parameters[$i][0] == $d[1]) {
                /**
                 * If parameter[1] is an array,
                 * then do something with it.
                 */
                if (is_array($this->parameters[$i][1])) {
                    // Ok. here's the fun part.

                    /**
                     * Data found counter
                     * @var integer data found counter
                     */
                    $dataFound = 0;

                    /**
                     * Temporary parameter keys
                     * @var array
                     */
                    $temporaryKeys = array();

                    for ($z = 0; $z < sizeof($this->parameters[$i][1]); $z++) {
                        // .. parse with {$this->parameters[$i][1][$z]} as parameters

                        /**
                         * Temporary data
                         * @var string
                         */
                        $temporaryData = $d[2];
                        foreach ($this->parameters[$i][1][$z] as $key => $value) {
                            /**
                             * Temporary data (replace keys)
                             * @var string
                             */
                            $temporaryData = preg_replace(
                                /**
                                 * Create an temporary Key
                                 * @var string
                                 */
                                $temporaryKey = "/{$d[1]}\.{$key}/",
                                $value,
                                $temporaryData
                            );

                            /**
                             * If key ($temporaryKey) matches with $d[2]
                             * Input: /\{while (\w+)\}(.*)\{\/(while|wend)\}/s
                             */
                            if (preg_match($temporaryKey, $d[2])) {
                                /**
                                 * Data found.
                                 */
                                $dataFound++;
                            } else {
                                /**
                                 * Temporary key added.
                                 */
                                $temporaryKeys[] = "{$d[1]}.{$key}";
                            }
                        }

                        /**
                         * Parse the temporaryData
                         */
                        $returning .= $this->parseTemplate($temporaryData);

                        /**
                         * No data found
                         */
                        if ($dataFound == 0) {
                            /**
                             * Fatal error.
                             * No data found.
                             */
                            $this->fatalError(
                                sprintf(
                                    '%s%s%s%s</b>&nbsp;',
                                    'Missing a replacement key in a while-loop!<br />',
                                    'While loop: <b>{$d[1]}</b><br />',
                                    'Confirm existence for least one of the following keys: <b>',
                                    implode(', ', $temporaryKeys)
                                )
                            );
                        }
                    }

                    /**
                     * Return the parsed data.
                     */
                    return $returning;
                }
            }
        }
    }

    /**
     * Parse a {for} loop in the template.
     *
     * @since Version 2.0
     * @access private
     * @param string[] $d Data/Template to parse
     * @internal
     */
    public function parseArray($d)
    {
        /**
         * Return string
         * @var string returning to parent command
         */
        $returning = '';

        for ($i = 0; $i < sizeof($this->tParameters); $i++) {
            if ($this->tParameters[$i][0] == $d[1]) {
                /**
                 * Replace ; with ,
                 */
                $this->tParameters[$i][1] = preg_replace('/;/', ',', $this->tParameters[$i][1]);

                /**
                 * Explode ,
                 * @var [string]
                 */
                $explode = explode(",", $this->tParameters[$i][1]);

                /**
                 * loop trough $explode
                 */
                for ($z = 0; $z < sizeof($explode); $z++) {
                    /**
                     * Temporary data is $d[2]
                     * Input data: /\{for (\w+)\}(.*)\{\/for\}/s
                     *
                     * @var string
                     */
                    $temporaryData = $d[2];

                    /**
                     * Replace {$d[1]} to exploded data.
                     */
                    $temporaryData = preg_replace("/\{{$d[1]}\}/", $explode[$z], $temporaryData);

                    /**
                     * Add data to returning string.
                     */
                    $returning .= $temporaryData;
                }
            }
        }

        /**
         * Return the parsed data.
         */
        return $returning;
    }

    /**
     * Parse a menu.
     *
     * @since Version 2.0
     * @access private
     * @param string[] $d Data/Template to parse
     * @internal
     */
    public function parseMenu($d)
    {
        /**
         * Create a empty menu
         * @var string menu
         */
        $this->config['generatedMenu'] = '';

        /**
         * Extract ending tag for a General menu item
         * @var string
         */
        $generalMenuItem = explode("{/MENUITEM}", $d[1]);

        if (isset($generalMenuItem[0])) {
            /* Found ending tag */
            $generalMenuItem = $generalMenuItem[0];
        } else {
            /* Didn't found a /menuitem tag */
            $this->fatalError("Failed to load menu!");
        }

        /**
         * Extract starting tag for a General menu item
         * @var string
         */
        $generalMenuItem = explode("{MENUITEM}", $generalMenuItem);
        if (isset($generalMenuItem[1])) {
            /* Found beginning tag */
            $generalMenuItem = $generalMenuItem[1];
        } else {
            /* Didn't found a menuitem tag */
            $this->fatalError("Failed to load menu!");
        }

        // MARK: Submenu
        /**
         * Extract start tag for a submenu
         * @var string
         */
        $subMenuHeader = explode("{SUBMENU}", $d[1]);
        if (isset($subMenuHeader[1])) {
            /* Found beginning tag */
            $subMenuHeader = $subMenuHeader[1];
        } else {
            /* Didn't found a submenu tag */
            $this->fatalError("Failed to load sub menu!");
        }

        /**
         * Extract starting tag for a submenu item
         * @var string
         */
        $subMenuHeader = explode("{MENUITEM}", $subMenuHeader);
        if (isset($subMenuHeader[0])) {
            /* Found beginning tag */
            $subMenuHeader = $subMenuHeader[0];
        } else {
            /* Didn't found a menuitem tag */
            $this->fatalError("Failed to load sub menu!");
        }

        /**
         * Extract starting tag for a submenu
         * @var string
         */
        $subMenuFooter = explode("{SUBMENU}", $d[1]);
        if (isset($subMenuFooter[1])) {
            /* Found beginning tag */
            $subMenuFooter = $subMenuFooter[1];
        } else {
            /* Didn't found a submenu tag */
            $this->fatalError("Failed to load sub menu!");
        }

        /**
         * Extract ending tag for a menu item (in submenu)
         * @var string
         */
        $subMenuFooter = explode("{/MENUITEM}", $subMenuFooter);
        if (isset($subMenuFooter[1])) {
            /* Found beginning tag */
            $subMenuFooter = $subMenuFooter[1];
        } else {
            /* Didn't found a menuitem tag */
            $this->fatalError("Failed to load sub menu!");
        }

        /**
         * Extract ending tag for a submenu
         * @var string
         */
        $subMenuFooter = explode("{/SUBMENU}", $subMenuFooter);
        if (isset($subMenuFooter[0])) {
            /* Found beginning tag */
            $subMenuFooter = $subMenuFooter[0];
        } else {
            /* Didn't found a submenu tag */
            $this->fatalError("Failed to load sub menu!");
        }

        /**
         * Extract starting tag for a submenu item
         * @var string
         */
        $subMenuItem = explode("{SUBMENU}", $d[1]);
        if (isset($subMenuItem[1])) {
            /* Found beginning tag */
            $subMenuItem = $subMenuItem[1];
        } else {
            /* Didn't found a submenu tag */
            $this->fatalError("Failed to load sub menu items!");
        }

        /**
         * Extract starting tag for a menu item (in submenu)
         * @var string
         */
        $subMenuItem = explode("{MENUITEM}", $subMenuItem);
        if (isset($subMenuItem[1])) {
            /* Found beginning tag */
            $subMenuItem = $subMenuItem[1];
        } else {
            /* Didn't found a menuitem tag */
            $this->fatalError("Failed to load sub menu items!");
        }

        /**
         * Extract ending tag for a menu item (in submenu)
         * @var string
         */
        $subMenuItem = explode("{/MENUITEM}", $subMenuItem);
        if (isset($subMenuItem[0])) {
            /* Found beginning tag */
            $subMenuItem = $subMenuItem[0];
        } else {
            /* Didn't found a menuitem tag */
            $this->fatalError("Failed to load sub menu items!");
        }
        // MARK -

        // MARK: Extensions support
        /**
         * Extensions support...
         */
        if (isset($this->config['menuContents'])) {
            /**
             * Walk trough menu content items
             */
            foreach ($this->config['menuContents'] as $i => $data) {
                /**
                 * A / means submenu items!
                 */
                if (preg_match("/\//", $data['name'])) {
                    /**
                     * Explode submenu from item's name
                     * @var [string]
                     */
                    $e = explode("/", $data['name']);

                    /**
                     * If size is less then 4, then it contains valid menu data.
                     * Otherwise there are to much submenu's, and that's not built-in
                     */
                    if (sizeof($e) < 4) {
                        /**
                         * Walk again trouch menu contents,
                         * but now we'll know where we're searching for.
                         */
                        foreach ($this->config['menuContents'] as $seekI => $seekData) {
                            /**
                             * If seekdata equals submenu name, then
                             * parse it.
                             */
                            if (strtolower($seekData['name']) == strtolower($e[0])) {
                                /**
                                 * if !isset $e[2] then it's a one layered submenu.
                                 * Otherwise there is a sub-in-submenu.
                                 */
                                if (!isset($e[2])) {
                                    /**
                                     * Is the $seekData has a 'submenu' item.
                                     * then parse it, otherwise ignore
                                     */
                                    if (is_array($seekData['submenu'])) {
                                        /**
                                         * new Data (removes submenu name, because it's added to the submenu)
                                         * @var [string]
                                         */
                                        $newData = $data;

                                        /**
                                         * Remove submenu name.
                                         */
                                        $newData['name'] = $e[1];

                                        /**
                                         * Append to submenu
                                         */
                                        $this->config['menuContents'][$seekI]['submenu'][] = $newData;

                                        /**
                                         * Unset 'old' menu item (submenuname/item)
                                         */
                                        unset($this->config['menuContents'][$i]);
                                    }
                                } else {
                                    /**
                                     * loop, and search, otherwise create sub-in-submenu
                                     */

                                    /**
                                     * Is found in Sub-in-sub menu
                                     * @var boolean
                                     */
                                    $foundSubInSub = false;

                                    /**
                                     * Walking trough the sub-in-sub menu
                                     */
                                    foreach ($seekData['submenu'] as $subI => $subData) {
                                        /**
                                         * If seekdata equals sub-in-sub menu name, then
                                         * parse it.
                                         */
                                        if (strtolower($subData['name']) == strtolower($e[1])) {
                                            /**
                                             * Is found in Sub-in-sub menu, found!
                                             * @var boolean
                                             */
                                            $foundSubInSub = true;

                                            /**
                                             * Remove submenu name.
                                             */
                                            $data['name'] = $e[2];

                                            /**
                                             * si = SeekI
                                             * Otherwise the line is too long
                                             * @var string
                                             */
                                            $si = $seekI;

                                            /**
                                             * ssi = Sub I
                                             * Otherwise the line is too long
                                             * @var string
                                             */
                                            $ssi = $subI;

                                            /**
                                             * Append to submenu
                                             */
                                            $this->config['menuContents'][$si]['submenu'][$ssi]['submenu'][] = $data;

                                            /**
                                             * Unset 'old' menu item (submenu/submenuname/item)
                                             */
                                            unset($this->config['menuContents'][$i]);
                                        }
                                    }

                                    /**
                                     * Nothing found?
                                     * cool. it's a new submenu
                                     */
                                    if (!$foundSubInSub) {
                                        /**
                                         * Remove parent's submenu name
                                         */
                                        $data['name'] = $e[2];

                                        /**
                                         * Append to submenu
                                         */
                                        $this->config['menuContents'][$seekI]['submenu'][] = $newSubmenuItem = array(
                                            'name' => $e[1],
                                            'url' => '#',
                                            'userlevel' => (
                                                isset($seekData['userlevel']) ? $seekData['userlevel'] : '*'
                                            ),
                                            'submenu' => array($data),
                                        );

                                        /**
                                         * Unset 'old' menu item (submenu/....)
                                         */
                                        unset($this->config['menuContents'][$i]);
                                    }
                                }
                            }
                        }
                    } else {
                        /**
                         * Error to much submenu's.
                         */
                        $this->fatalError(
                            sprintf(
                                '<b>FATAL ERROR</b><br />Please not use more than 2 submenu levels,' .
                                ' current:%d<br />menu item creating this issue: <pre>%s</pre>',
                                (((int) sizeof($e)) - 1),
                                preg_replace("/\//", " -> ", $data['name'])
                            )
                        );
                    }
                }
            }
        }
        // MARK -

        /**
         * Checks if menuContents isSet.
         */
        if (isset($this->config['menuContents'])) {
            /**
             * Walk trough the menu, finally.
             */
            foreach ($this->config['menuContents'] as $i => $data) {
                /**
                 * make $lang global
                 */
                global $lang;

                /**
                 * Check if the data is an array
                 */
                if (!is_array($data)) {
                    /**
                     * $data is not an array.
                     * Malformed menu data!
                     */
                    $this->fatalError("Malformed menu data.");
                } else {
                    /**
                     * Check if the item is a submenu.
                     * by checking the following keys match the list below
                     * - isSet data[submenu]
                     * - is array data[submenu]
                     * - sizeof data[submenu] > 1
                     */
                    if (isset($data['submenu']) &&
                        is_array($data['submenu']) &&
                        sizeof($data['submenu']) > 1) {
                        /**
                         * Append submenu header
                         * @var string
                         */
                        $addItem = $subMenuHeader;
                    } else {
                        /**
                         * Append menu header
                         * @var string
                         */
                        $addItem = $generalMenuItem;
                    }

                    /**
                     * replace {NAME} to the menu item name
                     */
                    $addItem = preg_replace(
                        "/\{NAME\}/",
                        (
                            function_exists('__')
                            ? __($data['name'])
                            : $data['name']
                        ),
                        $addItem
                    );

                    /**
                     * replace {ICON} to the menu item icon
                     */
                    $addItem = preg_replace(
                        "/\{ICON\}/",
                        (
                            isset($data['icon'])
                            ? $data['icon']
                            : ''
                        ),
                        $addItem
                    );

                    /**
                     * Check if the item is not a submenu.
                     * by checking the following keys match the list below
                     * - not isSet data[submenu]
                     * - not is array data[submenu]
                     * - not sizeof data[submenu] > 1
                     */
                    if (!isset($data['submenu']) ||
                        !is_array($data['submenu']) ||
                        !(sizeof($data['submenu']) > 1)
                    ) {
                        /**
                         * replace {HREF}, {LINK} or {URL} to the menu item url
                         */
                        $addItem = preg_replace(
                            "/\{(HREF|LINK|URL)\}/",
                            (
                                isset($data['url'])
                                ? $data['url']
                                : '#'
                            ),
                            $addItem
                        );
                    }

                    /**
                     * Append to 'generatedMenu'
                     */
                    $this->config['generatedMenu'] .= $addItem;

                    /**
                     * If isset submenu
                     */
                    if (isset($data['submenu'])) {
                        /**
                         * if is array
                         */
                        if (is_array($data['submenu'])) {
                            /**
                             * Walk trough submenu
                             */
                            foreach ($data['submenu'] as $ii => $subData) {
                                /**
                                 * If subdata is an array...
                                 */
                                if (is_array($subData)) {
                                    /**
                                     * if not isset subdata, and is not an array.
                                     */
                                    if (!isset($subData['submenu']) ||
                                        !is_array($subData['submenu'])) {

                                        /**
                                         * Temporary item
                                         * @var string
                                         */
                                        $addItem = $subMenuItem;

                                        /**
                                         * replace {NAME} to the menu item name
                                         */
                                        $addItem = preg_replace(
                                            "/\{NAME\}/",
                                            (
                                                function_exists('__')
                                                ? __($subData['name'])
                                                : $subData['name']
                                            ),
                                            $addItem
                                        );

                                        /**
                                         * replace {ICON} to the menu item icon
                                         */
                                        $addItem = preg_replace(
                                            "/\{ICON\}/",
                                            (
                                                isset($subData['icon'])
                                                ? $subData['icon']
                                                : ''
                                            ),
                                            $addItem
                                        );

                                        /**
                                         * replace {HREF}, {LINK} or {URL} to the menu item url
                                         */
                                        $addItem = preg_replace(
                                            "/\{(HREF|LINK|URL)\}/",
                                            (
                                                isset($subData['url'])
                                                ? $subData['url']
                                                : '#'
                                            ),
                                            $addItem
                                        );

                                        /**
                                         * Append Temporary item to final menu
                                         */
                                        $this->config['generatedMenu'] .= $addItem;
                                    } else {
                                        /**
                                         * Hey, it's a submenu
                                         */

                                        /**
                                         * Temporary menu item
                                         * @var string
                                         */
                                        $addItem = $subMenuHeader;

                                        /**
                                         * replace {NAME} to the menu item name
                                         */
                                        $addItem = preg_replace(
                                            "/\{NAME\}/",
                                            (
                                                function_exists('__')
                                                ? __($subData['name'])
                                                : $subData['name']
                                            ),
                                            $addItem
                                        );

                                        /**
                                         * replace {ICON} to the menu item icon
                                         */
                                        $addItem = preg_replace(
                                            "/\{ICON\}/",
                                            (
                                                isset($subData['icon'])
                                                ? $subData['icon']
                                                : ''
                                            ),
                                            $addItem
                                        );

                                        /**
                                         * Append to final menu.
                                         */
                                        $this->config['generatedMenu'] .= $addItem;

                                        /**
                                         * If isset submenu
                                         */
                                        if (isset($subData['submenu'])) {
                                            /**
                                             * If is an array..
                                             */
                                            if (is_array($subData['submenu'])) {
                                                /**
                                                 * Walk trough the submenu
                                                 */
                                                foreach ($subData['submenu'] as $ii => $subSubData) {
                                                    /**
                                                     * If subSubData is an array
                                                     */
                                                    if (is_array($subSubData)) {
                                                        /**
                                                         * Check if item does NOT contain a submenu.
                                                         * - not isSet subSubData[submenu]
                                                         * - not is array subSubData[submenu]
                                                         * - not sizeof subSubData[submenu] > 1
                                                         */
                                                        if (!isset($subSubData['submenu']) ||
                                                            !is_array($subSubData['submenu'])) {
                                                            /**
                                                             * Temporary menu item
                                                             * @var string
                                                             */
                                                            $addItem = $subMenuItem;

                                                            /**
                                                             * replace {NAME} to the sub menu item name
                                                             */
                                                            $addItem = preg_replace(
                                                                "/\{NAME\}/",
                                                                (
                                                                    function_exists('__')
                                                                    ? __($subSubData['name'])
                                                                    : $subSubData['name']
                                                                ),
                                                                $addItem
                                                            );

                                                            /**
                                                             * replace {ICON} to the sub menu item icon
                                                             */
                                                            $addItem = preg_replace(
                                                                "/\{ICON\}/",
                                                                (
                                                                    isset($subSubData['icon'])
                                                                    ? $subSubData['icon']
                                                                    : ''
                                                                ),
                                                                $addItem
                                                            );

                                                            /**
                                                             * replace {HREF}, {LINK} or {URL} to the sub menu item url
                                                             */
                                                            $addItem = preg_replace(
                                                                "/\{(HREF|LINK|URL)\}/",
                                                                (
                                                                    isset($subSubData['url'])
                                                                    ? $subSubData['url']
                                                                    : '#'
                                                                ),
                                                                $addItem
                                                            );

                                                            /**
                                                             * Append Temporary menu item to final menu
                                                             */
                                                            $this->config['generatedMenu'] .= $addItem;
                                                        } else {
                                                            /**
                                                             * Error to much submenu's.
                                                             */
                                                            $this->fatalError(
                                                                sprintf(
                                                                    "<b>FATAL ERROR</b><br />" .
                                                                    "Please not use more than 2 submenu levels," .
                                                                    " current: 3+<br />" .
                                                                    "menu item creating this issue: <pre>%s</pre>",
                                                                    preg_replace(
                                                                        "/\//",
                                                                        " -> ",
                                                                        $subSubData['name']
                                                                    )
                                                                )
                                                            );
                                                        }
                                                    } else {
                                                        /**
                                                         * Malformed submenu data
                                                         */
                                                        echo "<pre>";
                                                        print_r(
                                                            $this->config['menuContents']
                                                        );
                                                        echo "</pre>";

                                                        echo "\nThis needs to be an array!\n<pre>";
                                                        print_r($subData['submenu']);
                                                        echo "</pre>";

                                                        $this->fatalError("Malformed submenu data.");
                                                    }
                                                }
                                            }
                                        }

                                        /**
                                         * Append submenu footer to final menu.
                                         */
                                        $this->config['generatedMenu'] .= $subMenuFooter;
                                    }
                                }
                            }
                        }
                    }

                    /**
                     * Check if the item is a submenu.
                     * by checking the following keys match the list below
                     * - isSet data[submenu]
                     * - is array data[submenu]
                     * - sizeof data[submenu] > 1
                     */
                    if (isset($data['submenu']) &&
                        is_array($data['submenu']) &&
                        sizeof($data['submenu']) > 1) {
                        /**
                         * Append submenu footer to final menu (if needed)
                         */
                        $this->config['generatedMenu'] .= $subMenuFooter;
                    }
                }
            }
        }

        /**
         * Finally, we've got a menu, now return it.
         */
        return $this->config['generatedMenu'];
    }

    /**
     * Parse a sub-template.
     *
     * @since Version 2.0
     * @access private
     * @param string[] $d Data/Template to parse
     * @internal
     */
    public function parseSubTemplate($d)
    {
        /**
         * If exists, $d[2] it has custom parameters!
         */
        if (isset($d[2])) {
            /**
             * re-set temporary parameters
             * @var array
             */
            $this->tParameters = array();

            /**
             * Explode custom parameters (name=value;name2=value2...)
             * @var [string]
             */
            $cfg = explode(';', $d[2]);

            /**
             * Walk trough the custom parameters
             */
            for ($i = 0; $i < sizeof($cfg); $i++) {
                /**
                 * Explode = (name=value) from custom parameter
                 * @var [string]
                 */
                $_d = explode("=", $cfg[$i]);

                /**
                 * if data = CONTENT, then decode it
                 */
                if ($_d[0] == 'CONTENT') {
                    /**
                     * Decode content
                     */
                    $_d[1] = base64_decode($_d[1]);
                }

                /**
                 * Append to temporary parameters
                 */
                $this->tParameters[] = array(
                    /**
                     * Parameter name
                     */
                    $_d[0],
                    /**
                     * Parameter value
                     */
                    isset($_d[1]) ? $_d[1] : null,
                );
            }
        }

        /**
         * Check if sub template item exists!
         */
        if (!file_exists($this->config['templateDirectory'] . $this->config['theme'] . '/' . $d[1]) ||
            !is_readable($this->config['templateDirectory'] . $this->config['theme'] . '/' . $d[1])) {
            /**
             * Does not exists, or is not readable
             */
            $this->fatalError(sprintf(
                'Warning file \'%s\' does not exists, or isn\'t readable.<br />Cannot load sub-template item.',
                $this->config['templateDirectory'] . $this->config['theme'] . '/' . $d[1]
            ));

            return;
        }

        /**
         * Parse sub-template
         */
        return $this->parseTemplate(
            /**
             * Load sub-template.
             */
            file_get_contents(
                $this->config['templateDirectory'] . $this->config['theme'] . '/' . $d[1]
            ),
            /**
             * Append custom parameters
             */
            isset($this->tParameters) ? $this->tParameters : array()
        );
    }

    /**
     * is the {ISSET ITEM:ITEMNAME}...{/ISSET} valid?
     * @param $d search/parse parameter in template.
     * @return mixed
     */
    public function isSetItem($d)
    {
        /**
         * If no custom parameters
         */
        if (sizeof($this->tParameters) === 0) {
            /**
             * If a debugger is set, debug.
             */
            if (isset($this->debugger)) {
                /**
                 * Append debug message
                 */
                $this->debugger->log(
                    'we\'re not in a sub loop so \'tParameters\' is empty,' .
                    ' checking other \'parameters\'.'
                );
            }

            /**
             * Walk trough parameters
             */
            for ($i = 0; $i < sizeof($this->parameters); $i++) {
                /**
                 * If parameter equals $d
                 */
                if ($this->parameters[$i][0] == $d[1]) {
                    /**
                     * If a debugger is set, debug.
                     */
                    if (isset($this->debugger)) {
                        /**
                         * Append debug message
                         */
                        $this->debugger->log(
                            'found parameter \'' . $d[1] . '\' in $this->parameters[' . $i . '][0]'
                        );
                    }

                    /**
                     * Checks if parameter value is not empty
                     */
                    if (!empty($this->parameters[$i][1])) {
                        /**
                         * Parse template with custom value, and original parameters
                         */
                        return $this->parseTemplate(
                            $d[2],
                            $this->parameters
                        );
                    }
                }
            }
        }

        /**
         * Walk trough temporary parameters
         */
        for ($i = 0; $i < sizeof($this->tParameters); $i++) {
            /**
             * If temporary parameter equals $d
             */
            if ($this->tParameters[$i][0] == $d[1]) {
                /**
                 * If a debugger is set, debug.
                 */
                if (isset($this->debugger)) {
                    /**
                     * Append debug message
                     */
                    $this->debugger->log(
                        'found parameter \'' . $d[1] . '\' in $this->parameters[' . $i . '][0]'
                    );
                }

                /**
                 * Checks if parameter value is not empty
                 */
                if (!empty($this->tParameters[$i][1])) {
                    /**
                     * Parse template with custom value, and temporary parameters
                     */
                    return $this->parseTemplate(
                        $d[2],
                        $this->tParameters
                    );
                }
            }
        }
    }

    /**
     * Minify a page output
     *
     * @since Version 2.0
     * @access private
     * @param string $contents The contents to minify
     */
    private function minify($contents)
    {
        $search = array(
            '/function \(/', // compress function ( ) to function() (saves: 1 byte)
            '/\>[^\S ]+/s', // strip whitespaces after tags, except space (saves: many bytes)
            '/[^\S ]+\</s', // strip whitespaces before tags, except space (saves: many bytes)
            '#\btrue\b#', // Replace `true` with `!0` [^3] (saves: 3 bytes)
            '#\bfalse\b#', // Replace `false` with `!1` [^3] (saves: 3 bytes)
            '/[^:]\/\/.*/', // Remove JS comments (saves: many bytes)
            '~//<!\[CDATA\[\s*|\s*//\]\]>~', // Remove JS comments (saves: many bytes)
            '/\s\s+/', // remove whitespaces (saves: 1 byte per whitepace)
            '/\)if/', // fix javascript error (saves: -1 byte)
            '/\n}<\/script>/s', // removes unnecessary newline
            '/; /', // removes unnecessary whitespace (saves: 1 byte)
            '/if \(/', // removes unnecessary whitespace (saves: 1 byte)
            '/ \/ /', // removes unnecessary whitespace (saves: 1 byte)
            '/, /', // removes unnecessary whitespace (saves: 1 byte)
            '/ = /', // removes unnecessary whitespace (saves: 1 byte)
            '/ > /', // removes unnecessary whitespace (saves: 1 byte)
            '/ < /', // removes unnecessary whitespace (saves: 1 byte)
            '/ \* /', // removes unnecessary whitespace (saves: 1 byte)
            '/ \+ /', // removes unnecessary whitespace (saves: 1 byte)
            '/for \(/', // removes unnecessary whitespace (saves: 1 byte)
            '/\) \{/', // removes unnecessary whitespace (saves: 1 byte)
        );

        /**
         * If needed to hide comments, then append them.
         */
        if ($this->config['hidecomments']) {
            $search[] = '/<!--(.|\s)*?-->/'; // Remove HTML comments (saves: many bytes)
        }

        $replace = array(
            'function(',
            '>',
            '<',
            '!0',
            '!1',
            '',
            '',
            '',
            ');if',
            '}</script>',
            ';',
            'if(',
            '/',
            ',',
            '=',
            '>',
            '<',
            '*',
            '+',
            'for(',
            '){',
        );

        /**
         * If needed to hide comments, then append them.
         */
        if ($this->config['hidecomments']) {
            $replace[] = '';
        }

        /**
         * Minify the HTML output!
         * @var string
         */
        $contents = preg_replace(
            $search,
            $replace,
            $contents
        );

        /**
         * Minified output for return
         */
        return $contents;
    }

    /**
     * Display.
     *
     * @access public
     * @since Version 1.0
     */
    public function display()
    {
        /**
         * If no parameters are present,
         * set default parameters.
         */
        if (!isset($this->config['parameter'])) {
            $this->setParameter();
        }

        /**
         * Parse the template.
         * and echo it directly.
         */
        echo $this->parseTemplate();

        /**
         * didDisplay = true
         */
        $this->config['didDisplay'] = true;
    }

    /**
     * didDisplay.
     *
     * @access public
     * @since Version 1.0
     */
    public function didDisplay()
    {
        /**
         * Did the template already display?
         */
        return !$this->config['didDisplay'];
    }

    /**
     * Parses a fatal error.
     *
     * @access private
     * @param string $errorDescription The error description
     * @param string $errorFile The filename
     * @param string $errorLine The linenumber in the file
     * @param string $helpURL If available the URL
     * @since Version 2.0
     */
    private function fatalError($errorDescription, $errorFile = __FILE__, $errorLine = __LINE__, $helpURL = null)
    {
        /**
         * Display error.
         */
        echo sprintf(
            'Fatal Error: %s',
            $errorDescription
        );

        /**
         * Exit with error
         */
        exit(1);
    }
}

/*
Simple template load.
{TEMPLATE LOAD:'post.html' CONFIG:'TITLE=hi;CONTENT=ola;RMLink=/r/1;KEYWORDS=tag,post;DATE=Today;COMMENTS=2;SHARES=8;'}

Template load in while (better solution)
{while post}
{TEMPLATE LOAD:'post.html' CONFIG:'TITLE=post.title;CONTENT=post.content;RMLink=post.rmLink;KEYWORDS=post.keywords;DATE=post.date;COMMENTS=post.comments;SHARES=post.shares;'}
{/while}
 */
