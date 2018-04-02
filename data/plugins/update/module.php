<?php
/**
 * WDGWV CMS Required file.
 * Full access: true
 * Module: Update
 * Version: 1.0
 * Description: Updates WDGWV CMS
 * Hash: * INSERT HASH HERE *
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

namespace WDGWV\CMS\Modules; /* Module namespace */

class update extends \WDGWV\CMS\extensionBase {
	private $updateURL = "https://www.wdgwv.com/upd/cms/?version=%s&module=%s&modver=%s";
	private $moduleList = array();

	/**
	 * Call the sharedInstance
	 * @since Version 1.0
	 */
	public static function sharedInstance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new \WDGWV\CMS\Modules\update();
		}
		return $inst;
	}

	/**
	 * Private so nobody else can instantiate it
	 *
	 */
	private function __construct() {
		// Read cached modules, if they exists, otherwise, skip.
		$this->moduleList = \WDGWV\CMS\modules::sharedInstance()->_displayModuleList();
	}

	public function _reload() {
		\WDGWV\CMS\modules::sharedInstance()->_forceReloadModules();
		if (!headers_sent()) {
			header("location: /");
		}
		echo "<script>window.location='/';</script>";
		exit;
	}

	public function _display() {
		$page = array();
		$page[] = array(
			'Test module: \'update\'.',
			'This is an example of a test module, which adds an item to the menu, and can display a page.<br />And many more!' .
			'to use localization use \__(\'the string which need to be translated\')');

		for ($i = 0; $i < sizeof($this->moduleList); $i++) {
			$page1 = $this->moduleList[$i];
			$page1 .= '<table>';
			foreach (\WDGWV\CMS\modules::sharedInstance()->information($this->moduleList[$i]) as $info => $value) {
				$page1 .= sprintf("<tr><td>%s:</td><td>%s</td></tr>", $info, htmlspecialchars($value));
			};
			$page1 .= '</table>';

			$page[] = array($this->moduleList[$i], $page1);
		}

		$page[] = array('reindex', sprintf('<a href=\'/%s/modules/reindex\'>Force reindex modules</a>', (new \WDGWV\CMS\Config)->adminURL()));

		return $page;
	}
}

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'menu',
	'administration/ ',
	array(
		'name' => 'Administration/ ',
	)
);

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'menu',
	'administration/update',
	array(
		'name' => 'Administration/Update (1)',
		'icon' => 'cogs',
		'url' => sprintf('/%s/update', (new \WDGWV\CMS\Config)->adminURL()),
		'userlevel' => 'admin',
	)
);

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'url',
	sprintf('/%s/update', (new \WDGWV\CMS\Config)->adminURL()), // Supports also /calendar/i*cs and then /calendar/ixcs works also
	array(update::sharedInstance(), '_display')
);

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'url',
	sprintf('/%s/modules/reindex', (new \WDGWV\CMS\Config)->adminURL()), // Supports also /calendar/i*cs and then /calendar/ixcs works also
	array(update::sharedInstance(), '_reload')
);
?>