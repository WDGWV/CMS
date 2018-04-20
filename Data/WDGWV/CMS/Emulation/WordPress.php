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
-       (c) WDGWV. 2013, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

if (!defined('CMS_TEMPLATE_DIR')) {
    if (isset($debugger)) {
        $debugger->error('Missing \'CMS_TEMPLATE_DIR\'.', true);
    }
    exit('Missing \'CMS_TEMPLATE_DIR\'.');
}

class WordPress
{
    /*
    is this a wordpress theme?
     */
    public function isWordpress($WPTHEME)
    {
        return ((
            file_exists(CMS_TEMPLATE_DIR . $WPTHEME . '/index.php') &&
            file_exists(CMS_TEMPLATE_DIR . $WPTHEME . '/header.php') &&
            file_exists(CMS_TEMPLATE_DIR . $WPTHEME . '/footer.php')
        ) ? true : false);
    }

    /* Load the "post" CONTENT */
    public function the_content()
    {
        echo \WDGWV\CMS\Base::sharedInstance()->getContent();
    }

    #function the_post ( )
    # Load the "post" CONTENT
    ## WdG: 23-DEC-2013
    public function the_post()
    {
        //    echo "CONTENT CONTENT CONTENT CONTENT :D";
    }

#function theme_is_home ( )
    # yep. it's the homepage
    ## WdG: 23-DEC-2013
    public function theme_is_home()
    {
        return true;
    }

#function theme_get_dynamic_sidebar_data ( )
    # return a empty array couse we won't load a other menu
    ## WdG: 23-DEC-2013
    public function theme_get_dynamic_sidebar_data()
    {
        return array(null, null);
    }

#function is_home ( )
    # yep. it's the homepage
    ## WdG: 23-DEC-2013
    public function is_home()
    {
        return true;
    }

#function get_option ( )
    # get some options ;)
    ## WdG: 23-DEC-2013
    public function get_option($option)
    {
        switch ($option) {
            case 'home':
                # code...
                break;

            default:
                # code...
                break;
        }
    }

#function theme_get_menu ( )
    # load the menu
    ## WdG: 23-DEC-2013
    public function theme_get_menu($nav)
    {
        echo "<div class=\"art-layout-cell art-layout-cell-size1\">
	<div class=\"art-hmenu-extra1\">
		MENU
	</div>
</div>";
    }

#function wp_list_pages ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function wp_list_pages()
    {
        //MENU...
    }

#function theme_get_option ( )
    # get some options of a 'theme'
    ## WdG: 23-DEC-2013
    public function theme_get_option($sidebar)
    {
        switch ($sidebar) {
            case 'nav':
                # code...
                //echo "THIS IS NAVIGATION?";
                return true;
                break;

            case 'theme_header_clickable':
                return true;
                break;

            case 'theme_header_show_headline':
                return true;
                break;

            case 'theme_posts_headline_tag':
            case 'theme_posts_slogan_tag':
                return 'div';
                break;

            case 'theme_footer_content':
                return "&copy; 2013 WDGWV";
                break;

            default:
                return 'ERROR {' . $sidebar . '}';
                break;
        }
    }

#function wp_head ( )
    # load extra meta tags and scripts.
    ## WdG: 23-DEC-2013
    public function wp_head()
    {
        #ADDIONAL THINGS
        echo "<style type=\"text/css\">@import url('" . THEMEDIR . "style.css');</style>";
    }

#function body_class ( )
    # Class from the body
    ## WdG: 23-DEC-2013
    public function body_class()
    {
        echo "WDGWVCms";
    }

#function remove_action ( )
    # return null, we remove nothing
    ## WdG: 23-DEC-2013
    public function remove_action($s1 = null, $s2 = null, $s3 = null)
    {
        return null;
    }

#function get_post_format ( )
    # ignore this.
    ## WdG: 23-DEC-2013
    public function get_post_format()
    {
        return null;
    }

#function get_template_part ( )
    # ignore this.
    ## WdG: 23-DEC-2013
    public function get_template_part($s1 = null, $s2 = null)
    {
        //get_template_part('content', 'page');
        if ($s1 == 'content' /* && $s2 == 'page' */) {
            echo the_content();
        } else {
            return null;
        }
    }

#function have_posts ( )
    # Yup. we've got 1 post :D
    ## WdG: 23-DEC-2013
    public function have_posts()
    {
        if (!defined('WP_POST_CONTENT')) {
            if (!defined('WP_POST_MADE')) {
                define('WP_POST_MADE', true);
                return true;
            } else {
                if (!defined('WP_POST_CONTENT')) {
                    define('WP_POST_CONTENT', true);
                    return true;
                }
            }
        } else {
            return false;
        }
    }

#function is_singular ( )
    # Nope.
    ## WdG: 23-DEC-2013
    public function is_singular()
    {
        return false;
    }

#function wp_title ( )
    # Load the title of the page.
    ## WdG: 23-DEC-2013
    public function wp_title()
    {
        echo \WDGWV\CMS\Base::sharedInstance()->getPageName();
    }

#function language_attrubutes ( )
    # return true :D
    ## WdG: 23-DEC-2013
    public function language_attributes()
    {
        return true;
    }

#function theme_page_navigation ( )
    # NAVIGATION!!!
    ## WdG: 23-DEC-2013
    public function theme_page_navigation($s1 = null)
    {
        //echo "?? $s1 ?? ";
        return null;
    }

#function do_shortcode ( itm )
    # return ( itm )
    ## WdG: 23-DEC-2013
    public function do_shortcode($item = null)
    {
        return $item;
    }

#function bloginfo ( info )
    # returns some bloginfo ( info )
    ## WdG: 23-DEC-2013
    public function bloginfo($info)
    {
        switch ($info) {
            case 'charset':
                echo "NL-nl";
                break;

            case 'name':
                echo \WDGWV\CMS\Base::sharedInstance()->getTitle();
                break;

            case 'description':
                echo \WDGWV\CMS\Base::sharedInstance()->getDescription();
                break;

            case 'template_directory':
            case 'template_url':
                echo THEMEDIR;
                break;

            default:
                # code...
                break;
        }
    }

#function get_sidebar ( )
    # include some files from the sidebar
    ## WdG: 23-DEC-2013
    public function get_sidebar($what = 'sidebar')
    {
        switch ($what) {
            case 'top':
                include THEMEDIR . 'sidebar-top.php';
                break;

            case 'header':
                include THEMEDIR . 'sidebar-header.php';
                break;

            case 'footer':
                include THEMEDIR . 'sidebar-footer.php';
                break;

            case 'bottom':
                include THEMEDIR . 'sidebar-bottom.php';
                break;

            case 'sidebar':
                include THEMEDIR . 'sidebar.php';
                break;

            case 'nav':
                # code...
                break;

            default:
                exit('ERROR {' . $what . '}');
                break;
        }
    }

#function _e ( s1, s2=null )
    # is the same as __( s1, s2=null )
    ## WdG: 30-DEC-2013
    public function _e($s1, $s2 = null)
    {
        return __($s1, $s2);
    }

#function get_header ( )
    # load the header
    ## WdG: 23-DEC-2013
    public function get_header()
    {
        include THEMEDIR . 'header.php';
    }

#function wp_footer ( )
    # We ain't wordpress!
    ## WdG: 23-DEC-2013
    public function wp_footer()
    {
        echo \WDGWV\CMS\Base::sharedInstance()->getFooter();
    }

#function get_footer ( )
    # load the footer
    ## WdG: 23-DEC-2013
    public function get_footer()
    {
        include THEMEDIR . 'footer.php';
    }

#function wordpress ( )
    # load the wordpress theme
    ## WdG: 23-DEC-2013
    public function wordpress($WPTHEME)
    {
        define('RWMB_DIR', CMS_TEMPLATE_DIR . $WPTHEME);
        define('WPTHEME', $WPTHEME);
        define('THEMEDIR', CMS_TEMPLATE_DIR . $WPTHEME . '/');
        define('THEME_NS', THEMEDIR);
        define('TEMPLATEPATH', THEMEDIR);
        require_once CMS_COMPATIBILITY_DIR . 'emulate_WordPress_funcs.php';

        if (file_exists(CMS_TEMPLATE_DIR . $WPTHEME . '/index.php')) {
            include CMS_TEMPLATE_DIR . $WPTHEME . '/index.php';
        } else {
            echo "MISSING THEME {$WPTHEME}!";
        }

    }

#function previous_posts_link ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function previous_posts_link()
    {
        return '/';
    }

#function next_posts_link ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function next_posts_link()
    {
        return '/';
    }

#function is_search ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function is_search()
    {
        return false;
    }

#function the_tags ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function the_tags()
    {
        return null;
    }

#function is_single ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function is_single()
    {
        return null;
    }

#function is_page ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function is_page()
    {
        return null;
    }

#function is_category ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function is_category()
    {
        return null;
    }

#function is_month ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function is_month()
    {
        return null;
    }

#function the_ID ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function the_ID()
    {
        return 0;
    }

#function comments_number ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function comments_number()
    {
        return 0;
    }

#function the_permalink ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function the_permalink()
    {
        return null;
    }

#function the_category ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function the_category()
    {
        return null;
    }

#function the_author_link ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function the_author_link()
    {
        return null;
    }

#function the_time ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function the_time()
    {
        return null; //TIME
    }

#function the_title ( )
    # is wp_title();
    ## WdG: 30-DEC-2013
    public function the_title()
    {
        return \WDGWV\CMS\Base::sharedInstance()->getPageName();
    }

#function comments_link ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function comments_link()
    {
        return null;
    }

#function readintro ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function readintro()
    {
        //SLOGAN..
        echo \WDGWV\CMS\Base::sharedInstance()->getSlogan();
    }

#function is_tag ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function is_tag()
    {
        return false;
    }

#function wp_get_archives ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function wp_get_archives()
    {
        return null;
    }

#function wp_list_cats ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function wp_list_cats()
    {
        return null;
    }

#function get_links ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function get_links()
    {
        return null;
    }

#function wp_loginout ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function wp_loginout()
    {
        return null;
    }

#function wp_meta ( )
    # null returning we don't support it
    ## WdG: 30-DEC-2013
    public function wp_meta()
    {
        return null;
    }

#function theme_print_sidebar ( )
    # ignore all things D:
    ## WdG: 23-DEC-2013
    public function theme_print_sidebar($what)
    {
        switch ($what) {
            case 'header-widget-area':
                # code...
                break;

            default:
                # code...
                break;
        }
    }

#function theme_has_layout_part ( part )
    # Does (part) exists?
    ## WdG: 23-DEC-2013
    public function theme_has_layout_part($part)
    {
        switch ($part) {
            case 'header':
                return true;
                break;

            default:
                # code...
                break;
        }
    }

#function get_num_queries ( )
    # we don't support that.
    ## WdG: 23-DEC-2013
    public function get_num_queries()
    {
        return 0;
    }

#function timer_stop ( )
    # where is the timer started?
    ## WdG: 23-DEC-2013
    public function timer_stop()
    {
        return 0;
    }

    public function theme_wordpress($s)
    {
        return wordpress($s);
    }

#function trailingslashit ( str )
    # add a trailing slash if not extsts.
    ## WdG: 13 DEC 2013
    public function trailingslashit($item)
    {
        return $item;
    }

#function get_template_directory ( )
    # load the template directory
    ## WdG: 13 DEC 2013
    public function get_template_directory()
    {
        global $WPTHEME;

        if (isset($WPTHEME)) {
            return CMS_TEMPLATE_DIR . $WPTHEME;
        }

    }

#function esc_url ( url(str) )
    # escape url
    ## WdG: 5 DEC 2013
    public function esc_url($url)
    {
        #TODO: WP:esc_url
    }

#function home_url ( url(str) )
    # return the home url
    ## WdG: 5 DEC 2013
    public function home_url($url)
    {
        #TODO: WP:home_url
    }

#function is_day ( )
    # is it daylight?
    ## WdG: 5 DEC 2013
    public function is_day($date)
    {
        #TODO: WP:is_day
    }

#function get_the_date ( )
    # get the date
    ## WdG: 5 DEC 2013
    public function get_the_date($date)
    {
        return date($date);
    }

#function single_cat_title ( )
    # !!! DON'T KNOW WHAT IT IS !!!
    ## WdG: 5 DEC 2013
    public function single_cat_title($one, $par = false)
    {
        #TODO: WP:single_cat_title
    }

#function get_the_author ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_the_author()
    {
        #TODO: WP:get_the_author
    }

#function get_the_author_meta ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_the_author_meta($what)
    {
        #TODO: WP:get_the_author_meta
    }

#function get_avatar ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_avatar($from, $widheight)
    {
        #TODO: WP:get_avatar
    }

#function rewind_posts ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function rewind_posts()
    {
        #TODO: WP:rewind_posts
    }

#function of_get_option ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function of_get_option($option)
    {
        #TODO: WP:of_get_option
    }

#function get_query_var ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_query_var($what)
    {
        #TODO: WP:get_query_var
    }

#function get_search_query ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_search_query()
    {
        #TODO: WP:get_search_query
    }

#function do_acrion ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function do_action()
    {
        #TODO: WP:do_action
    }

#function is_active_sidebar ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function is_active_sidebar($sidebar) //main-sidebar

    {
        #TODO: WP:is_active_sidebar
        return false;
    }

#function dynamic_sidebar ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function dynamic_sidebar() //main-sidebar

    {
        #TODO: WP:dynamic_sidebar
    }

#function wp_register ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function wp_register()
    {
        #TODO: WP:wp_register
    }

#function post_class ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function post_class()
    {
        #TODO: WP:post_class (echo)
        echo " class='post'";
    }

#function edit_post_link ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function edit_post_link()
    {
        #TODO: WP:edit_post_link
    }

#function comments_template ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function comments_template($what, $switch)
    {
        #TODO: WP:comments_template
    }

#function comments_popup_link ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function comments_popup_link($leave, $one, $more)
    {
        #TODO: WP:comments_popup_link
    }

#function wp_pagenavi ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function wp_pagenavi()
    {
        //V2 NAVIGATION
        #TODO: WP:wp_pagenavi
    }

#function post_password_required ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function post_password_required()
    {
        #TODO: WP:post_password_required
        return false; //NOT SUPPORTED YET
    }

#function have_comments ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function have_comments()
    {
        #TODO: WP:have_comments
    }

#function wp_list_comments ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function wp_list_comments($how)
    {
        #TODO: WP:wp_list_comments (how)
    }

#function get_comment_page_count ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_comment_pages_count()
    {
        #TODO: WP:get_comment_pages_count
        return 0;
    }

#function previous_comments_link ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function previous_comments_link()
    {
        #TODO: WP:previous_comments_link
    }

#function next_comments_link ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function next_comments_link()
    {
        #TODO: WP:next_comments_link
    }

#function comments_open ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function comments_open()
    {
        #TODO: WP:comments_open
        return true; //comments are allowed
    }

#function post_tyoe_supports ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function post_type_supports($supports, $region = 'comments')
    {
        #TODO: WP:post_type_supports
    }

#function get_post_type ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_post_type()
    {
        #TODO: WP:get_post_type
    }

#function comment_form ( array(arr) )
    #TODO
    ## WdG: 5 DEC 2013
    public function comment_form($array)
    {
        //ARRAY
        #TODO: WP:comment_form
    }

#function has_nav_menu ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function has_nav_menu()
    {
        #TODO: WP:has_nav_menu
    }

#function wp_nav_menu ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function wp_nav_menu()
    {
        #TODO: WP:wp_nav_menu
    }

#function get_post_meta ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_post_meta($what, $where, $how)
    {
        #TODO: WP:get_post_meta
    }

#function delete_post_meta ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function delete_post_meta($id, $count)
    {
        #TODO: WP:delete_post_meta
    }

#function add_post_meta ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function add_post_meta($id, $countkey, $count)
    {
        #TODO: WP:add_post_meta
    }

#function update_post_meta ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function update_post_meta($id, $countkey, $count)
    {
        #TODO: WP:update_post_meta
    }

#function locate_template ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function locate_template($template, $options)
    {
        #TODO: WP:locate_template
    }

#function apply_filters ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function apply_filters($filter, $options)
    {
        #TODO: WP:apply_filters
    }

#function is_front_page ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function is_front_page()
    {
        #TODO: WP:is_front_page
        return true;
    }

#function esc_attr ( string(str) )
    #escape attributes
    ## WdG: 5 DEC 2013
    public function esc_attr($escape)
    {
        #TODO: WP:esc_attr
    }

#function is_plugin_active ( path(str) )
    #TODO
    ## WdG: 5 DEC 2013
    public function is_plugin_active($path)
    {
        #TODO: WP:is_plugin_active
        return false;
    }

#function get_stylesheet_directory_url ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_stylesheet_directory_uri()
    {
        #TODO: WP:get_stylesheet_directory_uri
    }

#function get_pages ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_pages($how)
    {
        #TODO: WP:get_pages
    }

#function get_categories ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_categories($how)
    {
        #TODO: WP:get_categories
    }

#function update_option ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function update_option($what)
    {
        #TODO: WP:update_option
    }

#function has_post_thumbnail ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function has_post_thumbnail()
    {
        #TODO: WP:has_post_thumbnail
    }

#function the_post_thumbnail ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function the_post_thumbnail($kind)
    {
        #TODO: WP:the_post_thumbnail
    }

#function get_template_directory_uri ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_template_directory_uri()
    {
        #TODO: WP:get_template_directory_uri
    }

#function wp_get_object_terms ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function wp_get_object_terms($id, $theme)
    {
        #TODO: WP:wp_get_object_terms
    }

#function wp_reset_postdata ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function wp_reset_postdata()
    {
        #TODO: WP:wp_reset_postdata
    }

#function the_author_post_links ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function the_author_posts_link()
    {
        #TODO: WP:the_author_posts_link
    }

#function is_sticky ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function is_sticky()
    {
        #TODO: WP:is_sticky
        return false;
    }

#function get_search_form ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_search_form()
    {
        #TODO: WP:get_search_form
    }

#function add_theme_support ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function add_theme_support($what, $options = null)
    {
        #TODO: WP:add_theme_support
    }

#function add_image_size ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function add_image_size($kind, $width, $height, $load)
    {
        #TODO: WP:add_image_size
    }

#function register_nav_menus ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function register_nav_menus($menu)
    {
        #TODO: WP:register_nav_menus
        //$menu = array.
    }

#function load_theme_textdomain ( ) [NOT SUPPORTED!!!]
    #TODO
    ## WdG: 5 DEC 2013
    public function load_theme_textdomain($theme, $dir)
    {
        #TODO: WP:load_theme_textdomain
        return false; //NOT SUPPORTED MO & PO FILES
    }

#function get_locale ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_locale()
    {
        #TODO: WP:get_locale
    }

#function add_action ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function add_action($when, $action)
    {
        #TODO: WP:add_action
    }

#function _n_noop ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function _n_noop($what, $other)
    {
        #TODO: WP:_n_noop
        //NO IDEA WHAT IT DOES.
    }

#function tgmpa ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function tgmpa($some, $thing)
    {
        #TODO: WP:tgmpa
        //NO IDEA WHAT IT DOES.
    }

#function add_filter ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function add_filter($when, $what)
    {
        #TODO: WP:add_filter
    }

#function is_admin ( )
    #is the 'loggedin' user a admin?
    ## WdG: 5 DEC 2013
    public function is_admin()
    {
        #TODO: WP:is_admin
        if (is_loggedin()) {
            if ($_SESSION['WDGWV_USER_LEVEL'] > WDGWV_LEVEL_ADMIN) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

#function wp_register_script ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function wp_register_script($script)
    {
        #TODO: WP:wp_register_script
    }

#function wp_enqueue_script ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function wp_enqueue_script($what)
    {
        #TODO: WP:wp_enqueue_script
        //load a javascript, SEE wp_register_script
    }

#function wp_register_style ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function wp_register_style($style)
    {
        #TODO: WP:wp_register_style
    }

#function wp_enqueue_style ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function wp_enqueue_style($what)
    {
        #TODO: WP:wp_enqueue_style
        //load a css style, SEE wp_register_style
    }

#function is_ssl ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function is_ssl()
    {
        #TODO: WP:is_ssl
        return false;
    }

#function is_author ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function is_author()
    {
        #TODO: WP:is_author
    }

#function is_year ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function is_year($date)
    {
        #TODO: WP:is_year
    }

#function register_sidebar ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function register_sidebar($theSidebarItemToAdd)
    {
        #TODO: WP:register_sidebar
    }

#function register_widget ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function register_widget($widget)
    {
        #TODO: WP:register_widget
    }

#function get_the_excerpt ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_the_excerpt()
    {
        #TODO: WP:get_the_excerpt
    }

#function get_the_tag_list ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_the_tag_list($how, $string)
    {
        #TODOL WP:get_the_tag_list
    }

#function get_comment_author_link ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function get_comment_author_link()
    {
        #TODO: WP:get_comment_author_link
    }

#function comment_reply_link ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function comment_reply_link()
    {
        #TODO: WP:comment_reply_link
    }

#function comment_text ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function comment_text()
    {
        #TODO: WP:comment_text
    }

#function get_sidebar ( )
    #Check if the user is logged in...
    ## WdG: 5 DEC 2013
    public function is_loggedin()
    {
        if (isset($_SESSION['WDGWV_USER_ID'])) {
            if ($_SESSION['WDGWV_USER_IP'] == $_SERVER['REMOTE_ADDR']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

#function get_bloginfo ( )
    # Returns the blog info
    ## WdG: 13 DEC 2013
    public function get_bloginfo($choise)
    {
        switch ($choise) {
            case 'charset':
                return "UTF-8";
                break;

            default:
                # code...
                break;
        }
    }

#function wp_parse_args ( )
    # Parse Arguments
    ## WdG: 13 DEC 2013
    public function wp_parse_args($args = null, $array)
    {
        return $array;
    }

#function add_shortcode ( )
    #Just to remove a error
    ## WdG: 13 DEC 2013
    public function add_shortcode()
    {

    }
}

// namespace WDGWV\CMS\Emulation\WordPressExtended;
// ^ does not work.

#class WP_Widget ( )
#TODO
## WdG: 13 DEC 2013
class WP_Widget
{

    public function __construct($argument = null)
    {
        #TODO
        #array(
        #                'post_type' =>'post',
        #                'post_status' => 'publish',
        #                'paged' => $paged )

    }
}

#class WP_Query ( )
#TODO
## WdG: 5 DEC 2013
class WP_Query
{

    public function __construct($argument = null)
    {
        #TODO
        #array(
        #                'post_type' =>'post',
        #                'post_status' => 'publish',
        #                'paged' => $paged )
    }

#function have_posts ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function have_posts()
    {
        #TODO
    }

#function found_posts ( )
    #TODO
    ## WdG: 5 DEC 2013
    public function found_posts()
    {
        # code...
    }
}
