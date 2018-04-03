<?php
/**
 * WDGWV CMS Module file.
 * Full access: false
 * Module: Test module
 * Version: 1.0
 * Description: This is a simple test for a module file.
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

class moduleList extends \WDGWV\CMS\extensionBase {
	private $moduleList = array();
	/**
	 * Call the sharedInstance
	 * @since Version 1.0
	 */
	public static function sharedInstance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new \WDGWV\CMS\Modules\moduleList();
		}
		return $inst;
	}

	/**
	 * Private so nobody else can instantiate it
	 *
	 */
	private function __construct() {
		$this->moduleList = \WDGWV\CMS\modules::sharedInstance()->_displayModuleList();
	}

	public function _forceReload() {
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
			'Module list',
			'This is module list all loaded modules, it also offers a force-reload option in the bottom of the page',
		);

		for ($i = 0; $i < sizeof($this->moduleList); $i++) {
			$name = explode('/', $this->moduleList[$i])[sizeof(explode('/', $this->moduleList[$i])) - 2];

			$page1 = $this->moduleList[$i];
			$page1 .= '<table>';
			foreach (\WDGWV\CMS\modules::sharedInstance()->information($this->moduleList[$i]) as $info => $value) {
				if ($info === 'module') {$name = $value;}
				$page1 .= sprintf("<tr><td>%s:</td><td>%s</td></tr>", $info, htmlspecialchars($value));
			};
			$page1 .= '</table>';

			$page[] = array(
				sprintf('%s module', $name),
				$page1,
			);
		}

		$page[] = array(
			'Reindex modules',
			sprintf('<a href=\'/%s/modules/reindex\'>Force reindex modules</a>', (new \WDGWV\CMS\Config)->adminURL()),
		);

		return $page;
	}
}

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'menu',
	'administration/module list',
	array(
		'name' => 'administration/module list',
		'icon' => 'pencil',
		'url' => sprintf('/%s/modules/list', (new \WDGWV\CMS\Config)->adminURL()),
		'userlevel' => 'admin',
	)
);

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'menu',
	'administration/module search',
	array(
		'name' => 'administration/module search',
		'icon' => 'pencil',
		'url' => sprintf('/%s/modules/search', (new \WDGWV\CMS\Config)->adminURL()),
		'userlevel' => 'admin',
	)
);

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'url',
	sprintf('/%s/modules/list', (new \WDGWV\CMS\Config)->adminURL()), // Supports also /calendar/i*cs and then /calendar/ixcs works also
	array(moduleList::sharedInstance(), '_display')
);

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'url',
	sprintf('/%s/modules/reindex', (new \WDGWV\CMS\Config)->adminURL()), // Supports also /calendar/i*cs and then /calendar/ixcs works also
	array(moduleList::sharedInstance(), '_forceReload')
);
?>