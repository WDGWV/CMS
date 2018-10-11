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
-       (c) WDGWV. 2018, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

if (!defined('DB_PATH')) {
    define('DB_PATH', './Data/Database/');
}

define('SQLITE_DB', DB_PATH . 'CMS.sqllite');

class SQLite extends \WDGWV\CMS\Controllers\Databases\Base
{
    /**
     * @var mixed
     */
    private $db = null;

    /**
     * @var array
     */
    private $create = array();

    /**
     * Call the database
     * @since Version 1.0
     */
    public static function shared()
    {
        /**
         * @var mixed
         */
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Controllers\Databases\SQLite();
        }
        return $inst;
    }

    /**
     * setUp
     */
    protected function setUp()
    {
        $this->create['postsDatabase'] = "CREATE TABLE IF NOT EXISTS `posts` (
                                            `id`            INTEGER PRIMARY KEY AUTOINCREMENT,
                                            `title`         TEXT,
                                            `contents`      TEXT,
                                            `keywords`      TEXT,
                                            `date`          TEXT,
                                            `options`       TEXT
                                          );";

        $this->create['pagesDatabase'] = "CREATE TABLE IF NOT EXISTS `pages` (
                                            `id`            INTEGER PRIMARY KEY AUTOINCREMENT,
                                            `title`         TEXT,
                                            `contents`      TEXT,
                                            `keywords`      TEXT,
                                            `date`          TEXT,
                                            `options`       TEXT
                                          );";

        $this->create['CMSDatabase'] = "CREATE TABLE IF NOT EXISTS `CMSconfiguration` (
                                            `item`          TEXT,
                                            `value`         TEXT
                                        );";

        $this->create['usersDatabase'] = "CREATE TABLE IF NOT EXISTS `users` (
                                            `id`            INTEGER PRIMARY KEY AUTOINCREMENT,
                                            `username`      TEXT,
                                            `password`      TEXT,
                                            `email`         TEXT,
                                            `userlevel`     TEXT,
                                            `is_activated`  TEXT,
                                            `extra`         TEXT
                                          );";

        $this->create['extensionsDatabase'] = "CREATE TABLE IF NOT EXISTS `extensions` (
                                                `id`        INTEGER PRIMARY KEY AUTOINCREMENT,
                                                `filePath`  TEXT,
                                                `loaded`    TEXT
                                               );";

        $this->create['translationsDatabase'] = "CREATE TABLE IF NOT EXISTS `translations` (
                                                    `id`            INTEGER PRIMARY KEY AUTOINCREMENT,
                                                    `language`      TEXT,
                                                    `original`      TEXT,
                                                    `translation`   TEXT
                                                );";

        $this->create['user'] = "INSERT INTO `users`
                                    (`id`, `username`, `password`, `email`, `userlevel`, `is_activated`, `extra`)
                                VALUES
                                    (NULL, :username, :password, :email, :userlevel, :activated, :extra);";

        $this->create['setting'] = "INSERT INTO `CMSconfiguration` (`item`, `value`)
                                    VALUES (:item, :value);";

        $this->create['page'] = "INSERT INTO `pages`
                                    (`id`, `title`, `contents`, `keywords`, `date`, `options`)
                                 VALUES
                                    (NULL, :title, :contents, :keywords, :time, :options);";

        $this->create['post'] = "INSERT INTO `posts`
                                    (`id`, `title`, `contents`, `keywords`, `date`, `options`)
                                 VALUES
                                    (NULL, :title, :contents, :keywords, :time, :options);";
    }

    /**
     * Fix for Travis CI
     * @return array empty.
     */
    public function __sleep()
    {
        /* FIX TRAVIS */
        return array();
    }

    /**
     * Fix for Travis CI
     */
    public function __wakeup()
    {
        /* FIX TRAVIS */
        try {
            $this->db = new \PDO(sprintf('sqlite:%s', SQLITE_DB));
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print 'Exception : ' . $e->getMessage();
        }
    }

    /**
     * protected so nobody else can instantiate it
     *
     */
    protected function __construct()
    {
        $this->setUp();
        if (sizeof($this->create) < 2) {
            exit('setUp failed.');
        }

        try {
            $this->db = new \PDO(sprintf('sqlite:%s', SQLITE_DB));
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print 'Exception : ' . $e->getMessage();
        }

        if (!$this->userExists('admin')) {
            if (is_array($this->generateUserDB())) {
                foreach ($this->generateUserDB() as $newUser) {
                    $this->userRegister(
                        $newUser['username'],
                        $newUser['password'],
                        $newUser['email'],
                        $newUser['extra']
                    );
                }
            }

            /**
             * If no user is created as well, then it's a new installation, so create the post
             */
            if (!$this->postExists('Welcome to the WDGWV CMS!')) {
                $this->postCreate(
                    'Welcome to the WDGWV CMS!',
                    'Welcome to the WDGWV CMS!<br />',
                    'Welcome,WDGWV,CMS',
                    date('d-m-Y H:i:s'),
                    json_encode(array('userID' => 0, 'sticky' => true))
                );
            }
        }

        foreach ($this->create as $key => $value) {
            if (preg_match("/Database/", $key)) {
                \WDGWV\CMS\Debugger::shared()->log(sprintf('Creating %s table (if not exists)', $key));
                $this->db->exec($value);
            }
        }
    }

    public function __destruct()
    {
        unset($this->db);
    }

    /**
     * userExists
     *
     * @param $userID
     */
    public function userExists($userID)
    {
        $count = 0;

        $query = $this->queryWithParameters(
            'SELECT * FROM `users` WHERE `username`=:username',
            array(':username' => $userID)
        );

        foreach ($query as $users) {
            $count++;
        }

        return ($count !== 0);
    }

    /**
     * Register an user
     *
     * @param $userID
     * @param $userPassword
     * @param $userEmail
     * @param array $options
     * @return mixed
     */
    public function userRegister($userID, $userPassword, $userEmail, $options = array())
    {
        if (!$this->userExists($userID)) {
            return $this->queryWithParameters(
                $this->create['user'],
                array(
                    ':username' => $userID,
                    ':password' => hash('sha512', $userPassword),
                    ':email' => $userEmail,
                    ':userlevel' => 'member',
                    ':activated' => 'yes',
                    ':extra' => json_encode($options),
                )
            );
        }

        return false;
    }

    /**
     * Delete an user
     *
     * @param $userID the user ID
     */
    public function userDelete($userID)
    {
        if ($this->userExists($userID)) {
            return $this->queryWithParameters(
                'SELECT * FROM `users` WHERE `username`=:username',
                array(':username' => $userID)
            );
        }

        return false;
    }

    /**
     * User Login
     *
     * @param $userID the user ID
     * @param $userPassword the user password
     */
    public function userLogin($userID, $userPassword)
    {
        $count = 0;
        $query = $this->queryWithParameters(
            'SELECT * FROM `users` WHERE `username`=:username AND `password`=:password',
            array(
                ':username' => $userID,
                ':password' => hash('sha512', $userPassword),
            )
        );

        foreach ($query as $users) {
            $count++;
        }

        return ($count !== 0);
    }

    /**
     * Load user
     *
     * @param $userID the user ID
     */
    public function userLoad($userID)
    {
        $query = $this->queryWithParameters(
            'SELECT * FROM `users` WHERE `username`=:username',
            array(
                ':username' => $userID,
            )
        );
        $query = sprintf($query, $userID);
        foreach ($query as $users) {
            return $users;
        }

        return false;
    }

    /**
     * Set theme name.
     *
     * @param $themeName theme name
     * @param $force force (use insert)
     */
    public function themeSet($themeName, $force = false)
    {
        if ($force) {
            $query = "INSERT INTO `CMSconfiguration` (`value`, `item`) VALUES(:theme, 'theme');";

            if (file_exists(sprintf('./Data/Themes/%s', $themeName))) {
                $this->queryWithParameters(
                    $query,
                    array(':theme' => $themeName)
                );
            } else {
                trigger_error(sprintf('Theme %s does not exists', $themeName), E_USER_ERROR);
            }
        } else {
            $query = "UPDATE `CMSconfiguration` SET `value`=:theme WHERE `item`='theme'";

            if (file_exists(sprintf('./Data/Themes/%s', $themeName))) {
                $this->queryWithParameters(
                    $query,
                    array(':theme' => $themeName)
                );
            } else {
                trigger_error(sprintf('Theme %s does not exists', $themeName), E_USER_ERROR);
            }
        }
    }

    /**
     * Get current theme
     *
     * @return mixed
     */
    public function themeGet()
    {
        $count = 0;
        foreach ($this->queryWithParameters(
            'SELECT * FROM `CMSconfiguration` WHERE item=:theme',
            array(':theme' => 'theme')
        ) as $item) {
            return $item[1];
        }

        $this->themeSet('admin', true);

        return 'admin';
    }

    /**
     * Replaces any parameter placeholders in a query with the value of that
     * parameter. Useful for debugging. Assumes anonymous parameters from
     * $params are are in the same order as specified in $query
     *
     * @param string $query The sql query with parameter placeholders
     * @param array $params The array of substitution parameters
     * @return string The interpolated query
     */
    public function debugQuery($query, $params)
    {
        $keys = array();

        foreach ($params as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/' . $key . '/';
            } else {
                $keys[] = '/[?]/';
            }
        }

        $query = preg_replace($keys, $params, $query, 1, $count);

        return $query;
    }
    /**
     * Load menu contents
     *
     * @return mixed
     */
    public function menuLoad()
    {
        foreach ($this->queryWithParameters(
            'SELECT * FROM `CMSconfiguration` WHERE item=:menu',
            array(':menu' => 'menu')
        ) as $item) {
            return json_decode($item[1], true);
        }

        $this->menuSetItems($this->generateMenuDB(), true);

        return $this->generateMenuDB();
    }

    /**
     * Set menu items
     *
     * @param $menuItemsArray
     */
    public function menuSetItems($menuItemsArray, $force = false)
    {
        if ($force) {
            $query = "INSERT INTO `CMSconfiguration` (`value`, `item`) VALUES(:menu, 'menu');";
            return $this->queryWithParameters(
                $query,
                array(':menu' => json_encode($menuItemsArray))
            );
        } else {
            $query = "UPDATE `CMSconfiguration` SET `value`=:menu WHERE `item`='menu'";
            return $this->queryWithParameters(
                $query,
                array(':menu' => json_encode($menuItemsArray))
            );
        }
    }

    /**
     * pageLoad
     *
     * @param $pageTitleOrID
     * @param $strict
     * @return mixed
     */
    public function pageLoad($pageTitleOrID, $strict = false)
    {
        /* load ID at the latest point, since we'll need to handle legacy sysyems. */
        $query = "SELECT `title`, `contents`, `keywords`, `date`, `options`, `id` FROM pages WHERE `title` %s :pageTitleOrID";
        $query = sprintf($query, ($strict ? '=' : 'LIKE'));
        $query = $this->queryWithParameters(
            $query,
            array(
                ':pageTitleOrID' => $pageTitleOrID,
            )
        );

        $count = 0;
        foreach ($query as $page) {
            return $page;
        }
    }

    /**
     * pageExists
     *
     * @param $pageTitleOrID
     * @param $strict
     */
    public function pageExists($pageTitleOrID, $strict = false)
    {
        $query = "SELECT `title`, `contents`, `keywords`, `date`, `options`, `id` FROM pages WHERE `title` %s :pageTitleOrID";
        $query = sprintf($query, ($strict ? '=' : 'LIKE'));
        $query = $this->queryWithParameters(
            $query,
            array(
                ':pageTitleOrID' => $pageTitleOrID,
            )
        );

        $count = 0;

        if ($query === 1 || $query === '1') {
            return false;
        }

        foreach ($query as $page) {
            if (isset($page)) {}
            $count++;
        }

        return ($count !== 0);
    }

    /**
     * pageCreate
     *
     * @param $pageTitle
     * @param $pageContents
     * @param $pageKeywords
     * @param array $pageOptions
     * @param $pageID
     */
    public function pageCreate($pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0)
    {
        if (!$this->pageExists($pageTitle)) {
            $stmt = $this->db->prepare($this->create['page']);

            $stmt->bindValue(
                ':title',
                $pageTitle,
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':contents',
                $pageContents,
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':keywords',
                $pageKeywords,
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':options',
                json_encode($pageOptions),
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':time',
                date('d-m-Y H:i:s'),
                SQLITE3_TEXT
            );

            return $stmt->execute();
        }

        return false;
    }

    /**
     * postEdit
     *
     * @param $postID
     * @param $postTitle
     * @param $postContents
     * @param $postKeywords
     * @param $postDate
     * @param $postOptions
     */
    public function postEdit($postID, $postTitle, $postContents, $postKeywords, $postDate, $postOptions)
    {
        if ($this->postExists($postID)) {
            $stmt = $this->db->prepare(
                "UPDATE posts SET `title`=:title, `contents`=:contents, `keywords`=:keywords, `date`=:date, `options`:options WHERE `id`=:id"
            );

            $stmt->bindValue(
                ':title',
                $postTitle,
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':contents',
                $postContents,
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':keywords',
                $postKeywords,
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':options',
                json_encode($postOptions),
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':time',
                date('d-m-Y H:i:s'),
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':id',
                $postID,
                SQLITE3_TEXT
            );

            return $stmt->execute();
        }

        return false;
    }

    /**
     * postRemove
     *
     * @param $postID
     */
    public function postRemove($postID, $strict = false)
    {
        if ($this->postExists($postID, $strict)) {
            $query = "DELETE FROM posts WHERE `title` %s :pageTitleOrID";
            $query = sprintf($query, ($strict ? '=' : 'LIKE'));
            return $this->queryWithParameters(
                $query,
                array(
                    ':pageTitleOrID' => $pageTitleOrID,
                )
            );
        }

        return false;
    }

    /**
     * postLoad
     *
     * @param $postID
     * @param $strict
     */
    public function postLoad($postID, $strict = false)
    {
        if ($this->postExists($postID, $strict)) {
            $query = "SELECT * FROM `posts` WHERE `title` %s :postID";
            $query = sprintf($query, ($strict ? '=' : 'LIKE'));
            $query = $this->queryWithParameters(
                $query,
                array(
                    ':postID' => $postID,
                )
            );

            foreach ($query as $post) {
                return array(
                    /* title... */$post['title'],
                    /* contents */$post['contents'],
                    /* keywords */$post['keywords'],
                    /* date.... */$post['date'],
                    /* options. */$post['options'],
                );
            }
        }

        return false;
    }

    /**
     * postExists
     *
     * @param $postTitle
     * @param $strict
     */
    public function postExists($postTitle, $strict = false)
    {
        $query = "SELECT * FROM `posts` WHERE `title` %s :postTitle";
        $query = sprintf($query, ($strict ? '=' : 'LIKE'));
        $query = $this->queryWithParameters(
            $query,
            array(
                ':postTitle' => $postTitle,
            )
        );

        $count = 0;
        if (is_array($query)) {
            foreach ($query as $post) {
                $count++;
            }
        }

        return ($count !== 0);
    }

    /**
     * postCreate
     *
     * @param $postTitle
     * @param $postContents
     * @param $postKeywords
     * @param $postDate
     * @param $postOptions
     * @param $postID
     */
    public function postCreate($postTitle, $postContents, $postKeywords, $postDate, $postOptions, $postID = 0)
    {
        if (!$this->postExists($postTitle)) {
            $stmt = $this->db->prepare(
                $this->create['post']
            );

            $stmt->bindValue(
                ':title',
                $postTitle,
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':contents',
                $postContents,
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':keywords',
                $postKeywords,
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':options',
                json_encode($postOptions),
                SQLITE3_TEXT
            );

            $stmt->bindValue(
                ':time',
                date('d-m-Y H:i:s'),
                SQLITE3_TEXT
            );

            return $stmt->execute();
        }

        return false;
    }

    /**
     * post Get Last
     */
    public function postGetLast()
    {
        $query = "SELECT * FROM `posts` ORDER BY `id` DESC;";
        $query = sprintf($query);
        foreach ($this->db->query($query) as $post) {
            return array(
                /* title... */$post['title'],
                /* contents */$post['contents'],
                /* keywords */$post['keywords'],
                /* date.... */$post['date'],
                /* options. */$post['options'],
            );
        }

        return array(
            /* title... */"Warning",
            /* contents */"No posts found.",
            /* keywords */"",
            /* date.... */date('d-m-Y H:i:s'),
            /* options. */array('userID' => 0, 'sticky' => true),
        );
    }

    /**
     * SQLite query
     *
     * @param $query
     * @return mixed
     */
    public function query($query)
    {
        return $this->db->exec($query);
    }

    /**
     * SQL Query with parameters
     * @param  string $query Query text
     * @param  [string] $parameters Query parameters
     * @return bool Query executed
     */
    public function queryWithParameters($query, $parameters)
    {
        /**
         * Prepared statement
         * @var object
         */
        $stmt = $this->db->prepare($query);

        /**
         * Walk trough parameters
         */
        foreach ($parameters as $bindKey => $bindValue) {
            /**
             * Bind values
             */
            $stmt->bindValue(
                $bindKey,
                $bindValue,
                SQLITE3_TEXT
            );
        }

        /**
         * Executed statement
         * @var object
         */
        $e = $stmt->execute();

        /**
         * fetched content
         * @var [string]
         */
        $x = $stmt->fetchAll();

        /**
         * data check, If less then 1
         * then skip.
         */
        if (sizeof($x) > 1) {
            /**
             * We've got values
             */
            return $x;
        }

        /**
         * Didn't got values
         * Retry in another way
         */

        /**
         * Query
         * @var string
         */
        $newQuery = $query;

        /**
         * Parameter values
         * @var array
         */
        $values = array();

        /**
         * Walk trough parameters
         */
        foreach ($parameters as $bindKey => $bindValue) {
            /**
             * Replace parameter bindings :parameter to ?
             * @var string
             */
            $newQuery = preg_replace('/' . $bindKey . '/', '?', $newQuery, 1, $count);

            /**
             * Append parameter values!
             */
            $values[] = $bindValue;
        }

        /**
         * Prepare for the second time
         * @var [type]
         */
        $new = $this->db->prepare($newQuery);

        /**
         * Execute with parameter values
         */
        $new->execute($values);

        /**
         * Fetch contents
         * @var [string]
         */
        $x = $new->fetch(\PDO::FETCH_BOTH);

        /**
         * data check, If less then 1
         * then skip.
         */
        if (sizeof($x) > 1) {
            /**
             * We've got values
             * hack it togheter.
             */
            return array(0 => $x);
        }

        /**
         * Failed, or no data found.
         */
        return false;
    }

    /**
     * SQLite query
     *
     * @alias query
     * @param $query
     * @return mixed
     */
    public function exec($query)
    {
        return $this->query($query);
    }
}
