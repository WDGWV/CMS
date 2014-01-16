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

#function myfunction()
# Description
## WdG: DD MMM YYYY

#function mod_getConfig ( mod )
# Fetch the config and return it as array
  # Example usage: 
  	/*
  		$myConfig = mod_getConfig('MyAwesomeModule');
  		if ( !is_array ( $myConfig ) )
  			die('Unable to load the config file!');
  	*/	
## WdG: 16-JAN-2014
function mod_getConfig ( $mod )
{
	$file1 = sprintf("modules/%s/settings.php", 		$mod); // Only some settings
	$file2 = sprintf("modules/%s/settings.cnf", 		$mod); // Only Settings file (ini file)

	if ( file_exists ( $file1 ) )
	{
		//Parse the ini and return the config as a array.
		$config = load_config_from_ini($file1);
	}
	elseif ( file_exists ( $file2 ) )
	{
		$config = parse_config_file($file2);
	}
	else
	{
		$config = "Unable to see config file, Database support is not yet included";
		#LATER-TODO: Add Database support for later.
	}
}

#function mod_admin ( mod )
# Load the administration/settings file for the module
## WdG: 16-JAN-2014
function mod_admin ( $mod )
{
	$file1 = sprintf("modules/%s/admin.php", 			$mod); // Standard Admin
	$file2 = sprintf("modules/%s/administration.php", 	$mod); // Standard Admin
	$file3 = sprintf("modules/%s/settings.php", 		$mod); // Only some settings
	$file4 = sprintf("modules/%s/settings.cnf", 		$mod); // Only Settings file (ini file)


	if ( file_exists ( $file4 ) ) // Only a ini file
	{
		// Parse the ini file, 
		// and make a edit settings page
		mod_writeAdmin ( $mod, $file4 );
	}

	elseif ( file_exists (  $file3 ) ) // Settings file... see example
	{
		// Only Some settings, On/Off Toggle...
		/* Example:
			setting1=true
			setting2=This can be a really long string, but dont use enters in it! (use instead [ENT] )
			headline=This is a Multiline Test...[ENT]and it works well!
			footer=hello, this is the footer
			licencekey=X123W-WDGYD-WDGWV-WPOEN-WODBT-20394-QAZWS
		*/
		mod_seeSettings ( $mod, $file3 );
	}

	elseif ( file_exists ( $file2 ) ) // include the config file.
	{
		// it's a self written config, so load it...

		//mod_admin_header();
			include $file2;
		//mod_admin_footer();
	}

	elseif ( file_exists ( $file1 ) ) // include the config file
	{
		// i'ts a self written config, so load it....

		//mod_admin_header();
			include $file1;
		//mod_admin_footer();
	}

	else // No settings are found.
	{
		// No settings are found.
		mod_Error('No settings...');
	}
}
?>