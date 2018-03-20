<?php
error_reporting(E_ALL);
$CMSStartTime = microtime(true);
include_once './data/WDGWV/CMS/loader.php';

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
$CMSEndTime = microtime(true);
if ((new \WDGWV\CMS\config())->debug) {
	echo sprintf("Generated this page in %.2fμs.", ($CMSEndTime - $CMSStartTime));
}
?>