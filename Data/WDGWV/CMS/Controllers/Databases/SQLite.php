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
    public static function sharedInstance()
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

        $this->create['setting'] = "INSERT INTO CMSconfiguration (`item`, `value`)
                                    VALUES (:item, :value);";

        $this->create['page'] = "INSERT INTO pages
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
        // FIX TRAVIS
        return array();
    }

    /**
     * Fix for Travis CI
     */
    public function __wakeup()
    {
        // FIX TRAVIS
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
                $this->userDatabase[] = (object) $this->generateUserDB();
            }
        }
        if (!$this->postExists('Welcome to the WDGWV CMS!')) {
            $this->postDatabase[] = array(
                'Welcome to the WDGWV CMS!',
                'Welcome to the WDGWV CMS!<br />',
                'Welcome,WDGWV,CMS',
                date('d-m-Y H:i:s'),
                array('userID' => 0, 'sticky' => true),
            );
        }

        foreach ($this->create as $key => $value) {
            if (preg_match("/Database/", $key)) {
                \WDGWV\CMS\Debugger::sharedInstance()->log(sprintf('Creating %s table (if not exists)', $key));
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
        $query = "SELECT * FROM users WHERE `username`='%s';";
        $query = sprintf($query, $userID);
        foreach ($this->db->query($query) as $users) {
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
            $query = sprintf(
                'DELETE FROM `users` WHERE `username`=\'%s\';',
                $userID
            );

            return $this->db->exec($query);
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
        $query = "SELECT * FROM users WHERE `username`='%s' AND `password`='%s';";
        $query = sprintf($query, $userID, hash('sha512', $userPassword));
        foreach ($this->db->query($query) as $users) {
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
        $query = "SELECT * FROM users WHERE `username`='%s';";
        $query = sprintf($query, $userID);
        foreach ($this->db->query($query) as $users) {
            return $users;
        }

        return false;
    }

    /**
     * Set theme name.
     *
     * @param $themeName
     */
    public function themeSet($themeName)
    {
        $query = "UPDATE CMSconfiguration SET `value`='%s' WHERE `item`='theme';";
        $query = sprintf($query, $themeName);

        if (file_exists(sprintf('./Data/Themes/%s', $themeName))) {
            $this->db->exec($query);
        }
    }

    /**
     * Get current theme
     *
     * @return mixed
     */
    public function themeGet()
    {
        $query = "SELECT * FROM CMSconfiguration WHERE `item`='theme';";
        $count = 0;
        foreach ($this->db->query($query) as $item) {
            return $item[1];
        }

        $query = sprintf(
            $this->create['setting'],
            'theme',
            'admin'
        );
        $this->db->exec($query);

        return 'admin'; //Temporary.
    }

    /**
     * Load menu contents
     *
     * @return mixed
     */
    public function menuLoad()
    {
        $query = "SELECT * FROM CMSconfiguration WHERE `item`='menu';";
        $count = 0;
        foreach ($this->db->query($query) as $item) {
            return json_decode($item[1], true);
        }

        $query = sprintf(
            $this->create['setting'],
            'menu',
            json_encode($this->generateMenuDB())
        );
        $this->db->exec($query);

        return $this->generateMenuDB();
    }

    /**
     * Set menu items
     *
     * @param $menuItemsArray
     */
    public function menuSetItems($menuItemsArray)
    {
        $query = "UPDATE CMSconfiguration SET `value`='%s' WHERE `item`='theme';";
        $query = sprintf($query, json_encode($menuItemsArray));

        $this->db->exec($query);
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
        // load ID at the latest point, since we'll need to handle legacy sysyems.
        $query = "SELECT `title`, `contents`, `keywords`, `date`, `options`, `id` FROM pages WHERE `title` %s '%s';";
        $query = sprintf($query, ($strict ? '=' : 'LIKE'), $pageTitleOrID);
        $count = 0;
        foreach ($this->db->query($query) as $page) {
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
        $query = "SELECT * FROM pages WHERE `title` %s '%s';";
        $query = sprintf($query, ($strict ? '=' : 'LIKE'), $pageTitleOrID);
        $count = 0;
        foreach ($this->db->query($query) as $page) {
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
        \trigger_error("Function \"" . __FUNCTION__ . "\" is not yet done", E_USER_WARNING);
    }

    /**
     * postRemove
     *
     * @param $postID
     */
    public function postRemove($postID, $strict = false)
    {
        if ($this->postExists($postID, $strict)) {
            $query = "DELETE FROM posts WHERE `title` %s '%s';";
            $query = sprintf($query, ($strict ? '=' : 'LIKE'), $postTitle);
            return $this->db->query($query);
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
            $query = "SELECT * FROM posts WHERE `title` %s '%s';";
            $query = sprintf($query, ($strict ? '=' : 'LIKE'), $postTitle);
            foreach ($this->db->query($query) as $post) {
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
        $query = "SELECT * FROM posts WHERE `title` %s '%s';";
        $query = sprintf($query, ($strict ? '=' : 'LIKE'), $postTitle);
        $count = 0;
        foreach ($this->db->query($query) as $post) {
            $count++;
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
        $this->db->prepare($query);

        foreach ($parameters as $bindKey => $bindValue) {
            $stmt->bindValue(
                $bindKey,
                $bindValue,
                SQLITE3_TEXT
            );
        }

        return $stmt->execute();
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
