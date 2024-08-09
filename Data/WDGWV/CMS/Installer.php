<?php

/** CMS Installer
 *
 * it installs it for you!
 */

namespace WDGWV\CMS;

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
-       (c) WDGWV. 2018, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

/**
 *
 * WDGWV CMS Installer Class
 *
 * Installer.
 *
 * @package    WDGWV
 * @subpackage WDGWV/CMS
 * @author     Wesley de Groot <wes@wdgwv.com>
 * @version    v1.0s
 * @access     public
 */
class Installer
{
    /**
     * debugger
     *
     * @since v1.0a
     * @access private
     * @return bool $debug
     */
    private $debug = false;

    /**
     * debugger class
     *
     * @since v1.0a
     * @access private
     * @return class $debugger
     */
    private $debugger = null;

    /**
     * Call the shared instance
     * @since Version 1.0
     */
    public static function shared()
    {
        /**
         * Shared Instance
         * @var class
         */
        static $inst = null;

        /**
         * If not have a instance, create one.
         */
        if ($inst === null) {
            /**
             * Initialisize Shared Instance
             * @var class
             */
            $inst = new \WDGWV\CMS\Installer();
        }

        /**
         * Return Shared Instance
         */
        return $inst;
    }

    /**
     * @param $debugger
     */
    public function setDebugger($debugger)
    {
        $this->debug = true;
        $this->debugger = $debugger;
    }

    /**
     *
     * checks if the system is already installed is, or not.
     *
     * @since v1.0a
     * @access public
     * @return void
     */
    public function isInstalled()
    {
        if (file_exists('Data/WDGWV/CMS/installed')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * checks if the files are already downloaded is.
     *
     * @since v1.0a
     * @access public
     * @return void
     */
    public function canOfflineInstall()
    {
        if (file_exists('install.app')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * turns int into unicode HTML
     *
     * @since v1.0a
     * @param string $u the Unicode
     * @access public
     * @return void
     */
    private function unichr($char)
    {
        return mb_convert_encoding('&#' . intval($char) . ';', 'UTF-8', 'HTML-ENTITIES');
    }

    /**
     *
     * turns chars into code
     *
     * @since v1.0a
     * @param string $char character
     * @access public
     * @return void
     */
    private function tochr($char)
    {
        $i = 0;
        $number = '';
        while (isset($char[$i])) {
            $number .= ord($char[$i]) . ";";
            ++$i;
        }
        return $number;
    }

    /**
     *
     * checks if the file is a real WDGWV Setupfile!
     *
     * @since v1.0a
     * @param string $filesString files as String
     * @access public
     * @return void
     */
    private function validatedInstall($filesString)
    {
        $checked = array();

        if ((substr($filesString, 0, 15) . chr(10)) == base64_decode("V0RHV1YgU2V0dXBGaWxlCg==")) {
            $checked[] = true;
        }

        if ((substr($filesString, 17, 11) . chr(10)) == base64_decode("V0RHV1YgU2V0dXAK")) {
            $checked[] = true;
        }

        if (sizeof($checked) >= 2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * write contents down to a specified file.
     *
     * @since v1.0a
     * @param string $file Filename
     * @param string $contents File content
     * @access public
     * @return void
     */
    private function setupWrite($file, $contents)
    {
        $handle = @fopen($file, 'w');

        if ($handle) {
            if (is_array($contents)) {
                @ob_start();
                print_r($contents);
                $contents = ob_get_contents();
                @ob_end_clean();
            }

            @fwrite($handle, $contents);
            @fclose($handle);
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     * handle the install
     *
     * @since v1.0a
     * @param string $filesString files as String
     * @access public
     * @return void
     */
    private function parseSetupFiles($filesString)
    {
        $setupLog = array();

        if (validatedInstall($filesString)) {
            $filesString = preg_replace("#\r#", null, $filesString);
            $explodeAll = explode("\n", $filesString);
            $setupRunning = true;
            if (!is_writable('.')) {
                $setupLog['error'][] = 'Not a writeable file system';
                $this->debugger->error('Not a writeable file system');
                echo "Not writeable file system!";
                setupWrite('setup.log', $setupLog);
                $setupRunning = false;
            }

            for ($i = 0; $i < sizeof($explodeAll); $i++) {
                if ($setupRunning) {
                    if (substr($explodeAll[$i], 0, 2) == "~~") {
                        if (!is_dir(substr($explodeAll[$i], 2))) {
                            if (@mkdir(substr($explodeAll[$i], 2))) {
                                $setupLog['info'][] = 'Dir "' . substr($explodeAll[$i], 2) . '" Created';
                                $this->debugger->log('Dir "' . substr($explodeAll[$i], 2) . '" Created');
                            } else {
                                $setupLog['error'][] = 'Dir "' . substr($explodeAll[$i], 2) . '" not Created';
                                $this->debugger->error('Dir "' . substr($explodeAll[$i], 2) . '" not Created');
                                setupWrite('setup.log', $setupLog);
                                $setupRunning = false;
                                return false;
                                break;
                            }
                        } else {
                            $setupLog['info'][] = 'Dir "' . substr($explodeAll[$i], 2) . '" already created.';
                            $this->debugger->log('Dir "' . substr($explodeAll[$i], 2) . '" already created.');
                        }
                    } elseif (substr($explodeAll[$i], 0, 1) == "~" && substr($explodeAll[$i], 0, 2) != "~~") {
                        // PUT TO DB
                        // NOT SUPPORTED.
                    } else {
                        $file = explode("~", $explodeAll[$i]);

                        if (sizeof($file) == 3) {
                            if ($this->debug) {
                                $setupLog['x-files'][base64_decode($file[0])] = $file;
                            }

                            $ver = explode("/", base64_decode($file[0]));
                            $ver[sizeof($ver) - 1] = '.' . $ver[sizeof($ver) - 1];
                            $ver = implode('/', $ver);

                            $file1 = setupWrite(base64_decode($file[0]), base64_decode($file[2]));
                            $file2 = setupWrite($ver, base64_decode($file[1]));

                            if ($file1 && $file2) {
                                if (substr(PHP_OS, 0, 3) == 'WIN') {
                                    @system('attrib +h ' . base64_decode($file[0]) . '.version');
                                }

                                $setupLog['info'][] = 'File "' . base64_decode($file[0]) . '" Created';
                                $this->debugger->log('File "' . base64_decode($file[0]) . '" Created');
                            } else {
                                $setupLog['error'][] = 'File "' . base64_decode($file[0]) . '" not Created';
                                $this->debugger->error('File "' . base64_decode($file[0]) . '" not Created');
                                $setupRunning = false;
                                setupWrite('setup.log', $setupLog);
                                return false;
                                break;
                            }
                        }
                    }
                }
            }
        } else {
            $setupLog['error'][] = 'Setupfile Corrupted!!!';
            $this->debugger->error('Setupfile Corrupted!!!');
            setupWrite('setup.log', "The setupfile seems to be corrupted, the setup cannot continue!");
            return false;
        }

        #IF DEBUG VERSION THEN..
        setupWrite('setup.log', $setupLog);
        return true;
    }

    /**
     *
     * begins a offline install.
     *
     * @since v1.0a
     * @access public
     * @return void
     */
    public function beginOfflineInstall()
    {
        if (is_readable('install.app')) {
            if (parseSetupFiles(gzuncompress(file_get_contents('install.app')))) {
                echo "Installed!!!";
            } else {
                echo file_get_contents('setup.log');
            }
        }
    }

    /**
     *
     * begins a "online" install.
     *
     * @since v1.0a
     * @access public
     * @return void
     */
    public function beginOnlineInstall()
    {
        #DOWNLOAD ALL THE FILES.
        echo "Please wait downloading...";
        $downloadURL = "https://github.com/WDGWV/WDGWVSS_ONLINEDOWNLOADER/blob/master/ONLINEINSTALL/install.app?raw=true";

        $opts = array(
            'http' => array(
                'method' => "GET",
                'header' => "Accept-language: en\r\n" .
                    "Cookie: WDGWV=CMS\r\n" .
                    "User-Agent: WDGWV CMS Online downloader (http://www.wdgwv.com)",
            ),
        );

        $context = stream_context_create($opts);
        $file = file_get_contents($downloadURL, false, $context);
        file_put_contents('install.app', $file);

        if (parseSetupFiles(gzuncompress($file))) {
            echo "Installed!!!";
        } else {
            echo file_get_contents('setup.log');
        }
    }
}
