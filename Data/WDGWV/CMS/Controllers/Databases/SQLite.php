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

if (!defined('DB_PATH')) {
    define('DB_PATH', './Data/Database/');
}

define('SQLITE_DB', DB_PATH . 'CMS.sqllite');

class SQLite extends \WDGWV\CMS\Controllers\Databases\Base
{
    private $db = null;
    private $create = array();

    /**
     * Call the database
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Controllers\Databases\SQLite();
        }
        return $inst;
    }

    protected function setUp()
    {
        $this->create['postsDatabase'] = "CREATE TABLE IF NOT EXISTS `posts` (
                                            `id`            INTEGER PRIMARY KEY AUTOINCREMENT,
                                            `title`         TEXT,
                                            `contents`      TEXT,
                                            `keywords`      TEXT,
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

        $this->create['user'] = "INSERT INTO `users` (
                                    `id`,
                                    `username`,
                                    `password`,
                                    `email`,
                                    `userlevel`,
                                    `is_activated`,
                                    `extra`
                                ) VALUES (
                                    NULL,
                                    '%s',
                                    '%s',
                                    '%s',
                                    '%s',
                                    '%s',
                                    '%s'
                                );";

        $this->create['setting'] = "INSERT INTO CMSconfiguration (
                                        `item`,
                                        `value`
                                    ) VALUES (
                                        '%s',
                                        '%s'
                                    );";

        $this->create['page'] = "INSERT INTO pages (
                                    `id`,
                                    `title`,
                                    `contents`,
                                    `keywords`,
                                    `date`,
                                    `options`
                                 ) VALUES (
                                    NULL,
                                    '%s',
                                    '%s',
                                    '%s',
                                    '%s',
                                    '%s'
                                 );";
    }

    public function __sleep()
    {
        // FIX TRAVIS
        return array();
    }

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

            $this->userDatabase[] = (object) array(
                'username' => 'admin',
                'password' => hash('sha512', 'changeme'),
                'email' => 'admin@localhost',
                'userlevel' => 'admin',
                'is_activated' => true,
                'extra' => array('userlevel' => 100, 'is_admin' => true),
            );
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
                \WDGWV\CMS\Debugger::sharedInstance()->log(sprintf('Creating %s database', $key));
                $this->db->exec($value);
            }
        }
    }

    public function __destruct()
    {
        unset($this->db);
    }

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

    public function userRegister($userID, $userPassword, $userEmail, $options = array())
    {
        if (!$this->userExists($userID)) {
            $query = sprintf(
                $this->create['user'],
                $userID,
                hash('sha512', $userPassword),
                $userEmail,
                'member',
                'yes',
                json_encode($options)
            );

            return $this->db->exec($query);
        }

        return false;
    }

    public function userDelete($userID)
    {
        \trigger_error("Function \"" . __FUNCTION__ . "\" is not yet done", E_USER_WARNING);
    }

    public function userLogin($userID, $userPassword)
    {
        \trigger_error("Function \"" . __FUNCTION__ . "\" is not yet done", E_USER_WARNING);
    }

    public function userLoad($userID)
    {
        \trigger_error("Function \"" . __FUNCTION__ . "\" is not yet done", E_USER_WARNING);
    }

    public function setTheme($themeName)
    {
        $query = "UPDATE CMSconfiguration SET `value`='%s' WHERE `item`='theme';";
        $query = sprintf($query, $themeName);

        if (file_exists(sprintf('./Data/Themes/%s', $themeName))) {
            $this->db->exec($query);
        }
    }

    public function getTheme()
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

    public function loadMenu()
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

    public function setMenuItems($menuItemsArray)
    {
        $query = "UPDATE CMSconfiguration SET `value`='%s' WHERE `item`='theme';";
        $query = sprintf($query, json_encode($menuItemsArray));

        $this->db->exec($query);
    }

    public function loadPage($pageTitleOrID, $strict = false)
    {
        // load ID at the latest point, since we'll need to handle legacy sysyems.
        $query = "SELECT `title`, `contents`, `keywords`, `date`, `options`, `id` FROM pages WHERE `title` %s '%s';";
        $query = sprintf($query, ($strict ? '=' : 'LIKE'), $pageTitleOrID);
        $count = 0;
        foreach ($this->db->query($query) as $page) {
            return $page;
        }
    }

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

    public function createPage($pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0)
    {
        if (!$this->pageExists($pageTitle)) {
            $query = sprintf(
                $this->create['page'],
                $pageTitle,
                $pageContents,
                $pageKeywords,
                time(),
                json_encode($pageOptions)
            );

            $this->db->exec($query);
        }
    }

    public function editPost($postID, $postTitle, $postContents, $postKeywords, $postDate, $postOptions)
    {
        \trigger_error("Function \"" . __FUNCTION__ . "\" is not yet done", E_USER_WARNING);
    }

    public function postRemove($postID)
    {
        \trigger_error("Function \"" . __FUNCTION__ . "\" is not yet done", E_USER_WARNING);
    }

    public function postLoad($postID, $strict = false)
    {
        \trigger_error("Function \"" . __FUNCTION__ . "\" is not yet done", E_USER_WARNING);
    }

    public function postExists($postTitle, $strict = false)
    {
        $query = "SELECT * FROM posts WHERE `title` %s '%s';";
        $query = sprintf($query, ($strict ? '=' : 'LIKE'), $postTitle);
        $count = 0;
        foreach ($this->db->query($query) as $page) {
            $count++;
        }

        return ($count !== 0);
    }

    public function postCreate($postTitle, $postContents, $postKeywords, $postDate, $postOptions, $postID = 0)
    {
    }

    public function postGetLast()
    {
        \trigger_error("Function \"" . __FUNCTION__ . "\" is not yet done", E_USER_WARNING);
    }

    public function query($query)
    {
        return $this->db->exec($query);
    }

    public function exec($query)
    {
        return $this->query($query);
    }
}
