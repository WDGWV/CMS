<?php
/**
 * WDGWV CMS Extension file.
 * Extension: TODO Extension
 * Version: 1.0
 * Description: This is a simple test for a static TODO Extension.
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
-       (c) WDGWV. 2018, http://www.wdgwv.com              -
-    Websites, Apps, Hosting, Services, Development.       -
------------------------------------------------------------
 */

namespace WDGWV\CMS\Extension; /* Module namespace */

class TodoExtension extends \WDGWV\CMS\ExtensionBase
{
    /**
     * Call the shared
     * @since Version 1.0
     */
    public static function shared()
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
        $items = array();

        $items['Extensibility'] = array(
            'Page extensions' => 100,
            'Menu extensions' => 100,
            'URL-extensions (override)' => 100,
            'before-content' => 100,
            'after-content' => 100,
            'Specific $_POST extensions' => 100,
            'Specific $_GET extensions' => 100,
            'Partial: UBB code extensions' => 25,
        );

        $items['Extension: demo mode'] = array(
            'Strip $_POST' => 100,
            'Strip $_GET' => 100,
            'Warning if $_GET or $_POST (before-content)' => 100,
            'Extra footer notice (after-content)' => 100,
        );

        $items['Administration'] = array(
            'Extensions Administration' => 100,
            'Extensions: Enable Extension' => 100,
            'Extensions: Disable Extension' => 100,
            'Extensions: Check Hash' => 100,
            'Extensions: Check Integrity' => 50,
            'Extensions: Cache IntegrityDB' => 0,
            'Extensions: Cache via Database instead of plain text' => 0,
            'Extensions: Install (via webinterface)' => 0,
            'Extensions: Edit (via web)' => 0,
            'Extensions: Search' => 0,
        );

        $items['Databases: Database controller'] = array(
            'Connection' => 100,
            'Setup database' => 100,
            'function: `\Databases\Controller::shared()->userExists(...)`' => 100,
            'function: `\Databases\Controller::shared()->userRegister(...)`' => 100,
            'function: `\Databases\Controller::shared()->userDelete(...)`' => 100,
            'function: `\Databases\Controller::shared()->userLogin(...)`' => 100,
            'function: `\Databases\Controller::shared()->userLoad(...)`' => 100,
            'function: `\Databases\Controller::shared()->themeSet(...)`' => 100,
            'function: `\Databases\Controller::shared()->themeGet(...)`' => 100,
            'function: `\Databases\Controller::shared()->menuLoad(...)`' => 100,
            'function: `\Databases\Controller::shared()->menuSetItems(...)`' => 100,
            'function: `\Databases\Controller::shared()->pageLoad(...)`' => 100,
            'function: `\Databases\Controller::shared()->pageExists(...)`' => 100,
            'function: `\Databases\Controller::shared()->pageCreate(...)`' => 100,
            'function: `\Databases\Controller::shared()->postEdit(...)`' => 100,
            'function: `\Databases\Controller::shared()->postRemove(...)`' => 100,
            'function: `\Databases\Controller::shared()->postLoad(...)`' => 100,
            'function: `\Databases\Controller::shared()->postExists(...)`' => 100,
            'function: `\Databases\Controller::shared()->postCreate(...)`' => 100,
            'function: `\Databases\Controller::shared()->postGetLast(...)`' => 100,
            'function: `\Databases\Controller::shared()->query(...)`' => 100,
        );

        $items['Databases: MySQLite Database support'] = array(
            'Connection' => 100,
            'Setup database' => 100,
            'function: `\Databases\SQLite::shared()->userExists(...)`' => 100,
            'function: `\Databases\SQLite::shared()->userRegister(...)`' => 100,
            'function: `\Databases\SQLite::shared()->userDelete(...)`' => 100,
            'function: `\Databases\SQLite::shared()->userLogin(...)`' => 100,
            'function: `\Databases\SQLite::shared()->userLoad(...)`' => 100,
            'function: `\Databases\SQLite::shared()->themeSet(...)`' => 100,
            'function: `\Databases\SQLite::shared()->themeGet(...)`' => 100,
            'function: `\Databases\SQLite::shared()->menuLoad(...)`' => 100,
            'function: `\Databases\SQLite::shared()->menuSetItems(...)`' => 100,
            'function: `\Databases\SQLite::shared()->pageLoad(...)`' => 100,
            'function: `\Databases\SQLite::shared()->pageExists(...)`' => 100,
            'function: `\Databases\SQLite::shared()->pageCreate(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postEdit(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postRemove(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postLoad(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postExists(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postCreate(...)`' => 100,
            'function: `\Databases\SQLite::shared()->postGetLast(...)`' => 100,
            'function: `\Databases\SQLite::shared()->query(...)`' => 100,
        );

        $items['Databases: MySQL Database support'] = array(
            'Connection' => 0,
            'Setup database' => 0,
            'function: `\Databases\MySQL::shared()->userExists(...)`' => 0,
            'function: `\Databases\MySQL::shared()->userRegister(...)`' => 0,
            'function: `\Databases\MySQL::shared()->userDelete(...)`' => 0,
            'function: `\Databases\MySQL::shared()->userLogin(...)`' => 0,
            'function: `\Databases\MySQL::shared()->userLoad(...)`' => 0,
            'function: `\Databases\MySQL::shared()->themeSet(...)`' => 0,
            'function: `\Databases\MySQL::shared()->themeGet(...)`' => 0,
            'function: `\Databases\MySQL::shared()->menuLoad(...)`' => 0,
            'function: `\Databases\MySQL::shared()->menuSetItems(...)`' => 0,
            'function: `\Databases\MySQL::shared()->pageLoad(...)`' => 0,
            'function: `\Databases\MySQL::shared()->pageExists(...)`' => 0,
            'function: `\Databases\MySQL::shared()->pageCreate(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postEdit(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postRemove(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postLoad(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postExists(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postCreate(...)`' => 0,
            'function: `\Databases\MySQL::shared()->postGetLast(...)`' => 0,
            'function: `\Databases\MySQL::shared()->query(...)`' => 0,
        );

        $items['Databases: Plain text database support'] = array(
            'Connection' => 100,
            'Setup database' => 100,
            'function: `\Databases\PlainText::shared()->userExists(...)`' => 100,
            'function: `\Databases\PlainText::shared()->userRegister(...)`' => 100,
            'function: `\Databases\PlainText::shared()->userDelete(...)`' => 100,
            'function: `\Databases\PlainText::shared()->userLogin(...)`' => 100,
            'function: `\Databases\PlainText::shared()->userLoad(...)`' => 100,
            'function: `\Databases\PlainText::shared()->themeSet(...)`' => 100,
            'function: `\Databases\PlainText::shared()->themeGet(...)`' => 100,
            'function: `\Databases\PlainText::shared()->menuLoad(...)`' => 100,
            'function: `\Databases\PlainText::shared()->menuSetItems(...)`' => 100,
            'function: `\Databases\PlainText::shared()->pageLoad(...)`' => 100,
            'function: `\Databases\PlainText::shared()->pageExists(...)`' => 100,
            'function: `\Databases\PlainText::shared()->pageCreate(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postEdit(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postRemove(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postLoad(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postExists(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postCreate(...)`' => 100,
            'function: `\Databases\PlainText::shared()->postGetLast(...)`' => 100,
        );

        $items['Controllers: API Controller'] = array(
        );

        $items['Controllers: Page Controller'] = array(
            'Add Catagories' => 0,
            'Delete Catagories' => 0,
            'Edit Catagories' => 0,
            'View Catagories' => 0,
            'Add Items' => 0,
            'Delete Items' => 0,
            'Edit Items' => 0,
            'View Items' => 0,
        );

        $items['Controllers: Shop Controller'] = array(
            'Add Catagories' => 0,
            'Delete Catagories' => 0,
            'Edit Catagories' => 0,
            'View Catagories' => 0,
            'Add Items' => 0,
            'Delete Items' => 0,
            'Edit Items' => 0,
            'View Items' => 0,
        );

        $items['Controllers: User Controller'] = array(
            'User login' => 100,
            'User register' => 100,
            'User info' => 0,
            'User edit' => 0,
            'User permisions' => 0,
        );

        $items['Emulation: WordPress'] = array(
            'Alias: \'`the_content(...)`\' to `...\WordPress()->the_content(...)`' => 100,
            'Alias: \'`the_post(...)`\' to `...\WordPress()->the_post(...)`' => 100,
            'Alias: \'`theme_is_home(...)`\' to `...\WordPress()->theme_is_home(...)`' => 100,
            'Alias: \'`theme_get_dynamic_sidebar_data(...)`\' to `...\WordPress()->theme_get_dynamic_sidebar_data(...)`' => 100,
            'Alias: \'`is_home(...)`\' to `...\WordPress()->is_home(...)`' => 100,
            'Alias: \'`get_option(...)`\' to `...\WordPress()->get_option(...)`' => 100,
            'Alias: \'`theme_get_menu(...)`\' to `...\WordPress()->theme_get_menu(...)`' => 100,
            'Alias: \'`wp_list_pages(...)`\' to `...\WordPress()->wp_list_pages(...)`' => 100,
            'Alias: \'`theme_get_option(...)`\' to `...\WordPress()->theme_get_option(...)`' => 100,
            'Alias: \'`wp_head(...)`\' to `...\WordPress()->wp_head(...)`' => 100,
            'Alias: \'`body_class(...)`\' to `...\WordPress()->body_class(...)`' => 100,
            'Alias: \'`remove_action(...)`\' to `...\WordPress()->remove_action(...)`' => 100,
            'Alias: \'`get_post_format(...)`\' to `...\WordPress()->get_post_format(...)`' => 100,
            'Alias: \'`get_template_part(...)`\' to `...\WordPress()->get_template_part(...)`' => 100,
            'Alias: \'`have_posts(...)`\' to `...\WordPress()->have_posts(...)`' => 100,
            'Alias: \'`is_singular(...)`\' to `...\WordPress()->is_singular(...)`' => 100,
            'Alias: \'`wp_title(...)`\' to `...\WordPress()->wp_title(...)`' => 100,
            'Alias: \'`language_attributes(...)`\' to `...\WordPress()->language_attributes(...)`' => 100,
            'Alias: \'`theme_page_navigation(...)`\' to `...\WordPress()->theme_page_navigation(...)`' => 100,
            'Alias: \'`do_shortcode(...)`\' to `...\WordPress()->do_shortcode(...)`' => 100,
            'Alias: \'`bloginfo(...)`\' to `...\WordPress()->bloginfo(...)`' => 100,
            'Alias: \'`get_sidebar(...)`\' to `...\WordPress()->get_sidebar(...)`' => 100,
            'Alias: \'`_e(...)`\' to `...\WordPress()->_e(...)`' => 100,
            'Alias: \'`get_header(...)`\' to `...\WordPress()->get_header(...)`' => 100,
            'Alias: \'`wp_footer(...)`\' to `...\WordPress()->wp_footer(...)`' => 100,
            'Alias: \'`get_footer(...)`\' to `...\WordPress()->get_footer(...)`' => 100,
            'Alias: \'`wordpress(...)`\' to `...\WordPress()->wordpress(...)`' => 100,
            'Alias: \'`previous_posts_link(...)`\' to `...\WordPress()->previous_posts_link(...)`' => 100,
            'Alias: \'`next_posts_link(...)`\' to `...\WordPress()->next_posts_link(...)`' => 100,
            'Alias: \'`is_search(...)`\' to `...\WordPress()->is_search(...)`' => 100,
            'Alias: \'`the_tags(...)`\' to `...\WordPress()->the_tags(...)`' => 100,
            'Alias: \'`is_single(...)`\' to `...\WordPress()->is_single(...)`' => 100,
            'Alias: \'`is_page(...)`\' to `...\WordPress()->is_page(...)`' => 100,
            'Alias: \'`is_category(...)`\' to `...\WordPress()->is_category(...)`' => 100,
            'Alias: \'`is_month(...)`\' to `...\WordPress()->is_month(...)`' => 100,
            'Alias: \'`the_ID(...)`\' to `...\WordPress()->the_ID(...)`' => 100,
            'Alias: \'`comments_number(...)`\' to `...\WordPress()->comments_number(...)`' => 100,
            'Alias: \'`the_permalink(...)`\' to `...\WordPress()->the_permalink(...)`' => 100,
            'Alias: \'`the_category(...)`\' to `...\WordPress()->the_category(...)`' => 100,
            'Alias: \'`the_author_link(...)`\' to `...\WordPress()->the_author_link(...)`' => 100,
            'Alias: \'`the_time(...)`\' to `...\WordPress()->the_time(...)`' => 100,
            'Alias: \'`the_title(...)`\' to `...\WordPress()->the_title(...)`' => 100,
            'Alias: \'`comments_link(...)`\' to `...\WordPress()->comments_link(...)`' => 100,
            'Alias: \'`readintro(...)`\' to `...\WordPress()->readintro(...)`' => 100,
            'Alias: \'`is_tag(...)`\' to `...\WordPress()->is_tag(...)`' => 100,
            'Alias: \'`wp_get_archives(...)`\' to `...\WordPress()->wp_get_archives(...)`' => 100,
            'Alias: \'`wp_list_cats(...)`\' to `...\WordPress()->wp_list_cats(...)`' => 100,
            'Alias: \'`get_links(...)`\' to `...\WordPress()->get_links(...)`' => 100,
            'Alias: \'`wp_loginout(...)`\' to `...\WordPress()->wp_loginout(...)`' => 100,
            'Alias: \'`wp_meta(...)`\' to `...\WordPress()->wp_meta(...)`' => 100,
            'Alias: \'`theme_print_sidebar(...)`\' to `...\WordPress()->theme_print_sidebar(...)`' => 100,
            'Alias: \'`theme_has_layout_part(...)`\' to `...\WordPress()->theme_has_layout_part(...)`' => 100,
            'Alias: \'`get_num_queries(...)`\' to `...\WordPress()->get_num_queries(...)`' => 100,
            'Alias: \'`timer_stop(...)`\' to `...\WordPress()->timer_stop(...)`' => 100,
            'Alias: \'`theme_wordpress(...)`\' to `...\WordPress()->theme_wordpress(...)`' => 100,
            'Alias: \'`trailingslashit(...)`\' to `...\WordPress()->trailingslashit(...)`' => 100,
            'Alias: \'`get_template_directory(...)`\' to `...\WordPress()->get_template_directory(...)`' => 100,
            'Alias: \'`esc_url(...)`\' to `...\WordPress()->esc_url(...)`' => 100,
            'Alias: \'`home_url(...)`\' to `...\WordPress()->home_url(...)`' => 100,
            'Alias: \'`is_day(...)`\' to `...\WordPress()->is_day(...)`' => 100,
            'Alias: \'`get_the_date(...)`\' to `...\WordPress()->get_the_date(...)`' => 100,
            'Alias: \'`single_cat_title(...)`\' to `...\WordPress()->single_cat_title(...)`' => 100,
            'Alias: \'`get_the_author(...)`\' to `...\WordPress()->get_the_author(...)`' => 100,
            'Alias: \'`get_the_author_meta(...)`\' to `...\WordPress()->get_the_author_meta(...)`' => 100,
            'Alias: \'`get_avatar(...)`\' to `...\WordPress()->get_avatar(...)`' => 100,
            'Alias: \'`rewind_posts(...)`\' to `...\WordPress()->rewind_posts(...)`' => 100,
            'Alias: \'`of_get_option(...)`\' to `...\WordPress()->of_get_option(...)`' => 100,
            'Alias: \'`get_query_var(...)`\' to `...\WordPress()->get_query_var(...)`' => 100,
            'Alias: \'`get_search_query(...)`\' to `...\WordPress()->get_search_query(...)`' => 100,
            'Alias: \'`do_action(...)`\' to `...\WordPress()->do_action(...)`' => 100,
            'Alias: \'`is_active_sidebar(...)`\' to `...\WordPress()->is_active_sidebar(...)`' => 100,
            'Alias: \'`dynamic_sidebar(...)`\' to `...\WordPress()->dynamic_sidebar(...)`' => 100,
            'Alias: \'`wp_register(...)`\' to `...\WordPress()->wp_register(...)`' => 100,
            'Alias: \'`post_class(...)`\' to `...\WordPress()->post_class(...)`' => 100,
            'Alias: \'`edit_post_link(...)`\' to `...\WordPress()->edit_post_link(...)`' => 100,
            'Alias: \'`comments_template(...)`\' to `...\WordPress()->comments_template(...)`' => 100,
            'Alias: \'`comments_popup_link(...)`\' to `...\WordPress()->comments_popup_link(...)`' => 100,
            'Alias: \'`wp_pagenavi(...)`\' to `...\WordPress()->wp_pagenavi(...)`' => 100,
            'Alias: \'`post_password_required(...)`\' to `...\WordPress()->post_password_required(...)`' => 100,
            'Alias: \'`have_comments(...)`\' to `...\WordPress()->have_comments(...)`' => 100,
            'Alias: \'`wp_list_comments(...)`\' to `...\WordPress()->wp_list_comments(...)`' => 100,
            'Alias: \'`get_comment_pages_count(...)`\' to `...\WordPress()->get_comment_pages_count(...)`' => 100,
            'Alias: \'`previous_comments_link(...)`\' to `...\WordPress()->previous_comments_link(...)`' => 100,
            'Alias: \'`next_comments_link(...)`\' to `...\WordPress()->next_comments_link(...)`' => 100,
            'Alias: \'`comments_open(...)`\' to `...\WordPress()->comments_open(...)`' => 100,
            'Alias: \'`post_type_supports(...)`\' to `...\WordPress()->post_type_supports(...)`' => 100,
            'Alias: \'`get_post_type(...)`\' to `...\WordPress()->get_post_type(...)`' => 100,
            'Alias: \'`comment_form(...)`\' to `...\WordPress()->comment_form(...)`' => 100,
            'Alias: \'`has_nav_menu(...)`\' to `...\WordPress()->has_nav_menu(...)`' => 100,
            'Alias: \'`wp_nav_menu(...)`\' to `...\WordPress()->wp_nav_menu(...)`' => 100,
            'Alias: \'`get_post_meta(...)`\' to `...\WordPress()->get_post_meta(...)`' => 100,
            'Alias: \'`delete_post_meta(...)`\' to `...\WordPress()->delete_post_meta(...)`' => 100,
            'Alias: \'`add_post_meta(...)`\' to `...\WordPress()->add_post_meta(...)`' => 100,
            'Alias: \'`update_post_meta(...)`\' to `...\WordPress()->update_post_meta(...)`' => 100,
            'Alias: \'`locate_template(...)`\' to `...\WordPress()->locate_template(...)`' => 100,
            'Alias: \'`apply_filters(...)`\' to `...\WordPress()->apply_filters(...)`' => 100,
            'Alias: \'`is_front_page(...)`\' to `...\WordPress()->is_front_page(...)`' => 100,
            'Alias: \'`esc_attr(...)`\' to `...\WordPress()->esc_attr(...)`' => 100,
            'Alias: \'`is_plugin_active(...)`\' to `...\WordPress()->is_plugin_active(...)`' => 100,
            'Alias: \'`get_stylesheet_directory_uri(...)`\' to `...\WordPress()->get_stylesheet_directory_uri(...)`' => 100,
            'Alias: \'`get_pages(...)`\' to `...\WordPress()->get_pages(...)`' => 100,
            'Alias: \'`get_categories(...)`\' to `...\WordPress()->get_categories(...)`' => 100,
            'Alias: \'`update_option(...)`\' to `...\WordPress()->update_option(...)`' => 100,
            'Alias: \'`has_post_thumbnail(...)`\' to `...\WordPress()->has_post_thumbnail(...)`' => 100,
            'Alias: \'`the_post_thumbnail(...)`\' to `...\WordPress()->the_post_thumbnail(...)`' => 100,
            'Alias: \'`get_template_directory_uri(...)`\' to `...\WordPress()->get_template_directory_uri(...)`' => 100,
            'Alias: \'`wp_get_object_terms(...)`\' to `...\WordPress()->wp_get_object_terms(...)`' => 100,
            'Alias: \'`wp_reset_postdata(...)`\' to `...\WordPress()->wp_reset_postdata(...)`' => 100,
            'Alias: \'`the_author_posts_link(...)`\' to `...\WordPress()->the_author_posts_link(...)`' => 100,
            'Alias: \'`is_sticky(...)`\' to `...\WordPress()->is_sticky(...)`' => 100,
            'Alias: \'`get_search_form(...)`\' to `...\WordPress()->get_search_form(...)`' => 100,
            'Alias: \'`add_theme_support(...)`\' to `...\WordPress()->add_theme_support(...)`' => 100,
            'Alias: \'`add_image_size(...)`\' to `...\WordPress()->add_image_size(...)`' => 100,
            'Alias: \'`register_nav_menus(...)`\' to `...\WordPress()->register_nav_menus(...)`' => 100,
            'Alias: \'`load_theme_textdomain(...)`\' to `...\WordPress()->load_theme_textdomain(...)`' => 100,
            'Alias: \'`get_locale(...)`\' to `...\WordPress()->get_locale(...)`' => 100,
            'Alias: \'`add_action(...)`\' to `...\WordPress()->add_action(...)`' => 100,
            'Alias: \'`_n_noop(...)`\' to `...\WordPress()->_n_noop(...)`' => 100,
            'Alias: \'`tgmpa(...)`\' to `...\WordPress()->tgmpa(...)`' => 100,
            'Alias: \'`add_filter(...)`\' to `...\WordPress()->add_filter(...)`' => 100,
            'Alias: \'`is_admin(...)`\' to `...\WordPress()->is_admin(...)`' => 100,
            'Alias: \'`wp_register_script(...)`\' to `...\WordPress()->wp_register_script(...)`' => 100,
            'Alias: \'`wp_enqueue_script(...)`\' to `...\WordPress()->wp_enqueue_script(...)`' => 100,
            'Alias: \'`wp_register_style(...)`\' to `...\WordPress()->wp_register_style(...)`' => 100,
            'Alias: \'`wp_enqueue_style(...)`\' to `...\WordPress()->wp_enqueue_style(...)`' => 100,
            'Alias: \'`is_ssl(...)`\' to `...\WordPress()->is_ssl(...)`' => 100,
            'Alias: \'`is_author(...)`\' to `...\WordPress()->is_author(...)`' => 100,
            'Alias: \'`is_year(...)`\' to `...\WordPress()->is_year(...)`' => 100,
            'Alias: \'`register_sidebar(...)`\' to `...\WordPress()->register_sidebar(...)`' => 100,
            'Alias: \'`register_widget(...)`\' to `...\WordPress()->register_widget(...)`' => 100,
            'Alias: \'`get_the_excerpt(...)`\' to `...\WordPress()->get_the_excerpt(...)`' => 100,
            'Alias: \'`get_the_tag_list(...)`\' to `...\WordPress()->get_the_tag_list(...)`' => 100,
            'Alias: \'`get_comment_author_link(...)`\' to `...\WordPress()->get_comment_author_link(...)`' => 100,
            'Alias: \'`comment_reply_link(...)`\' to `...\WordPress()->comment_reply_link(...)`' => 100,
            'Alias: \'`comment_text(...)`\' to `...\WordPress()->comment_text(...)`' => 100,
            'Alias: \'`is_loggedin(...)`\' to `...\WordPress()->is_loggedin(...)`' => 100,
            'Alias: \'`get_bloginfo(...)`\' to `...\WordPress()->get_bloginfo(...)`' => 100,
            'Alias: \'`wp_parse_args(...)`\' to `...\WordPress()->wp_parse_args(...)`' => 100,
            'Alias: \'`add_shortcode(...)`\' to `...\WordPress()->add_shortcode(...)`' => 100,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_content(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_post(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->theme_is_home(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->theme_get_dynamic_sidebar_data(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_home(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_option(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->theme_get_menu(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_list_pages(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->theme_get_option(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_head(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->body_class(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->remove_action(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_post_format(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_template_part(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->have_posts(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_singular(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_title(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->language_attributes(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->theme_page_navigation(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->do_shortcode(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->bloginfo(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_sidebar(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->_e(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_header(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_footer(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_footer(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wordpress(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->previous_posts_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->next_posts_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_search(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_tags(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_single(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_page(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_category(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_month(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_ID(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->comments_number(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_permalink(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_category(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_author_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_time(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_title(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->comments_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->readintro(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_tag(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_get_archives(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_list_cats(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_links(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_loginout(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_meta(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->theme_print_sidebar(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->theme_has_layout_part(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_num_queries(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->timer_stop(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->theme_wordpress(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->trailingslashit(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_template_directory(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->esc_url(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->home_url(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_day(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_the_date(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->single_cat_title(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_the_author(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_the_author_meta(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_avatar(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->rewind_posts(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->of_get_option(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_query_var(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_search_query(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->do_action(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_active_sidebar(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->dynamic_sidebar(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_register(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->post_class(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->edit_post_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->comments_template(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->comments_popup_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_pagenavi(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->post_password_required(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->have_comments(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_list_comments(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_comment_pages_count(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->previous_comments_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->next_comments_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->comments_open(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->post_type_supports(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_post_type(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->comment_form(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->has_nav_menu(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_nav_menu(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_post_meta(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->delete_post_meta(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->add_post_meta(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->update_post_meta(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->locate_template(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->apply_filters(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_front_page(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->esc_attr(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_plugin_active(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_stylesheet_directory_uri(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_pages(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_categories(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->update_option(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->has_post_thumbnail(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_post_thumbnail(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_template_directory_uri(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_get_object_terms(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_reset_postdata(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->the_author_posts_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_sticky(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_search_form(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->add_theme_support(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->add_image_size(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->register_nav_menus(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->load_theme_textdomain(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_locale(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->add_action(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->_n_noop(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->tgmpa(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->add_filter(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_admin(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_register_script(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_enqueue_script(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_register_style(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_enqueue_style(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_ssl(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_author(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_year(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->register_sidebar(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->register_widget(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_the_excerpt(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_the_tag_list(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_comment_author_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->comment_reply_link(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->comment_text(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->is_loggedin(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->get_bloginfo(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->wp_parse_args(...)`' => 75,
            'Function: `\WDGWV\CMS\emulation\WordPress()->add_shortcode(...)`' => 75,
        );

        $items['Emulation: Blogger'] = array(
            'Template' => 75,
        );

        $items['WDGWV/CMS/Debugger.php'] = array(
            'Function: `\WDGWV\CMS\Debugger::shared()->log(...)`' => 100,
            'Function: `\WDGWV\CMS\Debugger::shared()->logf(...)`' => 100,
            'Function: `\WDGWV\CMS\Debugger::shared()->warning(...)`' => 100,
            'Function: `\WDGWV\CMS\Debugger::shared()->error(...)`' => 100,
            'Function: `\WDGWV\CMS\Debugger::shared()->logdump(...)`' => 100,
            'Function: `\WDGWV\CMS\Debugger::shared()->dumpAllClasses(...)`' => 100,
            'Function: `\WDGWV\CMS\Debugger::shared()->dump(...)`' => 100,
            'Function: `\WDGWV\CMS\Debugger::shared()->warrayFill(...)`' => 100,
        );

        $items['WDGWV/CMS/Extensions.php'] = array(
            'Defines: `\WDGWV\CMS\Extensions::shared()->$scan_directories`' => 100,
            'Defines: `\WDGWV\CMS\Extensions::shared()->$load_files`' => 100,
            'Defines: `\WDGWV\CMS\Extensions::shared()->$systemExtensions`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->__construct(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->displayExtensionList(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->loadExtensions(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->isSystem(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->isActive(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->integrityCheck(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->checkHash(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->enableExtension(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->disableExtension(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->getExtensionPath(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->information(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->match(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->parseInformation(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->forceReloadExtensions(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->reloadExtensions(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->saveDatabase(...)`' => 100,
            'Function: `\WDGWV\CMS\Extensions::shared()->__destruct(...)`' => 100,
        );

        $items['WDGWV/CMS/Hooks.php'] = array(
            'Function: `\WDGWV\CMS\Hooks::shared()->getUBBHooks(...)`' => 0,
            'Function: `\WDGWV\CMS\Hooks::shared()->loopHooks(...)`' => 100,
            'Function: `\WDGWV\CMS\Hooks::shared()->haveHooksFor(...)`' => 100,
            'Function: `\WDGWV\CMS\Hooks::shared()->loadHooksFor(...)`' => 100,
            'Function: `\WDGWV\CMS\Hooks::shared()->pageLoadFor(...)`' => 100,
            'Function: `\WDGWV\CMS\Hooks::shared()->loopHook(...)`' => 100,
            'Function: `\WDGWV\CMS\Hooks::shared()->createHook(...)`' => 100,
            'Function: `\WDGWV\CMS\Hooks::shared()->dumpDatabase(...)`' => 100,
            'Function: `\WDGWV\CMS\Hooks::shared()->adminURL(...)`' => 100,
        );

        $items['WDGWV/CMS/Installer.php'] = array(
            'Note: installer works for < 1.0 versions' => 50,
            'Note: it\'s need a re-implementation to work with 1.0+' => 50,
            'Install (online)' => 75,
            'Install (offline)' => 0,
            '...' => 0,
            'Function: `\WDGWV\CMS\Installer::shared->setDebugger(...)`' => 100,
            'Function: `\WDGWV\CMS\Installer::shared->isInstalled(...)`' => 100,
            'Function: `\WDGWV\CMS\Installer::shared->canOfflineInstall(...)`' => 100,
            'Function: `\WDGWV\CMS\Installer::shared->validatedInstall(...)`' => 100,
            'Function: `\WDGWV\CMS\Installer::shared->setupWrite(...)`' => 100,
            'Function: `\WDGWV\CMS\Installer::shared->parseSetupFiles(...)`' => 100,
            'Function: `\WDGWV\CMS\Installer::shared->beginOfflineInstall(...)`' => 100,
            'Function: `\WDGWV\CMS\Installer::shared->beginOnlineInstall(...)`' => 100,
        );

        $items['WDGWV/CMS/Loader.php'] = array(
            'function: `\WDGWV\CMS\autloadWDGWVCMS(...)`' => 100,
            'spl_autoload_register' => 100,
            'Load: `\WDGWV\CMS\Config::shared()`' => 100,
            'Load: `\WDGWV\CMS\Debugger::shared()`' => 100,
            'Load: `\WDGWV\CMS\Hooks::shared()`' => 100,
            'Load: `\WDGWV\CMS\Extensions::shared()`' => 100,
            'Load: `\WDGWV\CMS\Installer::shared()`' => 100,
            'Load: `\WDGWV\CMS\Database::shared()`' => 100,
            'Load: `\WDGWV\CMS\Base::shared()`' => 100,
            'Display: debug' => 100,
        );

        /**
         * DO NOT CHANGE AFTER THIS LINE
         */

        $page = array();
        $page[] = array(
            'CMS Progress',
            '---<br /><br />This is a todo list (static, for creating/debugging use only atm)',
        );

        $allItemsCount = 0;
        $allItemsProgress = 0;

        foreach ($items as $title => $subitems) {
            $count = 0;
            $c_items = 0;
            $contents = sprintf('---<br />%s<br /><br />', $title);
            $contents .= '<b>**Progress**</b><br /><br /><ul>';

            foreach ($subitems as $key => $value) {
                $allItemsCount++;
                $allItemsProgress = $allItemsProgress + $value;

                $count = $count + $value;
                $c_items++;

                $contents .= sprintf(
                    '<li%s>*<progress min=0 max=100 value=%s></progress> %s%% | %s</li>',
                    ($value < 100 ? ($value < 75 ? ' style=\'color:red;\'' : ' style=\'color:orange;\'') : ' style=\'color:green;\''),
                    $value,
                    $value,
                    $key
                );
            }

            $contents .= sprintf(
                '</ul><br />Overall progress: <progress min=0 max=%s value=%s></progress> %s/%s<br /><br />',
                $c_items * 100,
                $count,
                $count / 100,
                $c_items
            );

            $page[] = array($title, $contents);
        }

        $calcItems = $allItemsProgress / 100;
        $calcProgress = round(($calcItems / $allItemsCount) * 100);

        $page[0][1] = "---<br /><br />Overall progress: {$calcItems} of {$allItemsCount} items = {$calcProgress}%<br /><br />";

        return $page;
    }
}

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'administration/Todo/Create',
    array(
        'name' => 'administration/Todo/Create',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Todo/Create', ADMIN_URL),
        'userlevel' => '*',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'administration/Todo/Remove',
    array(
        'name' => 'administration/Todo/Remove',
        'icon' => 'pencil',
        'url' => sprintf('/%s/Todo/Remove/*', ADMIN_URL),
        'userlevel' => '*',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'menu',
    'TODO',
    array(
        'name' => 'TODO',
        'icon' => 'pencil',
        'url' => '/dev/TODO',
        'userlevel' => '*',
    )
);

\WDGWV\CMS\Hooks::shared()->createHook(
    'url',
    '/dev/TODO', // Supports also /calendar/i*cs and then /calendar/ixcs works also
    array(todoExtension::shared(), '_display')
);
