<?php
namespace WDGWV\CMS\controllers;

class base extends \WDGWV\CMS\base {
	private static $databaseConnection = '';

	public function __construct($databaseConnection) {
		static::$databaseConnection = $databaseConnection;
	}

	public function getUserById($userID) {
		return;
	}
}

?>