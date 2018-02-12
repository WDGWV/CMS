<?php
// include './data/include/template.php';
// include './data/include/MySQL.php';
define('CMS_SYSTEM_DIR', './data/system/');
define('CMS_TEMPLATE_DIR', './data/themes/');
define('CMS_CONTROLLERS_DIR', './data/controllers/');
define('CMS_COMPATIBILITY_DIR', './data/compatibility/');

require_once CMS_SYSTEM_DIR . 'WDGWV.php';

require_once CMS_SYSTEM_DIR . 'CMSConfig.php';
$_config = new WDGWV\CMS\Config();

require_once CMS_SYSTEM_DIR . 'Debugger.php';
$debugger = new WDGWV\CMS\Debugger();

require_once CMS_SYSTEM_DIR . 'Installer.php';
$installer = new WDGWV\CMS\Installer();

require_once CMS_SYSTEM_DIR . 'templateParser.php';
require_once CMS_SYSTEM_DIR . 'MySQL.php';
require_once CMS_SYSTEM_DIR . 'WDGWV_Cms.php';
$CMS = new WDGWV\CMS\base($_config);

require_once CMS_COMPATIBILITY_DIR . 'blogger.php';
require_once CMS_COMPATIBILITY_DIR . 'wordpress.php';

// Load all controllers ('temporary solution')
require_once CMS_CONTROLLERS_DIR . 'base.php';
require_once CMS_CONTROLLERS_DIR . 'database.php';
require_once CMS_CONTROLLERS_DIR . 'plainTextDatabase.php';
$database = new \WDGWV\CMS\controllers\databases\plainText();

// TEMPORARY
// TODO: REMOVE ME!!!
$database->userRegister('wdg', 'test', 'wes@vista.aero', array('userLevel' => 100, 'is_admin' => true));
if ($database->userLogin('wdg', 'test')) {
	$_SESSION['CMS_USER_LOGIN'] = 'Wes';
	$_SESSION['SITE_TITLE'] = 'WDGWV';
} else {
	echo "Password Incorrect";
}
$database->postCreate('Welcome', $CMS->getContent(), 'Welcome, WDGWV, Tag1, Tag2', date('d-m-Y H:i:s'), array('sticky' => true));
// /TEMPORARY

require_once CMS_CONTROLLERS_DIR . 'base.php';
require_once CMS_CONTROLLERS_DIR . 'APIController.php';
require_once CMS_CONTROLLERS_DIR . 'ContentController.php';
require_once CMS_CONTROLLERS_DIR . 'FutureController.php'; // Experimental functions.
require_once CMS_CONTROLLERS_DIR . 'LayoutController.php';
require_once CMS_CONTROLLERS_DIR . 'MenuController.php';
require_once CMS_CONTROLLERS_DIR . 'pageController.php';
require_once CMS_CONTROLLERS_DIR . 'ShopController.php';
require_once CMS_CONTROLLERS_DIR . 'UserController.php';

if ($_config->debug) {
	$installer->setDebugger($debugger);
}

// Relase after continue
unset($_config);

// $loader = new \WDGWV\General\WDGWVCMSFileLoader();
// $loader->load(array(
// 'languageController',
// 'Debugger',
// 'WDGWV_CMS_Installer',
// 'WDGWV_Templateparser',
// 'MySQL',
// 'WDGWV_CMS',
// 'wordpress-compatibility',
// ));

?>