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

/*
<?php get_header(); ?> (inc: header.php)
<?php get_sidebar('top'); ?> (inc: sidebar-header.php)
have_posts() == 1
theme_get_option == false
have_posts() == 1 (NO LOOP!!!)
the_post(); (CONTENT)
<?php get_sidebar('bottom'); ?> (inc: sidebar-bottom.php)
<?php get_footer(); ?> (inc: footer.php)
*/

function theme_get_menu ( $nav )
{
	#?
}

function theme_get_option ( $sidebar )
{
	switch ($sidebar) 
	{
		case 'nav':
			# code...
		break;

		case 'theme_header_clickable':
			return true;
		break;
	
		default:
			# code...
		break;
	}
}

function wp_head ( )
{
	#ADDIONAL THINGS
}

function body_class ( )
{
	echo "WDGWVCms";
}

function remove_action ( $s1=null, $s2=null, $s3=null )
{
	#do nothing.
}

function is_singular ( )
{
	return false;
}

function wp_title ( )
{
	echo "WDGWV CMS v3";
}

function language_attributes ( )
{
	return true;
}

function bloginfo ( $info )
{
	switch ($info) {
		case 'charset':
			echo "NL-nl";
		break;
		
		default:
			# code...
		break;
	}
}

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

		case 'nav':
			# code...
		break;

		default:
			exit('ERROR {'.$what.'}');
		break;
	}
}
function get_header ( )
{
	include THEMEDIR . 'header.php';
}

function isWordpress ( $theme )
{
	return true;
}

function wordpress($WPTHEME)
{
	define('RWMB_DIR', 'themes/' . $WPTHEME);
	define('WPTHEME',  $WPTHEME);
	define('THEMEDIR', 'themes/' . $WPTHEME . '/');

	if ( file_exists ( 'themes/' . $WPTHEME . '/index.php' ) )
		include 'themes/' . $WPTHEME . '/index.php';
	else
		echo "MISSING THEME {$WPTHEME}!";
	
}

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
?>