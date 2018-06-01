<?php
/** CMS Debugger
 *
 * it makes the best debug logs for you!
 */

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

// phpcs:disable
$WDGWV_DEBUG = array();
$WDGWV_DEBUG['info'] = array('WDGWV Debug (info) started.');
$WDGWV_DEBUG['error'] = array('WDGWV Debug (errors) started.');
$WDGWV_DEBUG['warning'] = array('WDGWV Debug (warnings) started.');
// phpcs:enable

/**
 * WDGWV CMS Debugger
 *
 * This is the WDGWV CMS Debugger
 *
 * @version Version 1.0
 * @author Wesley de Groot / WDGWV
 * @copyright 2017 Wesley de Groot / WDGWV
 * @package WDGWV/CMS
 * @subpackage Debugger
 * @link http://www.wesleydegroot.nl © Wesley de Groot
 * @link https://www.wdgwv.com © WDGWV
 */
class Debugger
{
    /**
     * Call the debugger
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Debugger();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        return;
    }

    /**
     * Log a message
     * @param string $message Logmessage
     * @param bool $error custom error code
     * @since Version 1.0
     */
    public function log($message, $error = 'info')
    {
        global $WDGWV_DEBUG;

        if ($error == 'warn') {
            $error = 'warning';
        }

        $WDGWV_DEBUG[$error][] = htmlspecialchars(is_array($message) ? json_encode($message) : $message);
    }

    /**
     * Log a message (sprintf)
     * @param string $bool log code
     * @param string string overload... (sprintf)
     * @since Version 1.0
     */
    public function logf($cat = 'info')
    {
        global $WDGWV_DEBUG;

        if ($cat == 'warn') {
            $cat = 'warning';
        }

        $customArgs = func_get_args();
        unset($customArgs[0]);

        $WDGWV_DEBUG[$cat][] = @call_user_func_array('sprintf', $customArgs);
    }

    /**
     * Warning message
     * @param string $message Logmessage
     * @param bool $invokeWarning trigger_error? (default: false)
     * @since Version 1.0
     */
    public function warning($message, $invokeWarning = false)
    {
        global $WDGWV_DEBUG;
        $caller = debug_backtrace()[0];

        if ($invokeWarning) {
            trigger_error(
                $message . ' in <strong>' . $caller['file'] .
                '</strong> on line <strong>' . $caller['line'] .
                '</strong>' . "\n<br /> From error handler",
                E_USER_WARNING
            );
        }

        $this->log($message, 'warning');
    }

    /**
     * Error message
     * @param string $message Logmessage
     * @param bool $invokeWarning trigger_error? (default: false)
     * @since Version 1.0
     */
    public function error($message, $invokeWarning = false)
    {
        global $WDGWV_DEBUG;
        $caller = debug_backtrace()[0];

        if ($invokeWarning) {
            trigger_error(
                $message . ' in <strong>' . $caller['file'] .
                '</strong> on line <strong>' . $caller['line'] .
                '</strong>' . "\n<br /><!-- From error handler",
                E_USER_ERROR
            );
        }

        $this->log($message, 'error');
    }

    /**
     * Dump log to HTML
     * @param bool $r return?
     * @since Version 1.0
     */
    public function logdump($r = false)
    {
        global $WDGWV_DEBUG;

        if ($r) {
            return $r;
        } else {
            echo $this->dump($WDGWV_DEBUG);
        }
    }
    /**
     * Dump all namespaces and classes to HTML
     * @param bool $r return?
     * @since Version 1.0
     */
    public function dumpAllClasses()
    {
        $namespaces = array();
        foreach (get_declared_classes() as $name) {
            if (preg_match("/\\\\/", $name)) {
                $x = explode("\\", $name);

                if (isset($x[0]) && !isset($namespaces[$x[0]])) {
                    if (isset($x[1])) {
                        $namespaces[$x[0]] = array();
                    } else {
                        $namespaces[] = $x[0];
                    }
                }

                if (isset($x[1]) && !isset($namespaces[$x[0]][$x[1]])) {
                    if (isset($x[2])) {
                        $namespaces[$x[0]][$x[1]] = array();
                    } else {
                        $namespaces[$x[0]][] = $x[1];
                    }
                }

                if (isset($x[2]) && !isset($namespaces[$x[0]][$x[1]][$x[2]])) {
                    if (isset($x[3])) {
                        $namespaces[$x[0]][$x[1]][$x[2]] = array();
                    } else {
                        $namespaces[$x[0]][$x[1]][] = $x[2];
                    }
                }

                if (isset($x[3]) && !isset($namespaces[$x[0]][$x[1]][$x[2]][$x[3]])) {
                    if (isset($x[4])) {
                        $namespaces[$x[0]][$x[1]][$x[2]][$x[3]] = array();
                    } else {
                        $namespaces[$x[0]][$x[1]][$x[2]][] = $x[3];
                    }
                }

                if (isset($x[4]) && !isset($namespaces[$x[0]][$x[1]][$x[2]][$x[3]][$x[4]])) {
                    if (isset($x[5])) {
                        $namespaces[$x[0]][$x[1]][$x[2]][$x[3]][$x[4]] = array();
                    } else {
                        $namespaces[$x[0]][$x[1]][$x[2]][$x[3]][] = $x[4];
                    }
                }

                if (isset($x[5]) && !isset($namespaces[$x[0]][$x[1]][$x[2]][$x[3]][$x[4]][$x[5]])) {
                    if (isset($x[6])) {
                        $namespaces[$x[0]][$x[1]][$x[2]][$x[3]][$x[4]][$x[5]] = array("LIMIT REACHED");
                    } else {
                        $namespaces[$x[0]][$x[1]][$x[2]][$x[3]][$x[4]] = $x[5];
                    }
                }
            }
        }
        echo $this->dump($namespaces);
    }

    /**
     * Dump to HTML
     * @param string $orgVar Log what?
     * @param int $depth Which dept we are
     * @param string $firstcall Is this the first call (leave true!)
     * @param int $objdepth Depth of the object
     * @since Version 1.0
     */
    public function dump($orgvar = null, $depth = 0, $firstcall = true, $objdepth = 0)
    {
        // first check if the variable has already been parsed
        $keyvar = 'the_elegant_dump_recursion_protection_scheme';

        //Anti recursie
        if (is_array($orgvar) && isset($orgvar[$keyvar])) {
            // the passed variable is already being parsed!
            $real_var = &$orgvar[$keyvar];
            $type = gettype($real_var);
            $recursed = 'Recursion!';
        } else {
            if ($objdepth > 3) {
                $recursed = 'Copy of Object printed 3 times.';
            } else {
                $recursed = false;
            }
        }

        $var = array($keyvar => $orgvar);
        $var = $var[$keyvar];

        // we will insert an elegant parser-stopper

        $type = gettype($var);

        $c['bg'] = ini_get('highlight.bg');
        $c['comment'] = ini_get('highlight.comment');
        $c['default'] = ini_get('highlight.default');
        $c['html'] = ini_get('highlight.html');
        $c['keyword'] = ini_get('highlight.keyword');
        $c['string'] = ini_get('highlight.string');

        $sp = @implode('', $this->warrayFill(0, $depth, '&nbsp;&nbsp;&nbsp;&nbsp;'));

        if (is_resource($var) || $type == 'resource') {
            if (get_resource_type($var) == 'stream') {
                $streamData = stream_get_meta_data($var);
                $ret = '<span style="color: ' . $c['keyword'] . ';">';
                $ret .= 'Recource: </span><strong style="color: ' . $c['html'];
                $ret .= ';">Stream</strong> ' . $this->dump($streamData, $depth + 1, false);
            } else {
                $ret = '<span style="color: ' . $c['keyword'] . ';">Recource: ';
                $ret .= '</span><strong style="color: ' . $c['html'] . ';">';
                $ret .= ucfirst(get_resource_type($var)) . '</strong>';
            }
        } elseif (is_array($var) || $type == 'array') {
            $depth++;
            $i = count($var);

            $uniqueId = rand();

            if ($i && !$recursed) {
                if (!$firstcall && $i > 2) {
                    $default_state = 'none';
                    $dots = '...';
                } else {
                    $default_state = 'inline';
                    $dots = '';
                }

                $ret = '<a href="#" style="color: ' . $c['default'] . '; ';
                $ret .= 'text-decoration: none;" onclick="arr = document.';
                $ret .= 'getElementById(\'arr_' . $uniqueId . '\'); dots ';
                $ret .= '= document.getElementById(\'dots_' . $uniqueId;
                $ret .= '\'); if(arr.style.display == \'none\') {arr.styl';
                $ret .= 'e.display = \'inline\'; dots.innerHTML = \'\'} e';
                $ret .= 'lse {arr.style.display = \'none\'; dots.innerHTM';
                $ret .= 'L = \'...\'} this.blur(); return false;">array</';
                $ret .= 'a> <span style="color: ' . $c['html'] . ';">(</span>';
                $ret .= '<code style="display: ' . $default_state;
                $ret .= ';" id="arr_' . $uniqueId . '"><br>';
                $sp = $sp . '&nbsp;&nbsp;&nbsp;&nbsp;';

                foreach ($var as $k => &$v) {
                    $ret .= $sp . '<span style="color: ' . $c['default'] .
                    ';">[</span>' . $this->dump($k, false, false) .
                    '<span style="color: ' . $c['default'] .
                    ';">] => </span>' . $this->dump($v, $depth, false);
                    $ret .= ($i-- > 1 ? '<span style="color: ' . $c['html'] . ';">,</span>' : '') . '<br>';
                }
                $depth--;
                $sp = @implode('', $this->warrayFill(0, $depth, '&nbsp;&nbsp;&nbsp;&nbsp;'));

                $ret .= $sp . '</code><span style="color: ' . $c['html'] .
                    ';" id="dots_' . $uniqueId . '" >' . $dots .
                    '</span><span style="color: ' . $c['html'] . ';">)</span>';
            } else {
                $ret = '<span style="color: ' . $c['default'] .
                    ';">array </span> <span style="color: ' . $c['html'] .
                    ';">( ' . (
                    $recursed ?
                    '<strong style="color: red;">' . $recursed . '</strong>' :
                    '') . ' )</span>';
            }
        } elseif (is_bool($var) || $type == 'bool') {
            $ret = '<span style="color: ' . $c['keyword'] . ';">' . ($var ? 'true' : 'false') . '</span>';
        } elseif (is_float($var) || is_int($var) || is_numeric($var) || $type == 'double' || $type == 'integer') {
            $ret = '<span style="color: ' . $c['string'] . ';">' . $var . '</span>';
        } elseif (is_object($var) || $type == 'object') {
            $vars = get_object_vars($var);
            $methods = get_class_methods($var);

            // Bouw stamboom op
            $tmp = $var;
            $parents = array();
            while ($tmp = get_parent_class($tmp)) {
                $parents[] = $tmp;
            }

            $tree = implode(' -> ', array_merge($parents, array(get_class($var))));

            $depth++;
            $i = count($vars) + count($methods);

            $uniqueId = rand();

            if ($i && !$recursed) {
                $ret = '<a href="#" style="color: ' . $c['keyword']
                    . '; text-decoration: none;" onclick="obj = document.getElementById(\'obj_' .
                    $uniqueId . '\'); dots = document.getElementById(\'dots_' . $uniqueId .
                    '\'); if(obj.style.display == \'none\') {obj.style.display = \'inline\'; ' .
                    'dots.innerHTML = \'\'} else {obj.style.display = \'none\'; dots.innerHTM' .
                    'L = \'...\'} this.blur(); return false;">Object: <span style="color: ' .
                    $c['default'] . ';">' . $tree . '</span></a> <span style="color: ' .
                    $c['html'] . ';">{</span>';

                if (!$firstcall && $i > 2) {
                    $default_state = 'none';
                    $dots = '...';
                } else {
                    $default_state = 'inline';
                    $dots = '';
                }

                $ret .= '<code style="display: ' . $default_state . ';" id="obj_' . $uniqueId . '"><br>';
                $sp = $sp . '&nbsp;&nbsp;&nbsp;&nbsp;';

                $objdepth++;

                foreach ($vars as $k => &$v) {
                    $ret .= $sp . '<span style="color: ' . $c['default'] .
                    ';">[</span>' . $this->dump($k, false, false) .
                    '<span style="color: ' . $c['default'] . ';">] => </span>' .
                    $this->dump($v, $depth, false, $objdepth);
                    $ret .= ($i-- > 1 ? '<span style="color: ' . $c['html'] . ';">,</span>' : '') . '<br>';
                }

                foreach ($methods as $k => $v) {
                    $ret .= $sp . '<span style="color: ' . $c['default'] .
                        ';">function</span> <span style="color: ' . $c['html'] .
                        ';">' . $v . '()</span>';
                    $ret .= ($i-- > 1 ? '<span style="color: ' . $c['html'] .
                        ';">,</span>' : '') . '<br>';
                }
                $depth--;
                $sp = @implode('', $this->warrayFill(0, $depth, '&nbsp;&nbsp;&nbsp;&nbsp;'));

                $ret .= $sp . '</code><span id="dots_' . $uniqueId .
                    '" style="color: ' . $c['html'] . '">' . $dots .
                    '</span><span style="color: ' . $c['html'] .
                    ';">}</span>';
            } else {
                $ret = '<span style="color: ' . $c['keyword'] .
                    ';">Object: </span><span style="color: ' . $c['default'] .
                    ';">' . $tree . '</span> <span style="color: ' .
                    $c['html'] . ';">{ ' . (
                    $recursed ?
                    '<strong style="color: red;">' . $recursed . '</strong>' :
                    ''
                ) . ' }</span>';
            }
        } elseif (is_string($var) || $type == 'string') {
            $ret = '<span style="color: ' . $c['string'] . ';">\'' . $var . '\'</span>';
        } elseif (is_null($var) || $type == 'NULL') {
            $ret = '<span style="color: ' . $c['keyword'] . ';">NULL</span>';
        } else {
            $ret = '<strong style="color: red;">Unknown: </strong><span style="color: ';
            $ret .= $c['html'] . ';">' . gettype($var) . '</span>';
        }

        if ($firstcall) {
            return '<code style="display: block; background-color: ' . $c['bg'] .
                '; border: 1px solid black; padding: 5px; margin: 5px;">' . $ret . '</code>';
        } else {
            return $ret;
        }
    }

    /**
     * If array_fill is missing
     * @param string $iStart where to start
     * @param string $iLen where to end
     * @param string $vValue which value?
     * @since Version 1.0
     */
    private function warrayFill($iStart, $iLen, $vValue)
    {
        $aResult = array();
        for ($iCount = $iStart; $iCount < $iLen + $iStart; $iCount++) {
            $aResult[$iCount] = $vValue;
        }
        return $aResult;
    }
}
