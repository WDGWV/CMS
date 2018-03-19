<?php
/** Loader
 *
 * Loads everything you'll ever need.
 */

/*
------------------------------------------------------------
-                :....................,:,                  -
-              ,.`,,,::;;;;;;;;;;;;;;;;:;`                 -
-            `...`,::;:::::;;;;;;;;;;;;;::'                -
-           ,..``,,,::::::::::::::::;:;;:::;               -
-          :.,,``..::;;,,,,,,,,,,,,,:;;;;;::;`             -
-         ,.,,,`...,:.:,,,,,,,,,,,,,:;:;;;;:;;             -
-        `..,,``...;;,;::::::::::::::'';';';:''            -
-        ,,,,,``..:;,;;:::::::::::::;';;';';;'';           -
-       ,,,,,``....;,,:::::::;;;;;;;;':'''';''+;           -
-       :,::```....,,,:;;;;;;;;;;;;;;;''''';';';;          -
-      `,,::``.....,,,;;;;;;;;;;;;;;;;'''''';';;;'         -
-      :;:::``......,;;;;;;;;:::::;;;;'''''';;;;:-         -
-      ;;;::,`.....,::;;::::::;;;;;;;;'''''';;,;;,         -
-      ;:;;:;`....,:::::::::::::::::;;;;'''':;,;;;         -
-      ';;;;;.,,,,::::::::::::::::::;;;;;''':::;;'         -
-      ;';;;;.;,,,,::::::::::::::::;;;;;;;''::;;;'         -
-      ;'';;:;..,,,;;;:;;:::;;;;;;;;;;;;;;;':::;;'         -
-      ;'';;;;;.,,;:;;;;;;;;;;;;;;;;;;;;;;;;;:;':;         -
-      ;''';;:;;.;;;;;;;;;;;;;;;;;;;;;;;;;;;''';:.         -
-      :';';;;;;;::,,,,,,,,,,,,,,:;;;;;;;;;;'''';          -
-       '';;;;:;;;.,,,,,,,,,,,,,,,,:;;;;;;;;'''''          -
-       '''';;;;;:..,,,,,,,,,,,,,,,,,;;;;;;;''':,          -
-       .'''';;;;....,,,,,,,,,,,,,,,,,,,:;;;''''           -
-        ''''';;;;....,,,,,,,,,,,,,,,,,,;;;''';.           -
-         '''';;;::.......,,,,,,,,,,,,,:;;;''''            -
-         `''';;;;:,......,,,,,,,,,,,,,;;;;;''             -
-          .'';;;;;:.....,,,,,,,,,,,,,,:;;;;'              -
-           `;;;;;:,....,,,,,,,,,,,,,,,:;;''               -
-             ;';;,,..,.,,,,,,,,,,,,,,,;;',                -
-               '';:,,,,,,,,,,,,,,,::;;;:                  -
-                 `:;'''''''''''''''';:.                   -
-                                                          -
- ,,,::::::::::::::::::::::::;;;;,:::::::::::::::::::::::: -
- ,::::::::::::::::::::::::::;;;;,:::::::::::::::::::::::: -
- ,:; ## ## ##  #####     ####      ## ## ##  ##   ##  ;:: -
- ,,; ## ## ##  ## ##    ##         ## ## ##  ##   ##  ;:: -
- ,,; ## ## ##  ##  ##  ##   ####   ## ## ##   ## ##   ;:: -
- ,,' ## ## ##  ## ##    ##    ##   ## ## ##   ## ##   ::: -
- ,:: ########  ####      ######    ########    ###    ::: -
- ,,,:,,:,,:::,,,:;:::::::::::::::;;;:::;:;::::::::::::::: -
- ,,,,,,,,,,,,,,,,,,,,,,,,:,::::::;;;;:::::;;;;::::;;;;::: -
-                                                          -
-       (c) WDGWV. 2013, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

//TODO: Setup Autoloader.
function autloadWDGWVCMS($class) {
	$fileName = str_replace('\\', '/', $class);
	$fileName = sprintf('./data/%s.php', $fileName);

	if (file_exists($fileName)) {
		require_once $fileName;
	} else {
		if (sizeof(explode('\\', $class)) > 1) {
			echo "<b>WARNING</b><br />";
			echo "Couldn't load class <b>{$class}</b> the required file is missing!<br />";
			echo "Attempted to load: {$fileName}";
			exit();
		}
	}

	return;
}

spl_autoload_register('autloadWDGWVCMS');

/**
 * Define Template directory
 */
define('CMS_TEMPLATE_DIR', './data/themes/');

/**
 * Initialize the configuration
 * @param $_config class The configuration class
 */
$_config = new WDGWV\CMS\Config();

/**
 * Initialize the debugger
 * @param $debugger class The debugger class
 */
$debugger = \WDGWV\CMS\Debugger::sharedInstance();

/**
 * Initialize the installer
 * @param $installer class The installer class
 */
$installer = \WDGWV\CMS\Installer::sharedInstance();
$database = \WDGWV\CMS\controllers\databases\plainText::sharedInstance();
$CMS = new WDGWV\CMS\base($_config);

// TEMPORARY
// TODO: REMOVE ME!!!
$regi = $database->userRegister('wdg', 'test', 'wes@vista.aero', array('userLevel' => 100, 'is_admin' => true));
// echo ($regi) ? 'Created user' : 'Failed to create';
if ($regi) {
	if ($database->userLogin('wdg', 'test')) {
		$_SESSION['CMS_USER_LOGIN'] = 'Wes';
		$_SESSION['SITE_TITLE'] = 'WDGWV';
	} else {
		echo "Password Incorrect";
	}
}
//$pageTitle, $pageContents, $pageKeywords, $pageOptions = array(), $pageID = 0

$database->createPage('home', 'Welcome at the homepage!', 'Welcome,WDGWV,CMS', array('user' => 0));
$database->createPage('about', '
<h1>Welcome to WDGWV CMS</h1>
Some stats:<br />
<script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_factoids_stats.js"></script>
<br />
<script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_users.js?style=blue"></script>
<br /><br />
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ONDERAAN -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-5555094756467155"
     data-ad-slot="1975252506"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>', 'WDGWV,CMS', array('user' => 0));
// /TEMPORARY

if ($_config->debug) {
	$installer->setDebugger($debugger);
}

// Relase after continue
unset($_config);
?>