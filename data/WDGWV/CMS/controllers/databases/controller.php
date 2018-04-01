<?php
/** Plain text databse controller
 *
 * Controller for a plain text database
 */

namespace WDGWV\CMS\controllers\databases;

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

class controller extends \WDGWV\CMS\controllers\databases\base {
	private $db = false;

	/**
	 * Call the database controller
	 * @since Version 1.0
	 */
	public static function sharedInstance() {
		static $inst = null;

		if ($inst === null) {
			$inst = new \WDGWV\CMS\controllers\databases\controller();
		}

		return $inst;
	}

	/**
	 * Private so nobody else can instantiate it
	 * Call the database
	 *
	 * @since Version 1.0
	 */
	protected function __construct() {
		parent::__construct();
		$d = (new \WDGWV\CMS\Config())->database();
		$this->db = call_user_func("\\WDGWV\\CMS\\controllers\\databases\\{$d}::sharedInstance");
		if ($this->db) {
			if (!is_object($this->db)) {
				echo "Failed to load database";
				exit;
			}
		}
	}

	public function __destruct() {
		//..
	}

	public function postExists($postTitle, $strict = false) {
		return $this->db->postExists(
			$postTitle,
			$strict
		);
	}

	public function postGetLast() {
		return $this->db->postGetLast();
	}

	public function postCreate($postTitle, $postContents, $postKeywords, $postDate, $postOptions, $postID = 0) {
		return $this->db->postCreate(
			$postTitle,
			$postContents,
			$postKeywords,
			$postDate,
			$postOptions,
			$postID
		);
	}

	public function postLoad($postID, $strict = false) {
		return $this->db->postLoad(
			$postID,
			$strict
		);
	}

	public function postRemove($postID) {
		return $this->db->postRemove(
			$postID
		);
	}

	public function editPost($postID, $postTitle, $postContents, $postKeywords, $postDate, $postOptions) {
		return $this->db->editPost(
			$postID,
			$postTitle,
			$postContents,
			$postKeywords,
			$postDate,
			$postOptions
		);
	}

	private function userExists($userID) {
		return $this->db->userExists(
			$userID
		);
	}

	public function userLoad($userID) {
		return $this->db->userLoad(
			$userID
		);
	}

	public function userLogin($userID, $userPassword) {
		return $this->db->userLogin(
			$userID,
			$userPassword
		);
	}

	public function userDelete($userID) {
		return $this->db->userDelete(
			$userID
		);
	}

	public function userRegister($userID, $userPassword, $userEmail, $options = array()) {
		return $this->db->userRegister(
			$userID,
			$userPassword,
			$userEmail,
			$options
		);
	}

	public function createPage($pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0) {
		return $this->db->createPage(
			$pageTitle,
			$pageContents,
			$pageKeywords,
			$pageOptions,
			$pageID
		);
	}

	public function pageExists($pageTitleOrID, $strict = false) {
		return $this->db->pageExists(
			$pageTitleOrID,
			$strict
		);
	}

	public function loadPage($pageTitleOrID, $strict = false) {
		return $this->db->loadPage(
			$pageTitleOrID,
			$strict
		);
	}

	public function setMenuItems($menuItemsArray) {
		return $this->db->setMenuItems(
			$menuItemsArray
		);
	}

	public function getTheme() {
		return $this->db->getTheme();
	}

	public function setTheme($themeName) {
		return $this->db->setTheme(
			$themeName
		);
	}

	public function loadMenu() {
		return array_merge($this->db->loadMenu(), \WDGWV\CMS\hooks::sharedInstance()->loopHook('menu'));
	}
}