<?php
namespace WDGWV\CMS\controllers;

class page extends \WDGWV\CMS\controllers\base {
	private static $databaseConnection = '';

	public function __construct($databaseConnection) {
		static::$databaseConnection = $databaseConnection;
	}

	public function getUserById($userID) {
		return;
	}

	public function pageExists($pageID) {
		return true;
	}

	public function displayPage($pageID) {
		return "./data/controllers/pageController.php:20";
	}
}

?>