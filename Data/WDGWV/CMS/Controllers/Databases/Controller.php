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

class Controller extends \WDGWV\CMS\Controllers\Databases\Base
{
    /**
     * @var mixed
     */
    private $db = false;

    /**
     * Call the database controller
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
        /**
         * @var mixed
         */
        static $inst = null;

        if ($inst === null) {
            $inst = new \WDGWV\CMS\Controllers\Databases\Controller();
        }

        return $inst;
    }

    /**
     * Private so nobody else can instantiate it
     * Call the database
     *
     * @since Version 1.0
     */
    protected function __construct()
    {
        parent::__construct();
        $d = (new \WDGWV\CMS\Config())->database();
        $this->db = call_user_func("\\WDGWV\\CMS\\Controllers\\Databases\\{$d}::sharedInstance");
        if ($this->db) {
            if (!is_object($this->db)) {
                echo "Failed to load database";
                exit;
            }
        }
    }

    public function __destruct()
    {
        //..
    }

    /**
     * @param $postTitle
     * @param $strict
     * @return mixed
     */
    public function postExists($postTitle, $strict = false)
    {
        return $this->db->postExists(
            $postTitle,
            $strict
        );
    }

    /**
     * @return mixed
     */
    public function postGetLast()
    {
        return $this->db->postGetLast();
    }

    /**
     * @param $postTitle
     * @param $postContents
     * @param $postKeywords
     * @param $postDate
     * @param $postOptions
     * @param $postID
     * @return mixed
     */
    public function postCreate($postTitle, $postContents, $postKeywords, $postDate, $postOptions, $postID = 0)
    {
        return $this->db->postCreate(
            $postTitle,
            $postContents,
            $postKeywords,
            $postDate,
            $postOptions,
            $postID
        );
    }

    /**
     * @param $postID
     * @param $strict
     * @return mixed
     */
    public function postLoad($postID, $strict = false)
    {
        return $this->db->postLoad(
            $postID,
            $strict
        );
    }

    /**
     * @param $postID
     * @return mixed
     */
    public function postRemove($postID)
    {
        return $this->db->postRemove(
            $postID
        );
    }

    /**
     * @param $postID
     * @param $postTitle
     * @param $postContents
     * @param $postKeywords
     * @param $postDate
     * @param $postOptions
     * @return mixed
     */
    public function editPost($postID, $postTitle, $postContents, $postKeywords, $postDate, $postOptions)
    {
        return $this->db->editPost(
            $postID,
            $postTitle,
            $postContents,
            $postKeywords,
            $postDate,
            $postOptions
        );
    }

    /**
     * @param $userID
     * @return mixed
     */
    private function userExists($userID)
    {
        return $this->db->userExists(
            $userID
        );
    }

    /**
     * @param $userID
     * @return mixed
     */
    public function userLoad($userID)
    {
        return $this->db->userLoad(
            $userID
        );
    }

    /**
     * @param $userID
     * @param $userPassword
     * @return mixed
     */
    public function userLogin($userID, $userPassword)
    {
        return $this->db->userLogin(
            $userID,
            $userPassword
        );
    }

    /**
     * @param $userID
     * @return mixed
     */
    public function userDelete($userID)
    {
        return $this->db->userDelete(
            $userID
        );
    }

    /**
     * @param $userID
     * @param $userPassword
     * @param $userEmail
     * @param array $options
     * @return mixed
     */
    public function userRegister($userID, $userPassword, $userEmail, $options = array())
    {
        return $this->db->userRegister(
            $userID,
            $userPassword,
            $userEmail,
            $options
        );
    }

    /**
     * @param $pageTitle
     * @param $pageContents
     * @param $pageKeywords
     * @param array $pageOptions
     * @param $pageID
     * @return mixed
     */
    public function createPage($pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0)
    {
        return $this->db->createPage(
            $pageTitle,
            $pageContents,
            $pageKeywords,
            $pageOptions,
            $pageID
        );
    }

    /**
     * @param $pageTitleOrID
     * @param $strict
     * @return mixed
     */
    public function pageExists($pageTitleOrID, $strict = false)
    {
        return $this->db->pageExists(
            $pageTitleOrID,
            $strict
        );
    }

    /**
     * @param $pageTitleOrID
     * @param $strict
     * @return mixed
     */
    public function loadPage($pageTitleOrID, $strict = false)
    {
        return $this->db->loadPage(
            $pageTitleOrID,
            $strict
        );
    }

    /**
     * @param $menuItemsArray
     * @return mixed
     */
    public function setMenuItems($menuItemsArray)
    {
        return $this->db->setMenuItems(
            $menuItemsArray
        );
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->db->getTheme();
    }

    /**
     * @param $themeName
     * @return mixed
     */
    public function setTheme($themeName)
    {
        return $this->db->setTheme(
            $themeName
        );
    }

    public function loadMenu()
    {
        return array_merge($this->db->loadMenu(), \WDGWV\CMS\Hooks::sharedInstance()->loopHook('menu'));
    }
}
