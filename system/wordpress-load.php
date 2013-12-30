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

$theme_sidebars = array();
$headline = 'div';

#function the_post ( ) 
# Load the "post" CONTENT
## WdG: 23-DEC-2013
function the_content ( )
{
	echo '
Here you\'ll find some statics about this project, for now al the pages are static, and not yet changeable.<br />
Come back later ;)<br /><br />
<table><tr><td><script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_factoids_stats.js"></script></td><td>
<script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_cocomo.js"></script></tr></table>
<script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_users.js?style=blue"></script>
';
}

#function the_post ( ) 
# Load the "post" CONTENT
## WdG: 23-DEC-2013
function the_post ( )
{
//	echo "CONTENT CONTENT CONTENT CONTENT :D";
}

#function theme_is_home ( ) 
# yep. it's the homepage
## WdG: 23-DEC-2013
function theme_is_home ( )
{
	return true;
}

#function theme_get_dynamic_sidebar_data ( ) 
# return a empty array couse we won't load a other menu
## WdG: 23-DEC-2013
function theme_get_dynamic_sidebar_data ( )
{
	return array(null,null);
}

#function is_home ( ) 
# yep. it's the homepage
## WdG: 23-DEC-2013
function is_home ( )
{
	return true;
}

#function get_option ( ) 
# get some options ;)
## WdG: 23-DEC-2013
function get_option ( $option )
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
function theme_get_menu ( $nav )
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
function wp_list_pages ( )
{
	//MENU...
}

#function theme_get_option ( ) 
# get some options of a 'theme'
## WdG: 23-DEC-2013
function theme_get_option ( $sidebar )
{
	switch ($sidebar) 
	{
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
			return 'ERROR {'.$sidebar.'}';
		break;
	}
}

#function wp_head ( ) 
# load extra meta tags and scripts.
## WdG: 23-DEC-2013
function wp_head ( )
{
	#ADDIONAL THINGS
	echo "<style type=\"text/css\">@import url('".THEMEDIR."style.css');</style>";
}

#function body_class ( ) 
# Class from the body
## WdG: 23-DEC-2013
function body_class ( )
{
	echo "WDGWVCms";
}

#function remove_action ( ) 
# return null, we remove nothing
## WdG: 23-DEC-2013
function remove_action ( $s1=null, $s2=null, $s3=null )
{
	return null;
}

#function get_post_format ( ) 
# ignore this.
## WdG: 23-DEC-2013
function get_post_format ( )
{
	return null;
}

#function get_template_part ( ) 
# ignore this.
## WdG: 23-DEC-2013
function get_template_part ( $s1=null, $s2=null)
{
	//get_template_part('content', 'page');
	if ( $s1 == 'content' /* && $s2 == 'page' */ )
	{
		echo the_content();
	}
	else
	{
		return null;
	}
}

#function have_posts ( ) 
# Yup. we've got 1 post :D
## WdG: 23-DEC-2013
function have_posts ( )
{
	if ( !defined ( 'WP_POST_CONTENT' ) )
	{
		if ( !defined ( 'WP_POST_MADE' ) )
		{
			define ( 'WP_POST_MADE', true );
			return true;
		}
		else
		{
			if ( !defined ( 'WP_POST_CONTENT' ) )
			{
				define ( 'WP_POST_CONTENT', true );
				return true;
			}
		}
	}
	else
	{
		return false;
	}
}

#function is_singular ( ) 
# Nope.
## WdG: 23-DEC-2013
function is_singular ( )
{
	return false;
}

#function wp_title ( ) 
# Load the title
## WdG: 23-DEC-2013
function wp_title ( )
{
	echo "WDGWV CMS v3";
}

#function language_attrubutes ( ) 
# return true :D
## WdG: 23-DEC-2013
function language_attributes ( )
{
	return true;
}

#function theme_page_navigation ( ) 
# NAVIGATION!!!
## WdG: 23-DEC-2013
function theme_page_navigation ( $s1=null )
{
	//echo "?? $s1 ?? ";
	return null;
}

#function do_shortcode ( itm ) 
# return ( itm )
## WdG: 23-DEC-2013
function do_shortcode ( $item = null )
{
	return $item;
}

#function bloginfo ( info ) 
# returns some bloginfo ( info )
## WdG: 23-DEC-2013
function bloginfo ( $info )
{
	switch ($info) {
		case 'charset':
			echo "NL-nl";
		break;
		
		case 'name':
			echo "WDGWV CMS v3";
		break;

		case 'description':
			echo "testing!";
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
function get_sidebar ( $what = 'sidebar' )
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
			exit('ERROR {'.$what.'}');
		break;
	}
}

#function __ ( s1, s2=null ) 
# we do not translate
## WdG: 23-DEC-2013
function __( $s1, $s2=null )
{
	return $s1;
}

#function _e ( s1, s2=null ) 
# is the same as __( s1, s2=null )
## WdG: 30-DEC-2013
function _e ( $s1, $s2=null )
{
	return __( $s1, $s2 );
}

#function get_header ( ) 
# load the header
## WdG: 23-DEC-2013
function get_header ( )
{
	include THEMEDIR . 'header.php';
}

#function wp_footer ( ) 
# We ain't wordpress!
## WdG: 23-DEC-2013
function wp_footer ( )
{
	echo "WDGWV CMS";
}

#function get_footer ( ) 
# load the footer
## WdG: 23-DEC-2013
function get_footer ( )
{
	include THEMEDIR . 'footer.php';
}

#function isWordpress ( ) 
# is this a wordpress theme?!
## WdG: 23-DEC-2013
function isWordpress ( $WPTHEME )
{
	return (
			file_exists ( 'themes/' . $WPTHEME . '/index.php' ) &&
			file_exists ( 'themes/' . $WPTHEME . '/header.php' ) &&
			file_exists ( 'themes/' . $WPTHEME . '/footer.php' )// &&
			//file_exists ( 'themes/' . $WPTHEME . '/sidebar-top.php' ) &&
			//file_exists ( 'themes/' . $WPTHEME . '/sidebar-header.php' ) &&
			//file_exists ( 'themes/' . $WPTHEME . '/sidebar-footer.php' ) &&
			//file_exists ( 'themes/' . $WPTHEME . '/sidebar-bottom.php' )
		   ) ? true : false;
}

#function wordpress ( ) 
# load the wordpress theme
## WdG: 23-DEC-2013
function wordpress($WPTHEME)
{
	define('RWMB_DIR', 'themes/' . $WPTHEME);
	define('WPTHEME',  $WPTHEME);
	define('THEMEDIR', 'themes/' . $WPTHEME . '/');
	define('THEME_NS', THEMEDIR);
	define('TEMPLATEPATH', THEMEDIR);

	if ( file_exists ( 'themes/' . $WPTHEME . '/index.php' ) )
		include 'themes/' . $WPTHEME . '/index.php';
	else
		echo "MISSING THEME {$WPTHEME}!";
	
}

#function previous_posts_link ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function previous_posts_link ( )
{
	return '/';
}

#function next_posts_link ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function next_posts_link ( )
{
	return '/';
}

#function is_search ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function is_search ( )
{
	return false;
}

#function the_tags ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function the_tags ( )
{
	return null;
} 

#function is_single ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function is_single ( )
{
	return null;
} 

#function is_page ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function is_page ( )
{
	return null;
}

#function is_category ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function is_category ( ) 
{
	return null;
}

#function is_month ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function is_month ( )
{
	return null;
}

#function the_ID ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function the_ID ( )
{
	return 0;
}

#function comments_number ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function comments_number ( )
{
	return 0;
}

#function the_permalink ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function the_permalink ( )
{
	return null;
}

#function the_category ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function the_category ( )
{
	return null;
}

#function the_author_link ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function the_author_link ( )
{
	return null;
}

#function the_time ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function the_time ( )
{
	return null; //TIME
} 

#function the_title ( ) 
# is wp_title();
## WdG: 30-DEC-2013
function the_title ( )
{
	return wp_title();
}

#function comments_link ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function comments_link ( )
{
	return NULL;
}

#function readintro ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function readintro ( )
{
	//SLOGAN..
	echo "SLOGAN";
}

#function is_tag ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function is_tag ( )
{
	return false;
} 

#function wp_get_archives ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function wp_get_archives ( )
{
	return null;
}

#function wp_list_cats ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function wp_list_cats ( )
{
	return null;
}

#function get_links ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function get_links ( )
{
	return null;
}

#function wp_loginout ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function wp_loginout ( )
{
	return null;
}

#function wp_meta ( ) 
# null returning we don't support it
## WdG: 30-DEC-2013
function wp_meta ( )
{
	return null;
}

#function theme_print_sidebar ( ) 
# ignore all things D:
## WdG: 23-DEC-2013
function theme_print_sidebar ( $what )
{
	switch ( $what ) {
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
function theme_has_layout_part ( $part )
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
function get_num_queries ( )
{
	return 0;
}

#function timer_stop ( ) 
# where is the timer started?
## WdG: 23-DEC-2013
function timer_stop ( )
{
	return 0;
}
?>