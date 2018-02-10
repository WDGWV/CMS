<?php
namespace WDGWV\CMS\controllers;

class content extends \WDGWV\CMS\Controllers\base {
	private static $databaseConnection = '';

	public function __construct($databaseConnection) {
		static::$databaseConnection = $databaseConnection;
	}

	public function getUserById($userID) {
		return;
	}
}

?>