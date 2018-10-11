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
-       (c) WDGWV. 2018, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

/**
 * Class 'Controller'
 *
 * @version 1.0
 * @copyright Wesley de Groot
 * @depends \WDGWV\CMS\Controllers\Databases\Base
 * @package WDGWV
 * @subpackage CMS
 */
class Controller extends \WDGWV\CMS\Controllers\Databases\Base
{
    /**
     * @var mixed $database Database class.
     */
    private $database = false;

    /**
     * $dbCache
     * @var array
     */
    private $dbCache = array();

    /**
     * Call the database controller
     * @since Version 1.0
     */
    public static function shared()
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
        $databaseController = (new \WDGWV\CMS\Config())->database();
        $this->database = call_user_func("\\WDGWV\\CMS\\Controllers\\Databases\\{$databaseController}::shared");
        if ($this->database) {
            if (!is_object($this->database)) {
                echo "Failed to load database";
                exit;
            }
        }
    }

    /**
     * destruct the class.
     */
    public function __destruct()
    {
        //..
    }

    /**
     * Does the post exists
     *
     * @param string $postTitle Title
     * @param bool $strict Strict mode?
     * @return bool
     */
    public function postExists($postTitle, $strict = false)
    {
        return $this->database->postExists(
            $postTitle,
            $strict
        );
    }

    /**
     * Get the last Post
     *
     * @return mixed
     */
    public function postGetLast()
    {
        return $this->database->postGetLast();
    }

    /**
     * Create a post.
     *
     * @param string $postTitle Post title
     * @param string $postContents Post contents
     * @param string $postKeywords Post keywords
     * @param string $postDate Post date
     * @param mixed $postOptions array of options
     * @param int $postID Optional, postID
     * @return mixed
     */
    public function postCreate($postTitle, $postContents, $postKeywords, $postDate, $postOptions, $postID = 0)
    {
        return $this->database->postCreate(
            $postTitle,
            $postContents,
            $postKeywords,
            $postDate,
            $postOptions,
            $postID
        );
    }

    /**
     * Load Post
     *
     * @param int $postID postID
     * @param bool $strict Strict mode?
     * @return mixed
     */
    public function postLoad($postID, $strict = false)
    {
        return $this->database->postLoad(
            $postID,
            $strict
        );
    }

    /**
     * Remove post
     *
     * @param int $postID postID
     * @return bool
     */
    public function postRemove($postID)
    {
        return $this->database->postRemove(
            $postID
        );
    }

    /**
     * Edit post
     *
     * @param int $postID postID
     * @param string $postTitle post title
     * @param string $postContents post contents
     * @param string $postKeywords post keywords
     * @param string $postDate post date
     * @param mixed $postOptions array of options
     * @return bool
     */
    public function postEdit($postID, $postTitle, $postContents, $postKeywords, $postDate, $postOptions)
    {
        return $this->database->postEdit(
            $postID,
            $postTitle,
            $postContents,
            $postKeywords,
            $postDate,
            $postOptions
        );
    }

    /**
     * user exists?
     *
     * @param string|int $userID userID
     * @return bool
     */
    private function userExists($userID)
    {
        return $this->database->userExists(
            $userID
        );
    }

    /**
     * user load
     *
     * @param string|int $userID userID
     * @return mixed
     */
    public function userLoad($userID)
    {
        return $this->database->userLoad(
            $userID
        );
    }

    /**
     * user login
     *
     * @param string|int $userID userID
     * @param string $userPassword user password
     * @return mixed
     */
    public function userLogin($userID, $userPassword)
    {
        return $this->database->userLogin(
            $userID,
            $userPassword
        );
    }

    /**
     * delete user
     *
     * @param string|int $userID userID
     * @return bool
     */
    public function userDelete($userID)
    {
        return $this->database->userDelete(
            $userID
        );
    }

    /**
     * register user
     *
     * @param int|string $userID userID
     * @param string $userPassword
     * @param string $userEmail
     * @param array $options
     * @return mixed
     */
    public function userRegister($userID, $userPassword, $userEmail, $options = array())
    {
        return $this->database->userRegister(
            $userID,
            $userPassword,
            $userEmail,
            $options
        );
    }

    /**
     * create page
     *
     * @param string $pageTitle page title
     * @param string $pageContents page contents
     * @param string $pageKeywords page keywords
     * @param array $pageOptions page options
     * @param int $pageID Page ID (optional)
     * @return mixed
     */
    public function pageCreate($pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0)
    {
        return $this->database->pageCreate(
            $pageTitle,
            $pageContents,
            $pageKeywords,
            $pageOptions,
            $pageID
        );
    }

    /**
     * page exists
     *
     * @param string|int $pageTitleOrID page Title Or ID
     * @param bool $strict strict mode?
     * @return bool
     */
    public function pageExists($pageTitleOrID, $strict = false)
    {
        \WDGWV\CMS\Debugger::shared()->logf(
            'db',
            'pageExists(%s%s) %s',
            $pageTitleOrID,
            ($strict ? ' (strict)' : ''),
            ($this->database->pageExists(
                $pageTitleOrID,
                $strict
            ) ? 'Exists' : 'Not found')
        );

        return $this->database->pageExists(
            $pageTitleOrID,
            $strict
        );
    }

    /**
     * load page
     *
     * @param string|int $pageTitleOrID page Title Or ID
     * @param bool $strict strict mode?
     * @return mixed
     */
    public function pageLoad($pageTitleOrID, $strict = false)
    {
        \WDGWV\CMS\Debugger::shared()->logf(
            'db',
            'pageLoad(%s%s) = %s',
            $pageTitleOrID,
            ($strict ? ' (strict)' : ''),
            htmlspecialchars(
                json_encode(
                    $this->database->pageLoad(
                        $pageTitleOrID,
                        $strict
                    )
                )
            )
        );

        return $this->database->pageLoad(
            $pageTitleOrID,
            $strict
        );
    }

    /**
     * set menu items
     *
     * @param array $menuItemsArray array of menu items
     */
    public function menuSetItems($menuItemsArray = array())
    {
        \WDGWV\CMS\Debugger::shared()->logf('db', 'menuSetItems = %s', json_encode($menuItemsArray));

        return $this->database->menuSetItems(
            $menuItemsArray
        );
    }

    /**
     * get theme
     *
     * @return string theme
     */
    public function themeGet()
    {
        \WDGWV\CMS\Debugger::shared()->logf('db', 'theme = %s', $this->database->themeGet());

        return $this->database->themeGet();
    }

    /**
     * set theme
     *
     * @param string $themeName theme name
     */
    public function themeSet($themeName)
    {
        \WDGWV\CMS\Debugger::shared()->logf('db', 'themeSet = %s', $themeName);

        return $this->database->themeSet(
            $themeName
        );
    }

    /**
     * load menu items
     *
     * @return mixed array with menu contents
     */
    public function menuLoad()
    {
        \WDGWV\CMS\Debugger::shared()->logf(
            'db',
            'menuLoad = %s',
            json_encode(
                array_merge(
                    $this->database->menuLoad(),
                    \WDGWV\CMS\Hooks::shared()->loopHook('menu')
                )
            )
        );

        return array_merge(
            $this->database->menuLoad(),
            \WDGWV\CMS\Hooks::shared()->loopHook('menu')
        );
    }
}
