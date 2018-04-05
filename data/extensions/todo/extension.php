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

namespace WDGWV\CMS\Extension; /* Module namespace */

class todoExtension extends \WDGWV\CMS\extensionBase {
	/**
	 * Call the sharedInstance
	 * @since Version 1.0
	 */
	public static function sharedInstance() {
		static $inst = null;
		if ($inst === null) {
			$inst = new \WDGWV\CMS\Extension\todoExtension();
		}
		return $inst;
	}

	/**
	 * Private so nobody else can instantiate it
	 *
	 */
	private function __construct() {
	}

	public function _display() {
		$page = array(
			array(
				'Todo list.',
				'This is a todo list (static, for creating/debugging use only atm)',
			),

			array('Plain text Database support', 'Plain text Database support<br /><br />
				<b>Supported</b>
				<ul>
					<li><progress min=0 max=100 value=100></progress> 100% | Connection (N/A)</li>
					<li><progress min=0 max=100 value=100></progress> 000% | ... Other</li>
				</ul><br />Overall progress: <progress min=0 max=2 value=2></progress> 2/2%'),

			array('Extensibility', "Extensibility for plugins<br /><br />
				<b>Supported</b>
				<ul>
					<li><progress min=0 max=100 value=100></progress> 100% | Page extensions</li>
					<li><progress min=0 max=100 value=100></progress> 100% | Menu extensions</li>
					<li><progress min=0 max=100 value=100></progress> 100% | URL-extensions (override)</li>
					<li><progress min=0 max=100 value=100></progress> 100% | Specific \$_POST extensions</li>
					<li><progress min=0 max=100 value=100></progress> 100% | Specific \$_GET extensions</li>
					<li><progress min=0 max=100 value=25></progress> 025% | Partial: UBB code extensions</li>
				</ul><br />
				Progress: <progress min=0 max=6 value=5></progress> 5/6", ),
			array('item 2', 'description<br /><br />
				<b>Supported</b>
				<ul>
					<li><progress min=0 max=100 value=0></progress> 000% | ...</li>
					<li><progress min=0 max=100 value=0></progress> 000% | ...</li>
				</ul><br />Overall progress: <progress min=0 max=2 value=0></progress> 0/2%'),

			array('MySQL Database support', 'MySQL Database support<br /><br />
				<b>Supported</b>
				<ul>
					<li><progress min=0 max=100 value=0></progress> 000% | Connection</li>
					<li><progress min=0 max=100 value=0></progress> 000% | ...</li>
				</ul><br />Overall progress: <progress min=0 max=2 value=0></progress> 0/2%'),
			array('SQLite Database support', 'SQLite Database support<br /><br />
				<b>Supported</b>
				<ul>
					<li><progress min=0 max=100 value=0></progress> 000% | Connection</li>
					<li><progress min=0 max=100 value=0></progress> 000% | ...</li>
				</ul><br />Overall progress: <progress min=0 max=2 value=0></progress> 0/2%'),

			array('MAYBE LATER: CRM',
				'CRM Support (extension?)<br /><br />Depends on: usage of CMS<br /><br />Progress: <progress min=0 max=100 value=0></progress> 0%'),
			array('MAYBE LATER: ERP',
				'ERP Support (extension?)<br /><br />Depends on: usage of CMS<br /><br />Progress: <progress min=0 max=100 value=0></progress> 0%'),
		);

		return $page;
	}
}

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'menu',
	'TODO',
	array(
		'name' => 'TODO',
		'icon' => 'pencil',
		'url' => '/dev/TODO',
		'userlevel' => '*',
	)
);

\WDGWV\CMS\hooks::sharedInstance()->createHook(
	'url',
	'/dev/TODO', // Supports also /calendar/i*cs and then /calendar/ixcs works also
	array(todoExtension::sharedInstance(), '_display')
);
?>