<?php
namespace WDGWV\CMS\controllers;

class page extends \WDGWV\CMS\controllers\base {
	// private static $databaseConnection = '';
	private $parser = '';
	private $database = '';
	private $CMS = '';

	public function __construct($parser, $CMS, $databaseConnection = 'std') {
		global $database;
		$this->parser = $parser;
		$this->CMS = $CMS;
		if ($databaseConnection === 'std') {
			$this->database = $database;
		} else {
			$this->database = $databaseConnection;
		}
	}

	public function pageExists($pageID) {
		return false;
	}

	public function displayPage($pageID = 'auto') {
		$e = explode("/", $_SERVER['REQUEST_URI']);
		$activeComponent = isset($e[1]) ? strtolower($e[1]) : 'home';
		$subComponent = isset($e[2]) ? strtolower($e[2]) : '';

		if ($this->CMS->maintenanceMode()) {
			$parser->bindParameter('post', array(
				array(
					"title" => "Maintenance Mode",
					"content" => "Please wait...",
					"date" => date("d-m-Y"),
					"comments" => null,
					"shares" => null,
					"readmore" => null,
					"keywords" => "Updating, Update, WDGWV CMS",
				),
			));

			return;
		}
		if ($this->CMS->singlePage()) {
			$parser->bindParameter('page', $this->CMS->getContent());
			return;
		}

		if ($activeComponent === "blog") {
			if (!empty($subComponent)) {
				if ($this->database->postExists($subComponent)) {
					$blogData = $this->database->postLoad($subComponent);

					$this->parser->bindParameter('post', array(
						array(
							"title" => $blogData[0],
							"content" => base64_encode($blogData[1]),
							"date" => $blogData[3],
							"comments" => null,
							"shares" => null,
							"readmore" => null,
							"keywords" => $blogData[2],
						),
					));
					$this->parser->bindParameter('page', '');
					return;
				}
			} else {
				$this->parser->bindParameter('page', '');
				$blogData = $this->database->postGetLast();

				$this->parser->bindParameter('post', array(
					array(
						"title" => $blogData[0],
						"content" => base64_encode($blogData[1]),
						"date" => $blogData[3],
						"comments" => null,
						"shares" => null,
						"readmore" => null,
						"keywords" => $blogData[2],
					),
				));
				return;
			}
		}

		if ($activeComponent === 'search') {
			$this->parser->bindParameter('page', sprintf('Searching \'%s\'...', $subComponent));
			return;
		}

		$this->parser->bindParameter('page', sprintf('THE PAGE \'%s\' DOES NOT EXISTS', $activeComponent));
		return;
	}
}

?>