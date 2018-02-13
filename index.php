<?php
error_reporting(E_ALL);

include_once './data/system/loader.php';

if ($installer->isInstalled()) {
	$CMS->serve();
} else {
	if ($installer->canOfflineInstall()) {
		$installer->beginOfflineInstall();
	} else {
		$installer->beginOnlineInstall();
	}
}

if ((new \WDGWV\CMS\config())->debug) {
	echo "<hr>";
	if (isset($debugger)) {
		$debugger->logdump();
	}
	echo "<hr>";
	$debugger->dumpAllClasses();
}
?>