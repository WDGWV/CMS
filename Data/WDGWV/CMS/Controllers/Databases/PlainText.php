<?php
/** Plain text databse controller
 *
 * Controller for a plain text database
 */

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

define('PT_CMS_DB', DB_PATH . 'CMS.PTdb');
define('PT_MENU_DB', DB_PATH . 'menuItems.PTdb');
define('PT_USER_DB', DB_PATH . 'userInfo.PTdb');
define('PT_POST_DB', DB_PATH . 'posts.PTdb'); // Tip, Purge every year.
define('PT_PAGE_DB', DB_PATH . 'pages.PTdb');
define('PT_SHOP_DB', DB_PATH . 'shopItems.PTdb');
define('PT_WIKI_DB', DB_PATH . 'wikiItems.PTdb');
define('PT_ORDER_DB', DB_PATH . 'orders.PTdb');
define('PT_FORUM_DB', DB_PATH . 'forumItems.PTdb');

class PlainText extends \WDGWV\CMS\Controllers\Databases\Base
{
    private $CMSDatabase = array();
    private $userDatabase = array();
    private $postDatabase = array();
    private $pageDatabase = array();
    private $shopDatabase = array();
    private $wikiDatabase = array();
    private $orderDatabase = array();
    private $forumDatabase = array();
    private $compressDatabase = false;

    /**
     * Call the database
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\Controllers\Databases\PlainText();
        }
        return $inst;
    }

    private function _loadDatabase($databasePath)
    {
        if (!file_exists($databasePath)) {
            if (!touch($databasePath)) {
                $databaseName = end(explode("/", $databasePath));
                $databaseName = explode(".", $databaseName)[0];

                $error = sprintf("<b>Fatal error: Could not create '%s' database.</b>", $databaseName);
                if (class_exists('\WDGWV\CMS\Debugger')) {
                    \WDGWV\CMS\Debugger::sharedInstance()->error($error);
                }
                echo $error;

                exit;
            }
        }

        if ($this->compressDatabase) {
            $_database = @gzuncompress(file_get_contents($databasePath));
        } else {
            $_database = file_get_contents($databasePath);
        }
        if (strlen($_database) > 10) {
            return json_decode($_database);
        }

        return array();
    }

    private function _saveDatabase($databasePath, $databaseContents)
    {
        $error = false;
        if (!is_writeable($databasePath)) {
            $error = true;
        }

        if ($this->compressDatabase) {
            $_compressed = gzcompress(json_encode($databaseContents), 9);
        } else {
            $_compressed = json_encode($databaseContents);
        }

        if (!file_put_contents($databasePath, $_compressed)) {
            $error = true;
        }

        if (file_get_contents($databasePath) !== $_compressed) {
            $error = true;
        }

        if ($error) {
            $databaseName = explode("/", $databasePath);
            $databaseName = explode(".", end($databaseName))[0];

            $error = sprintf("<b>Fatal error: Could not create '%s' database.</b><br />Expected length: %s, got %s.<br />", $databaseName, strlen($_compressed), strlen(file_get_contents($databasePath)));
            if (class_exists('\WDGWV\CMS\Debugger')) {
                \WDGWV\CMS\Debugger::sharedInstance()->error($error);

                \WDGWV\CMS\Debugger::sharedInstance()->error("Expected: {$_compressed}");
                \WDGWV\CMS\Debugger::sharedInstance()->error("Got: " . file_get_contents($databasePath));
            }

            echo $error;
        }
    }

    /**
     * Private so nobody else can instantiate it
     * Construct the database
     */
    protected function __construct()
    {
        parent::__construct();

        $this->pageDatabase = $this->_loadDatabase(PT_PAGE_DB);
        $this->userDatabase = $this->_loadDatabase(PT_USER_DB);
        $this->postDatabase = $this->_loadDatabase(PT_POST_DB);
        $this->shopDatabase = $this->_loadDatabase(PT_SHOP_DB);
        $this->wikiDatabase = $this->_loadDatabase(PT_WIKI_DB);
        $this->forumDatabase = $this->_loadDatabase(PT_FORUM_DB);
        $this->orderDatabase = $this->_loadDatabase(PT_ORDER_DB);
        $this->CMSDatabase = $this->_loadDatabase(PT_CMS_DB);

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
    }

    public function __destruct()
    {
        $this->_saveDatabase(PT_CMS_DB, $this->CMSDatabase);
        $this->_saveDatabase(PT_USER_DB, $this->userDatabase);
        $this->_saveDatabase(PT_POST_DB, $this->postDatabase);
        $this->_saveDatabase(PT_PAGE_DB, $this->pageDatabase);
        $this->_saveDatabase(PT_SHOP_DB, $this->shopDatabase);
        $this->_saveDatabase(PT_WIKI_DB, $this->wikiDatabase);
        $this->_saveDatabase(PT_ORDER_DB, $this->orderDatabase);
        $this->_saveDatabase(PT_FORUM_DB, $this->forumDatabase);
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
            if (isset($this->userDatabase[$i]->username) && $this->userDatabase[$i]->username !== $userID) {
                continue;
            } else {
                return true;
            }
        }

        if (sizeof($this->userDatabase) == 0) {
            $this->userDatabase = $this->generateUserDB();
            echo "Unown error occured.<script>window.location.reload();</script>";
        }
        return false;
    }

    public function userLoad($userID)
    {

    }

    public function userLogin($userID, $userPassword)
    {
        for ($i = 0; $i < sizeof($this->userDatabase); $i++) {
            // Loaded
            // stdClass Object
            if (
                isset($this->userDatabase[$i]->password) &&
                $this->userDatabase[$i]->password == hash('sha512', $userPassword) &&
                (
                    $i === $userID or // userID matches DB ID
                    $this->userDatabase[$i]->username === $userID or // userID matches userName
                    $this->userDatabase[$i]->email === $userID // userID matches userEmail
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
                if ($this->userDatabase[$i]->username !== $userID) {
                    continue;
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
            $user = new \stdClass();
            $user->username = $userID;
            $user->password = hash('sha512', $userPassword);
            $user->email = $userEmail;
            $user->userlevel = 'member';
            $user->is_activated = false;
            $user->extra = $options;

            $this->userDatabase[] = $user;

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

    public function getTheme()
    {
        return isset($this->CMSDatabase->theme) ? $this->CMSDatabase->theme : 'admin';
    }

    public function setTheme($themeName)
    {
        if (file_exists(sprintf('./Data/Themes/%s', $themeName))) {
            if (isset($this->CMSDatabase->theme)) {
                $this->CMSDatabase->theme = $themeName;
            }
        }
    }
    public function loadMenu()
    {
        if (isset($this->CMSDatabase->menu)) {
            // force downcast stdClass to array.
            $this->CMSDatabase = json_decode(json_encode($this->CMSDatabase), true);
        }
        if (is_array(@$this->CMSDatabase['menu'])) {
            return $this->CMSDatabase['menu'];
        } else {
            if (sizeof($this->CMSDatabase) == 0) {
                $this->CMSDatabase = $this->generateSystemDB();
            }
            return $this->CMSDatabase['menu'] = $this->generateMenuDB();
        }
    }
}
