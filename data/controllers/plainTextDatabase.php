<?php
namespace WDGWV\CMS\controllers\databases;

define('DB_PATH', './data/database/_');
define('MENU_DB', DB_PATH . 'menuItems.db');
define('USER_DB', DB_PATH . 'userInfo.db');
define('POST_DB', DB_PATH . 'posts.db'); // Tip, Purge every year.
define('PAGE_DB', DB_PATH . 'pages.db');

class plainText extends \WDGWV\CMS\controllers\databases\base {
	private $userDatabase = array();
	private $menuDatabase = array();
	private $postDatabase = array();
	private $pageDatabase = array();

	public function __construct() {
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

		if (!$this->userExists('admin')) {
			$this->userDatabase[] = array(
				'admin',
				hash('sha512', 'changeme'),
				'admin@localhost',
				array('userLevel' => 100, 'is_admin' => true),
			);
			return true;
		}
	}

	public function __destruct() {
		file_put_contents(MENU_DB, gzcompress(json_encode($this->menuDatabase), 9));
		file_put_contents(USER_DB, gzcompress(json_encode($this->userDatabase), 9));
		file_put_contents(POST_DB, gzcompress(json_encode($this->postDatabase), 9));
		file_put_contents(PAGE_DB, gzcompress(json_encode($this->pageDatabase), 9));
	}

	public function getMenuItems() {
		// ... Offline
	}

	public function setMenuItems($menuItems) {
		// ... Offline
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

	public function userRegister($userID, $userPassword, $userEmail, $options) {
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
}