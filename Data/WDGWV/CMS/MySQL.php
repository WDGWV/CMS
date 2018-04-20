<?php
/** SQL Class
 *
 * it makes the best SQL for you
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

namespace WDGWV\General;

/**
 *
 * WDGWV SQL Class
 *
 * <pre>
 * This set of functions is basicly to support the deprecated mysql_* functions
 * So if you replace mysql_* with this class it will work again.
 * The class is written in pdo, and is only meaned for temporary!
 * </pre>
 * http://wdgwv.github.io/MySQL_Support.html
 *
 * @package    WDGWV
 * @subpackage WDGWV/General
 * @author     Wesley de Groot <wes@wdgwv.com>
 * @version    v1.0s
 * @access     public
 * @see        http://wdgwv.github.io/MySQL_Support.html
 */
class SQL
{
    /**
     * the SQL connection
     *
     * @since v1.0a
     * @access private
     * @return array $_sql
     */
    private $_sql;

    /**
     *
     * Constructs the class.
     *
     * @since v1.0a
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->_sql = array();
        $this->_sql['config']['trigger_error'] = false;
        $this->_sql['config']['fetch_type'] = null; //PDO::FETCH_ASSOC (names)
        //PDO::FETCH_NUM   (array 0,1,2,3,etc)
        $this->_sql['error'] = null; //WGT: FIX: 29-JAN-2014
        $this->_sql['lastCMD'] = null;
        $this->_sql['num_rows'] = null;
    }

    /**
     *
     * Replaces mysql_real_escape_string.
     *
     * @since v1.0a
     * @access public
     * @param string $string SQL Query
     * @return string
     */
    public function real_escape_string($string)
    {
        $return = '';

        for ($i = 0; $i < strlen($string); ++$i) {
            $char = $string[$i];
            $ord = ord($char);

            if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126) {
                $return .= $char;
            } else {
                $return .= '\\x' . dechex($ord);
            }
        }

        return $return;
    }

    /**
     *
     * Alias to real_escape_string.
     *
     * @since v1.0a
     * @access public
     * @param string $string SQL Query
     * @return string
     */
    public function safe($string)
    {
        $string = preg_replace("/'/", "\\'", $string);
        return $string;
    }

    /**
     *
     * Alias to real_escape_string.
     *
     * @since v1.0a
     * @access public
     * @param string $string SQL Query
     * @return string
     */
    public function safe_string($string)
    {
        $return = '';

        for ($i = 0; $i < strlen($string); ++$i) {
            $char = $string[$i];
            $ord = ord($char);

            if ($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126) {
                $return .= $char;
            } else {
                $return .= '\\x' . dechex($ord);
            }
        }

        return $return;
    }

    /**
     *
     * Replaces mysql_escape_string.
     *
     * @since v1.0a
     * @access public
     * @param string $string SQL Query
     * @return string
     */
    public function escape_string($string)
    {
        $search = array("\\", "\x00", "\n", "\r", "'", '"', "\x1a");
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");
        $string = str_replace($search, $replace, $string);

        return $string;
    }

    /**
     *
     * Replaces none, checks if needed to trigger a error otherwise save it in $this->_sql.
     *
     * @since v1.0a
     * @access public
     * @param string $error Error.
     * @return string
     * @deprecated v1.0b
     */
    public function trigger_error($error)
    {
        return 'deprecated';
    }

    /**
     *
     * Replaces none, checks if needed to trigger a error otherwise save it in $this->_sql.
     *
     * @since v1.0b
     * @access public
     * @param string $error Error.
     * @return string
     */
    public function trigger_my_error($error)
    {
        //what to do? reset or make a error?
        if ($error == false) {
            //reset the error.
            $this->_sql['old_error'] = $this->_sql['error'];
            $this->_sql['error'] = null;
        } else {
            // need to trigger the error?
            if ($this->_sql['config']['trigger_error']) {
                //yes, trigger the error.
                trigger_error($error);
            } else {
                //nope, save the error only...
                $this->_sql['old_error'] = $this->_sql['error'];
                $this->_sql['error'] = $error;
            }
        }
    }

    /**
     *
     * Replaces mysql_connect(hostname, username, password)
     *
     * @since v1.0a
     * @access public
     * @param string $hostname Hostname
     * @param string $username Username
     * @param string $password Password
     * @return bool
     */
    public function connect($hostname, $username, $password)
    {
        $this->trigger_my_error(false);
        //Set some parameters
        $this->_sql['connect']['hostname'] = $hostname;
        $this->_sql['connect']['username'] = $username;
        $this->_sql['connect']['password'] = $password;

        //return: true (connection)
        // cause pdo need database for connect.
        return true;
    }

    /**
     *
     * Replaces none
     * Calls $this->select_db($database, $link);
     *
     * @since v1.0b
     * @access public
     * @param string $database Database
     * @param string $link Link
     * @return bool
     */
    public function db($database, $link = null)
    {
        return $this->select_db($database, $link);
    }

    /**
     *
     * Replaces mysql_select_db(database, link)
     *
     * @since v1.0a
     * @access public
     * @param string $database Database
     * @param string $link Link
     * @return bool
     */
    public function select_db($database, $link = null)
    {
        $this->trigger_my_error(false);

        //Set database name
        $this->_sql['connect']['database'] = $database;

        //we do nothing with $link.

        //Let's connect...
        $this->_sql['connection'] = new PDO(
            'mysql:host=' . //Say use mysql with host..
            $this->_sql['connect']['hostname'] . // <-- HOST
            ';dbname=' . //And database...
            $this->_sql['connect']['database'] . // <-- DATABASE
            ';charset:utf8', //With Charset utf8.
            $this->_sql['connect']['username'], // <-- USERNAME.
            $this->_sql['connect']['password']// <-- PASSWORD.
        );

        if (@$this->_sql['connection']) {
//if connected then..
            // set the PDO modes...
            $this->_sql['connection']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_sql['connection']->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            //and return i'm connected
            return true;
        } else {
            // Failed... trigger a error
            $this->trigger_my_error('Can\'t Connect or Select database');

            // And sent i did'nt connect...
            return false;
        }
    }

    /**
     *
     * Replaces mysql_error
     *
     * @since v1.0a
     * @access public
     * @return string|null
     */
    public function error()
    {

        // Is there a error?
        if (isset($this->_sql['error'])) {
            return $this->_sql['error']; //Yes, so return it back
        } else {
            return null; //Nope error is null.
        }
    }

    /**
     *
     * Replaces mysql_query(query, link)
     *
     * @since v1.0a
     * @access public
     * @param string $query Query
     * @param string $link Link
     * @return resource|bool
     */
    public function query($query, $link = null)
    {
        $this->trigger_my_error(false);

        try {
            // Execute and return command...
            $cmd = (
                @$this->_sql['connection']->query($query)
                //                             ^ Query...
            );

            $this->_sql['lastCMD'] = $cmd;
            $this->_sql['num_rows'] = $cmd->rowCount();
        } catch (PDOException $ex) {
            $this->trigger_my_error('Query: ' . $query . ' Was not executed, ' . $ex);
        }

        // Is the command executed good?
        if (@$cmd) {
            return @$cmd; //Yes, so return the Query data!
        } else {
            // No trigger a error...
            $this->trigger_my_error('Query: ' . $query . ' Was not executed, please check your query');

            // and return i've a error.
            return false;
        }
    }

    /**
     *
     * Replaces mysql_fetch_array(resource, link)
     *
     * @since v1.0a
     * @access public
     * @param string $command Resource
     * @param string $link Link
     * @return array|bool
     */
    public function fetch_array($command, $type = null)
    {
        if ($command) {
            //Load global config
            $this->trigger_my_error(false);

            //Create a temporary array.
            $tempArray = array();

            while ($row = (@$command->fetch($this->_sql['config']['fetch_type']))) {
                // Load the data, but please ignore errors!
                // Put the data to the temporary array.
                $tempArray[] = $row;
            }

            // if the size is zero, i think it's a error, so i trigger a error!
            if (sizeof($tempArray) == 0) {
                //error so trigger a error.
                $this->trigger_my_error('Error can\'t fetch data.');

                // return false we got nothing?!
                return false;
            } else {
                if (sizeof($tempArray) == 1) { //WGT: Fix 29-JAN-2014 one item then not needed to
                    return array($tempArray[0]); // have $arr[0][SELECTED ITEMS]
                } else {
                    return $tempArray; //no error, so just return the data.
                }
            }

            unset($tempArray); // unset the temporary array to clean up the mess.
        } else {
            return false;
        }
    }

    /**
     *
     * Replaces mysql_fetch_assoc(resource, link)
     *
     * @since v1.0a
     * @access public
     * @param string $command Resource
     * @param string $link Link
     * @return array|bool
     */
    public function fetch_assoc($command, $type = null)
    {
        $this->trigger_my_error(false);

        //Create a temporary array.
        $tempArray = array();

        while ($row = (@$command->fetch(PDO::FETCH_ASSOC))) {
            // Load the data, but please ignore errors!
            // Put the data to the temporary array.
            $tempArray[] = $row;
        }

        // if the size is zero, i think it's a error, so i trigger a error!
        if (sizeof($tempArray) == 0) {
            //error so trigger a error.
            $this->trigger_my_error('Error can\'t fetch data.');

            // return false we got nothing?!
            return false;
        } else {
            if (sizeof($tempArray) == 1) { //WGT: Fix 29-JAN-2014 one item then not needed to
                return $tempArray[0]; // have $arr[0][SELECTED ITEMS]
            } else {
                return $tempArray; //no error, so just return the data.
            }
        }

        unset($tempArray); // unset the temporary array to clean up the mess.
    }

    /**
     *
     * Replaces mysql_fetch_row(resource, link)
     *
     * @since v1.0a
     * @access public
     * @param string $resource Resource
     * @param string $link Link
     * @return string|bool
     */
    public function fetch_row($resource, $type = null)
    {
        $this->trigger_my_error(false);

        //Create a temporary array.
        $tempArray = array();

        while ($row = (@$resource->fetch($this->_sql['config']['fetch_type']))) {
            // Load the data, but please ignore errors!
            // Put the data to the temporary array.
            $tempArray[] = $row;
        }

        // if the size is zero, i think it's a error, so i trigger a error!
        if (sizeof($tempArray) == 0) {
            //error so trigger a error.
            $this->trigger_my_error('Error can\'t fetch data.');

            // return false we got nothing?!
            return false;
        } else {
            return $tempArray[0]; //no error, so just return the data.
        }

        unset($tempArray); // unset the temporary array to clean up the mess.
    }

    /**
     *
     * Replaces mysql_num_rows(resource, link)
     *
     * @since v1.0a
     * @access public
     * @param string $resource Resource
     * @param string $link Link
     * @return int|bool
     */
    public function num_rows($resource, $link = null)
    {
        $this->trigger_my_error(false);

        //num rows
        $num_rows = (@$resource->rowCount());

        //is there a error?!
        if ($num_rows) {
            //no error, return the count...
            return $num_rows;
        } else {
            //Try to fix!
            if (is_numeric($this->_sql['num_rows'])) {
                return ($this->_sql['num_rows']);
            } else {
                $this->trigger_my_error('Can\'t count rows');

                //error so return false.
                return false;
            }
        }
    }

    /**
     *
     * Replaces mysql_insert_id(resource)
     *
     * @since v1.0a
     * @access public
     * @param string $resource Resource
     * @return int|bool
     */
    public function insert_id($resource = null)
    {
        $this->trigger_my_error(false);

        //num the rows
        $lastInsertedId = ($this->_sql['connection']->lastInsertId());

        //is there a error?!
        if ($lastInsertedId) {
            //no error, return the count...
            return $lastInsertedId;
        } else {
            //ERROR, trigger a error
            $this->trigger_my_error('Can\'t fetch id of last row');

            //error so return false.
            return false;
        }
    }

    /**
     *
     * Replaces mysql_affected_rows(resource)
     *
     * @since v1.0a
     * @access public
     * @param string $resource Resource
     * @return int|bool
     */
    public function affected_rows($resource = null)
    {
        $this->trigger_my_error(false);

        //num the rows
        $affected_rows = (@$this->_sql['connection']->lastInsertId());

        //is there a error?!
        if ($affected_rows) {
            //no error, return the count...
            return $affected_rows;
        } else {
            //ERROR, trigger a error
            $this->trigger_my_error('Can\'t get affected rows');

            //error so return false.
            return false;
        }
    }
}
