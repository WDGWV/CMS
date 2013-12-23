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
## WdG: 5 DEC 2013
function the_post ( )
{
	echo "CONTENT CONTENT CONTENT CONTENT :D";
}

#function theme_is_home ( ) 
# yep. it's the homepage
## WdG: 5 DEC 2013
function theme_is_home ( )
{
	return true;
}

#function theme_get_dynamic_sidebar_data ( ) 
# return a empty array couse we won't load a other menu
## WdG: 5 DEC 2013
function theme_get_dynamic_sidebar_data ( )
{
	return array(null,null);
}

#function is_home ( ) 
# yep. it's the homepage
## WdG: 5 DEC 2013
function is_home ( )
{
	return true;
}

#function get_option ( ) 
# get some options ;)
## WdG: 5 DEC 2013
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
## WdG: 5 DEC 2013
function theme_get_menu ( $nav )
{
	echo "<div class=\"art-layout-cell art-layout-cell-size1\">
	<div class=\"art-hmenu-extra1\">
		MENU
	</div>
</div>";
}

#function theme_get_option ( ) 
# get some options of a 'theme'
## WdG: 5 DEC 2013
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
## WdG: 5 DEC 2013
function wp_head ( )
{
	#ADDIONAL THINGS
	echo "<style type=\"text/css\">@import url('".THEMEDIR."style.css');</style>";
}

#function body_class ( ) 
# Class from the body
## WdG: 5 DEC 2013
function body_class ( )
{
	echo "WDGWVCms";
}

#function remove_action ( ) 
# return null, we remove nothing
## WdG: 5 DEC 2013
function remove_action ( $s1=null, $s2=null, $s3=null )
{
	return null;
}

#function get_post_format ( ) 
# ignore this.
## WdG: 5 DEC 2013
function get_post_format ( )
{
	return null;
}

#function get_template_part ( ) 
# ignore this.
## WdG: 5 DEC 2013
function get_template_part ( )
{
	return null;
}

#function have_posts ( ) 
# Yup. we've got 1 post :D
## WdG: 5 DEC 2013
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
## WdG: 5 DEC 2013
function is_singular ( )
{
	return false;
}

#function wp_title ( ) 
# Load the title
## WdG: 5 DEC 2013
function wp_title ( )
{
	echo "WDGWV CMS v3";
}

#function language_attrubutes ( ) 
# return true :D
## WdG: 5 DEC 2013
function language_attributes ( )
{
	return true;
}

#function theme_page_navigation ( ) 
# NAVIGATION!!!
## WdG: 5 DEC 2013
function theme_page_navigation ( $s1=null )
{
	echo "?? $s1 ?? ";
}

#function do_shortcode ( itm ) 
# return ( itm )
## WdG: 5 DEC 2013
function do_shortcode ( $item = null )
{
	return $item;
}

#function bloginfo ( info ) 
# returns some bloginfo ( info )
## WdG: 5 DEC 2013
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

		default:
			# code...
		break;
	}
}

#function get_sidebar ( ) 
# include some files from the sidebar
## WdG: 5 DEC 2013
function get_sidebar ( $what )
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

		case 'nav':
			# code...
		break;

		default:
			exit('ERROR {'.$what.'}');
		break;
	}
}

#function __ ( ) 
# we do not translate
## WdG: 5 DEC 2013
function __( $s1, $s2=null )
{
	return $s1;
}

#function get_header ( ) 
# load the header
## WdG: 5 DEC 2013
function get_header ( )
{
	include THEMEDIR . 'header.php';
}

#function wp_footer ( ) 
# We ain't wordpress!
## WdG: 5 DEC 2013
function wp_footer ( )
{
	echo "WDGWV CMS";
}

#function get_footer ( ) 
# load the footer
## WdG: 5 DEC 2013
function get_footer ( )
{
	include THEMEDIR . 'footer.php';
}

#function isWordpress ( ) 
# is this a wordpress theme?!
## WdG: 5 DEC 2013
function isWordpress ( $WPTHEME )
{
	return (
			file_exists ( 'themes/' . $WPTHEME . '/index.php' ) &&
			file_exists ( 'themes/' . $WPTHEME . '/header.php' ) &&
			file_exists ( 'themes/' . $WPTHEME . '/footer.php' ) &&
			file_exists ( 'themes/' . $WPTHEME . '/sidebar-top.php' ) &&
			file_exists ( 'themes/' . $WPTHEME . '/sidebar-header.php' ) &&
			file_exists ( 'themes/' . $WPTHEME . '/sidebar-footer.php' ) &&
			file_exists ( 'themes/' . $WPTHEME . '/sidebar-bottom.php' )
		   ) ? true : false;
}

#function wordpress ( ) 
# load the wordpress theme
## WdG: 5 DEC 2013
function wordpress($WPTHEME)
{
	define('RWMB_DIR', 'themes/' . $WPTHEME);
	define('WPTHEME',  $WPTHEME);
	define('THEMEDIR', 'themes/' . $WPTHEME . '/');
	define('THEME_NS', THEMEDIR);

	if ( file_exists ( 'themes/' . $WPTHEME . '/index.php' ) )
		include 'themes/' . $WPTHEME . '/index.php';
	else
		echo "MISSING THEME {$WPTHEME}!";
	
}

#function theme_print_sidebar ( ) 
# ignore all things D:
## WdG: 5 DEC 2013
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
## WdG: 5 DEC 2013
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
## WdG: 5 DEC 2013
function get_num_queries ( )
{
	return 0;
}

#function timer_stop ( ) 
# where is the timer started?
## WdG: 5 DEC 2013
function timer_stop ( )
{
	return 0;
}
?>