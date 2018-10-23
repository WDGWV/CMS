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

class MySQLDriver
{
    # @object, The PDO object
    private $pdo;

    # @object, PDO statement object
    private $sQuery;

    # @array,  The database settings
    private $settings;

    # @? ,  Connected to the database
    private $bConnected = false;

    # @object, Object for logging exceptions
    private $log;

    # @array, The parameters of the SQL query
    private $parameters;

    /**
     *   Default Constructor
     *
     *    1. Instantiate Log class.
     *    2. Connect to database.
     *    3. Creates the parameter array.
     */
    public function __construct()
    {
        $this->connect();
        $this->parameters = array();
    }

    /**
     *    This method makes connection to the database.
     *
     *    1. Reads the database settings from a ini file.
     *    2. Puts  the ini content into the settings array.
     *    3. Tries to connect to the database.
     *    4. If connection failed, exception is displayed and a log file gets created.
     */
    private function connect()
    {
        $this->settings = parse_ini_file("settings.ini.php");
        $dsn = 'mysql:dbname=' . $this->settings["dbname"] . ';host=' . $this->settings["host"] . '';
        try {
            # Read settings from INI file, set UTF8
            $this->pdo = new PDO($dsn, $this->settings["user"], $this->settings["password"], array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            ));

            # We can now log any exceptions on Fatal error.
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            # Disable emulation of prepared statements, use REAL prepared statements instead.
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            # Connection succeeded, set the boolean to true.
            $this->bConnected = true;
        } catch (PDOException $e) {
            # Write into log
            echo $this->ExceptionLog($e->getMessage());
            die();
        }
    }
    /*
     *   You can use this little method if you want to close the PDO connection
     *
     */
    public function CloseConnection()
    {
        # Set the PDO object to null to close the connection
        # http://www.php.net/manual/en/pdo.connections.php
        $this->pdo = null;
    }

    /**
     *    Every method which needs to execute a SQL query uses this method.
     *
     *    1. If not connected, connect to the database.
     *    2. Prepare Query.
     *    3. Parameterize Query.
     *    4. Execute Query.
     *    5. On exception : Write Exception into the log + SQL query.
     *    6. Reset the Parameters.
     */
    private function Init($query, $parameters = "")
    {
        # Connect to database
        if (!$this->bConnected) {
            $this->connect();
        }
        try {
            # Prepare query
            $this->sQuery = $this->pdo->prepare($query);

            # Add parameters to the parameter array
            $this->bindMore($parameters);

            # Bind parameters
            if (!empty($this->parameters)) {
                foreach ($this->parameters as $param => $value) {
                    if (is_int($value[1])) {
                        $type = PDO::PARAM_INT;
                    } else if (is_bool($value[1])) {
                        $type = PDO::PARAM_BOOL;
                    } else if (is_null($value[1])) {
                        $type = PDO::PARAM_NULL;
                    } else {
                        $type = PDO::PARAM_STR;
                    }
                    // Add type when binding the values to the column
                    $this->sQuery->bindValue($value[0], $value[1], $type);
                }
            }

            # Execute SQL
            $this->sQuery->execute();
        } catch (PDOException $e) {
            # Write into log and display Exception
            echo $this->ExceptionLog($e->getMessage(), $query);
            die();
        }

        # Reset the parameters
        $this->parameters = array();
    }

    /**
     *    @void
     *
     *    Add the parameter to the parameter array
     *    @param string $para
     *    @param string $value
     */
    public function bind($para, $value)
    {
        $this->parameters[sizeof($this->parameters)] = [":" . $para, $value];
    }
    /**
     *    @void
     *
     *    Add more parameters to the parameter array
     *    @param array $parray
     */
    public function bindMore($parray)
    {
        if (empty($this->parameters) && is_array($parray)) {
            $columns = array_keys($parray);
            foreach ($columns as $i => &$column) {
                $this->bind($column, $parray[$column]);
            }
        }
    }
    /**
     *  If the SQL query  contains a SELECT or SHOW statement it returns an array containing all of the result set row
     *    If the SQL statement is a DELETE, INSERT, or UPDATE statement it returns the number of affected rows
     *
     *       @param  string $query
     *    @param  array  $params
     *    @param  int    $fetchmode
     *    @return mixed
     */
    public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
    {
        $query = trim(str_replace("\r", " ", $query));

        $this->Init($query, $params);

        $rawStatement = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query));

        # Which SQL statement is used
        $statement = strtolower($rawStatement[0]);

        if ($statement === 'select' || $statement === 'show') {
            return $this->sQuery->fetchAll($fetchmode);
        } elseif ($statement === 'insert' || $statement === 'update' || $statement === 'delete') {
            return $this->sQuery->rowCount();
        } else {
            return null;
        }
    }

    /**
     *  Returns the last inserted id.
     *  @return string
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Starts the transaction
     * @return boolean, true on success or false on failure
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     *  Execute Transaction
     *  @return boolean, true on success or false on failure
     */
    public function executeTransaction()
    {
        return $this->pdo->commit();
    }

    /**
     *  Rollback of Transaction
     *  @return boolean, true on success or false on failure
     */
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    /**
     *    Returns an array which represents a column from the result set
     *
     *    @param  string $query
     *    @param  array  $params
     *    @return array
     */
    public function column($query, $params = null)
    {
        $this->Init($query, $params);
        $Columns = $this->sQuery->fetchAll(PDO::FETCH_NUM);

        $column = null;

        foreach ($Columns as $cells) {
            $column[] = $cells[0];
        }

        return $column;

    }
    /**
     *    Returns an array which represents a row from the result set
     *
     *    @param  string $query
     *    @param  array  $params
     *       @param  int    $fetchmode
     *    @return array
     */
    public function row($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
    {
        $this->Init($query, $params);
        $result = $this->sQuery->fetch($fetchmode);
        $this->sQuery->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued,
        return $result;
    }
    /**
     *    Returns the value of one single field/column
     *
     *    @param  string $query
     *    @param  array  $params
     *    @return string
     */
    public function single($query, $params = null)
    {
        $this->Init($query, $params);
        $result = $this->sQuery->fetchColumn();
        $this->sQuery->closeCursor(); // Frees up the connection to the server so that other SQL statements may be issued
        return $result;
    }
    /**
     * Writes the log and returns the exception
     *
     * @param  string $message
     * @param  string $sql
     * @return string
     */
    private function ExceptionLog($message, $sql = "")
    {
        $exception = 'Unhandled Exception. <br />';
        $exception .= $message;
        $exception .= "<br /> You can find the error back in the log.";

        if (!empty($sql)) {
            # Add the Raw SQL to the Log
            $message .= "\r\nRaw SQL : " . $sql;
        }

        return $exception;
    }
}

class mySQLdatabase extends \WDGWV\CMS\Controllers\Databases\Base
{
    private $db = null;

    /**
     * Call the database
     * @since Version 1.0
     */
    public static function shared()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Controllers\Databases\PlainText();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        $this->db = new MySQLDriver();
    }

    public function __destruct()
    {
        file_put_contents(CMS_DB, gzcompress(json_encode($this->CMSDatabase), 9));
        file_put_contents(MENU_DB, gzcompress(json_encode($this->menuDatabase), 9));
        file_put_contents(USER_DB, gzcompress(json_encode($this->userDatabase), 9));
        file_put_contents(POST_DB, gzcompress(json_encode($this->postDatabase), 9));
        file_put_contents(PAGE_DB, gzcompress(json_encode($this->pageDatabase), 9));
        file_put_contents(SHOP_DB, gzcompress(json_encode($this->shopDatabase), 9));
        file_put_contents(WIKI_DB, gzcompress(json_encode($this->wikiDatabase), 9));
        file_put_contents(ORDER_DB, gzcompress(json_encode($this->orderDatabase), 9));
        file_put_contents(FORUM_DB, gzcompress(json_encode($this->forumDatabase), 9));
    }

    public function postExists($postTitle, $strict = false)
    {
        if ($strict) {
            return isset($this->postDatabase[$postTitle]);
        }

        for ($i = 0; $i < sizeof($this->postDatabase); $i++) {
            if (strtolower($postTitle) !== strtolower($this->postDatabase[$i][0])) {
                // continue
            } else {
                return true;
            }
        }
        return false;
    }

    public function postGetLast()
    {
        return $this->postDatabase[sizeof($this->postDatabase) - 1];
    }

    public function postCreate($postTitle, $postContents, $postKeywords, $postDate, $postOptions, $postID = 0)
    {
        if ($postID === 0) {
            if (!$this->postExists($postTitle)) {
                $this->postDatabase[] = array(
                    $postTitle,
                    $postContents,
                    $postKeywords,
                    $postDate,
                    $postOptions,
                );
            } else {
                return false;
            }
        } else {
            $this->postDatabase[$postID] = array(
                $postTitle,
                $postContents,
                $postKeywords,
                $postDate,
                $postOptions,
            );
        }
        return true;
    }

    public function postLoad($postID, $strict = false)
    {
        if ($this->postExists($postID, $strict)) {
            if (is_numeric($postID)) {
                return $this->postDatabase[$postID];
            } else {
                for ($i = 0; $i < sizeof($this->postDatabase); $i++) {
                    if (strtolower($postID) !== strtolower($this->postDatabase[$i][0])) {
                        // continue
                    } else {
                        return $this->postDatabase[$i];
                    }
                }
            }
        } else {
            echo "postID does not exists!";
        }
    }

    public function postRemove($postID)
    {
        if ($this->postExists($postID, true)) {
            unset($this->postDatabase[$postID]);
        }
    }

    public function editPost($postID, $postTitle, $postContents, $postKeywords, $postDate, $postOptions)
    {
        if ($this->postRemove($postID)) {
            if ($this->postCreate($postTitle, $postContents, $postKeywords, $postDate, $postOptions, $postID)) {
                return true;
            }
        }
        return false;
    }

    private function userExists($userID)
    {
        for ($i = 0; $i < sizeof($this->userDatabase); $i++) {
            if (!in_array($userID, $this->userDatabase[$i])) {
                // continue
            } else {
                return true;
            }
        }

        return false;
    }

    public function userLoad($userID)
    {

    }

    public function userLogin($userID, $userPassword)
    {
        for ($i = 0; $i < sizeof($this->userDatabase); $i++) {
            if (
                $this->userDatabase[$i][1] != $userPassword &&
                (
                    $i === $userID or // userID matches DB ID
                    $this->userDatabase[$i][0] === $userID or // userID matches userName
                    $this->userDatabase[$i][2] === $userID // userID matches userEmail
                )
            ) {
                return true;
            }
        }

        return false;
    }

    public function userDelete($userID)
    {
        if ($this->userExists($userID)) {
            for ($i = 0; $i < sizeof($this->userDatabase); $i++) {
                if (!in_array($userID, $this->userDatabase[$i])) {
                    // continue
                } else {
                    unset($this->userDatabase[$i]);
                    return true;
                }
            }

            return false;
        }
    }

    public function userRegister($userID, $userPassword, $userEmail, $options = array())
    {
        if (!$this->userExists($userID)) {
            $this->userDatabase[] = array(
                $userID,
                hash('sha512', $userPassword),
                $userEmail,
                $options,
            );
            return true;
        } else {
            return false;
        }
    }

    public function createPage($pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0)
    {
        if ($pageID === 0) {
            if (!$this->pageExists($pageTitle)) {
                $this->pageDatabase[] = array(
                    $pageTitle,
                    $pageContents,
                    $pageKeywords,
                    time(),
                    $pageOptions,
                );
            } else {
                return false;
            }
        } else {
            $this->pageDatabase[$pageID] = array(
                $pageTitle,
                $pageContents,
                $pageKeywords,
                time(),
                $pageOptions,
            );
        }
        return true;
    }

    public function pageExists($pageTitleOrID, $strict = false)
    {
        if ($strict) {
            return isset($this->pageDatabase[$pageTitleOrID]);
        }

        for ($i = 0; $i < sizeof($this->pageDatabase); $i++) {
            if (strtolower($pageTitleOrID) !== strtolower($this->pageDatabase[$i][0])) {
                // continue
            } else {
                return true;
            }
        }
        return false;
    }

    public function loadPage($pageTitleOrID, $strict = false)
    {
        if ($strict) {
            return ($this->pageDatabase[$pageTitleOrID]);
        }

        for ($i = 0; $i < sizeof($this->pageDatabase); $i++) {
            if (strtolower($pageTitleOrID) !== strtolower($this->pageDatabase[$i][0])) {
                // continue
            } else {
                return $this->pageDatabase[$i];
            }
        }
        return false;
    }

    public function setMenuItems($menuItemsArray)
    {
        $this->CMSDatabase['menu'] = $menuItemsArray;
    }

    public function loadMenu()
    {
        if (is_array(@$this->CMSDatabase['menu'])) {
            return $this->CMSDatabase['menu'];
        } else {
            return $this->CMSDatabase['menu'] = array(
                'Home' => '/home',
                'Blog' => '/blog',
                'Administration' => '/administration',
                'About' => '/about',
            );
        }
    }
}
