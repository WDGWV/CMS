<?php
/**
 * WDGWV CMS Extension file.
 * Full access: false
 * Extension: Test Extension
 * Version: 1.0
 * Description: This is a simple test for a Extension file.
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

namespace WDGWV\CMS\Extension; /* Extension namespace */

class extensionList extends \WDGWV\CMS\extensionBase {
	private $extensionList = array();
	/**
	 * Call the sharedInstance
	 * @since Version 1.0
	 */
	public static function sharedInstance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new \WDGWV\CMS\Extension\extensionList();
		}
		return $inst;
	}

	/**
	 * Private so nobody else can instantiate it
	 *
	 */
	private function __construct() {
		$this->extensionList = \WDGWV\CMS\extensions::sharedInstance()->_displayExtensionList();
	}

	public function _forceReload() {
		\WDGWV\CMS\extensions::sharedInstance()->_forceReloadExtensions();
		if (!headers_sent()) {
			header("location: /");
		}
		echo "<script>window.location='/';</script>";
		exit;
	}

	public function _display() {
		$page = array();
		$page[] = array(
			'Extensions list',
			'This is an extension what list all loaded extensions, it also offers a force-reload option in the bottom of the page',
		);

		for ($i = 0; $i < sizeof($this->extensionList); $i++) {
			$name = explode('/', $this->extensionList[$i])[sizeof(explode('/', $this->extensionList[$i])) - 2];

			$page1 = $this->extensionList[$i];
			$page1 .= '<table>';
			foreach (\WDGWV\CMS\extensions::sharedInstance()->information($this->extensionList[$i]) as $info => $value) {
				if ($info === 'extension') {$name = $value;}
				$page1 .= sprintf("<tr><td>%s:</td><td>%s</td></tr>", $info, htmlspecialchars($value));
			};
			$page1 .= '</table>';

			$page[] = array(
				sprintf('%s extension', $name),
				$page1,
			);
		}

		$page[] = array(
			'Reindex extensions',
			sprintf('<a href=\'/%s/extensions/reindex\'>Force reindex extensions</a>', (new \WDGWV\CMS\Config)->adminURL()),
		);

		return $page;
	}
}

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'menu',
	'administration/Extension list',
	array(
		'name' => 'administration/Extension list',
		'icon' => 'pencil',
		'url' => sprintf('/%s/extensions/list', (new \WDGWV\CMS\Config)->adminURL()),
		'userlevel' => 'admin',
	)
);

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'menu',
	'administration/Extension search',
	array(
		'name' => 'administration/Extension search',
		'icon' => 'pencil',
		'url' => sprintf('/%s/extensions/search', (new \WDGWV\CMS\Config)->adminURL()),
		'userlevel' => 'admin',
	)
);

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'url',
	sprintf('/%s/extensions/list', (new \WDGWV\CMS\Config)->adminURL()), // Supports also /calendar/i*cs and then /calendar/ixcs works also
	array(extensionList::sharedInstance(), '_display')
);

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'url',
	sprintf('/%s/extensions/reindex', (new \WDGWV\CMS\Config)->adminURL()), // Supports also /calendar/i*cs and then /calendar/ixcs works also
	array(extensionList::sharedInstance(), '_forceReload')
);
?>