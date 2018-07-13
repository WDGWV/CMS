<?php
namespace WDGWV\CMS\Controllers;

class Page extends \WDGWV\CMS\Controllers\Base
{
    /**
     * @var string
     */
    private $parser = '';

    /**
     * @var string
     */
    private $database = '';

    /**
     * @var string
     */
    private $CMS = '';

    /**
     * @param $parser
     * @param $CMS
     * @param $databaseConnection
     */
    public function __construct($parser, $CMS, $databaseConnection = 'std')
    {
        /**
         * Global database
         */
        global $database;

        /**
         * Set the parser
         * @var class
         */
        $this->parser = $parser;

        /**
         * CMS base class
         * @var class
         */
        $this->CMS = $CMS;

        /**
         * Check database connection
         */
        if ($databaseConnection === 'std') {
            /**
             * Set database connection
             * @var resource
             */
            $this->database = $database;
        } else {
            /**
             * Set database connection
             * @var resource
             */
            $this->database = $databaseConnection;
        }
    }

    /**
     * @param $pageID
     */
    public function pageExists($pageID)
    {
        return false;
    }

    /**
     * @param $input
     * @return mixed
     */
    private function parseUBBTags($input)
    {
        /**
         * Check if the 'hooks' system is present
         */
        if (class_exists('\WDGWV\CMS\Hooks')) {
            /**
             * Get custom hooks for UBB
             * @var array
             */
            $customHooks = \WDGWV\CMS\Hooks::shared()->getUBBHooks();
        }

        /**
         * Create a unique id
         * @var int
         */
        $uniid = uniqid();

        /**
         * Set replacer, if customhooks are present.
         * @var [type]
         */
        $replacer = (isset($customHooks) ? $customHooks : array());

        /**
         * Parse {php} and {/php} tags
         */
        $replacer[] = array('/\{php\}(.*)\{\/php\}/s', '<?php \\1 ?>');

        /**
         * Checks if the debugger is present
         */
        if (class_exists('\WDGWV\CMS\Debugger')) {
            /**
             * Debug the data
             */
            \WDGWV\CMS\Debugger::shared()->log(
                sprintf('Parsing UBB tags with %s replacers', sizeof($replacer))
            );
        }

        /**
         * Set the data to parse
         * @var string
         */
        $parse = $input;

        /**
         * Walk trough the replacers
         */
        foreach ($replacer as $replaceWith) {
            /**
             * If the size isn't 2 then continue, i miss something
             */
            if (sizeof($replaceWith) !== 2) {
                /**
                 * Continue, missing things
                 */
                continue;
            }

            /**
             * Replace the data
             */
            $parse = preg_replace($replaceWith[0], $replaceWith[1], $parse);
        }

        /**
         * Check if filesystem is writeable, and the directory exists.
         */
        if (is_writable('./Data/') && !file_exists('./Data/Temp')) {
            /**
             * Create ./Data/Temp
             */
            @mkdir('./Data/Temp/');
        }

        /**
         * Check if './Data/Temp/' is writeable
         */
        if (is_writable('./Data/Temp/')) {
            /**
             * Writable, create a filehandle resource
             * @var resource
             */
            $fh = @fopen('./Data/Temp/Page_' . $uniid . '.bin', 'w');

            /**
             * write the parsed data
             */
            @fwrite($fh, $parse);

            /**
             * Close filehandle
             */
            @fclose($fh);
        }

        /**
         * Check if the file exists
         */
        if (!file_exists('./Data/Temp/Page_' . $uniid . '.bin')) {
            /**
             * File does not exists.
             * Start a object.
             */
            @ob_start();

            /**
             * Assign eval to the object
             * @var string
             */
            $ob = @eval(
                sprintf(
                    /* String to end with */
                    '%s%s%s%s%s',

                    /* Dirty eval hack */
                    '/* ! */',

                    /* Close php tag */
                    ' ?>',

                    /* UniqueID? */
                    $uniid,

                    /* Open php tag */
                    '<?php ',

                    /* Dirty eval hack */
                    '/* ! */'
                )
            );

            /**
             * Get object contents
             * @var string
             */
            $ob = ob_get_contents();

            /**
             * Close object
             */
            @ob_end_clean();

            /**
             * Force try to delete the 'unexisting' file
             */
            @unlink('./Data/Temp/Page_' . $uniid . '.bin');

            /**
             * Checks if we got page output
             */
            if (!$ob) {
                /**
                 * Failed to get output
                 */
                return 'Failed to parse the page.';
            } else {
                /**
                 * Got output, returing it.
                 */
                return $ob;
            }
        } else {
            /**
             * Start a object
             */
            @ob_start();

            /**
             * Include the file
             * @var string
             */
            $ob = include './Data/Temp/Page_' . $uniid . '.bin';

            /**
             * Get object contents
             * @var string
             */
            $ob = ob_get_contents();

            /**
             * Close object
             */
            @ob_end_clean();

            /**
             * Unlink (delete) the file
             */
            @unlink('./Data/Temp/Page_' . $uniid . '.bin');

            /**
             * Check for data
             */
            if (!$ob) {
                /**
                 * Not data found, so returning error message
                 */
                return 'Failed to parse the page.';
            } else {
                /**
                 * Returning the found data
                 */
                return $ob;
            }
        }
    }

    /**
     * @param $pageID
     * @return null
     */
    public function displayPage($pageID = 'auto')
    {
        /**
         * Explode URL data
         * @var [string]
         */
        $e = explode("/", $_SERVER['REQUEST_URI']);

        /**
         * Check for the active component
         * @var string
         */
        $activeComponent = isset($e[1]) ? strtolower($e[1]) : 'Home';

        /**
         * Check subcomponent
         * @var string
         */
        $subComponent = isset($e[2]) ? strtolower($e[2]) : '';

        /**
         * Check if there are hooks for post, get, url
         */
        if (\WDGWV\CMS\Hooks::shared()->haveHooksFor(array('post', 'get', 'url'))) {
            /**
             * Is the debugger loaded?
             */
            if (class_exists('\WDGWV\CMS\Debugger')) {
                /**
                 * Debug output: Override page from extension
                 */
                \WDGWV\CMS\Debugger::shared()->log('Override page from extension');
            }

            /**
             * Get page data
             * @var array
             */
            $pageData = \WDGWV\CMS\Hooks::shared()->pageLoadFor(array('post', 'get', 'url'));

            /**
             * Check for the 'before-content' flag
             */
            if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
                /**
                 * Check if there is already a filled $pageData
                 */
                if (!is_array($pageData[0])) {
                    /**
                     * No $pageData found, so create one
                     * @var array
                     */
                    $pageData = array(
                        /**
                         * Hook data
                         */
                        \WDGWV\CMS\Hooks::shared()->loopHook('before-content'),

                        /**
                         * Page data
                         */
                        $pageData,
                    );
                } else {
                    /**
                     * Merge arrays
                     * @var array
                     */
                    $pageData = array_merge(
                        /**
                         * Empry array with data
                         */
                        array(\WDGWV\CMS\Hooks::shared()->loopHook('before-content')),

                        /**
                         * original $pageData
                         */
                        $pageData
                    );
                }
            }

            /**
             * Check for the 'after-content' flag
             */
            if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
                /**
                 * Check if we'll aready got $pageData
                 */
                if (!is_array($pageData[0])) {
                    /**
                     * Create $pageData
                     * @var array
                     */
                    $pageData = array(
                        /**
                         * $pageData
                         */
                        $pageData,

                        /**
                         * Hook data
                         */
                        \WDGWV\CMS\Hooks::shared()->loopHook('after-content'),
                    );
                } else {
                    /**
                     * Append to $pageData.
                     * @var array
                     */
                    $pageData = array_merge(
                        /**
                         * $pageData
                         */
                        $pageData,

                        /**
                         * Hook data
                         */
                        array(\WDGWV\CMS\Hooks::shared()->loopHook('after-content'))
                    );
                }
            }

            /**
             * Checks if $pageData[0] is still not a array
             */
            if (!is_array($pageData[0])) {
                /**
                 * Bind 'title' to $pageData[0]
                 */
                $this->parser->bindParameter('title', $pageData[0]);

                /**
                 * Bind 'page' to $pageData[1]
                 */
                $this->parser->bindParameter('page', $pageData[1]);
            } else {
                /**
                 * Multiple entries found.
                 * Creating a empty array to parse them
                 *
                 * @var array
                 */
                $tempArray = array();

                /**
                 * Walk trough $pageData
                 */
                for ($i = 0; $i < sizeof($pageData); $i++) {
                    /**
                     * Append them to $tempArray
                     */
                    $tempArray[] = array(
                        "title" => $pageData[$i][0],
                        "content" => base64_encode($pageData[$i][1]),
                        "date" => date("d-m-Y"),
                        "comments" => null,
                        "shares" => null,
                        "readmore" => null,
                        "keywords" => null,
                    );
                }

                $this->parser->bindParameter('post', $tempArray);
                $this->parser->bindParameter('page', '');
            }
            return;
        }

        if ($this->CMS->maintenanceMode()) {
            if (class_exists('\WDGWV\CMS\Debugger')) {
                \WDGWV\CMS\Debugger::shared()->log('Maintenance mode!');
            }

            $this->parser->bindParameter('post', array(
                array(
                    "title" => "Maintenance Mode",
                    "content" => base64_encode("Please wait..."),
                    "date" => date("d-m-Y"),
                    "comments" => null,
                    "shares" => null,
                    "readmore" => null,
                    "keywords" => "Updating, Update, WDGWV CMS",
                ),
            ));

            return;
        }

        if ($this->CMS->singlePage()) {
            if (class_exists('\WDGWV\CMS\Debugger')) {
                \WDGWV\CMS\Debugger::shared()->log('Single page mode!');
            }
            $this->parser->bindParameter('page', $this->CMS->getContent());
            return;
        }

        if ($activeComponent === '') {
            $activeComponent = 'home';
        }

        if ($activeComponent === 'blog') {
            if (class_exists('\WDGWV\CMS\Debugger')) {
                \WDGWV\CMS\Debugger::shared()->log('loading Blog');
            }

            if (!empty($subComponent)) {
                if ($this->database->postExists($subComponent)) {
                    if (class_exists('\WDGWV\CMS\Debugger')) {
                        \WDGWV\CMS\Debugger::shared()->log(sprintf('Post %s', $subComponent));
                    }
                    $blogData = $this->database->postLoad($subComponent);

                    $post = array(
                        array(
                            'title' => $blogData[0],
                            'content' => base64_encode($blogData[1]),
                            'date' => $blogData[3],
                            'comments' => null,
                            'shares' => null,
                            'readmore' => null,
                            'keywords' => $blogData[2],
                        ),
                    );

                    if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
                        $myData = \WDGWV\CMS\Hooks::shared()->loopHook('before-content');
                        $myPost = array(array(
                            "title" => $myData[0],
                            "content" => base64_encode($myData[1]),
                            "date" => date("d-m-Y"),
                            "comments" => null,
                            "shares" => null,
                            "readmore" => null,
                            "keywords" => null,
                        ));

                        $post = array_merge($myPost, $post);
                    }

                    if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
                        $myData = \WDGWV\CMS\Hooks::shared()->loopHook('after-content');
                        $myPost = array(array(
                            "title" => $myData[0],
                            "content" => base64_encode($myData[1]),
                            "date" => date("d-m-Y"),
                            "comments" => null,
                            "shares" => null,
                            "readmore" => null,
                            "keywords" => null,
                        ));

                        $post = array_merge($post, $myPost);
                    }

                    $this->parser->bindParameter('post', $post);
                    $this->parser->bindParameter('page', '');
                    return;
                } elseif ($subComponent === 'last') {
                    $this->parser->bindParameter('page', '');
                    $blogData = $this->database->postGetLast();
                    $post = array(
                        array(
                            'title' => $blogData[0],
                            'content' => base64_encode($blogData[1]),
                            'date' => $blogData[3],
                            'comments' => null,
                            'shares' => null,
                            'readmore' => null,
                            'keywords' => $blogData[2],
                        ),
                    );

                    if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
                        $myData = \WDGWV\CMS\Hooks::shared()->loopHook('before-content');
                        $myPost = array(array(
                            "title" => $myData[0],
                            "content" => base64_encode($myData[1]),
                            "date" => date("d-m-Y"),
                            "comments" => null,
                            "shares" => null,
                            "readmore" => null,
                            "keywords" => null,
                        ));

                        $post = array_merge($myPost, $post);
                    }

                    if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
                        $myData = \WDGWV\CMS\Hooks::shared()->loopHook('after-content');
                        $myPost = array(array(
                            "title" => $myData[0],
                            "content" => base64_encode($myData[1]),
                            "date" => date("d-m-Y"),
                            "comments" => null,
                            "shares" => null,
                            "readmore" => null,
                            "keywords" => null,
                        ));

                        $post = array_merge($post, $myPost);
                    }

                    $this->parser->bindParameter('post', $post);
                    return;
                }
            } else {
                if (class_exists('\WDGWV\CMS\Debugger')) {
                    \WDGWV\CMS\Debugger::shared()->log('last post');
                }

                $this->parser->bindParameter('page', '');
                $blogData = $this->database->postGetLast();
                $post = array(array(
                    'title' => $blogData[0],
                    'content' => base64_encode($blogData[1]),
                    'date' => $blogData[3],
                    'comments' => null,
                    'shares' => null,
                    'readmore' => null,
                    'keywords' => $blogData[2],
                ));

                if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
                    $myData = \WDGWV\CMS\Hooks::shared()->loopHook('before-content');
                    $myPost = array(array(
                        "title" => $myData[0],
                        "content" => base64_encode($myData[1]),
                        "date" => date("d-m-Y"),
                        "comments" => null,
                        "shares" => null,
                        "readmore" => null,
                        "keywords" => null,
                    ));

                    $post = array_merge($myPost, $post);
                }

                if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
                    $myData = \WDGWV\CMS\Hooks::shared()->loopHook('after-content');
                    $myPost = array(array(
                        "title" => $myData[0],
                        "content" => base64_encode($myData[1]),
                        "date" => date("d-m-Y"),
                        "comments" => null,
                        "shares" => null,
                        "readmore" => null,
                        "keywords" => null,
                    ));

                    $post = array_merge($post, $myPost);
                }

                $this->parser->bindParameter('post', $post);
                return;
            }
        }

        /**
         * PAGE FROM DATABASE
         */
        if ($this->database->pageExists($activeComponent)) {
            if (class_exists('\WDGWV\CMS\Debugger')) {
                \WDGWV\CMS\Debugger::shared()->log('Found page in database');
                \WDGWV\CMS\Debugger::shared()->log($this->database->pageLoad($activeComponent)[1]);
            }

            $pageData = array();
            $pageData[] = array(
                $activeComponent,
                $this->parseUBBTags(
                    $this->database->pageLoad($activeComponent)[1]
                ),
            );

            if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
                if (!is_array($pageData[0])) {
                    $pageData = array(
                        \WDGWV\CMS\Hooks::shared()->loopHook('before-content'),
                        $pageData,
                    );
                } else {
                    $pageData = array_merge(
                        array(\WDGWV\CMS\Hooks::shared()->loopHook('before-content')),
                        $pageData
                    );
                }
            }

            if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
                if (!is_array($pageData[0])) {
                    $pageData = array(
                        $pageData,
                        \WDGWV\CMS\Hooks::shared()->loopHook('after-content'),
                    );
                } else {
                    $pageData = array_merge(
                        $pageData,
                        array(\WDGWV\CMS\Hooks::shared()->loopHook('after-content'))
                    );
                }
            }

            $tempArray = array();

            for ($i = 0; $i < sizeof($pageData); $i++) {
                $tempArray[] = array(
                    "title" => $pageData[$i][0],
                    "content" => base64_encode($pageData[$i][1]),
                    "date" => date("d-m-Y"),
                    "comments" => null,
                    "shares" => null,
                    "readmore" => null,
                    "keywords" => null,
                );
            }

            $this->parser->bindParameter('post', $tempArray);
            return;
        }

        /*
         * PAGE NOT FOUND
         */
        if (class_exists('\WDGWV\CMS\Debugger')) {
            \WDGWV\CMS\Debugger::shared()->log('Page not found!');
        }

        $pageData = array();
        $pageData[] = array(
            $activeComponent,
            sprintf('THE PAGE \'%s\' DOES NOT EXISTS', $activeComponent),
        );

        if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
            if (!is_array($pageData[0])) {
                $pageData = array(
                    \WDGWV\CMS\Hooks::shared()->loopHook('before-content'),
                    $pageData,
                );
            } else {
                $pageData = array_merge(
                    array(\WDGWV\CMS\Hooks::shared()->loopHook('before-content')),
                    $pageData
                );
            }
        }

        if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
            if (!is_array($pageData[0])) {
                $pageData = array(
                    $pageData,
                    \WDGWV\CMS\Hooks::shared()->loopHook('after-content'),
                );
            } else {
                $pageData = array_merge(
                    $pageData,
                    array(\WDGWV\CMS\Hooks::shared()->loopHook('after-content'))
                );
            }
        }

        $tempArray = array();

        for ($i = 0; $i < sizeof($pageData); $i++) {
            $tempArray[] = array(
                "title" => $pageData[$i][0],
                "content" => base64_encode($pageData[$i][1]),
                "date" => date("d-m-Y"),
                "comments" => null,
                "shares" => null,
                "readmore" => null,
                "keywords" => null,
            );
        }

        $this->parser->bindParameter('post', $tempArray);

        return;
    }
}
