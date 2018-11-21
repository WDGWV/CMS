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
        if ($pageID) {
            return false;
        }

        /**
         * Not done.
         */
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
            $object = @eval(
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
            $object = ob_get_contents();

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
            if (!$object) {
                /**
                 * Failed to get output
                 */
                return 'Failed to parse the page.';
            } else {
                /**
                 * Got output, returing it.
                 */
                return $object;
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
            $object = include './Data/Temp/Page_' . $uniid . '.bin';

            /**
             * Get object contents
             * @var string
             */
            $object = ob_get_contents();

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
            if (!$object) {
                /**
                 * Not data found, so returning error message
                 */
                return 'Failed to parse the page.';
            } else {
                /**
                 * Returning the found data
                 */
                return $object;
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
        $explodedUrl = explode("/", $_SERVER['REQUEST_URI']);

        /**
         * Check for the active component
         * @var string
         */
        $activeComponent = isset($explodedUrl[1]) ? strtolower($explodedUrl[1]) : 'Home';

        /**
         * Check subcomponent
         * @var string
         */
        $subComponent = isset($explodedUrl[2]) ? strtolower($explodedUrl[2]) : '';

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
                for ($item = 0; $item < sizeof($pageData); $item++) {
                    /**
                     * Append them to $tempArray
                     */
                    $tempArray[] = array(
                        /**
                         * Extract the title from $pageData[$item][0]
                         */
                        'title' => $pageData[$item][0],

                        /**
                         * Extract the contents from $pageData[$item][1]
                         */
                        'content' => base64_encode($pageData[$item][1]),

                        /**
                         * Set a date
                         */
                        'date' => date('d-m-Y'),

                        /**
                         * Comments: for future use
                         */
                        'comments' => null,

                        /**
                         * Shares: for future use
                         */
                        'shares' => null,

                        /**
                         * Read more: for future use
                         */
                        'readmore' => null,

                        /**
                         * Keywords: for future use
                         */
                        'keywords' => null,
                    );
                }

                /**
                 * Bind $tempArray to 'post's
                 */
                $this->parser->bindParameter('post', $tempArray);

                /**
                 * Set 'page' to ''
                 */
                $this->parser->bindParameter('page', '');
            }

            /**
             * Return, finished running.
             */
            return;
        }

        /**
         * Checks if the CMS is in the maintenance mode?
         */
        if ($this->CMS->maintenanceMode()) {
            /**
             * Checks the availability of the debugger
             */
            if (class_exists('\WDGWV\CMS\Debugger')) {
                /**
                 * Debugs: Maintenance mode!
                 */
                \WDGWV\CMS\Debugger::shared()->log('Maintenance mode!');
            }

            /**
             * Create a 'fake' post.
             */
            $this->parser->bindParameter(
                'post',
                array(
                    array(
                        /**
                         * Set 'title' to 'Maintenance Mode'
                         */
                        'title' => 'Maintenance Mode',

                        /**
                         * Set 'content' to 'Please wait...'
                         */
                        'content' => base64_encode('Please wait...'),

                        /**
                         * Set 'date' to today
                         */
                        'date' => date('d-m-Y'),

                        /**
                         * Set 'comments' to null (hide)
                         */
                        'comments' => null,

                        /**
                         * Set 'shares' to null (hide)
                         */
                        'shares' => null,

                        /**
                         * Set 'readmore' to null (hide)
                         */
                        'readmore' => null,

                        /**
                         * Set 'keywords' to null (hide)
                         */
                        'keywords' => 'Updating, Update, WDGWV CMS',
                    ),
                )
            );

            /**
             * Finished launching return.
             */
            return;
        }

        /**
         * Check if we are running in sinle page mode
         */
        if ($this->CMS->singlePage()) {
            /**
             * Check the availability of the debugger
             */
            if (class_exists('\WDGWV\CMS\Debugger')) {
                /**
                 * Debugs: Single page mode!
                 */
                \WDGWV\CMS\Debugger::shared()->log('Single page mode!');
            }

            /**
             * Bind 'page' to the contents of the single page.
             */
            $this->parser->bindParameter('page', $this->CMS->getContent());

            /**
             * Finished launching return.
             */
            return;
        }

        /**
         * Checks is the active component is not empty
         */
        if ($activeComponent === '') {
            /**
             * Set activeComponent to 'home'
             * @var string
             */
            $activeComponent = 'home';
        }

        /**
         * Checks if activeComponent is 'blog'
         */
        if ($activeComponent === 'blog') {
            /**
             * Checks the availability of the debugger
             */
            if (class_exists('\WDGWV\CMS\Debugger')) {
                /**
                 * Debug output
                 */
                \WDGWV\CMS\Debugger::shared()->log('loading Blog');
            }

            /**
             * Check for subComponents
             */
            if (!empty($subComponent)) {
                if ($this->database->postExists($subComponent)) {
                    /**
                     * Checks the availability of the debugger
                     */
                    if (class_exists('\WDGWV\CMS\Debugger')) {
                        /**
                         * Debug output
                         */
                        \WDGWV\CMS\Debugger::shared()->log(sprintf('Post %s', $subComponent));
                    }

                    /**
                     * Load post from subComponent
                     * @var [string]
                     */
                    $blogData = $this->database->postLoad($subComponent);

                    /**
                     * Create 'post' array
                     * @var array
                     */
                    $post = array(
                        array(
                            /**
                             * Set 'title' to $blogData[0]
                             */
                            'title' => $blogData[0],

                            /**
                             * Set 'content' to $blogData[1]
                             */
                            'content' => base64_encode($blogData[1]),

                            /**
                             * Set 'date' to $blogData[3]
                             */
                            'date' => $blogData[3],

                            /**
                             * Set 'comments' to null (hidden)
                             */
                            'comments' => null,

                            /**
                             * Set 'shares' to null (hidden)
                             */
                            'shares' => null,

                            /**
                             * Set 'readmore' to null (hidden)
                             */
                            'readmore' => null,

                            /**
                             * Set 'keywords' to $blogData[2]
                             */
                            'keywords' => $blogData[2],
                        ),
                    );

                    /**
                     * Check if we have hooks for 'before-content'
                     */
                    if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
                        /**
                         * Get hooks for 'before-content'
                         * @var [string]
                         */
                        $myData = \WDGWV\CMS\Hooks::shared()->loopHook('before-content');

                        /**
                         * Create a temporary post array
                         * @var array
                         */
                        $myPost = array(
                            array(
                                /**
                                 * Set 'title' to $myData[0]
                                 */
                                'title' => $myData[0],

                                /**
                                 * Set 'content' to $myData[1] (base64 encoded)
                                 */
                                'content' => base64_encode($myData[1]),

                                /**
                                 * Set 'date' to today
                                 */
                                'date' => date('d-m-Y'),

                                /**
                                 * Set 'comments' to null (hidden)
                                 */
                                'comments' => null,

                                /**
                                 * Set 'shares' to null (hidden)
                                 */
                                'shares' => null,

                                /**
                                 * Set 'readmore' to null (hidden)
                                 */
                                'readmore' => null,

                                /**
                                 * Set 'keywords' to null (hidden)
                                 */
                                'keywords' => null,
                            ),
                        );

                        /**
                         * Merge $myPost with $post
                         * @var array
                         */
                        $post = array_merge($myPost, $post);
                    }

                    /**
                     * Check if we have hooks for 'after-content'
                     */
                    if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
                        /**
                         * Get hooks for 'after-content'
                         * @var [string]
                         */
                        $myData = \WDGWV\CMS\Hooks::shared()->loopHook('after-content');

                        /**
                         * Create a temporary post array
                         * @var array
                         */
                        $myPost = array(
                            array(
                                /**
                                 * Set 'title' to $myData[0]
                                 */
                                'title' => $myData[0],

                                /**
                                 * Set 'content' to $myData[1] (base64 encoded)
                                 */
                                'content' => base64_encode($myData[1]),

                                /**
                                 * Set 'date' to today
                                 */
                                'date' => date('d-m-Y'),

                                /**
                                 * Set 'comments' to null (hidden)
                                 */
                                'comments' => null,

                                /**
                                 * Set 'shares' to null (hidden)
                                 */
                                'shares' => null,

                                /**
                                 * Set 'readmore' to null (hidden)
                                 */
                                'readmore' => null,

                                /**
                                 * Set 'keywords' to null (hidden)
                                 */
                                'keywords' => null,
                            ),
                        );

                        /**
                         * Merge $post with $myPost
                         * @var array
                         */
                        $post = array_merge($post, $myPost);
                    }

                    /**
                     * Bind 'post' to $post
                     */
                    $this->parser->bindParameter('post', $post);

                    /**
                     * Bind 'page' to ''
                     */
                    $this->parser->bindParameter('page', '');

                    /**
                     * Finished launching return.
                     */
                    return;
                } elseif ($subComponent === 'last') {
                    /**
                     * Bind parameter 'page' to ''
                     */
                    $this->parser->bindParameter('page', '');

                    /**
                     * Get last post
                     * @var [string]
                     */
                    $blogData = $this->database->postGetLast();

                    /**
                     * Create the temporary 'post' array
                     * @var array
                     */
                    $post = array(
                        array(
                            /**
                             * Set 'title' to $blogData[0]
                             */
                            'title' => $blogData[0],

                            /**
                             * Set 'content' to $blogData[1] (base64 encoded)
                             */
                            'content' => base64_encode($blogData[1]),
                            /**
                             * Set 'date' to $blogData[3]
                             */

                            'date' => $blogData[3],
                            /**
                             * Set 'comments' to null (hidden)
                             */

                            'comments' => null,
                            /**
                             * Set 'shares' to null (hidden)
                             */

                            'shares' => null,
                            /**
                             * Set 'readmore' to null (hidden)
                             */

                            'readmore' => null,

                            /**
                             * Set 'keywords' to $blogData[2]
                             */
                            'keywords' => $blogData[2],
                        ),
                    );

                    /**
                     * Check if we have hooks for 'before-content'
                     */
                    if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
                        /**
                         * Get hooks for 'before-content'
                         * @var [string]
                         */
                        $myData = \WDGWV\CMS\Hooks::shared()->loopHook('before-content');

                        /**
                         * Create a temporary post array
                         * @var array
                         */
                        $myPost = array(
                            array(
                                /**
                                 * Set 'title' to $myData[0]
                                 */
                                'title' => $myData[0],

                                /**
                                 * Set 'content' to $myData[1] (base64 encoded)
                                 */
                                'content' => base64_encode($myData[1]),

                                /**
                                 * Set 'date' to today
                                 */

                                'date' => date('d-m-Y'),
                                /**
                                 * Set 'comments' to null (hidden)
                                 */
                                'comments' => null,

                                /**
                                 * Set 'shares' to null (hidden)
                                 */
                                'shares' => null,

                                /**
                                 * Set 'readmore' to null (hidden)
                                 */
                                'readmore' => null,

                                /**
                                 * Set 'keywords' to null (hidden)
                                 */
                                'keywords' => null,
                            ),
                        );

                        /**
                         * Merge $myPost with $post
                         * @var array
                         */
                        $post = array_merge($myPost, $post);
                    }

                    /**
                     * Check if we have hooks for 'after-content'
                     */
                    if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
                        /**
                         * Get hooks for 'after-content'
                         * @var [string]
                         */
                        $myData = \WDGWV\CMS\Hooks::shared()->loopHook('after-content');

                        /**
                         * Create a temporary post array
                         * @var array
                         */
                        $myPost = array(
                            array(
                                /**
                                 * Set 'title' to $myData[0]
                                 */
                                'title' => $myData[0],

                                /**
                                 * Set 'content' to $myData[1] (base64 encoded)
                                 */
                                'content' => base64_encode($myData[1]),

                                /**
                                 * Set 'date' to today
                                 */
                                'date' => date('d-m-Y'),

                                /**
                                 * Set 'comments' to null (hidden)
                                 */
                                'comments' => null,

                                /**
                                 * Set 'shares' to null (hidden)
                                 */
                                'shares' => null,

                                /**
                                 * Set 'readmore' to null (hidden)
                                 */
                                'readmore' => null,

                                /**
                                 * Set 'keywords' to null (hidden)
                                 */
                                'keywords' => null,
                            ),
                        );

                        /**
                         * Merge $post with $myPost
                         * @var array
                         */
                        $post = array_merge($post, $myPost);
                    }

                    /**
                     * Bind parameter 'post' with $post
                     */
                    $this->parser->bindParameter('post', $post);

                    /**
                     * Finished launching return.
                     */
                    return;
                }
            } else {
                /**
                 * Checks the availability of the debugger
                 */
                if (class_exists('\WDGWV\CMS\Debugger')) {
                    /**
                     * Debug output
                     */
                    \WDGWV\CMS\Debugger::shared()->log('last post');
                }

                /**
                 * Bind 'page' to ''
                 */
                $this->parser->bindParameter('page', '');

                /**
                 * Get last post
                 * @var [string]
                 */
                $blogData = $this->database->postGetLast();

                /**
                 * Create the 'post' array
                 * @var array
                 */
                $post = array(
                    array(
                        /**
                         * Set 'title' to $blogData[0]
                         */
                        'title' => $blogData[0],

                        /**
                         * Set 'content' to $blogData[1] (base64 encoded)
                         */
                        'content' => base64_encode($blogData[1]),
                        /**
                         * Set 'date' to $blogData[3]
                         */

                        'date' => $blogData[3],
                        /**
                         * Set 'comments' to null (hidden)
                         */

                        'comments' => null,
                        /**
                         * Set 'shares' to null (hidden)
                         */

                        'shares' => null,
                        /**
                         * Set 'readmore' to null (hidden)
                         */

                        'readmore' => null,

                        /**
                         * Set 'keywords' to $blogData[2]
                         */
                        'keywords' => $blogData[2],
                    ),
                );

                /**
                 * Check if we have hooks for 'before-content'
                 */
                if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
                    /**
                     * Get hooks for 'before-content'
                     * @var [string]
                     */
                    $myData = \WDGWV\CMS\Hooks::shared()->loopHook('before-content');

                    /**
                     * Create a temporary post array
                     * @var array
                     */
                    $myPost = array(
                        array(
                            /**
                             * Set 'title' to $myData[0]
                             */
                            'title' => $myData[0],

                            /**
                             * Set 'content' to $myData[1] (base64 encoded)
                             */
                            'content' => base64_encode($myData[1]),

                            /**
                             * Set 'date' to today
                             */
                            'date' => date('d-m-Y'),

                            /**
                             * Set 'comments' to null (hidden)
                             */
                            'comments' => null,

                            /**
                             * Set 'shares' to null (hidden)
                             */
                            'shares' => null,

                            /**
                             * Set 'readmore' to null (hidden)
                             */
                            'readmore' => null,

                            /**
                             * Set 'keywords' to null (hidden)
                             */
                            'keywords' => null,
                        ),
                    );

                    /**
                     * Merge $myPost with $post
                     * @var array
                     */
                    $post = array_merge($myPost, $post);
                }

                /**
                 * Check if we have hooks for 'after-content'
                 */
                if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
                    /**
                     * Get hooks for 'after-content'
                     * @var [string]
                     */
                    $myData = \WDGWV\CMS\Hooks::shared()->loopHook('after-content');

                    /**
                     * Create a temporary post array
                     * @var array
                     */
                    $myPost = array(
                        array(
                            /**
                             * Set 'title' to $myData[0]
                             */
                            'title' => $myData[0],

                            /**
                             * Set 'content' to $myData[1] (base64 encoded)
                             */
                            'content' => base64_encode($myData[1]),

                            /**
                             * Set 'date' to today
                             */
                            'date' => date('d-m-Y'),

                            /**
                             * Set 'comments' to null (hidden)
                             */
                            'comments' => null,

                            /**
                             * Set 'shares' to null (hidden)
                             */
                            'shares' => null,

                            /**
                             * Set 'readmore' to null (hidden)
                             */
                            'readmore' => null,

                            /**
                             * Set 'keywords' to null (hidden)
                             */
                            'keywords' => null,
                        ),
                    );

                    /**
                     * Merge $post with $myPost
                     * @var array
                     */
                    $post = array_merge($post, $myPost);
                }

                /**
                 * Bind parameter 'post' to $post
                 */
                $this->parser->bindParameter('post', $post);

                /**
                 * Finished launching return.
                 */
                return;
            }
        }

        /**
         * PAGE FROM DATABASE
         */
        if ($this->database->pageExists($activeComponent)) {
            /**
             * Checks the availability of the debugger
             */
            if (class_exists('\WDGWV\CMS\Debugger')) {
                /**
                 * Debug output
                 */
                \WDGWV\CMS\Debugger::shared()->log('Found page in database');

                /**
                 * Debug page contents.
                 */
                \WDGWV\CMS\Debugger::shared()->log($this->database->pageLoad($activeComponent)[1]);
            }

            /**
             * Create pageData array
             * @var array
             */
            $pageData = array();

            /**
             * Append 'activeComponent'
             */
            $pageData[] = array(
                /**
                 * $activeComponent
                 */
                $activeComponent,

                /**
                 * Parse UBB tags from page
                 */
                $this->parseUBBTags(
                    /**
                     * Load pag
                     */
                    $this->database->pageLoad($activeComponent)[1]
                ),
            );

            /**
             * Check for 'before-content' hooks
             */
            if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
                /**
                 * Checks if we've got $pageData[0]
                 */
                if (!is_array($pageData[0])) {
                    /**
                     * Create $pageData
                     * @var array
                     */
                    $pageData = array(
                        /**
                         * Loop trough the hook 'before-content'
                         */
                        \WDGWV\CMS\Hooks::shared()->loopHook('before-content'),

                        /**
                         * Append $pageData
                         */
                        $pageData,
                    );
                } else {
                    /**
                     * Merge data from $pageData
                     * @var array
                     */
                    $pageData = array_merge(
                        /**
                         * Loop trough the hook 'before-content'
                         */
                        array(\WDGWV\CMS\Hooks::shared()->loopHook('before-content')),

                        /**
                         * Append $pageData
                         */
                        $pageData
                    );
                }
            }

            /**
             * Check for 'after-content' hooks
             */
            if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
                /**
                 * Checks if we've got $pageData[0]
                 */
                if (!is_array($pageData[0])) {
                    /**
                     * Create $pageData
                     * @var array
                     */
                    $pageData = array(
                        /**
                         * Append $pageData
                         */
                        $pageData,

                        /**
                         * Loop trough the hook 'after-content'
                         */
                        \WDGWV\CMS\Hooks::shared()->loopHook('after-content'),
                    );
                } else {
                    /**
                     * Merge data from $pageData
                     * @var array
                     */
                    $pageData = array_merge(
                        /**
                         * Append $pageData
                         */
                        $pageData,

                        /**
                         * Loop trough the hook 'after-content'
                         */
                        array(\WDGWV\CMS\Hooks::shared()->loopHook('after-content'))
                    );
                }
            }

            /**
             * Create a temporary array
             * @var array
             */
            $tempArray = array();

            /**
             * Walk trough $pageData
             */
            for ($item = 0; $item < sizeof($pageData); $item++) {
                /**
                 * Append item to $tempArray
                 */
                $tempArray[] = array(
                    /**
                     * Set 'title' to $pageData[$item][0]
                     */
                    'title' => $pageData[$item][0],

                    /**
                     * Set 'content' to $pageData[$item][1] (base64 encoded)
                     */
                    'content' => base64_encode($pageData[$item][1]),

                    /**
                     * Set 'date' to today
                     */
                    'date' => date('d-m-Y'),

                    /**
                     * Set 'comments' to null (hidden)
                     */
                    'comments' => null,

                    /**
                     * Set 'shares' to null (hidden)
                     */
                    'shares' => null,

                    /**
                     * Set 'readmore' to null (hidden)
                     */
                    'readmore' => null,

                    /**
                     * Set 'keywords' to null (hidden)
                     */
                    'keywords' => null,
                );
            }

            /**
             * Bind parameter 'post' to $tempArray
             */
            $this->parser->bindParameter('post', $tempArray);

            /**
             * Finished launching return.
             */
            return;
        }

        /*
         * SECTION: PAGE NOT FOUND
         */

        /**
         * Checks the availability of the debugger
         */
        if (class_exists('\WDGWV\CMS\Debugger')) {
            /**
             * Debug output
             */
            \WDGWV\CMS\Debugger::shared()->log('Page not found!');
        }

        /**
         * Checks if $pageData exists.
         */
        if (!isset($pageData)) {
            /**
             * Create a empty $pageData
             * @var array
             */
            $pageData = array();
        }

        /**
         * Append error message to $pageData
         */
        $pageData[] = array(
            /**
             * Active Component in URI
             */
            $activeComponent,

            /**
             * The page '...' does not exists.
             */
            sprintf('THE PAGE \'%s\' DOES NOT EXISTS', $activeComponent),
        );

        /**
         * Check for 'before-content' hooks
         */
        if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('before-content')) {
            /**
             * Checks if we've got $pageData[0]
             */
            if (!is_array($pageData[0])) {
                /**
                 * Create $pageData
                 * @var array
                 */
                $pageData = array(
                    /**
                     * Loop trough the hook 'before-content'
                     */
                    \WDGWV\CMS\Hooks::shared()->loopHook('before-content'),

                    /**
                     * Append $pageData
                     */
                    $pageData,
                );
            } else {
                /**
                 * Merge data from $pageData
                 * @var array
                 */
                $pageData = array_merge(
                    /**
                     * Loop trough the hook 'before-content'
                     */
                    array(\WDGWV\CMS\Hooks::shared()->loopHook('before-content')),

                    /**
                     * Append $pageData
                     */
                    $pageData
                );
            }
        }

        /**
         * Check for 'after-content' hooks
         */
        if (\WDGWV\CMS\Hooks::shared()->haveHooksFor('after-content')) {
            /**
             * Checks if we've got $pageData[0]
             */
            if (!is_array($pageData[0])) {
                /**
                 * Create $pageData
                 * @var array
                 */
                $pageData = array(
                    /**
                     * Append $pageData
                     */
                    $pageData,

                    /**
                     * Loop trough the hook 'after-content'
                     */
                    \WDGWV\CMS\Hooks::shared()->loopHook('after-content'),
                );
            } else {
                /**
                 * Merge data from $pageData
                 * @var array
                 */
                $pageData = array_merge(
                    /**
                     * Append $pageData
                     */
                    $pageData,

                    /**
                     * Loop trough the hook 'after-content'
                     */
                    array(\WDGWV\CMS\Hooks::shared()->loopHook('after-content'))
                );
            }
        }

        /**
         * Creeate a temporary array
         * @var array
         */
        $tempArray = array();

        for ($item = 0; $item < sizeof($pageData); $item++) {
            /**
             * Create a temporary array
             */
            $tempArray[] = array(
                /**
                 * Set 'title' to $pageData[$item][0]
                 */
                'title' => $pageData[$item][0],

                /**
                 * Set 'content' to $pageData[$item][1] (base64 encoded)
                 */
                'content' => base64_encode($pageData[$item][1]),

                /**
                 * Set 'date' to today
                 */
                'date' => date('d-m-Y'),

                /**
                 * Set 'comments' to null (hidden)
                 */
                'comments' => null,

                /**
                 * Set 'shares' to null (hidden)
                 */
                'shares' => null,

                /**
                 * Set 'readmore' to null (hidden)
                 */
                'readmore' => null,

                /**
                 * Set 'keywords' to null (hidden)
                 */
                'keywords' => null,
            );
        }

        /**
         * Bind parameter 'post' to $tempArray
         */
        $this->parser->bindParameter('post', $tempArray);

        /**
         * Finished launching return.
         */
        return;
    }
}
