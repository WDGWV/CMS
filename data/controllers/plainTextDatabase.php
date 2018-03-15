<?php
namespace WDGWV\CMS\controllers\databases;

define('DB_PATH', './data/database/');
define('CMS_DB', DB_PATH . 'CMS.db');
define('MENU_DB', DB_PATH . 'menuItems.db');
define('USER_DB', DB_PATH . 'userInfo.db');
define('POST_DB', DB_PATH . 'posts.db'); // Tip, Purge every year.
define('PAGE_DB', DB_PATH . 'pages.db');
define('SHOP_DB', DB_PATH . 'shopItems.db');
define('WIKI_DB', DB_PATH . 'wikiItems.db');
define('ORDER_DB', DB_PATH . 'orders.db');
define('FORUM_DB', DB_PATH . 'forumItems.db');

class plainText extends \WDGWV\CMS\controllers\databases\base {
	private $CMSDatabase = array();
	private $userDatabase = array();
	private $menuDatabase = array();
	private $postDatabase = array();
	private $pageDatabase = array();
	private $shopDatabase = array();
	private $wikiDatabase = array();
	private $orderDatabase = array();
	private $forumDatabase = array();

	/**
	 * Call the database
	 * @since Version 1.0
	 */
	public static function sharedInstance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new \WDGWV\CMS\controllers\databases\plainText();
		}
		return $inst;
	}

	/**
	 * Private so nobody else can instantiate it
	 *
	 */
	private function __construct() {
		if (!file_exists(MENU_DB)) {
			if (!touch(MENU_DB)) {
				// ... DEBuGGER
				// .. FATAL ERROR
				echo "COULD NOT CREATE MENU DATABASE";
			}
		}

		$_menu = @gzuncompress(file_get_contents(MENU_DB));
		if (strlen($_menu) > 10) {
			$this->menuDatabase = json_decode($_menu);
		}

		if (!file_exists(PAGE_DB)) {
			if (!touch(PAGE_DB)) {
				// ... DEBuGGER
				// .. FATAL ERROR
				echo "COULD NOT CREATE PAGE DATABASE";
			}
		}

		$_PAGE = @gzuncompress(file_get_contents(PAGE_DB));
		if (strlen($_PAGE) > 10) {
			$this->pageDatabase = json_decode($_PAGE);
		}

		if (!file_exists(USER_DB)) {
			if (!touch(USER_DB)) {
				// ... DEBuGGER
				// .. FATAL ERROR
				echo "COULD NOT CREATE USER DATABASE";
			}
		}

		$_user = @gzuncompress(file_get_contents(USER_DB));
		if (strlen($_user) > 10) {
			$this->userDatabase = json_decode($_user);
		}

		if (!file_exists(POST_DB)) {
			if (!touch(POST_DB)) {
				// ... DEBuGGER
				// .. FATAL ERROR
				echo "COULD NOT CREATE POSTS DATABASE";
			}
		}

		$_post = @gzuncompress(file_get_contents(POST_DB));
		if (strlen($_post) > 10) {
			$this->postDatabase = json_decode($_post);
		}

		if (!file_exists(SHOP_DB)) {
			if (!touch(SHOP_DB)) {
				// ... DEBuGGER
				// .. FATAL ERROR
				echo "COULD NOT CREATE SHOP DATABASE";
			}
		}

		$_shop = @gzuncompress(file_get_contents(SHOP_DB));
		if (strlen($_shop) > 10) {
			$this->shopDatabase = json_decode($_shop);
		}

		if (!file_exists(WIKI_DB)) {
			if (!touch(WIKI_DB)) {
				// ... DEBuGGER
				// .. FATAL ERROR
				echo "COULD NOT CREATE WIKI DATABASE";
			}
		}

		$_wiki = @gzuncompress(file_get_contents(WIKI_DB));
		if (strlen($_wiki) > 10) {
			$this->wikiDatabase = json_decode($_wiki);
		}

		if (!file_exists(CMS_DB)) {
			if (!touch(CMS_DB)) {
				// ... DEBuGGER
				// .. FATAL ERROR
				echo "COULD NOT CREATE CMS DATABASE";
			}
		}

		$_CMS = @gzuncompress(file_get_contents(CMS));
		if (strlen($_CMS) > 10) {
			$this->CMSDatabase = json_decode($_CMS);
		}

		if (!file_exists(ORDER_DB)) {
			if (!touch(ORDER_DB)) {
				// ... DEBuGGER
				// .. FATAL ERROR
				echo "COULD NOT CREATE ORDER DATABASE";
			}
		}

		$_order = @gzuncompress(file_get_contents(ORDER_DB));
		if (strlen($_order) > 10) {
			$this->orderDatabase = json_decode($_order);
		}

		if (!file_exists(FORUM_DB)) {
			if (!touch(FORUM_DB)) {
				// ... DEBuGGER
				// .. FATAL ERROR
				echo "COULD NOT CREATE FORUM DATABASE";
			}
		}

		$_forum = @gzuncompress(file_get_contents(FORUM_DB));
		if (strlen($_forum) > 10) {
			$this->forumDatabase = json_decode($_forum);
		}

		if (!$this->userExists('admin')) {
			$this->userDatabase[] = array(
				'admin',
				hash('sha512', 'changeme'),
				'admin@localhost',
				array('userLevel' => 100, 'is_admin' => true),
			);
		}
		if (!$this->postExists('Welcome')) {
			$this->postDatabase[] = array(
				'Welcome to the WDGWV CMS!',
				'Welcome to the WDGWV CMS!<br />',
				'Welcome,WDGWV,CMS',
				date('d-m-Y H:i:s'),
				array('userID' => 0, 'sticky' => true),
			);
		}
	}

	public function __destruct() {
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

	public function postExists($postTitle, $strict = false) {
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

	public function postGetLast() {
		return $this->postDatabase[sizeof($this->postDatabase) - 1];
	}

	public function postCreate($postTitle, $postContents, $postKeywords, $postDate, $postOptions, $postID = 0) {
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

	public function postLoad($postID, $strict = false) {
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

	public function postRemove($postID) {
		if ($this->postExists($postID, true)) {
			unset($this->postDatabase[$postID]);
		}
	}

	public function editPost($postID, $postTitle, $postContents, $postKeywords, $postDate, $postOptions) {
		if ($this->postRemove($postID)) {
			if ($this->postCreate($postTitle, $postContents, $postKeywords, $postDate, $postOptions, $postID)) {
				return true;
			}
		}
		return false;
	}

	private function userExists($userID) {
		for ($i = 0; $i < sizeof($this->userDatabase); $i++) {
			if (!in_array($userID, $this->userDatabase[$i])) {
				// continue
			} else {
				return true;
			}
		}

		return false;
	}

	public function userLoad($userID) {

	}

	public function userLogin($userID, $userPassword) {
		for ($i = 0; $i < sizeof($this->userDatabase); $i++) {
			if (
				$this->userDatabase[$i][1] != $userPassword &&
				(
					$i === $userID Or // userID matches DB ID
					$this->userDatabase[$i][0] === $userID Or // userID matches userName
					$this->userDatabase[$i][2] === $userID // userID matches userEmail
				)
			) {
				return true;
			}
		}

		return false;
	}

	public function userDelete($userID) {
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

	public function userRegister($userID, $userPassword, $userEmail, $options = array()) {
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

	public function createPage($pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0) {
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

	public function pageExists($pageTitleOrID, $strict = false) {
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

	public function loadPage($pageTitleOrID, $strict = false) {
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

	public function setMenuItems($menuItemsArray) {
		$this->CMSDatabase['menu'] = $menuItemsArray;
	}

	public function loadMenu() {
		if (is_array(@$this->CMSDatabase['menu'])) {
			return $this->CMSDatabase['menu'];
		} else {
			return array(
				'Home' => '/home',
				'Blog' => '/blog',
				'Administration' => '/administration',
				'About' => '/about',
			);
		}
	}
}