<?php
namespace WDGWV\CMS\Controllers;

class Page extends \WDGWV\CMS\Controllers\Base
{
    private $parser = '';
    private $database = '';
    private $CMS = '';

    public function __construct($parser, $CMS, $databaseConnection = 'std')
    {
        global $database;
        $this->parser = $parser;
        $this->CMS = $CMS;
        if ($databaseConnection === 'std') {
            $this->database = $database;
        } else {
            $this->database = $databaseConnection;
        }
    }

    public function pageExists($pageID)
    {
        return false;
    }

    private function parseUBBTags($input)
    {
        if (class_exists('\WDGWV\CMS\Hooks')) {
            $customHooks = \WDGWV\CMS\Hooks::sharedInstance()->getUBBHooks();
        }
        $uniid = uniqid();
        $replacer = (isset($customHooks) ? $customHooks : array());
        $replacer[] = array('/\{php\}(.*)\{\/php\}/s', '<?php \\1 ?>');

        if (class_exists('\WDGWV\CMS\Debugger')) {
            \WDGWV\CMS\Debugger::sharedInstance()->log(
                sprintf('Parsing UBB tags with %s replacers', sizeof($replacer))
            );
        }

        $parse = $input;
        foreach ($replacer as $replaceWith) {
            if (sizeof($replaceWith) !== 2) {
                continue;
            }

            $parse = preg_replace($replaceWith[0], $replaceWith[1], $parse);
        }

        if (is_writable('./data/') && !file_exists('./data/temp')) {
            @mkdir('./data/temp/');
        }

        if (is_writable('./data/temp/')) {
            $fh = @fopen('./data/temp/tmp_page_' . $uniid . '.bin', 'w');
            @fwrite($fh, $parse);
            @fclose($fh);
        }

        if (!file_exists('./data/temp/tmp_page_' . $uniid . '.bin')) {
            @ob_start();
            $ob = @eval(
                sprintf(
                    '%s%s%s%s%s',
                    '/* ! */',
                    ' ?>',
                    $uniid,
                    '<?php ',
                    '/* ! */'
                )
            );
            $ob = ob_get_contents();
            @ob_end_clean();

            @unlink('./data/temp/tmp_page_' . $uniid . '.bin');
            if (!$ob) {
                return 'Failed to parse the page.';
            } else {
                return $ob;
            }
        } else {
            @ob_start();
            $ob = include './data/temp/tmp_page_' . $uniid . '.bin';
            $ob = ob_get_contents();
            @ob_end_clean();

            @unlink('./data/temp/tmp_page_' . $uniid . '.bin');
            if (!$ob) {
                return 'Failed to parse the page.';
            } else {
                return $ob;
            }
        }
    }

    public function displayPage($pageID = 'auto')
    {
        $e = explode("/", $_SERVER['REQUEST_URI']);
        $activeComponent = isset($e[1]) ? strtolower($e[1]) : 'home';
        $subComponent = isset($e[2]) ? strtolower($e[2]) : '';

        if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor(array('post', 'get', 'url'))) {
            if (class_exists('\WDGWV\CMS\Debugger')) {
                \WDGWV\CMS\Debugger::sharedInstance()->log('Override page from extension');
            }

            $pageData = \WDGWV\CMS\Hooks::sharedInstance()->loadPageFor(array('post', 'get', 'url'));

            if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('before-content')) {
                if (!is_array($pageData[0])) {
                    $pageData = array(
                        \WDGWV\CMS\Hooks::sharedInstance()->loopHook('before-content'),
                        $pageData,
                    );
                } else {
                    $pageData = array_merge(
                        array(\WDGWV\CMS\Hooks::sharedInstance()->loopHook('before-content')),
                        $pageData
                    );
                }
            }

            if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('after-content')) {
                if (!is_array($pageData[0])) {
                    $pageData = array(
                        $pageData,
                        \WDGWV\CMS\Hooks::sharedInstance()->loopHook('after-content'),
                    );
                } else {
                    $pageData = array_merge(
                        $pageData,
                        array(\WDGWV\CMS\Hooks::sharedInstance()->loopHook('after-content'))
                    );
                }
            }

            if (!is_array($pageData[0])) {
                $this->parser->bindParameter('title', $pageData[0]);
                $this->parser->bindParameter('page', $pageData[1]);
            } else {
                // Blog style.
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
                $this->parser->bindParameter('page', '');
            }
            return;
        }

        if ($this->CMS->maintenanceMode()) {
            if (class_exists('\WDGWV\CMS\Debugger')) {
                \WDGWV\CMS\Debugger::sharedInstance()->log('Maintenance mode!');
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
                \WDGWV\CMS\Debugger::sharedInstance()->log('Single page mode!');
            }
            $this->parser->bindParameter('page', $this->CMS->getContent());
            return;
        }

        if ($activeComponent === '') {
            $activeComponent = 'home';
        }

        if ($activeComponent === 'blog') {
            if (class_exists('\WDGWV\CMS\Debugger')) {
                \WDGWV\CMS\Debugger::sharedInstance()->log('loading Blog');
            }

            if (!empty($subComponent)) {
                if ($this->database->postExists($subComponent)) {
                    if (class_exists('\WDGWV\CMS\Debugger')) {
                        \WDGWV\CMS\Debugger::sharedInstance()->log(sprintf('Post %s', $subComponent));
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

                    if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('before-content')) {
                        $myData = \WDGWV\CMS\Hooks::sharedInstance()->loopHook('before-content');
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

                    if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('after-content')) {
                        $myData = \WDGWV\CMS\Hooks::sharedInstance()->loopHook('after-content');
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

                    if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('before-content')) {
                        $myData = \WDGWV\CMS\Hooks::sharedInstance()->loopHook('before-content');
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

                    if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('after-content')) {
                        $myData = \WDGWV\CMS\Hooks::sharedInstance()->loopHook('after-content');
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
                    \WDGWV\CMS\Debugger::sharedInstance()->log('last post');
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

                if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('before-content')) {
                    $myData = \WDGWV\CMS\Hooks::sharedInstance()->loopHook('before-content');
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

                if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('after-content')) {
                    $myData = \WDGWV\CMS\Hooks::sharedInstance()->loopHook('after-content');
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
                \WDGWV\CMS\Debugger::sharedInstance()->log('Found page in database');
            }

            $pageData = array();
            $pageData[] = array(
                $activeComponent,
                $this->parseUBBTags(
                    $this->database->loadPage($activeComponent)[1]
                ),
            );

            if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('before-content')) {
                if (!is_array($pageData[0])) {
                    $pageData = array(
                        \WDGWV\CMS\Hooks::sharedInstance()->loopHook('before-content'),
                        $pageData,
                    );
                } else {
                    $pageData = array_merge(
                        array(\WDGWV\CMS\Hooks::sharedInstance()->loopHook('before-content')),
                        $pageData
                    );
                }
            }

            if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('after-content')) {
                if (!is_array($pageData[0])) {
                    $pageData = array(
                        $pageData,
                        \WDGWV\CMS\Hooks::sharedInstance()->loopHook('after-content'),
                    );
                } else {
                    $pageData = array_merge(
                        $pageData,
                        array(\WDGWV\CMS\Hooks::sharedInstance()->loopHook('after-content'))
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
            \WDGWV\CMS\Debugger::sharedInstance()->log('Page not found!');
        }

        $pageData = array();
        $pageData[] = array(
            $activeComponent,
            sprintf('THE PAGE \'%s\' DOES NOT EXISTS', $activeComponent),
        );

        if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('before-content')) {
            if (!is_array($pageData[0])) {
                $pageData = array(
                    \WDGWV\CMS\Hooks::sharedInstance()->loopHook('before-content'),
                    $pageData,
                );
            } else {
                $pageData = array_merge(
                    array(\WDGWV\CMS\Hooks::sharedInstance()->loopHook('before-content')),
                    $pageData
                );
            }
        }

        if (\WDGWV\CMS\Hooks::sharedInstance()->haveHooksFor('after-content')) {
            if (!is_array($pageData[0])) {
                $pageData = array(
                    $pageData,
                    \WDGWV\CMS\Hooks::sharedInstance()->loopHook('after-content'),
                );
            } else {
                $pageData = array_merge(
                    $pageData,
                    array(\WDGWV\CMS\Hooks::sharedInstance()->loopHook('after-content'))
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
