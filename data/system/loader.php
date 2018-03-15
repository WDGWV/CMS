<?php
define('CMS_SYSTEM_DIR', './data/system/');
define('CMS_TEMPLATE_DIR', './data/themes/');
define('CMS_CONTROLLERS_DIR', './data/controllers/');
define('CMS_COMPATIBILITY_DIR', './data/compatibility/');

require_once CMS_SYSTEM_DIR . 'WDGWV.php';

require_once CMS_SYSTEM_DIR . 'CMSConfig.php';
$_config = new WDGWV\CMS\Config();

require_once CMS_SYSTEM_DIR . 'Debugger.php';
$debugger = \WDGWV\CMS\Debugger::sharedInstance();

require_once CMS_SYSTEM_DIR . 'Installer.php';
$installer = \WDGWV\CMS\Installer::sharedInstance();

require_once CMS_SYSTEM_DIR . 'templateParser.php';
require_once CMS_SYSTEM_DIR . 'MySQL.php';

require_once CMS_COMPATIBILITY_DIR . 'blogger.php';
require_once CMS_COMPATIBILITY_DIR . 'wordpress.php';

require_once CMS_CONTROLLERS_DIR . 'base.php';
require_once CMS_CONTROLLERS_DIR . 'APIController.php';
require_once CMS_CONTROLLERS_DIR . 'ContentController.php';
require_once CMS_CONTROLLERS_DIR . 'FutureController.php';
require_once CMS_CONTROLLERS_DIR . 'LayoutController.php';
require_once CMS_CONTROLLERS_DIR . 'MenuController.php';
require_once CMS_CONTROLLERS_DIR . 'UserController.php';
require_once CMS_CONTROLLERS_DIR . 'pageController.php';
require_once CMS_CONTROLLERS_DIR . 'ShopController.php';
require_once CMS_CONTROLLERS_DIR . 'base.php';
require_once CMS_CONTROLLERS_DIR . 'database.php';
require_once CMS_CONTROLLERS_DIR . 'plainTextDatabase.php';

require_once CMS_SYSTEM_DIR . 'WDGWV_Cms.php';
$database = \WDGWV\CMS\controllers\databases\plainText::sharedInstance();
$CMS = new WDGWV\CMS\base($_config);

// TEMPORARY
// TODO: REMOVE ME!!!
$database->userRegister('wdg', 'test', 'wes@vista.aero', array('userLevel' => 100, 'is_admin' => true));
if ($database->userLogin('wdg', 'test')) {
	$_SESSION['CMS_USER_LOGIN'] = 'Wes';
	$_SESSION['SITE_TITLE'] = 'WDGWV';
} else {
	echo "Password Incorrect";
}
//$pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0

$database->createPage('home', 'Welcome at the homepage!', 'Welcome,WDGWV,CMS', array('user' => 0));
// /TEMPORARY

if ($_config->debug) {
	$installer->setDebugger($debugger);
}

// Relase after continue
unset($_config);
?>