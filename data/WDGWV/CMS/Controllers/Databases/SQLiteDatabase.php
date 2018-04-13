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
    define('DB_PATH', './data/database/');
}

define('SQLITE_DB', DB_PATH . 'CMS.sqllite');

class SQLite extends \WDGWV\CMS\controllers\databases\base
{
    private $db = null;

    /**
     * Call the database
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new \WDGWV\CMS\controllers\databases\SQLite();
        }
        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     *
     */
    private function __construct()
    {
        try {
            $this->db = new PDO(sprintf('sqlite:%s', SQLITE_DB));
        } catch (PDOException $e) {
            print 'Exception : ' . $e->getMessage();
        }
    }

    public function __destruct()
    {
        unset($this->db);
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
