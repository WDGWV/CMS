<?php
/*
                   :....................,:,              
                ,.`,,,::;;;;;;;;;;;;;;;;:;`              
              `...`,::;:::::;;;;;;;;;;;;;::'             
             ,..``,,,::::::::::::::::;:;;:::;            
            :.,,``..::;;,,,,,,,,,,,,,:;;;;;::;`          
           ,.,,,`...,:.:,,,,,,,,,,,,,:;:;;;;:;;          
          `..,,``...;;,;::::::::::::::'';';';:''         
          ,,,,,``..:;,;;:::::::::::::;';;';';;'';        
         ,,,,,``....;,,:::::::;;;;;;;;':'''';''+;        
         :,::```....,,,:;;;;;;;;;;;;;;;''''';';';;       
        `,,::``.....,,,;;;;;;;;;;;;;;;;'''''';';;;'      
        :;:::``......,;;;;;;;;:::::;;;;'''''';;;;:       
        ;;;::,`.....,::;;::::::;;;;;;;;'''''';;,;;,      
        ;:;;:;`....,:::::::::::::::::;;;;'''':;,;;;      
        ';;;;;.,,,,::::::::::::::::::;;;;;''':::;;'      
        ;';;;;.;,,,,::::::::::::::::;;;;;;;''::;;;'      
        ;'';;:;..,,,;;;:;;:::;;;;;;;;;;;;;;;':::;;'      
        ;'';;;;;.,,;:;;;;;;;;;;;;;;;;;;;;;;;;;:;':;      
        ;''';;:;;.;;;;;;;;;;;;;;;;;;;;;;;;;;;''';:.      
        :';';;;;;;::,,,,,,,,,,,,,,:;;;;;;;;;;'''';       
         '';;;;:;;;.,,,,,,,,,,,,,,,,:;;;;;;;;'''''       
         '''';;;;;:..,,,,,,,,,,,,,,,,,;;;;;;;''':,       
         .'''';;;;....,,,,,,,,,,,,,,,,,,,:;;;''''        
          ''''';;;;....,,,,,,,,,,,,,,,,,,;;;''';.        
           '''';;;::.......,,,,,,,,,,,,,:;;;''''         
           `''';;;;:,......,,,,,,,,,,,,,;;;;;''          
            .'';;;;;:.....,,,,,,,,,,,,,,:;;;;'           
             `;;;;;:,....,,,,,,,,,,,,,,,:;;''            
               ;';;,,..,.,,,,,,,,,,,,,,,;;',             
                 '';:,,,,,,,,,,,,,,,::;;;:               
                  `:;'''''''''''''''';:.                 
                                                         
 ,,,::::::::::::::::::::::::;;;;,::::::::::::::::::::::::
 ,::::::::::::::::::::::::::;;;;,::::::::::::::::::::::::
 ,:; ## ## ##  #####     ####      ## ## ##  ##   ##  ;::
 ,,; ## ## ##  ## ##    ##         ## ## ##  ##   ##  ;::
 ,,; ## ## ##  ##  ##  ##   ####   ## ## ##   ## ##   ;::
 ,,' ## ## ##  ## ##    ##    ##   ## ## ##   ## ##   :::
 ,:: ########  ####      ######    ########    ###    :::
 ,,,:,,:,,:::,,,:;:::::::::::::::;;;:::;:;:::::::::::::::
 ,,,,,,,,,,,,,,,,,,,,,,,,:,::::::;;;;:::::;;;;::::;;;;:::
                                                         
	     (c) WDGWV. 2013, http://www.wdgwv.com           
	 websites, Apps, Hosting, Services, Development.      

  File Checked.
  Checked by: WdG.
  File created: WdG.
  date: 07-06-2013

  © WDGWV, www.wdgwv.com
  All Rights Reserved.
*/

//compatibility

define('ABSPATH', true);

#function get_header ( ) 
# load the header
## WdG: 5 DEC 2013
function get_header( )
{
	#TODO: WP:HEADER
}

#function _e ( str ) 
# translations
## WdG: 5 DEC 2013
function _e ( $str, $theme )
{
	#TODO: WP:_e
}

#function esc_url ( url(str) ) 
# escape url
## WdG: 5 DEC 2013
function esc_url ( $url )
{
	#TODO: WP:esc_url
}

#function home_url ( url(str) ) 
# return the home url
## WdG: 5 DEC 2013
function home_url ( $url )
{
	#TODO: WP:home_url
}

#function get_footer ( ) 
# load the footer
## WdG: 5 DEC 2013
function get_footer ( )
{
	#TODO: WP:get_footer
}

#function is_day ( ) 
# is it daylight?
## WdG: 5 DEC 2013
function is_day ( $date )
{
	#TODO: WP:is_day
}

#function get_the_date ( ) 
# get the date
## WdG: 5 DEC 2013
function get_the_date ( $date )
{
	return date ( $date );
}

#function single_cat_title ( ) 
# !!! DON'T KNOW WHAT IT IS !!!
## WdG: 5 DEC 2013
function single_cat_title ( $one, $par=false )
{
	#TODO: WP:single_cat_title
}

#function get_template_part ( ) 
# get part of a template
## WdG: 5 DEC 2013
function get_template_part ( $part )
{
	#TODO: WP:get_template_part
}

#function get_sidebar ( ) 
# get the sidebar
## WdG: 5 DEC 2013
function get_sidebar ( $side='bar' )
{
	#TODO: WP:get_sidebar
}

#function have_posts ( ) 
#TODO
## WdG: 5 DEC 2013
function have_posts ( )
{
	return false;
	// NO POST SYSTEM INSTALLED SORRY.
}

#function the_post ( ) 
#TODO
## WdG: 5 DEC 2013
function the_post ( )
{
	#TODO: WP:the_post
}

#function get_the_author ( ) 
#TODO
## WdG: 5 DEC 2013
function get_the_author ( )
{
	#TODO: WP:get_the_author
}

#function get_the_author_meta ( ) 
#TODO
## WdG: 5 DEC 2013
function get_the_author_meta ( $what )
{
	#TODO: WP:get_the_author_meta
}

#function get_avatar ( ) 
#TODO
## WdG: 5 DEC 2013
function get_avatar ( $from, $widheight )
{
	#TODO: WP:get_avatar
}

#function rewind_posts ( ) 
#TODO
## WdG: 5 DEC 2013
function rewind_posts ( )
{
	#TODO: WP:rewind_posts
}

#function of_get_option ( ) 
#TODO
## WdG: 5 DEC 2013
function of_get_option ( $option )
{
	#TODO: WP:of_get_option
}

#function get_query_var ( ) 
#TODO
## WdG: 5 DEC 2013
function get_query_var ( $what )
{
	#TODO: WP:get_query_var
}

#class WP_Query ( ) 
#TODO
## WdG: 5 DEC 2013
class WP_Query
{
	
	function __construct(argument)
	{
		#TODO
		/*
		array( 
                        'post_type' =>'post',                       
                        'post_status' => 'publish',
                        'paged' => $paged )
        */
	}

#function have_posts ( ) 
#TODO
## WdG: 5 DEC 2013
	public function have_posts ( )
	{
		#TODO
	}

#function found_posts ( ) 
#TODO
## WdG: 5 DEC 2013
	public function found_posts( )
	{
		# code...
	}
}

#function get_search_query ( ) 
#TODO
## WdG: 5 DEC 2013
function get_search_query ( )
{
	#TODO: WP:get_search_query
}

#function do_acrion ( ) 
#TODO
## WdG: 5 DEC 2013
function do_action ( )
{
	#TODO: WP:do_action
}

#function is_active_sidebar ( ) 
#TODO
## WdG: 5 DEC 2013
function is_active_sidebar ( $sidebar ) //main-sidebar
{
	#TODO: WP:is_active_sidebar
	return false;
}

#function dynamic_sidebar ( ) 
#TODO
## WdG: 5 DEC 2013
function dynamic_sidebar ( ) //main-sidebar
{
	#TODO: WP:dynamic_sidebar
}

#function wp_get_archives ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_get_archives ( $archives )
{
	#TODO: WP:wp_get_archives (array!)
}

#function wp_register ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_register ( )
{
	#TODO: WP:wp_register
}

#function wp_meta ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_meta ( )
{
	#TODO: WP:wp_meta
}

#function the_title ( ) 
#TODO
## WdG: 5 DEC 2013
function the_title ( )
{
	#TODO: WP:the_title
}

#function the_ID ( ) 
#TODO
## WdG: 5 DEC 2013
function the_ID ( )
{
	#TODO: WP:the_ID (echo)
}

#function post_class ( ) 
#TODO
## WdG: 5 DEC 2013
function post_class ( )
{
	#TODO: WP:post_class (echo)
	echo " class='post'";
}

#function the_content ( ) 
#TODO
## WdG: 5 DEC 2013
function the_content ( )
{
	#TODO: WP:the_content
}

#function edit_post_link ( ) 
#TODO
## WdG: 5 DEC 2013
function edit_post_link ( )
{
	#TODO: WP:edit_post_link
}

#function comments_template ( ) 
#TODO
## WdG: 5 DEC 2013
function comments_template ( $what, $switch )
{
	#TODO: WP:comments_template
}

#function comments_popup_link ( ) 
#TODO
## WdG: 5 DEC 2013
function comments_popup_link ( $leave, $one, $more )
{
	#TODO: WP:comments_popup_link
}

#function wp_pagenavi ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_pagenavi ( )
{
	//V2 NAVIGATION
	#TODO: WP:wp_pagenavi
}

#function post_password_required ( ) 
#TODO
## WdG: 5 DEC 2013
function post_password_required ( )
{
	#TODO: WP:post_password_required
	return false; //NOT SUPPORTED YET
}

#function have_comments ( ) 
#TODO
## WdG: 5 DEC 2013
function have_comments ( )
{
	#TODO: WP:have_comments
}

#function comments_number ( ) 
#TODO
## WdG: 5 DEC 2013
function comments_number ( )
{
	#TODO: WP:comments_number (int, echo)
}

#function wp_list_comments ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_list_comments ( $how )
{
	#TODO: WP:wp_list_comments (how)
}

#function get_comment_page_count ( ) 
#TODO
## WdG: 5 DEC 2013
function get_comment_pages_count ( )
{
	#TODO: WP:get_comment_pages_count
	return 0;
}

#function previous_comments_link ( ) 
#TODO
## WdG: 5 DEC 2013
function previous_comments_link ( )
{
	#TODO: WP:previous_comments_link
}

#function next_comments_link ( ) 
#TODO
## WdG: 5 DEC 2013
function next_comments_link ( )
{
	#TODO: WP:next_comments_link
}

#function comments_open ( ) 
#TODO
## WdG: 5 DEC 2013
function comments_open ( )
{
	#TODO: WP:comments_open
	return true; //comments are allowed
}

#function is_page ( ) 
#TODO
## WdG: 5 DEC 2013
function is_page ( )
{
	#TODO: WP:is_page
	return true;
}

#function post_tyoe_supports ( ) 
#TODO
## WdG: 5 DEC 2013
function post_type_supports ( $supports, $region='comments' )
{
	#TODO: WP:post_type_supports
}

#function get_post_type ( ) 
#TODO
## WdG: 5 DEC 2013
function get_post_type ( )
{
	#TODO: WP:get_post_type
}

#function comment_form ( ) 
#TODO
## WdG: 5 DEC 2013
function comment_form ( $array )
{
	//ARRAY
	#TODO: WP:comment_form
}

#function has_nav_menu ( ) 
#TODO
## WdG: 5 DEC 2013
function has_nav_menu ( )
{
	#TODO: WP:has_nav_menu
}

#function wp_nav_menu ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_nav_menu ( )
{
	#TODO: WP:wp_nav_menu
}

#function bloginfo ( ) 
#TODO
## WdG: 5 DEC 2013
function bloginfo ( $what )
{
	#TODO: WP:bloginfo
}

#function get_post_meta ( ) 
#TODO
## WdG: 5 DEC 2013
function get_post_meta ( $what, $where, $how )
{
	#TODO: WP:get_post_meta
}

#function delete_post_meta ( ) 
#TODO
## WdG: 5 DEC 2013
function delete_post_meta ( $id, $count )
{
	#TODO: WP:delete_post_meta
}

#function add_post_meta ( ) 
#TODO
## WdG: 5 DEC 2013
function add_post_meta ( $id, $countkey, $count )
{
	#TODO: WP:add_post_meta
}

#function update_post_meta ( ) 
#TODO
## WdG: 5 DEC 2013
function update_post_meta ( $id, $countkey, $count )
{
	#TODO: WP:update_post_meta
}

#function locate_template ( ) 
#TODO
## WdG: 5 DEC 2013
function locate_template ( $template, $options )
{
	#TODO: WP:locate_template
}

#function apply_filters ( ) 
#TODO
## WdG: 5 DEC 2013
function apply_filters ( $filter, $options )
{
	#TODO: WP:apply_filters
}

#function language_attributes ( ) 
#TODO
## WdG: 5 DEC 2013
function language_attributes ( )
{
	#TODO: WP:language_attributes
}

#function wp_title ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_title ( )
{
	#TODO: WP:wp_title
}

#function wp_head ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_head ( )
{
	#TODO: WP:wp_head
}

#function is_front_page ( ) 
#TODO
## WdG: 5 DEC 2013
function is_front_page ( )
{
	#TODO: WP:is_front_page
	return true;
}

#function body_class ( ) 
#TODO
## WdG: 5 DEC 2013
function body_class ( $class )
{
	#TODO: WP:body_class
}

#function esc_attr ( string(str) ) 
#escape attributes
## WdG: 5 DEC 2013
function esc_attr ( $escape )
{
	#TODO: WP:esc_attr
}

#function wp_list_pages ( how ) 
#TODO
## WdG: 5 DEC 2013
function wp_list_pages ( $options )
{
	#TODO: WP:wp_list_pages
}

#function is_plugin_active ( path(str) ) 
#TODO
## WdG: 5 DEC 2013
function is_plugin_active ( $path )
{
	#TODO: WP:is_plugin_active
	return false;
}

#function get_stylesheet_directory_url ( ) 
#TODO
## WdG: 5 DEC 2013
function get_stylesheet_directory_uri ( )
{
	#TODO: WP:get_stylesheet_directory_uri
}

#function get_pages ( ) 
#TODO
## WdG: 5 DEC 2013
function get_pages ( $how )
{
	#TODO: WP:get_pages
}

#function get_categories ( ) 
#TODO
## WdG: 5 DEC 2013
function get_categories ( $how )
{
	#TODO: WP:get_categories
}

#function get_option ( ) 
#TODO
## WdG: 5 DEC 2013
function get_option ( $what )
{
	return of_get_option ( $what )
}

#function update_option ( ) 
#TODO
## WdG: 5 DEC 2013
function update_option ( $what )
{
	#TODO: WP:update_option
}

#function has_post_thumbnail ( ) 
#TODO
## WdG: 5 DEC 2013
function has_post_thumbnail ( )
{
	#TODO: WP:has_post_thumbnail
}

#function the_post_thumbnail ( ) 
#TODO
## WdG: 5 DEC 2013
function the_post_thumbnail ( $kind )
{
	#TODO: WP:the_post_thumbnail
}

#function get_template_directory_uri ( ) 
#TODO
## WdG: 5 DEC 2013
function get_template_directory_uri ( )
{
	#TODO: WP:get_template_directory_uri
}

#function wp_get_object_terms ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_get_object_terms ( $id, $theme )
{
	#TODO: WP:wp_get_object_terms
}

#function wp_reset_postdata ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_reset_postdata ( )
{
	#TODO: WP:wp_reset_postdata
}

#function the_author_post_links ( ) 
#TODO
## WdG: 5 DEC 2013
function the_author_posts_link ( )
{
	#TODO: WP:the_author_posts_link
}

#function the_permalink ( ) 
#TODO
## WdG: 5 DEC 2013
function the_permalink ( )
{
	#TODO: WP:the_permalink
}

#function is_sticky ( ) 
#TODO
## WdG: 5 DEC 2013
function is_sticky ( )
{
	#TODO: WP:is_sticky
	return false;
}

#function get_search_form ( ) 
#TODO
## WdG: 5 DEC 2013
function get_search_form ( )
{
	#TODO: WP:get_search_form
}

#function add_theme_support ( ) 
#TODO
## WdG: 5 DEC 2013
function add_theme_support ( $what, $options = null )
{
	#TODO: WP:add_theme_support
}

#function add_image_size ( ) 
#TODO
## WdG: 5 DEC 2013
function add_image_size ( $kind, $width, $height, $load )
{
	#TODO: WP:add_image_size
}

#function register_nav_menus ( ) 
#TODO
## WdG: 5 DEC 2013
function register_nav_menus ( $menu )
{
	#TODO: WP:register_nav_menus
	//$menu = array.
}

#function load_theme_textdomain ( ) [NOT SUPPORTED!!!]
#TODO
## WdG: 5 DEC 2013
function load_theme_textdomain ( $theme, $dir )
{
	#TODO: WP:load_theme_textdomain
	return false; //NOT SUPPORTED MO & PO FILES
}

#function get_locale ( ) 
#TODO
## WdG: 5 DEC 2013
function get_locale ( )
{
	#TODO: WP:get_locale
}

#function add_action ( ) 
#TODO
## WdG: 5 DEC 2013
function add_action ( $when, $action )
{
	#TODO: WP:add_action
}

#function _n_noop ( ) 
#TODO
## WdG: 5 DEC 2013
function _n_noop ( $what, $other )
{
	#TODO: WP:_n_noop
	//NO IDEA WHAT IT DOES.
}

#function tgmpa ( ) 
#TODO
## WdG: 5 DEC 2013
function tgmpa ( $some, $thing )
{
	#TODO: WP:tgmpa
	//NO IDEA WHAT IT DOES.
}

#function add_filter ( ) 
#TODO
## WdG: 5 DEC 2013
function add_filter ( $when, $what )
{
	#TODO: WP:add_filter
}

#function is_admin ( ) 
#is the 'loggedin' user a admin?
## WdG: 5 DEC 2013
function is_admin ( )
{
	#TODO: WP:is_admin
	if ( is_loggedin() )
	{
		if ( $_SESSION['WDGWV_USER_LEVEL'] > WDGWV_LEVEL_ADMIN )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

#function wp_register_script ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_register_script ( $script )
{
	#TODO: WP:wp_register_script
}

#function wp_enqueue_script ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_enqueue_script ( $what )
{
	#TODO: WP:wp_enqueue_script
	//load a javascript, SEE wp_register_script
}

#function wp_register_style ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_register_style ( $style )
{
	#TODO: WP:wp_register_style
}

#function wp_enqueue_style ( ) 
#TODO
## WdG: 5 DEC 2013
function wp_enqueue_style ( $what )
{
	#TODO: WP:wp_enqueue_style
	//load a css style, SEE wp_register_style
}

#function is_ssl ( ) 
#TODO
## WdG: 5 DEC 2013
function is_ssl ( )
{
	#TODO: WP:is_ssl
	return false;
}

#function remove_action ( ) 
#TODO
## WdG: 5 DEC 2013
function remove_action ( $action, $remove )
{
	#TODO: WP:remove_action
}

#function is_category ( ) 
#TODO
## WdG: 5 DEC 2013
function is_category ( )
{
	#TODO: WP:is_category
}

#function is_tag ( ) 
#TODO
## WdG: 5 DEC 2013
function is_tag ( )
{
	#TODO: WP:is_tag
}

#function is_author ( ) 
#TODO
## WdG: 5 DEC 2013
function is_author ( )
{
	#TODO: WP:is_author
}

#function is_home ( ) 
#TODO
## WdG: 5 DEC 2013
function is_home ( )
{
	#TODO: WP:is_home
}

#function is_year ( ) 
#TODO
## WdG: 5 DEC 2013
function is_year ( $date ) 
{
	#TODO: WP:is_year
}

#function is_month ( ) 
#TODO
## WdG: 5 DEC 2013
function is_month ( $date )
{
	#TODO: WP:is_month
}

#function register_sidebar ( ) 
#TODO
## WdG: 5 DEC 2013
function register_sidebar ( $theSidebarItemToAdd )
{
	#TODO: WP:register_sidebar
}

#function register_widget ( ) 
#TODO
## WdG: 5 DEC 2013
function register_widget ( $widget )
{
	#TODO: WP:register_widget
}

#function is_singular ( ) 
#TODO
## WdG: 5 DEC 2013
function is_singular ( )
{
	#TODO: WP:is_singular
	//DON'T KNOW IT...
}

#function get_the_excerpt ( ) 
#TODO
## WdG: 5 DEC 2013
function get_the_excerpt ( )
{
	#TODO: WP:get_the_excerpt
}

#function get_the_tag_list ( ) 
#TODO
## WdG: 5 DEC 2013
function get_the_tag_list ( $how, $string )
{
	#TODOL WP:get_the_tag_list
}

#function get_comment_author_link ( ) 
#TODO
## WdG: 5 DEC 2013
function get_comment_author_link ( )
{
	#TODO: WP:get_comment_author_link
}

#function comment_reply_link ( ) 
#TODO
## WdG: 5 DEC 2013
function comment_reply_link ( )
{
	#TODO: WP:comment_reply_link
}

#function comment_text ( ) 
#TODO
## WdG: 5 DEC 2013
function comment_text ( )
{
	#TODO: WP:comment_text
}

#function get_sidebar ( ) 
#Check if the user is logged in...
## WdG: 5 DEC 2013
function is_loggedin ( )
{
	if ( isset ( $_SESSION['WDGWV_USER_ID'] ) )
	{
		if ( $_SESSION['WDGWV_USER_IP'] == $_SERVER['REMOTE_ADDR'] ) 
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

######################################
######################################
## PROBALLY NOT THE END OF THE FILE ##
########## 5 DECEMBER 2013 ###########
######################################
?>