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
    public static function sharedInstance()
    {
        /**
         * @var mixed
         */
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\hooks();
        }
        return $inst;
    }

    /**
     * Construct the class
     *
     * @return null
     */
    protected function __construct()
    {
        return;
    }

    /**
     * getUBBHooks
     *
     * @return null
     */
    public function getUBBHooks()
    {
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
        if (!is_array($which)) {
            $which = array($which);
        }

        for ($i = 0; $i < sizeof($which); $i++) {
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
        if (!is_array($which)) {
            $which = array($which);
        }

        for ($i = 0; $i < sizeof($which); $i++) {
            if (sizeof($this->loopHook($which[$i])) > 0) {
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
        if (!is_array($which)) {
            $which = array($which);
        }

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
        if (!is_array($which)) {
            $which = array($which);
        }

        for ($i = 0; $i < sizeof($which); $i++) {
            if (sizeof(($x = $this->loopHook($which[$i]))) > 0) {
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
        switch ($at) {
            case 'before-content':
                if (isset($this->hookDatabase['before-content'])) {
                    for ($i = 0; $i < sizeof($this->hookDatabase['before-content']); $i++) {
                        return $this->hookDatabase['before-content'][$i]['action'];
                    }
                }
                break;

            case 'after-content':
                if (isset($this->hookDatabase['after-content'])) {
                    for ($i = 0; $i < sizeof($this->hookDatabase['after-content']); $i++) {
                        return $this->hookDatabase['after-content'][$i]['action'];
                    }
                }
                break;

            case 'script':
                if (isset($this->hookDatabase['script'])) {
                    $arr = array();
                    for ($i = 0; $i < sizeof($this->hookDatabase['script']); $i++) {
                        $arr[] = $this->hookDatabase['script'][$i]['action'];
                    }
                    return $arr;
                }
                break;

            case 'url':
                if (isset($this->hookDatabase['url'])) {
                    for ($i = 0; $i < sizeof($this->hookDatabase['url']); $i++) {
                        if (!isset($this->hookDatabase['url'][$i]['name'])) {
                            continue;
                        }

                        $safeMatch = $this->hookDatabase['url'][$i]['name'];
                        $safeMatch = preg_replace("/\//", "\\\\/", $safeMatch);
                        $safeMatch = preg_replace("/\*/", "(.*)", $safeMatch);
                        if (isset($_SERVER['REQUEST_URI'])) {
                            $niceURL = $_SERVER['REQUEST_URI'];

                            // if the URL have a "?" then get only before the "?"
                            if (sizeof(explode('?', $niceURL)) > 0) {
                                $niceURL = explode('?', $niceURL)[0];
                            }

                            if (preg_match("/" . $safeMatch . "$/", $niceURL)) {
                                if (is_callable($this->hookDatabase['url'][$i]['action'])) {
                                    $returnValue = call_user_func_array(
                                        $this->hookDatabase['url'][$i]['action'],
                                        $this->hookDatabase['url'][$i]['params']
                                    );

                                    if (!$returnValue) {
                                        // Temporary unset this hook, it's already loaded.
                                        unset($this->hookDatabase['url'][$i]);

                                        // Continue testing
                                        continue;
                                    }

                                    return $returnValue;
                                } else {
                                    if (sizeof($this->hookDatabase['url'][$i]['action']) > 1) {
                                        Debugger::sharedInstance()->error(sprintf(
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
                                        Debugger::sharedInstance()->error(
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

            case 'get':
                if (isset($this->hookDatabase['get'])) {
                    $this->hookDatabase['get'] = array_unique($this->hookDatabase['get']);
                    for ($i = 0; $i < sizeof($this->hookDatabase['get']); $i++) {
                        if (isset($_GET[$this->hookDatabase['get'][$i]['name']])) {
                            if (is_callable($this->hookDatabase['get'][$i]['action'])) {
                                $returnValue = call_user_func_array(
                                    $this->hookDatabase['get'][$i]['action'],
                                    $this->hookDatabase['get'][$i]['params']
                                );

                                if (!$returnValue) {
                                    continue;
                                }

                                return $returnValue;
                            } else {
                                echo sprintf('"%s" is not a function!', $this->hookDatabase['get'][$i]['action'][1]);
                            }
                        }
                    }
                }
                break;

            case 'post':
                if (isset($this->hookDatabase['post'])) {
                    $this->hookDatabase['post'] = array_unique($this->hookDatabase['post']);
                    for ($i = 0; $i < sizeof($this->hookDatabase['post']); $i++) {
                        if (isset($_POST[$this->hookDatabase['post'][$i]['name']])) {
                            if (is_callable($this->hookDatabase['post'][$i]['action'])) {
                                $returnValue = call_user_func_array(
                                    $this->hookDatabase['post'][$i]['action'],
                                    $this->hookDatabase['post'][$i]['params']
                                );

                                if (!$returnValue) {
                                    continue;
                                }

                                return $returnValue;
                            } else {
                                echo sprintf('"%s" is not a function!', $this->hookDatabase['post'][$i]['action'][1]);
                            }
                        }
                    }
                }
                break;

            case 'menu':
                $_temporaryArray = array();
                if (sizeof($this->hookDatabase['menu']) > 0) {
                    for ($i = 0; $i < sizeof($this->hookDatabase['menu']); $i++) {
                        $_temporaryArray[] = $this->hookDatabase['menu'][$i]['action'];
                    }
                }
                return $_temporaryArray;
                break;

            default:
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
        if (!isset($this->hookDatabase[$at])) {
            $this->hookDatabase[$at] = array();
        }

        // Disable double hooks...
        foreach ($this->hookDatabase[$at] as $key => $value) {
            if (isset($value['name']) && $value['name'] === $name) {
                return;
            }

            if (isset($value['action']) && $value['action'] === $action) {
                return;
            }
        }

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
        return $this->hookDatabase;
    }

    /**
     * Admin URL wrapper
     *
     * @return string adminURL
     */
    public function adminURL()
    {
        return (new \WDGWV\CMS\Config)->adminURL();
    }
}
