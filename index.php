<?php
error_reporting(E_ALL);

include_once './data/system/loader.php';

$emulation = array(
	'Blogger' => new \WDGWV\CMS\emulation\Blogger(),
	'WordPress' => new \WDGWV\CMS\emulation\WordPress(),
);
$pageController = new \WDGWV\CMS\controllers\page("x");

if ($installer->isInstalled()) {
	// echo $CMS->serve();
	// TODO: SEE ABOVE FUNCTION...
	if ($emulation['Blogger']->isBlogger($CMS->getTheme())) {
		$emulation['Blogger']->blogger(
			$CMS->getTheme()
		);
	} elseif ($emulation['WordPress']->isWordpress($CMS->getTheme())) {
		$emulation['WordPress']->wordpress(
			$CMS->getTheme()
		);
	} else {
		$parser = new WDGWV\General\templateParser(
			(new \WDGWV\CMS\Config())->debug,
			null,
			CMS_TEMPLATE_DIR
		);
		$parser->setParameter(
			'{ITEM:',
			'}'
		);
		$parser->setTemplate(
			$CMS->getTheme(),
			'html',
			'/data/themes/' . $CMS->getTheme() . '/'
		);
		$parser->bindParameter('year', @date('Y'));

		/**/
		$parser->bindParameter('SITE_TITLE', $CMS->getTitle());

		$parser->setMenuContents($CMS->menu());

		if ($CMS->maintenanceMode()) {
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
		} else if ($CMS->singlePage()) {
			$parser->bindParameter('page', $CMS->getContent());
		} else if ($pageController->pageExists($_SERVER['REQUEST_URI'])) {
			$parser->bindParameter('page', $pageController->displayPage($_SERVER['REQUEST_URI']));
		} elseif (false == true) {
			// BLOGPOST.
			$parser->bindParameter('page', '');
		} else {
			$parser->bindParameter('page', $pageController->displayPage('404'));
		}

		// $parser->bindParameter('post', array(
		// 	array(
		// 		"title" => "{$_SERVER['REQUEST_URI']}",
		// 		"content" => "Testing it out...",
		// 		"date" => date("d-m-Y"),
		// 		"comments" => null,
		// 		"shares" => null,
		// 		"keywords" => null,
		// 	),
		// 	array(
		// 		"title" => "Ali B",
		// 		"content" => "Testing it out...",
		// 		"date" => @date("d-m-Y H:i"),
		// 		"comments" => "0",
		// 		"shares" => "0",
		// 		"keywords" => "Thank You,Rapper,Gehuwd",
		// 	),
		// 	array(
		// 		"title" => "Bert S",
		// 		"content" => "Testing it out...",
		// 		"date" => @date("d-m-Y H:i"),
		// 		"comments" => "0",
		// 		"shares" => "0",
		// 		"keywords" => "Thank You,Sesamstraat,Hond",
		// 	),
		// 	array(
		// 		"title" => "Ernie S",
		// 		"content" => "Testing it out...",
		// 		"date" => @date("d-m-Y H:i"),
		// 		"comments" => "0",
		// 		"shares" => "0",
		// 		"keywords" => "Thank You,Sesamstraat,Muis",
		// 	),
		// 	array(
		// 		"title" => "Pino S",
		// 		"content" => "Testing it out...",
		// 		"date" => @date("d-m-Y H:i"),
		// 		"comments" => "0",
		// 		"shares" => "0",
		// 		"keywords" => "Thank You,Sesamstraat,Vogel",
		// 	),
		// ));
		/**/
		$parser->display();

		if ($parser->didDisplay()) {
			echo "THEME " . $CMS->getTheme() . " Does not exists!";
		}
	}
} else {
	if ($installer->canOfflineInstall()) {
		$installer->beginOfflineInstall();
	} else {
		$installer->beginOnlineInstall();
	}

}

echo "<hr>";
if (isset($debugger)) {
	$debugger->logdump();
}
echo "<hr>";
$debugger->dumpAllClasses();
?>