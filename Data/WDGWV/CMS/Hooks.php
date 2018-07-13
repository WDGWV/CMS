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

class Hooks extends \WDGWV\CMS\BaseProtected
{
    /**
     * @var array
     */
    private $hookDatabase = array();

    /**
     * Call the hooks class
     * @since Version 1.0
     */
    public static function shared()
    {
        /**
         * Shared Instance
         * @var class
         */
        static $inst = null;

        /**
         * If not have a instance, create one.
         */
        if ($inst === null) {
            /**
             * Initialisize Shared Instance
             * @var class
             */
            $inst = new \WDGWV\CMS\hooks();
        }

        /**
         * Return Shared Instance
         */
        return $inst;
    }

    /**
     * Construct the class
     *
     * @return null
     */
    protected function __construct()
    {
        /**
         * Return.
         */
        return;
    }

    /**
     * getUBBHooks
     *
     * @return null
     */
    public function getUBBHooks()
    {
        /**
         * Not implented yet.
         */
        return;
    }

    /**
     * loopHooks
     *
     * @param $which
     * @return mixed
     */
    public function loopHooks($which)
    {
        /**
         * Checks if it is an array.
         */
        if (!is_array($which)) {
            /**
             * Put it into an array
             * @var [string]
             */
            $which = array($which);
        }

        /**
         * Walk trough the hooks
         * @var integer
         */
        for ($i = 0; $i < sizeof($which); $i++) {
            /**
             * run the hook!
             */
            return $this->loopHook($which[$i]);
        }
    }

    /**
     * haveHooksFor
     *
     * @param $which
     */
    public function haveHooksFor($which)
    {
        /**
         * Checks if it is an array.
         */
        if (!is_array($which)) {
            /**
             * Put it into an array
             * @var [string]
             */
            $which = array($which);
        }

        /**
         * Walk trough the hooks
         * @var integer
         */
        for ($i = 0; $i < sizeof($which); $i++) {
            /**
             * Check if we have hooks
             */
            if (sizeof($this->loopHook($which[$i])) > 0) {
                /**
                 * Yes we have hooks
                 */
                return true;
            }
        }
    }

    /**
     * loadHooksFor
     *
     * @param $which
     * @return mixed
     */
    public function loadHooksFor($which)
    {
        /**
         * Checks if it is an array.
         */
        if (!is_array($which)) {
            /**
             * Put it into an array
             * @var [string]
             */
            $which = array($which);
        }

        /**
         * load page and return it.
         */
        return $this->pageLoadFor($which);
    }

    /**
     * pageLoadFor
     *
     * @param $which
     * @return mixed
     */
    public function pageLoadFor($which)
    {
        /**
         * Checks if it is an array.
         */
        if (!is_array($which)) {
            /**
             * Put it into an array
             * @var [string]
             */
            $which = array($which);
        }

        /**
         * Walk trough the hooks
         * @var integer
         */
        for ($i = 0; $i < sizeof($which); $i++) {
            /**
             * Check if we have hooks
             */
            if (sizeof(($x = $this->loopHook($which[$i]))) > 0) {
                /**
                 * Return the hook
                 */
                return $x;
            }
        }
    }

    /**
     * loopHook
     *
     * @param $at
     * @return null
     */
    public function loopHook($at)
    {
        /**
         * Switch statement
         */
        switch ($at) {
            /**
                 * Walk trough 'before-content'
                 */
            case 'before-content':
                /**
                 * Checks if we have 'before-content'
                 */
                if (isset($this->hookDatabase['before-content'])) {
                    /**
                     * Temporary Return string
                     * @var string
                     */
                    $temporaryReturn = '';

                    /**
                     * Walk trough the 'before-contents'
                     */
                    for ($i = 0; $i < sizeof($this->hookDatabase['before-content']); $i++) {
                        /**
                         * Append the hook to the temporaryReturn string
                         */
                        $temporaryReturn .= $this->hookDatabase['before-content'][$i]['action'];
                    }

                    /**
                     * return the temporary return string
                     */
                    return $temporaryReturn;
                }
                break;

            /**
                 * Walk trough 'after-content'
                 */
            case 'after-content':
                /**
                 * Checks if we have 'after-content'
                 */
                if (isset($this->hookDatabase['after-content'])) {
                    /**
                     * Temporary Return string
                     * @var string
                     */
                    $temporaryReturn = '';

                    /**
                     * Walk trough the 'after-contents'
                     */
                    for ($i = 0; $i < sizeof($this->hookDatabase['after-content']); $i++) {
                        /**
                         * Append the hook to the temporaryReturn string
                         */
                        $temporaryReturn .= $this->hookDatabase['after-content'][$i]['action'];
                    }

                    /**
                     * return the temporary return string
                     */
                    return $temporaryReturn;
                }
                break;

            /**
                 * Walk trough 'script'
                 */
            case 'script':
                /**
                 * check if we have hooks.
                 */
                if (isset($this->hookDatabase['script'])) {
                    /**
                     * Create a empty array
                     * @var array
                     */
                    $arr = array();

                    /**
                     * Walk trough the 'script' hooks
                     */
                    for ($i = 0; $i < sizeof($this->hookDatabase['script']); $i++) {
                        /**
                         * Append to array
                         */
                        $arr[] = $this->hookDatabase['script'][$i]['action'];
                    }

                    /**
                     * return array
                     */
                    return $arr;
                }
                break;

            /**
                 * Walk trough 'url'
                 */
            case 'url':
                /**
                 * Check if there are any hooks
                 */
                if (isset($this->hookDatabase['url'])) {
                    /**
                     * walk trough the hooks database
                     */
                    for ($i = 0; $i < sizeof($this->hookDatabase['url']); $i++) {
                        /**
                         * Check if the hook has a name
                         */
                        if (!isset($this->hookDatabase['url'][$i]['name'])) {
                            /**
                             * Continue, we don't have a name.
                             */
                            continue;
                        }

                        /**
                         * Create a safe match
                         * @var string
                         */
                        $safeMatch = $this->hookDatabase['url'][$i]['name'];

                        /**
                         * Replace / to \\\\ (\)
                         */
                        $safeMatch = preg_replace("/\//", "\\\\/", $safeMatch);

                        /**
                         * Replace * to (.*)
                         */
                        $safeMatch = preg_replace("/\*/", "(.*)", $safeMatch);

                        /**
                         * Check if we have a REQUEST_URI
                         */
                        if (isset($_SERVER['REQUEST_URI'])) {
                            /**
                             * Make the url some nicer
                             * @var string
                             */
                            $niceURL = $_SERVER['REQUEST_URI'];

                            /**
                             * if the URL have a "?" then get only before the "?"
                             */
                            if (sizeof(explode('?', $niceURL)) > 0) {
                                /**
                                 * remove everything after the ?
                                 */
                                $niceURL = explode('?', $niceURL)[0];
                            }

                            /**
                             * Checks if we have a safe match
                             */
                            if (preg_match("/" . $safeMatch . "$/", $niceURL)) {
                                /**
                                 * If the action is callable...
                                 */
                                if (is_callable($this->hookDatabase['url'][$i]['action'])) {
                                    /**
                                     * Call the action, and save it to a Temporary String
                                     * @var string
                                     */
                                    $returnValue = call_user_func_array(
                                        $this->hookDatabase['url'][$i]['action'],
                                        $this->hookDatabase['url'][$i]['params']
                                    );

                                    /**
                                     * Checks if we have a Temporary String
                                     */
                                    if (!$returnValue) {
                                        /**
                                         * Temporary unset this hook, it's already loaded.
                                         */
                                        unset($this->hookDatabase['url'][$i]);

                                        /**
                                         * Continue testing
                                         */
                                        continue;
                                    }

                                    /**
                                     * Return the temporary string
                                     */
                                    return $returnValue;
                                } else {
                                    /**
                                     * Action is not callable.
                                     */
                                    if (sizeof($this->hookDatabase['url'][$i]['action']) > 1) {
                                        /**
                                         * Debug it
                                         */
                                        Debugger::shared()->error(sprintf(
                                            'replacer [%s]: "(new \%s)->%s(%s)" is not callable.',
                                            $this->hookDatabase['url'][$i]['name'],
                                            get_class($this->hookDatabase['url'][$i]['action'][0]),
                                            $this->hookDatabase['url'][$i]['action'][1],
                                            (sizeof($this->hookDatabase['url'][$i]['params']) > 0
                                                ? implode(', ', $this->hookDatabase['url'][$i]['params'])
                                                : ''
                                            )
                                        ));
                                    } else {
                                        /**
                                         * What no action???
                                         */
                                        Debugger::shared()->error(
                                            sprintf(
                                                'replacer [%s]: "%s" is not callable',
                                                $this->hookDatabase['url'][$i]['name'],
                                                $this->hookDatabase['url'][$i]['action']
                                            )
                                        );
                                    }
                                }
                            }
                        }
                    }
                }
                break;

            /**
                 * Walk trough 'get'
                 */
            case 'get':
                /**
                 * check if there is a hook for 'get'
                 */
                if (isset($this->hookDatabase['get'])) {
                    /**
                     * Filter to only unique values
                     */
                    $this->hookDatabase['get'] = array_unique($this->hookDatabase['get']);
                    /**
                     * Walk trough the database
                     */
                    for ($i = 0; $i < sizeof($this->hookDatabase['get']); $i++) {
                        /**
                         * Check if the '$_GET[value]' exists
                         */
                        if (isset($_GET[$this->hookDatabase['get'][$i]['name']])) {
                            /**
                             * Check if it is callable
                             */
                            if (is_callable($this->hookDatabase['get'][$i]['action'])) {
                                /**
                                 * Call, and save string
                                 * @var string
                                 */
                                $returnValue = call_user_func_array(
                                    $this->hookDatabase['get'][$i]['action'],
                                    $this->hookDatabase['get'][$i]['params']
                                );

                                /**
                                 * Check if we have something to return
                                 */
                                if (!$returnValue) {
                                    /**
                                     * Continue with a new value
                                     */
                                    continue;
                                }

                                /**
                                 * Return value
                                 */
                                return $returnValue;
                            } else {
                                /**
                                 * Not callable, print a error
                                 */
                                echo sprintf('"%s" is not a function!', $this->hookDatabase['get'][$i]['action'][1]);
                            }
                        }
                    }
                }
                break;

            /**
                 * Walk trough 'post'
                 */
            case 'post':
                /**
                 * check if there is a hook for 'post'
                 */
                if (isset($this->hookDatabase['post'])) {
                    /**
                     * Filter to only unique values
                     */
                    $this->hookDatabase['post'] = array_unique($this->hookDatabase['post']);
                    /**
                     * Walk trough the database
                     */
                    for ($i = 0; $i < sizeof($this->hookDatabase['post']); $i++) {
                        /**
                         * Check if the '$_POST[value]' exists
                         */
                        if (isset($_POST[$this->hookDatabase['post'][$i]['name']])) {
                            /**
                             * Check if it is callable
                             */
                            if (is_callable($this->hookDatabase['post'][$i]['action'])) {
                                /**
                                 * Call, and save string
                                 * @var string
                                 */
                                $returnValue = call_user_func_array(
                                    $this->hookDatabase['post'][$i]['action'],
                                    $this->hookDatabase['post'][$i]['params']
                                );

                                /**
                                 * Check if we have something to return
                                 */
                                if (!$returnValue) {
                                    /**
                                     * Continue with a new value
                                     */
                                    continue;
                                }

                                /**
                                 * Return value
                                 */
                                return $returnValue;
                            } else {
                                /**
                                 * Not callable, print a error
                                 */
                                echo sprintf('"%s" is not a function!', $this->hookDatabase['post'][$i]['action'][1]);
                            }
                        }
                    }
                }
                break;

            /**
                 * Walk trough 'menu'
                 */
            case 'menu':
                /**
                 * Create a temporary array
                 * @var [string]
                 */
                $_temporaryArray = array();

                /**
                 * Check if we have menu database
                 */
                if (sizeof($this->hookDatabase['menu']) > 0) {
                    /**
                     * Walk trough the menu database
                     */
                    for ($i = 0; $i < sizeof($this->hookDatabase['menu']); $i++) {
                        /**
                         * Append to the temporary array.
                         */
                        $_temporaryArray[] = $this->hookDatabase['menu'][$i]['action'];
                    }
                }

                /**
                 * return temporary array
                 */
                return $_temporaryArray;
                break;

            /**
                 * Nothing found
                 */
            default:
                /**
                 * Return nothing
                 */
                return;
                break;
        }
    }

    /**
     * createHook
     *
     * @param $at
     * @param $name
     * @param $action
     * @param array $params
     * @return null
     */
    public function createHook($at, $name, $action, $params = array())
    {
        /**
         * Check if there is a 'x' database
         */
        if (!isset($this->hookDatabase[$at])) {
            /**
             * create a 'x' database
             */
            $this->hookDatabase[$at] = array();
        }

        /**
         * Disable double hooks...
         */
        foreach ($this->hookDatabase[$at] as $key => $value) {
            /**
             * if already exists
             */
            if (isset($value['name']) && $value['name'] === $name) {
                /**
                 * Exists, break function call.
                 */
                return;
            }

            /**
             * if already exists
             */
            if (isset($value['action']) && $value['action'] === $action) {
                /**
                 * Exists, break function call.
                 */
                return;
            }
        }

        /**
         * Append to hook database
         */
        $this->hookDatabase[$at][] = array(
            'name' => $name,
            'action' => $action,
            'params' => $params,
        );
    }

    /**
     * dump the database
     *
     * @return mixed
     */
    public function dumpDatabase()
    {
        /**
         * Return the hook database
         */
        return $this->hookDatabase;
    }

    /**
     * Admin URL wrapper
     *
     * @return string adminURL
     */
    public function adminURL()
    {
        /**
         * Return the admin URL
         */
        return (new \WDGWV\CMS\Config)->adminURL();
    }
}
