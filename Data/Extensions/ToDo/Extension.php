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

class TodoExtension extends \WDGWV\CMS\ExtensionBase
{
    /**
     * Call the sharedInstance
     * @since Version 1.0
     */
    public static function sharedInstance()
    {
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
    private function __construct()
    {
    }

    public function _display()
    {
        $page = array(
            array(
                'Todo list.',
                'This is a todo list (static, for creating/debugging use only atm)',
            ),

            array('Plain text Database support', '---<br />Plain text Database support<br /><br />
				<b>**Supported**</b><br /><br />
				<ul>
					<li>*<progress min=0 max=100 value=100></progress> 100% | Connection (N/A)</li>
					<li>*<progress min=0 max=100 value=100></progress> 000% | ... Other</li>
				</ul><br />Overall progress: <progress min=0 max=2 value=2></progress> 2/2<br /><br />', ),

            array('Extensibility', '---<br />Extensibility for extensions/plugins/modules<br /><br />
				<b>**Supported**</b><br /><br />
				<ul>
					<li>*<progress min=0 max=100 value=100></progress> 100% | Page extensions</li>
					<li>*<progress min=0 max=100 value=100></progress> 100% | Menu extensions</li>
					<li>*<progress min=0 max=100 value=100></progress> 100% | URL-extensions (override)</li>
					<li>*<progress min=0 max=100 value=100></progress> 100% | before-content (one item only)</li>
					<li>*<progress min=0 max=100 value=100></progress> 100% | after-content (one item only)</li>
					<li>*<progress min=0 max=100 value=100></progress> 100% | Specific $_POST extensions</li>
					<li>*<progress min=0 max=100 value=100></progress> 100% | Specific $_GET extensions</li>
					<li>*<progress min=0 max=100 value=25></progress> 025% | Partial: UBB code extensions</li>
				</ul><br />
				Progress: <progress min=0 max=6 value=5></progress> 7/8<br />'),

            array('Extension: demo mode', '---<br />Extension: demo mode<br /><br />
				<b>**Supported**</b><br /><br />
				<ul>
					<li>*<progress min=0 max=100 value=100></progress> 100% | Strip $_POST</li>
					<li>*<progress min=0 max=100 value=100></progress> 100% | Strip $_GET</li>
					<li>*<progress min=0 max=100 value=100></progress> 100% | Warning if $_GET or $_POST (before-content)</li>
					<li>*<progress min=0 max=100 value=100></progress> 100% | Extra footer notice (after-content)</li>
				</ul><br />Overall progress: <progress min=0 max=4 value=4></progress> 4/4<br /><br />', ),

            array('item 2', '---<br />description<br /><br />
				<b>**Supported**</b><br /><br />
				<ul>
					<li>*<progress min=0 max=100 value=0></progress> 000% | ...</li>
					<li>*<progress min=0 max=100 value=0></progress> 000% | ...</li>
				</ul><br />Overall progress: <progress min=0 max=2 value=0></progress> 0/2<br /><br />', ),

            array('MySQL Database support', '---<br />MySQL Database support<br /><br />
				<b>**Supported**</b><br /><br />
				<ul>
					<li>*<progress min=0 max=100 value=0></progress> 000% | Connection</li>
					<li>*<progress min=0 max=100 value=0></progress> 000% | ...</li>
				</ul><br />Overall progress: <progress min=0 max=2 value=0></progress> 0/2<br /><br />', ),
            array('SQLite Database support', '---<br />SQLite Database support<br /><br />
				<b>**Supported**</b><br /><br />
				<ul>
					<li>*<progress min=0 max=100 value=0></progress> 000% | Connection</li>
					<li>*<progress min=0 max=100 value=0></progress> 000% | ...</li>
				</ul><br />Overall progress: <progress min=0 max=2 value=0></progress> 0/2<br /><br />', ),

            array('MAYBE LATER: CRM',
                '---<br />CRM Support (extension?)<br /><br />Depends on: usage of CMS<br /><br />Progress: <progress min=0 max=100 value=0></progress> 0%<br /><br />'),
            array('MAYBE LATER: ERP',
                '---<br />ERP Support (extension?)<br /><br />Depends on: usage of CMS<br /><br />Progress: <progress min=0 max=100 value=0></progress> 0%<br /><br />'),
        );

        return $page;
    }
}

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'menu',
    'TODO',
    array(
        'name' => 'TODO',
        'icon' => 'pencil',
        'url' => '/dev/TODO',
        'userlevel' => '*',
    )
);

\WDGWV\CMS\Hooks::sharedInstance()->createHook(
    'url',
    '/dev/TODO', // Supports also /calendar/i*cs and then /calendar/ixcs works also
    array(todoExtension::sharedInstance(), '_display')
);
