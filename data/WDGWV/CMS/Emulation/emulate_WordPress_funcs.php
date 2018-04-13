<?php
// WARNING THIS FILE IS ONLY FOR LINKING TO THE CLASS.
// IF YOU NEED TO MAKE CHANGES PLEASE CHANGE IN WordPress.php
// THANKS IN ADVANCE.

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

if (!isset($emulation['wordpress'])) {
    $emulation['wordpress'] = new \WDGWV\CMS\Emulation\WordPress();
}

/**
 * Shortcut for WordPress from 'the_content(...)' to \WDGWV\CMS\Emulation\WordPress()->the_content(...)
 * @since Version 1.0
 */
function the_content()
{
    global $emulation;
    return $emulation['wordpress']->the_content();
}

/**
 * Shortcut for WordPress from 'the_post(...)' to \WDGWV\CMS\Emulation\WordPress()->the_post(...)
 * @since Version 1.0
 */
function the_post()
{
    global $emulation;
    return $emulation['wordpress']->the_post();
}

/**
 * Shortcut for WordPress from 'theme_is_home(...)' to \WDGWV\CMS\Emulation\WordPress()->theme_is_home(...)
 * @since Version 1.0
 */
function theme_is_home()
{
    global $emulation;
    return $emulation['wordpress']->theme_is_home();
}

/**
 * Shortcut for WordPress from 'theme_get_dynamic_sidebar_data(...)' to \WDGWV\CMS\Emulation\WordPress()->theme_get_dynamic_sidebar_data(...)
 * @since Version 1.0
 */
function theme_get_dynamic_sidebar_data()
{
    global $emulation;
    return $emulation['wordpress']->theme_get_dynamic_sidebar_data();
}

/**
 * Shortcut for WordPress from 'is_home(...)' to \WDGWV\CMS\Emulation\WordPress()->is_home(...)
 * @since Version 1.0
 */
function is_home()
{
    global $emulation;
    return $emulation['wordpress']->is_home();
}

/**
 * Shortcut for WordPress from 'get_option(...)' to \WDGWV\CMS\Emulation\WordPress()->get_option(...)
 * @since Version 1.0
 */
function get_option($option)
{
    global $emulation;
    return $emulation['wordpress']->get_option();
}

/**
 * Shortcut for WordPress from 'theme_get_menu(...)' to \WDGWV\CMS\Emulation\WordPress()->theme_get_menu(...)
 * @since Version 1.0
 */
function theme_get_menu($nav)
{
    global $emulation;
    return $emulation['wordpress']->theme_get_menu();
}

/**
 * Shortcut for WordPress from 'wp_list_pages(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_list_pages(...)
 * @since Version 1.0
 */
function wp_list_pages()
{
    global $emulation;
    return $emulation['wordpress']->wp_list_pages();
}

/**
 * Shortcut for WordPress from 'theme_get_option(...)' to \WDGWV\CMS\Emulation\WordPress()->theme_get_option(...)
 * @since Version 1.0
 */
function theme_get_option($sidebar)
{
    global $emulation;
    return $emulation['wordpress']->theme_get_option($sidebar);
}

/**
 * Shortcut for WordPress from 'wp_head(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_head(...)
 * @since Version 1.0
 */
function wp_head()
{
    global $emulation;
    return $emulation['wordpress']->wp_head();
}

/**
 * Shortcut for WordPress from 'body_class(...)' to \WDGWV\CMS\Emulation\WordPress()->body_class(...)
 * @since Version 1.0
 */
function body_class()
{
    global $emulation;
    return $emulation['wordpress']->body_class();
}

/**
 * Shortcut for WordPress from 'remove_action(...)' to \WDGWV\CMS\Emulation\WordPress()->remove_action(...)
 * @since Version 1.0
 */
function remove_action($p1 = null, $p2 = null, $p3 = null)
{
    global $emulation;
    return $emulation['wordpress']->remove_action($p1, $p2, $p3);
}

/**
 * Shortcut for WordPress from 'get_post_format(...)' to \WDGWV\CMS\Emulation\WordPress()->get_post_format(...)
 * @since Version 1.0
 */
function get_post_format()
{
    global $emulation;
    return $emulation['wordpress']->get_post_format();
}

/**
 * Shortcut for WordPress from 'get_template_part(...)' to \WDGWV\CMS\Emulation\WordPress()->get_template_part(...)
 * @since Version 1.0
 */
function get_template_part($p1 = null, $p2 = null)
{
    global $emulation;
    return $emulation['wordpress']->get_template_part($p1, $p2);
}

/**
 * Shortcut for WordPress from 'have_posts(...)' to \WDGWV\CMS\Emulation\WordPress()->have_posts(...)
 * @since Version 1.0
 */
function have_posts()
{
    global $emulation;
    return $emulation['wordpress']->have_posts();
}

/**
 * Shortcut for WordPress from 'is_singular(...)' to \WDGWV\CMS\Emulation\WordPress()->is_singular(...)
 * @since Version 1.0
 */
function is_singular()
{
    global $emulation;
    return $emulation['wordpress']->is_singular();
}

/**
 * Shortcut for WordPress from 'wp_title(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_title(...)
 * @since Version 1.0
 */
function wp_title()
{
    global $emulation;
    return $emulation['wordpress']->wp_title();
}

/**
 * Shortcut for WordPress from 'language_attributes(...)' to \WDGWV\CMS\Emulation\WordPress()->language_attributes(...)
 * @since Version 1.0
 */
function language_attributes()
{
    global $emulation;
    return $emulation['wordpress']->language_attributes();
}

/**
 * Shortcut for WordPress from 'theme_page_navigation(...)' to \WDGWV\CMS\Emulation\WordPress()->theme_page_navigation(...)
 * @since Version 1.0
 */
function theme_page_navigation($p1 = null)
{
    global $emulation;
    return $emulation['wordpress']->theme_page_navigation($p1);
}

/**
 * Shortcut for WordPress from 'do_shortcode(...)' to \WDGWV\CMS\Emulation\WordPress()->do_shortcode(...)
 * @since Version 1.0
 */
function do_shortcode($item = null)
{
    global $emulation;
    return $emulation['wordpress']->do_shortcode($item);
}

/**
 * Shortcut for WordPress from 'bloginfo(...)' to \WDGWV\CMS\Emulation\WordPress()->bloginfo(...)
 * @since Version 1.0
 */
function bloginfo($info)
{
    global $emulation;
    return $emulation['wordpress']->bloginfo($info);
}

/**
 * Shortcut for WordPress from 'get_sidebar(...)' to \WDGWV\CMS\Emulation\WordPress()->get_sidebar(...)
 * @since Version 1.0
 */
function get_sidebar($load = 'sidebar')
{
    global $emulation;
    return $emulation['wordpress']->get_sidebar($load);
}

/**
 * Shortcut for WordPress from '_e(...)' to \WDGWV\CMS\Emulation\WordPress()->_e(...)
 * @since Version 1.0
 */
function _e($p1, $p2 = null)
{
    global $emulation;
    return $emulation['wordpress']->_e($p1, $p2);
}

/**
 * Shortcut for WordPress from 'get_header(...)' to \WDGWV\CMS\Emulation\WordPress()->get_header(...)
 * @since Version 1.0
 */
function get_header()
{
    global $emulation;
    return $emulation['wordpress']->get_header();
}

/**
 * Shortcut for WordPress from 'wp_footer(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_footer(...)
 * @since Version 1.0
 */
function wp_footer()
{
    global $emulation;
    return $emulation['wordpress']->wp_footer();
}

/**
 * Shortcut for WordPress from 'get_footer(...)' to \WDGWV\CMS\Emulation\WordPress()->get_footer(...)
 * @since Version 1.0
 */
function get_footer()
{
    global $emulation;
    return $emulation['wordpress']->get_footer();
}

/**
 * Shortcut for WordPress from 'wordpress(...)' to \WDGWV\CMS\Emulation\WordPress()->wordpress(...)
 * @since Version 1.0
 */
function wordpress($WPTheme)
{
    global $emulation;
    return $emulation['wordpress']->wordpress($WPTheme);
}

/**
 * Shortcut for WordPress from 'previous_posts_link(...)' to \WDGWV\CMS\Emulation\WordPress()->previous_posts_link(...)
 * @since Version 1.0
 */
function previous_posts_link()
{
    global $emulation;
    return $emulation['wordpress']->previous_posts_link();
}

/**
 * Shortcut for WordPress from 'next_posts_link(...)' to \WDGWV\CMS\Emulation\WordPress()->next_posts_link(...)
 * @since Version 1.0
 */
function next_posts_link()
{
    global $emulation;
    return $emulation['wordpress']->next_posts_link();
}

/**
 * Shortcut for WordPress from 'is_search(...)' to \WDGWV\CMS\Emulation\WordPress()->is_search(...)
 * @since Version 1.0
 */
function is_search()
{
    global $emulation;
    return $emulation['wordpress']->is_search();
}

/**
 * Shortcut for WordPress from 'the_tags(...)' to \WDGWV\CMS\Emulation\WordPress()->the_tags(...)
 * @since Version 1.0
 */
function the_tags()
{
    global $emulation;
    return $emulation['wordpress']->the_tags();
}

/**
 * Shortcut for WordPress from 'is_single(...)' to \WDGWV\CMS\Emulation\WordPress()->is_single(...)
 * @since Version 1.0
 */
function is_single()
{
    global $emulation;
    return $emulation['wordpress']->is_single();
}

/**
 * Shortcut for WordPress from 'is_page(...)' to \WDGWV\CMS\Emulation\WordPress()->is_page(...)
 * @since Version 1.0
 */
function is_page()
{
    global $emulation;
    return $emulation['wordpress']->is_page();
}

/**
 * Shortcut for WordPress from 'is_category(...)' to \WDGWV\CMS\Emulation\WordPress()->is_category(...)
 * @since Version 1.0
 */
function is_category()
{
    global $emulation;
    return $emulation['wordpress']->is_category();
}

/**
 * Shortcut for WordPress from 'is_month(...)' to \WDGWV\CMS\Emulation\WordPress()->is_month(...)
 * @since Version 1.0
 */
function is_month()
{
    global $emulation;
    return $emulation['wordpress']->is_month();
}

/**
 * Shortcut for WordPress from 'the_ID(...)' to \WDGWV\CMS\Emulation\WordPress()->the_ID(...)
 * @since Version 1.0
 */
function the_ID()
{
    global $emulation;
    return $emulation['wordpress']->the_ID();
}

/**
 * Shortcut for WordPress from 'comments_number(...)' to \WDGWV\CMS\Emulation\WordPress()->comments_number(...)
 * @since Version 1.0
 */
function comments_number()
{
    global $emulation;
    return $emulation['wordpress']->comments_number();
}

/**
 * Shortcut for WordPress from 'the_permalink(...)' to \WDGWV\CMS\Emulation\WordPress()->the_permalink(...)
 * @since Version 1.0
 */
function the_permalink()
{
    global $emulation;
    return $emulation['wordpress']->the_permalink();
}

/**
 * Shortcut for WordPress from 'the_category(...)' to \WDGWV\CMS\Emulation\WordPress()->the_category(...)
 * @since Version 1.0
 */
function the_category()
{
    global $emulation;
    return $emulation['wordpress']->the_category();
}

/**
 * Shortcut for WordPress from 'the_author_link(...)' to \WDGWV\CMS\Emulation\WordPress()->the_author_link(...)
 * @since Version 1.0
 */
function the_author_link()
{
    global $emulation;
    return $emulation['wordpress']->the_author_link();
}

/**
 * Shortcut for WordPress from 'the_time(...)' to \WDGWV\CMS\Emulation\WordPress()->the_time(...)
 * @since Version 1.0
 */
function the_time()
{
    global $emulation;
    return $emulation['wordpress']->the_time();
}

/**
 * Shortcut for WordPress from 'the_title(...)' to \WDGWV\CMS\Emulation\WordPress()->the_title(...)
 * @since Version 1.0
 */
function the_title()
{
    global $emulation;
    return $emulation['wordpress']->the_title();
}

/**
 * Shortcut for WordPress from 'comments_link(...)' to \WDGWV\CMS\Emulation\WordPress()->comments_link(...)
 * @since Version 1.0
 */
function comments_link()
{
    global $emulation;
    return $emulation['wordpress']->comments_link();
}

/**
 * Shortcut for WordPress from 'readintro(...)' to \WDGWV\CMS\Emulation\WordPress()->readintro(...)
 * @since Version 1.0
 */
function readintro()
{
    global $emulation;
    return $emulation['wordpress']->readintro();
}

/**
 * Shortcut for WordPress from 'is_tag(...)' to \WDGWV\CMS\Emulation\WordPress()->is_tag(...)
 * @since Version 1.0
 */
function is_tag()
{
    global $emulation;
    return $emulation['wordpress']->is_tag();
}

/**
 * Shortcut for WordPress from 'wp_get_archives(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_get_archives(...)
 * @since Version 1.0
 */
function wp_get_archives()
{
    global $emulation;
    return $emulation['wordpress']->wp_get_archives();
}

/**
 * Shortcut for WordPress from 'wp_list_cats(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_list_cats(...)
 * @since Version 1.0
 */
function wp_list_cats()
{
    global $emulation;
    return $emulation['wordpress']->wp_list_cats();
}

/**
 * Shortcut for WordPress from 'get_links(...)' to \WDGWV\CMS\Emulation\WordPress()->get_links(...)
 * @since Version 1.0
 */
function get_links()
{
    global $emulation;
    return $emulation['wordpress']->get_links();
}

/**
 * Shortcut for WordPress from 'wp_loginout(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_loginout(...)
 * @since Version 1.0
 */
function wp_loginout()
{
    global $emulation;
    return $emulation['wordpress']->wp_loginout();
}

/**
 * Shortcut for WordPress from 'wp_meta(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_meta(...)
 * @since Version 1.0
 */
function wp_meta()
{
    global $emulation;
    return $emulation['wordpress']->wp_meta();
}

/**
 * Shortcut for WordPress from 'theme_print_sidebar(...)' to \WDGWV\CMS\Emulation\WordPress()->theme_print_sidebar(...)
 * @since Version 1.0
 */
function theme_print_sidebar($what)
{
    global $emulation;
    return $emulation['wordpress']->theme_print_sidebar($what);
}

/**
 * Shortcut for WordPress from 'theme_has_layout_part(...)' to \WDGWV\CMS\Emulation\WordPress()->theme_has_layout_part(...)
 * @since Version 1.0
 */
function theme_has_layout_part($part)
{
    global $emulation;
    return $emulation['wordpress']->theme_has_layout_part($part);
}

/**
 * Shortcut for WordPress from 'get_num_queries(...)' to \WDGWV\CMS\Emulation\WordPress()->get_num_queries(...)
 * @since Version 1.0
 */
function get_num_queries()
{
    global $emulation;
    return $emulation['wordpress']->get_num_queries();
}

/**
 * Shortcut for WordPress from 'timer_stop(...)' to \WDGWV\CMS\Emulation\WordPress()->timer_stop(...)
 * @since Version 1.0
 */
function timer_stop()
{
    global $emulation;
    return $emulation['wordpress']->timer_stop();
}

/**
 * Shortcut for WordPress from 'theme_wordpress(...)' to \WDGWV\CMS\Emulation\WordPress()->theme_wordpress(...)
 * @since Version 1.0
 */
function theme_wordpress($p)
{
    global $emulation;
    return $emulation['wordpress']->theme_wordpress($p);
}

/**
 * Shortcut for WordPress from 'trailingslashit(...)' to \WDGWV\CMS\Emulation\WordPress()->trailingslashit(...)
 * @since Version 1.0
 */
function trailingslashit($item)
{
    global $emulation;
    return $emulation['wordpress']->trailingslashit($item);
}

/**
 * Shortcut for WordPress from 'get_template_directory(...)' to \WDGWV\CMS\Emulation\WordPress()->get_template_directory(...)
 * @since Version 1.0
 */
function get_template_directory()
{
    global $emulation;
    return $emulation['wordpress']->get_template_directory();
}

/**
 * Shortcut for WordPress from 'esc_url(...)' to \WDGWV\CMS\Emulation\WordPress()->esc_url(...)
 * @since Version 1.0
 */
function esc_url($url)
{
    global $emulation;
    return $emulation['wordpress']->esc_url($url);
}

/**
 * Shortcut for WordPress from 'home_url(...)' to \WDGWV\CMS\Emulation\WordPress()->home_url(...)
 * @since Version 1.0
 */
function home_url($url)
{
    global $emulation;
    return $emulation['wordpress']->home_url($url);
}

/**
 * Shortcut for WordPress from 'is_day(...)' to \WDGWV\CMS\Emulation\WordPress()->is_day(...)
 * @since Version 1.0
 */
function is_day($date)
{
    global $emulation;
    return $emulation['wordpress']->is_day($date);
}

/**
 * Shortcut for WordPress from 'get_the_date(...)' to \WDGWV\CMS\Emulation\WordPress()->get_the_date(...)
 * @since Version 1.0
 */
function get_the_date($date)
{
    global $emulation;
    return $emulation['wordpress']->get_the_date($date);
}

/**
 * Shortcut for WordPress from 'single_cat_title(...)' to \WDGWV\CMS\Emulation\WordPress()->single_cat_title(...)
 * @since Version 1.0
 */
function single_cat_title($one, $par = false)
{
    global $emulation;
    return $emulation['wordpress']->single_cat_title($one, $par);
}

/**
 * Shortcut for WordPress from 'get_the_author(...)' to \WDGWV\CMS\Emulation\WordPress()->get_the_author(...)
 * @since Version 1.0
 */
function get_the_author()
{
    global $emulation;
    return $emulation['wordpress']->get_the_author();
}

/**
 * Shortcut for WordPress from 'get_the_author_meta(...)' to \WDGWV\CMS\Emulation\WordPress()->get_the_author_meta(...)
 * @since Version 1.0
 */
function get_the_author_meta($what)
{
    global $emulation;
    return $emulation['wordpress']->get_the_author_meta();
}

/**
 * Shortcut for WordPress from 'get_avatar(...)' to \WDGWV\CMS\Emulation\WordPress()->get_avatar(...)
 * @since Version 1.0
 */
function get_avatar($from, $size)
{
    global $emulation;
    return $emulation['wordpress']->get_avatar($from, $size);
}

/**
 * Shortcut for WordPress from 'rewind_posts(...)' to \WDGWV\CMS\Emulation\WordPress()->rewind_posts(...)
 * @since Version 1.0
 */
function rewind_posts()
{
    global $emulation;
    return $emulation['wordpress']->rewind_posts();
}

/**
 * Shortcut for WordPress from 'of_get_option(...)' to \WDGWV\CMS\Emulation\WordPress()->of_get_option(...)
 * @since Version 1.0
 */
function of_get_option($option)
{
    global $emulation;
    return $emulation['wordpress']->of_get_option($option);
}

/**
 * Shortcut for WordPress from 'get_query_var(...)' to \WDGWV\CMS\Emulation\WordPress()->get_query_var(...)
 * @since Version 1.0
 */
function get_query_var($what)
{
    global $emulation;
    return $emulation['wordpress']->get_query_var($what);
}

/**
 * Shortcut for WordPress from 'get_search_query(...)' to \WDGWV\CMS\Emulation\WordPress()->get_search_query(...)
 * @since Version 1.0
 */
function get_search_query()
{
    global $emulation;
    return $emulation['wordpress']->get_search_query();
}

/**
 * Shortcut for WordPress from 'do_action(...)' to \WDGWV\CMS\Emulation\WordPress()->do_action(...)
 * @since Version 1.0
 */
function do_action()
{
    global $emulation;
    return $emulation['wordpress']->do_action();
}

/**
 * Shortcut for WordPress from 'is_active_sidebar(...)' to \WDGWV\CMS\Emulation\WordPress()->is_active_sidebar(...)
 * @since Version 1.0
 */
function is_active_sidebar($pidebar)
{
    global $emulation;
    return $emulation['wordpress']->is_active_sidebar($psidebar);
}

/**
 * Shortcut for WordPress from 'dynamic_sidebar(...)' to \WDGWV\CMS\Emulation\WordPress()->dynamic_sidebar(...)
 * @since Version 1.0
 */
function dynamic_sidebar()
{
    global $emulation;
    return $emulation['wordpress']->dynamic_sidebar();
}

/**
 * Shortcut for WordPress from 'wp_register(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_register(...)
 * @since Version 1.0
 */
function wp_register()
{
    global $emulation;
    return $emulation['wordpress']->wp_register();
}

/**
 * Shortcut for WordPress from 'post_class(...)' to \WDGWV\CMS\Emulation\WordPress()->post_class(...)
 * @since Version 1.0
 */
function post_class()
{
    global $emulation;
    return $emulation['wordpress']->post_class();
}

/**
 * Shortcut for WordPress from 'edit_post_link(...)' to \WDGWV\CMS\Emulation\WordPress()->edit_post_link(...)
 * @since Version 1.0
 */
function edit_post_link()
{
    global $emulation;
    return $emulation['wordpress']->edit_post_link();
}

/**
 * Shortcut for WordPress from 'comments_template(...)' to \WDGWV\CMS\Emulation\WordPress()->comments_template(...)
 * @since Version 1.0
 */
function comments_template($what, $switch)
{
    global $emulation;
    return $emulation['wordpress']->comments_template($what, $switch);
}

/**
 * Shortcut for WordPress from 'comments_popup_link(...)' to \WDGWV\CMS\Emulation\WordPress()->comments_popup_link(...)
 * @since Version 1.0
 */
function comments_popup_link($leave, $one, $more)
{
    global $emulation;
    return $emulation['wordpress']->comments_popup_link($leave, $one, $more);
}

/**
 * Shortcut for WordPress from 'wp_pagenavi(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_pagenavi(...)
 * @since Version 1.0
 */
function wp_pagenavi()
{
    global $emulation;
    return $emulation['wordpress']->wp_pagenavi();
}

/**
 * Shortcut for WordPress from 'post_password_required(...)' to \WDGWV\CMS\Emulation\WordPress()->post_password_required(...)
 * @since Version 1.0
 */
function post_password_required()
{
    global $emulation;
    return $emulation['wordpress']->post_password_required();
}

/**
 * Shortcut for WordPress from 'have_comments(...)' to \WDGWV\CMS\Emulation\WordPress()->have_comments(...)
 * @since Version 1.0
 */
function have_comments()
{
    global $emulation;
    return $emulation['wordpress']->have_comments();
}

/**
 * Shortcut for WordPress from 'wp_list_comments(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_list_comments(...)
 * @since Version 1.0
 */
function wp_list_comments($how)
{
    global $emulation;
    return $emulation['wordpress']->wp_list_comments($how);
}

/**
 * Shortcut for WordPress from 'get_comment_pages_count(...)' to \WDGWV\CMS\Emulation\WordPress()->get_comment_pages_count(...)
 * @since Version 1.0
 */
function get_comment_pages_count()
{
    global $emulation;
    return $emulation['wordpress']->get_comment_pages_count();
}

/**
 * Shortcut for WordPress from 'previous_comments_link(...)' to \WDGWV\CMS\Emulation\WordPress()->previous_comments_link(...)
 * @since Version 1.0
 */
function previous_comments_link()
{
    global $emulation;
    return $emulation['wordpress']->previous_posts_link();
}

/**
 * Shortcut for WordPress from 'next_comments_link(...)' to \WDGWV\CMS\Emulation\WordPress()->next_comments_link(...)
 * @since Version 1.0
 */
function next_comments_link()
{
    global $emulation;
    return $emulation['wordpress']->next_comments_link();
}

/**
 * Shortcut for WordPress from 'comments_open(...)' to \WDGWV\CMS\Emulation\WordPress()->comments_open(...)
 * @since Version 1.0
 */
function comments_open()
{
    global $emulation;
    return $emulation['wordpress']->comments_open();
}

/**
 * Shortcut for WordPress from 'post_type_supports(...)' to \WDGWV\CMS\Emulation\WordPress()->post_type_supports(...)
 * @since Version 1.0
 */
function post_type_supports($supports, $region = 'comments')
{
    global $emulation;
    return $emulation['wordpress']->post_type_supports($supports, $region);
}

/**
 * Shortcut for WordPress from 'get_post_type(...)' to \WDGWV\CMS\Emulation\WordPress()->get_post_type(...)
 * @since Version 1.0
 */
function get_post_type()
{
    global $emulation;
    return $emulation['wordpress']->get_post_type();
}

/**
 * Shortcut for WordPress from 'comment_form(...)' to \WDGWV\CMS\Emulation\WordPress()->comment_form(...)
 * @since Version 1.0
 */
function comment_form($array)
{
    global $emulation;
    return $emulation['wordpress']->comment_form($array);
}

/**
 * Shortcut for WordPress from 'has_nav_menu(...)' to \WDGWV\CMS\Emulation\WordPress()->has_nav_menu(...)
 * @since Version 1.0
 */
function has_nav_menu()
{
    global $emulation;
    return $emulation['wordpress']->has_nav_menu();
}

/**
 * Shortcut for WordPress from 'wp_nav_menu(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_nav_menu(...)
 * @since Version 1.0
 */
function wp_nav_menu()
{
    global $emulation;
    return $emulation['wordpress']->wp_nav_menu();
}

/**
 * Shortcut for WordPress from 'get_post_meta(...)' to \WDGWV\CMS\Emulation\WordPress()->get_post_meta(...)
 * @since Version 1.0
 */
function get_post_meta($what, $where, $how)
{
    global $emulation;
    return $emulation['wordpress']->get_post_meta($what, $where, $how);
}

/**
 * Shortcut for WordPress from 'delete_post_meta(...)' to \WDGWV\CMS\Emulation\WordPress()->delete_post_meta(...)
 * @since Version 1.0
 */
function delete_post_meta($id, $count)
{
    global $emulation;
    return $emulation['wordpress']->delete_post_meta($id, $count);
}

/**
 * Shortcut for WordPress from 'add_post_meta(...)' to \WDGWV\CMS\Emulation\WordPress()->add_post_meta(...)
 * @since Version 1.0
 */
function add_post_meta($id, $countkey, $count)
{
    global $emulation;
    return $emulation['wordpress']->add_post_meta($id, $countkey, $count);
}

/**
 * Shortcut for WordPress from 'update_post_meta(...)' to \WDGWV\CMS\Emulation\WordPress()->update_post_meta(...)
 * @since Version 1.0
 */
function update_post_meta($id, $countkey, $count)
{
    global $emulation;
    return $emulation['wordpress']->update_post_meta($id, $countkey, $count);
}

/**
 * Shortcut for WordPress from 'locate_template(...)' to \WDGWV\CMS\Emulation\WordPress()->locate_template(...)
 * @since Version 1.0
 */
function locate_template($template, $options)
{
    global $emulation;
    return $emulation['wordpress']->locate_template($template, $options);
}

/**
 * Shortcut for WordPress from 'apply_filters(...)' to \WDGWV\CMS\Emulation\WordPress()->apply_filters(...)
 * @since Version 1.0
 */
function apply_filters($filter, $options)
{
    global $emulation;
    return $emulation['wordpress']->apply_filters($filter, $options);
}

/**
 * Shortcut for WordPress from 'is_front_page(...)' to \WDGWV\CMS\Emulation\WordPress()->is_front_page(...)
 * @since Version 1.0
 */
function is_front_page()
{
    global $emulation;
    return $emulation['wordpress']->is_front_page();
}

/**
 * Shortcut for WordPress from 'esc_attr(...)' to \WDGWV\CMS\Emulation\WordPress()->esc_attr(...)
 * @since Version 1.0
 */
function esc_attr($escape)
{
    global $emulation;
    return $emulation['wordpress']->esc_attr($escape);
}

/**
 * Shortcut for WordPress from 'is_plugin_active(...)' to \WDGWV\CMS\Emulation\WordPress()->is_plugin_active(...)
 * @since Version 1.0
 */
function is_plugin_active($path)
{
    global $emulation;
    return $emulation['wordpress']->is_plugin_active($path);
}

/**
 * Shortcut for WordPress from 'get_stylesheet_directory_uri(...)' to \WDGWV\CMS\Emulation\WordPress()->get_stylesheet_directory_uri(...)
 * @since Version 1.0
 */
function get_stylesheet_directory_uri()
{
    global $emulation;
    return $emulation['wordpress']->get_stylesheet_directory_uri();
}

/**
 * Shortcut for WordPress from 'get_pages(...)' to \WDGWV\CMS\Emulation\WordPress()->get_pages(...)
 * @since Version 1.0
 */
function get_pages($how)
{
    global $emulation;
    return $emulation['wordpress']->get_pages($how);
}

/**
 * Shortcut for WordPress from 'get_categories(...)' to \WDGWV\CMS\Emulation\WordPress()->get_categories(...)
 * @since Version 1.0
 */
function get_categories($how)
{
    global $emulation;
    return $emulation['wordpress']->get_categories($how);
}

/**
 * Shortcut for WordPress from 'update_option(...)' to \WDGWV\CMS\Emulation\WordPress()->update_option(...)
 * @since Version 1.0
 */
function update_option($what)
{
    global $emulation;
    return $emulation['wordpress']->update_option($what);
}

/**
 * Shortcut for WordPress from 'has_post_thumbnail(...)' to \WDGWV\CMS\Emulation\WordPress()->has_post_thumbnail(...)
 * @since Version 1.0
 */
function has_post_thumbnail()
{
    global $emulation;
    return $emulation['wordpress']->has_post_thumbnail();
}

/**
 * Shortcut for WordPress from 'the_post_thumbnail(...)' to \WDGWV\CMS\Emulation\WordPress()->the_post_thumbnail(...)
 * @since Version 1.0
 */
function the_post_thumbnail($kind)
{
    global $emulation;
    return $emulation['wordpress']->the_post_thumbnail($kind);
}

/**
 * Shortcut for WordPress from 'get_template_directory_uri(...)' to \WDGWV\CMS\Emulation\WordPress()->get_template_directory_uri(...)
 * @since Version 1.0
 */
function get_template_directory_uri()
{
    global $emulation;
    return $emulation['wordpress']->get_template_directory_uri();
}

/**
 * Shortcut for WordPress from 'wp_get_object_terms(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_get_object_terms(...)
 * @since Version 1.0
 */
function wp_get_object_terms($id, $theme)
{
    global $emulation;
    return $emulation['wordpress']->wp_get_object_terms();
}

/**
 * Shortcut for WordPress from 'wp_reset_postdata(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_reset_postdata(...)
 * @since Version 1.0
 */
function wp_reset_postdata()
{
    global $emulation;
    return $emulation['wordpress']->wp_reset_postdata();
}

/**
 * Shortcut for WordPress from 'the_author_posts_link(...)' to \WDGWV\CMS\Emulation\WordPress()->the_author_posts_link(...)
 * @since Version 1.0
 */
function the_author_posts_link()
{
    global $emulation;
    return $emulation['wordpress']->the_author_posts_link();
}

/**
 * Shortcut for WordPress from 'is_sticky(...)' to \WDGWV\CMS\Emulation\WordPress()->is_sticky(...)
 * @since Version 1.0
 */
function is_sticky()
{
    global $emulation;
    return $emulation['wordpress']->is_sticky();
}

/**
 * Shortcut for WordPress from 'get_search_form(...)' to \WDGWV\CMS\Emulation\WordPress()->get_search_form(...)
 * @since Version 1.0
 */
function get_search_form()
{
    global $emulation;
    return $emulation['wordpress']->get_search_form();
}

/**
 * Shortcut for WordPress from 'add_theme_support(...)' to \WDGWV\CMS\Emulation\WordPress()->add_theme_support(...)
 * @since Version 1.0
 */
function add_theme_support($what, $options = null)
{
    global $emulation;
    return $emulation['wordpress']->add_theme_support($what, $options);
}

/**
 * Shortcut for WordPress from 'add_image_size(...)' to \WDGWV\CMS\Emulation\WordPress()->add_image_size(...)
 * @since Version 1.0
 */
function add_image_size($kind, $width, $height, $load)
{
    global $emulation;
    return $emulation['wordpress']->add_image_size($kind, $width, $height, $load);
}

/**
 * Shortcut for WordPress from 'register_nav_menus(...)' to \WDGWV\CMS\Emulation\WordPress()->register_nav_menus(...)
 * @since Version 1.0
 */
function register_nav_menus($menu)
{
    global $emulation;
    return $emulation['wordpress']->register_nav_menus($menu);
}

/**
 * Shortcut for WordPress from 'load_theme_textdomain(...)' to \WDGWV\CMS\Emulation\WordPress()->load_theme_textdomain(...)
 * @since Version 1.0
 */
function load_theme_textdomain($theme, $dir)
{
    global $emulation;
    return $emulation['wordpress']->load_theme_textdomain($theme, $dir);
}

/**
 * Shortcut for WordPress from 'get_locale(...)' to \WDGWV\CMS\Emulation\WordPress()->get_locale(...)
 * @since Version 1.0
 */
function get_locale()
{
    global $emulation;
    return $emulation['wordpress']->get_locale();
}

/**
 * Shortcut for WordPress from 'add_action(...)' to \WDGWV\CMS\Emulation\WordPress()->add_action(...)
 * @since Version 1.0
 */
function add_action($when, $action)
{
    global $emulation;
    return $emulation['wordpress']->add_action($when, $action);
}

/**
 * Shortcut for WordPress from '_n_noop(...)' to \WDGWV\CMS\Emulation\WordPress()->_n_noop(...)
 * @since Version 1.0
 */
function _n_noop($what, $other)
{
    global $emulation;
    return $emulation['wordpress']->_n_noop($what, $other);
}

/**
 * Shortcut for WordPress from 'tgmpa(...)' to \WDGWV\CMS\Emulation\WordPress()->tgmpa(...)
 * @since Version 1.0
 */
function tgmpa($some, $thing)
{
    global $emulation;
    return $emulation['wordpress']->tgmpa($some, $thing);
}

/**
 * Shortcut for WordPress from 'add_filter(...)' to \WDGWV\CMS\Emulation\WordPress()->add_filter(...)
 * @since Version 1.0
 */
function add_filter($when, $what)
{
    global $emulation;
    return $emulation['wordpress']->add_filter($when, $what);
}

/**
 * Shortcut for WordPress from 'is_admin(...)' to \WDGWV\CMS\Emulation\WordPress()->is_admin(...)
 * @since Version 1.0
 */
function is_admin()
{
    global $emulation;
    return $emulation['wordpress']->is_admin();
}

/**
 * Shortcut for WordPress from 'wp_register_script(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_register_script(...)
 * @since Version 1.0
 */
function wp_register_script($script)
{
    global $emulation;
    return $emulation['wordpress']->wp_register_script($script);
}

/**
 * Shortcut for WordPress from 'wp_enqueue_script(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_enqueue_script(...)
 * @since Version 1.0
 */
function wp_enqueue_script($what)
{
    global $emulation;
    return $emulation['wordpress']->wp_enqueue_script($what);
}

/**
 * Shortcut for WordPress from 'wp_register_style(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_register_style(...)
 * @since Version 1.0
 */
function wp_register_style($style)
{
    global $emulation;
    return $emulation['wordpress']->wp_register_style($style);
}

/**
 * Shortcut for WordPress from 'wp_enqueue_style(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_enqueue_style(...)
 * @since Version 1.0
 */
function wp_enqueue_style($what)
{
    global $emulation;
    return $emulation['wordpress']->wp_enqueue_style($what);
}

/**
 * Shortcut for WordPress from 'is_ssl(...)' to \WDGWV\CMS\Emulation\WordPress()->is_ssl(...)
 * @since Version 1.0
 */
function is_ssl()
{
    global $emulation;
    return $emulation['wordpress']->is_ssl();
}

/**
 * Shortcut for WordPress from 'is_author(...)' to \WDGWV\CMS\Emulation\WordPress()->is_author(...)
 * @since Version 1.0
 */
function is_author()
{
    global $emulation;
    return $emulation['wordpress']->is_author();
}

/**
 * Shortcut for WordPress from 'is_year(...)' to \WDGWV\CMS\Emulation\WordPress()->is_year(...)
 * @since Version 1.0
 */
function is_year($date)
{
    global $emulation;
    return $emulation['wordpress']->is_year($date);
}

/**
 * Shortcut for WordPress from 'register_sidebar(...)' to \WDGWV\CMS\Emulation\WordPress()->register_sidebar(...)
 * @since Version 1.0
 */
function register_sidebar($theSidebarItemToAdd)
{
    global $emulation;
    return $emulation['wordpress']->register_sidebar($theSidebarItemToAdd);
}

/**
 * Shortcut for WordPress from 'register_widget(...)' to \WDGWV\CMS\Emulation\WordPress()->register_widget(...)
 * @since Version 1.0
 */
function register_widget($widget)
{
    global $emulation;
    return $emulation['wordpress']->register_widget($widget);
}

/**
 * Shortcut for WordPress from 'get_the_excerpt(...)' to \WDGWV\CMS\Emulation\WordPress()->get_the_excerpt(...)
 * @since Version 1.0
 */
function get_the_excerpt()
{
    global $emulation;
    return $emulation['wordpress']->get_the_excerpt();
}

/**
 * Shortcut for WordPress from 'get_the_tag_list(...)' to \WDGWV\CMS\Emulation\WordPress()->get_the_tag_list(...)
 * @since Version 1.0
 */
function get_the_tag_list($how, $string)
{
    global $emulation;
    return $emulation['wordpress']->get_the_tag_list($how, $string);
}

/**
 * Shortcut for WordPress from 'get_comment_author_link(...)' to \WDGWV\CMS\Emulation\WordPress()->get_comment_author_link(...)
 * @since Version 1.0
 */
function get_comment_author_link()
{
    global $emulation;
    return $emulation['wordpress']->get_comment_author_link();
}

/**
 * Shortcut for WordPress from 'comment_reply_link(...)' to \WDGWV\CMS\Emulation\WordPress()->comment_reply_link(...)
 * @since Version 1.0
 */
function comment_reply_link()
{
    global $emulation;
    return $emulation['wordpress']->comment_reply_link();
}

/**
 * Shortcut for WordPress from 'comment_text(...)' to \WDGWV\CMS\Emulation\WordPress()->comment_text(...)
 * @since Version 1.0
 */
function comment_text()
{
    global $emulation;
    return $emulation['wordpress']->comment_text();
}

/**
 * Shortcut for WordPress from 'is_loggedin(...)' to \WDGWV\CMS\Emulation\WordPress()->is_loggedin(...)
 * @since Version 1.0
 */
function is_loggedin()
{
    global $emulation;
    return $emulation['wordpress']->is_loggedin();
}

/**
 * Shortcut for WordPress from 'get_bloginfo(...)' to \WDGWV\CMS\Emulation\WordPress()->get_bloginfo(...)
 * @since Version 1.0
 */
function get_bloginfo($choise)
{
    global $emulation;
    return $emulation['wordpress']->get_bloginfo($choise);
}

/**
 * Shortcut for WordPress from 'wp_parse_args(...)' to \WDGWV\CMS\Emulation\WordPress()->wp_parse_args(...)
 * @since Version 1.0
 */
function wp_parse_args($args = null, $array)
{
    global $emulation;
    return $emulation['wordpress']->wp_parse_args($args, $array);
}

/**
 * Shortcut for WordPress from 'add_shortcode(...)' to \WDGWV\CMS\Emulation\WordPress()->add_shortcode(...)
 * @since Version 1.0
 */
function add_shortcode()
{
    global $emulation;
    return $emulation['wordpress']->add_shortcode();
}

class WP_Widget
{
    public function __construct($argument = null)
    {}
}

class WP_Query
{
    public function __construct($argument = null)
    {}
    public function have_posts()
    {}
    public function found_posts()
    {}
}

#Fixes some Warnings.
## WdG: 13 DEC 2013
while (!is_array(@$theme_ob_stack)) {
    global $theme_ob_stack;
    @$theme_ob_stack = (array) $theme_ob_stack;
}
