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

function have_posts ( )
{
	return false;
	// NO POST SYSTEM INSTALLED SORRY.
}

function the_post ( )
{
	#TODO: WP:the_post
}

function get_the_author ( )
{
	#TODO: WP:get_the_author
}

function get_the_author_meta ( $what )
{
	#TODO: WP:get_the_author_meta
}

function get_avatar ( $from )
{
	#TODO: WP:get_avatar
}

function rewind_posts ( )
{
	#TODO: WP:rewind_posts
}

function of_get_option ( $option )
{
	#TODO: WP:of_get_option
}

function get_query_var ( $what )
{
	#TODO: WP:get_query_var
}

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

	public function have_posts ( )
	{
		#TODO
	}

	public function found_posts( )
	{
		# code...
	}
}

function get_search_query ( )
{
	#TODO: WP:get_search_query
}

function do_action ( )
{
	#TODO: WP:do_action
}

function is_active_sidebar ( $sidebar ) //main-sidebar
{
	#TODO: WP:is_active_sidebar
	return false;
}

function dynamic_sidebar ( ) //main-sidebar
{
	#TODO: WP:dynamic_sidebar
}

function wp_get_archives ( $archives )
{
	#TODO: WP:wp_get_archives (array!)
}

function wp_register ( )
{
	#TODO: WP:wp_register
}

function wp_meta ( )
{
	#TODO: WP:wp_meta
}

function the_title ( )
{
	#TODO: WP:the_title
}

function the_ID ( )
{
	#TODO: WP:the_ID (echo)
}

function post_class ( )
{
	#TODO: WP:post_class (echo)
	echo " class='post'";
}

function the_content ( )
{
	#TODO: WP:the_content
}

function edit_post_link ( )
{
	#TODO: WP:edit_post_link
}

function comments_template ( $what, $switch )
{
	#TODO: WP:comments_template
}

function wp_pagenavi ( )
{
	//V2 NAVIGATION
	#TODO: WP:wp_pagenavi
}

function post_password_required ( )
{
	#TODO: WP:post_password_required
	return false; //NOT SUPPORTED YET
}

function have_comments ( )
{
	#TODO: WP:have_comments
}

function comments_number ( )
{
	#TODO: WP:comments_number (int, echo)
}

function wp_list_comments ( $how )
{
	#TODO: WP:wp_list_comments (how)
}

function get_comment_pages_count ( )
{
	#TODO: WP:get_comment_pages_count
	return 0;
}

function previous_comments_link ( )
{
	#TODO: WP:previous_comments_link
}

function next_comments_link ( )
{
	#TODO: WP:next_comments_link
}

function comments_open ( )
{
	#TODO: WP:comments_open
	return true; //comments are allowed
}

function is_page ( )
{
	#TODO: WP:is_page
	return true;
}

function post_type_supports ( $supports, $region='comments' )
{
	#TODO: WP:post_type_supports
}

function get_post_type ( )
{
	#TODO: WP:get_post_type
}

function comment_form ( $array )
{
	//ARRAY
	#TODO: WP:comment_form
}

function has_nav_menu ( )
{
	#TODO: WP:has_nav_menu
}

function wp_nav_menu ( )
{
	#TODO: WP:wp_nav_menu
}

function bloginfo ( $what )
{
	#TODO: WP:bloginfo
}

function get_post_meta ( $what, $where, $how )
{
	#TODO: WP:get_post_meta
}

function locate_template ( $template, $options )
{
	#TODO: WP:locate_template
}

function apply_filters ( $filter, $options )
{
	#TODO: WP:apply_filters
}

function language_attributes ( )
{
	#TODO: WP:language_attributes
}

function wp_title ( )
{
	#TODO: WP:wp_title
}

function wp_head ( )
{
	#TODO: WP:wp_head
}

function is_front_page ( )
{
	#TODO: WP:is_front_page
	return true;
}

function body_class ( $class )
{
	#TODO: WP:body_class
}

function esc_attr ( $escape )
{
	#TODO: WP:esc_attr
}

function wp_list_pages ( $options )
{
	#TODO: WP:wp_list_pages
}












?>