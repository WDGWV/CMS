<?php
/**
 * WDGWV CMS Required file.
 * Full access: true
 * Extension: Update
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

namespace WDGWV\CMS\Extension; /* Module namespace */

class update extends \WDGWV\CMS\extensionBase {
	private $updateURL = "https://www.wdgwv.com/upd/cms/?version=%s&module=%s&modver=%s";
	private $extensionList = array();

	/**
	 * Call the sharedInstance
	 * @since Version 1.0
	 */
	public static function sharedInstance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new \WDGWV\CMS\Extension\update();
		}
		return $inst;
	}

	/**
	 * Private so nobody else can instantiate it
	 *
	 */
	private function __construct() {
		// Read cached Extensions, if they exists, otherwise, skip.
		$this->extensionList = \WDGWV\CMS\extensions::sharedInstance()->_displayExtensionList();
	}

	public function _reload() {
		\WDGWV\CMS\extension::sharedInstance()->_forceReloadExtensions();
		if (!headers_sent()) {
			header("location: /");
		}
		echo "<script>window.location='/';</script>";
		exit;
	}

	public function _display() {
		$page = array();
		$page[] = array(
			'Test extension: \'update\'.',
			'This is an example of a test extension, which adds an item to the menu, and can display a page.<br />And many more!' .
			'to use localization use \__(\'the string which need to be translated\')');

		for ($i = 0; $i < sizeof($this->extensionList); $i++) {
			$page1 = $this->extensionList[$i];
			$page1 .= '<table>';
			foreach (\WDGWV\CMS\extensions::sharedInstance()->information($this->extensionList[$i]) as $info => $value) {
				$page1 .= sprintf("<tr><td>%s:</td><td>%s</td></tr>", $info, htmlspecialchars($value));
			};
			$page1 .= '</table>';

			$page[] = array($this->extensionList[$i], $page1);
		}

		$page[] = array('reindex', sprintf('<a href=\'/%s/extensions/reindex\'>Force reindex extensions</a>', (new \WDGWV\CMS\Config)->adminURL()));

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
	sprintf('/%s/extensions/reindex', (new \WDGWV\CMS\Config)->adminURL()), // Supports also /calendar/i*cs and then /calendar/ixcs works also
	array(update::sharedInstance(), '_reload')
);
?>