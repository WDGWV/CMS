<?php
namespace WDGWV\CMS\Emulation;

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

class Blogger
{
    /**
     * @param $theme
     */
    public function isBlogger($theme)
    {
        return (
            file_exists(CMS_TEMPLATE_DIR . $theme . '/main.xml') ? true : false
        );
    }

    /**
     * @param $matches
     * @return mixed
     */
    public function bloggerLoop($matches)
    {
        if ($matches[1] == 'links') {
            $matches[3] = preg_replace(
                "#a expr:href#",
                "a href",
                $matches[3]
            );
            $matches[3] = preg_replace(
                "#data:link\.target#",
                "http://www.wdgwv.com",
                $matches[3]
            );
            $matches[3] = preg_replace(
                "#<data:link\.name/>#",
                "WDGWV",
                $matches[3]
            );

            return $matches[3];
        }
    }

    /**
     * @param $matches
     * @return null
     */
    public function bloggerInclude($matches)
    {
        return;
    }

    /**
     * @param $matches
     * @return null
     */
    public function bloggerLoad($matches)
    {
        return;
    }

    /**
     * @param $theme
     * @param $name
     * @return mixed
     */
    public function bloggerParse($theme, $name)
    {
        $theme = preg_replace_callback(
            "#<b:loop values='data:(.*)' var='(.*)'>(.*?)</b:loop>#i",
            "bloggerLoop",
            $theme
        );

        $theme = preg_replace(
            "#<data:blog.pageTitle/>#",
            "WDGWV CMS v0.0.1",
            $theme
        );

        $theme = preg_replace(
            "#<!-- Created by Artisteer v(.*) -->#",
            null,
            $theme
        );

        $theme = preg_replace(
            "#<b:skin><\!\[CDATA\[(.*)\]\]></b:skin>#si",
            "<style type=\"text/css\">\\1</style>",
            $theme
        );

        $theme = preg_replace(
            "#data:blog\.homepageUrl#",
            "./",
            $theme
        );

        $theme = preg_replace(
            "#<b:include name=\"title\"/>#",
            "WDGWV Blog",
            $theme
        );

        $theme = preg_replace(
            "#<b:include name=\"description\"/>#",
            "WDGWV Products blog",
            $theme
        );

        $theme = preg_replace(
            "#url\('images/(.*)\.(.*)'\)#",
            "url('themes/" . $name . "/images/\\1.\\2')",
            $theme
        );

        $theme = preg_replace(
            "#<b:else/>
            <b:if cond='data:post.url'>
                <a expr:href='data:post.url'><data:post.title/></a>
            <b:else/>
                <data:post.title/>
            </b:if>
        </b:if>#",
            null,
            $theme
        );

        $theme = preg_replace(
            "#<data:post.title/>#",
            "PAGE TITLE",
            $theme
        );

        return $theme;
    }

    /**
     * @param $theme
     */
    public function blogger($theme)
    {
        $file = file_get_contents(
            sprintf('themes/%s/main.xml', $theme)
        );

        echo bloggerParse($file, $theme);
    }
}
