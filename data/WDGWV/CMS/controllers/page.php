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

	private function parseUBBTags($input) {
		if (class_exists('\WDGWV\CMS\hooks')) {
			$customHooks = \WDGWV\CMS\hooks::sharedInstance()->getUBBHooks();
		}
		$uniid = uniqid();
		$replacer = (isset($customHooks) ? $customHooks : array());
		$replacer[] = array('/\{php\}(.*)\{\/php\}/s', '<?php \\1 ?>');

		if (class_exists('\WDGWV\CMS\Debugger')) {
			\WDGWV\CMS\Debugger::sharedInstance()->log(sprintf('Parsing UBB tags with %s replacers', sizeof($replacer)));
		}

		$parse = $input;
		foreach ($replacer as $replaceWith) {
			if (sizeof($replaceWith) !== 2) {
				continue;
			}

			$parse = preg_replace($replaceWith[0], $replaceWith[1], $parse);
		}

		if (is_writable('./data/') && !file_exists('./data/temp')) {
			@mkdir('./data/temp/');
		}

		if (is_writable('./data/temp/')) {
			$fh = @fopen('./data/temp/tmp_page_' . $uniid . '.bin', 'w');
			@fwrite($fh, $parse);
			@fclose($fh);
		}

		if (!file_exists('./data/temp/tmp_page_' . $uniid . '.bin')) {
			@ob_start();
			$ob = @eval(sprintf('%s%s%s%s%s', '/* ! */', ' ?>', $uniid, '<?php ', '/* ! */'));
			$ob = ob_get_contents();
			@ob_end_clean();

			@unlink('./data/temp/tmp_page_' . $uniid . '.bin');
			if (!$ob) {
				return 'Failed to parse the page.';
			} else {
				return $ob;
			}
		} else {
			@ob_start();
			$ob = include './data/temp/tmp_page_' . $uniid . '.bin';
			$ob = ob_get_contents();
			@ob_end_clean();

			@unlink('./data/temp/tmp_page_' . $uniid . '.bin');
			if (!$ob) {
				return 'Failed to parse the page.';
			} else {
				return $ob;
			}
		}
	}

	public function displayPage($pageID = 'auto') {
		$e = explode("/", $_SERVER['REQUEST_URI']);
		$activeComponent = isset($e[1]) ? strtolower($e[1]) : 'home';
		$subComponent = isset($e[2]) ? strtolower($e[2]) : '';

		if ($activeComponent == 'crossdomain.xml' ||
			$activeComponent == 'crossdomain_xml') {
			header("content-type: text/xml");
			echo "<" . "?xml version=\"1.0\"?" . ">" . PHP_EOL;
			echo "<!DOCTYPE cross-domain-policy " . PHP_EOL;
			echo "SYSTEM \"http://www.macromedia.com/xml/dtds/cross-domain-policy.dtd\">" . PHP_EOL;
			echo "<cross-domain-policy>" . PHP_EOL;
			echo "\t<allow-access-from domain=\"googleads.g.doubleclick.net\" />" . PHP_EOL;
			echo "\t<allow-access-from domain=\"wdgwv.com\" />" . PHP_EOL;
			echo "\t<allow-access-from domain=\"" . @$_SERVER['HTTP_HOST'] . "\" />" . PHP_EOL;
			echo "</cross-domain-policy>";
			exit;
		}

		if (\WDGWV\CMS\hooks::sharedInstance()->haveHooksFor(array('post', 'get', 'url'))) {
			if (class_exists('\WDGWV\CMS\Debugger')) {
				\WDGWV\CMS\Debugger::sharedInstance()->log('Override page from module');
			}
			$pageData = \WDGWV\CMS\hooks::sharedInstance()->loadPageFor(array('post', 'get', 'url'));

			$this->parser->bindParameter('title', $pageData[0]);
			$this->parser->bindParameter('page', $pageData[1]);
			return;
		}

		if ($this->CMS->maintenanceMode()) {
			if (class_exists('\WDGWV\CMS\Debugger')) {
				\WDGWV\CMS\Debugger::sharedInstance()->log('Maintenance mode!');
			}

			$this->parser->bindParameter('post', array(
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
			if (class_exists('\WDGWV\CMS\Debugger')) {
				\WDGWV\CMS\Debugger::sharedInstance()->log('Single page mode!');
			}
			$this->parser->bindParameter('page', $this->CMS->getContent());
			return;
		}

		if ($activeComponent === '') {
			$activeComponent = 'home';
		}

		if ($activeComponent === 'blog') {
			if (class_exists('\WDGWV\CMS\Debugger')) {
				\WDGWV\CMS\Debugger::sharedInstance()->log('loading Blog');
			}

			if (!empty($subComponent)) {
				if ($this->database->postExists($subComponent)) {
					if (class_exists('\WDGWV\CMS\Debugger')) {
						\WDGWV\CMS\Debugger::sharedInstance()->log(sprintf('Post %s', $subComponent));
					}
					$blogData = $this->database->postLoad($subComponent);

					$this->parser->bindParameter('post', array(
						array(
							'title' => $blogData[0],
							'content' => base64_encode($blogData[1]),
							'date' => $blogData[3],
							'comments' => null,
							'shares' => null,
							'readmore' => null,
							'keywords' => $blogData[2],
						),
					));
					$this->parser->bindParameter('page', '');
					return;
				} elseif ($subComponent === 'last') {
					$this->parser->bindParameter('page', '');
					$blogData = $this->database->postGetLast();

					$this->parser->bindParameter('post', array(
						array(
							'title' => $blogData[0],
							'content' => base64_encode($blogData[1]),
							'date' => $blogData[3],
							'comments' => null,
							'shares' => null,
							'readmore' => null,
							'keywords' => $blogData[2],
						),
					));
					return;
				}
			} else {
				if (class_exists('\WDGWV\CMS\Debugger')) {
					\WDGWV\CMS\Debugger::sharedInstance()->log('last post');
				}

				$this->parser->bindParameter('page', '');
				$blogData = $this->database->postGetLast();

				$this->parser->bindParameter('post', array(
					array(
						'title' => $blogData[0],
						'content' => base64_encode($blogData[1]),
						'date' => $blogData[3],
						'comments' => null,
						'shares' => null,
						'readmore' => null,
						'keywords' => $blogData[2],
					),
				));
				return;
			}
		}

		if ($activeComponent === 'search') {
			if (class_exists('\WDGWV\CMS\Debugger')) {
				\WDGWV\CMS\Debugger::sharedInstance()->log('Search mode!');
			}

			$this->parser->bindParameter('page', sprintf('Searching \'%s\'...', $subComponent));
			$this->parser->bindParameter('title', $activeComponent);
			return;
		}

		if ($this->database->pageExists($activeComponent)) {
			if (class_exists('\WDGWV\CMS\Debugger')) {
				\WDGWV\CMS\Debugger::sharedInstance()->log('Found page in database');
			}
			$this->parser->bindParameter('page', sprintf(
				"%s",
				$this->parseUBBTags(
					$this->database->loadPage($activeComponent)[1]
				)
			));
			$this->parser->bindParameter('title', $activeComponent);
			return;
		}

		if (class_exists('\WDGWV\CMS\Debugger')) {
			\WDGWV\CMS\Debugger::sharedInstance()->log('Page not found!');
		}

		$this->parser->bindParameter('page', sprintf('THE PAGE \'%s\' DOES NOT EXISTS', $activeComponent));
		$this->parser->bindParameter('title', $activeComponent);
		return;
	}
}

?>