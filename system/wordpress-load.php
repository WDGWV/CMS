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

	$WPTHEME = 'wordpress-wdgwv-demo';
	define('RWMB_DIR', 'themes/' . $WPTHEME);

	if ( file_exists ( 'themes/' . $WPTHEME . '/functions/custom_functions.php' ) )
		include 'themes/' . $WPTHEME . '/functions/custom_functions.php';
	
	if ( file_exists ( 'themes/' . $WPTHEME . '/functions.php' ) )
		include 'themes/' . $WPTHEME . '/functions.php';

	if ( file_exists ( 'themes/' . $WPTHEME . '/library/admins.php' ) )
		include 'themes/' . $WPTHEME . '/library/admins.php';

	if ( file_exists ( 'themes/' . $WPTHEME . '/library/defaults.php' ) )
		include 'themes/' . $WPTHEME . '/library/defaults.php';

	if ( file_exists ( 'themes/' . $WPTHEME . '/library/misc.php' ) )
		include 'themes/' . $WPTHEME . '/library/misc.php';

	if ( file_exists ( 'themes/' . $WPTHEME . '/library/navigation.php' ) )
		include 'themes/' . $WPTHEME . '/library/navigation.php';

	if ( file_exists ( 'themes/' . $WPTHEME . '/library/options.php' ) )
		include 'themes/' . $WPTHEME . '/library/options.php';

	if ( file_exists ( 'themes/' . $WPTHEME . '/library/shortcodes.php' ) )
		include 'themes/' . $WPTHEME . '/library/shortcodes.php';

	if ( file_exists ( 'themes/' . $WPTHEME . '/library/sidebars.php' ) )
		include 'themes/' . $WPTHEME . '/library/sidebars.php';

	if ( file_exists ( 'themes/' . $WPTHEME . '/library/smiley.php' ) )
		include 'themes/' . $WPTHEME . '/library/smiley.php';

	if ( file_exists ( 'themes/' . $WPTHEME . '/library/widgets.php' ) )
		include 'themes/' . $WPTHEME . '/library/widgets.php';

	if ( file_exists ( 'themes/' . $WPTHEME . '/library/wrappers.php' ) )
		include 'themes/' . $WPTHEME . '/library/wrappers.php';

	include 'themes/'.$WPTHEME.'/home.php';

?>