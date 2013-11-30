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


#function isInstalled()
#checks if the system is already installed is, or not.
## WdG: 30 NOV 2013
function isInstalled ( )
{
	if ( file_exists ( 'config/installed' ) )
		return true;
	else
		return false;
}

#function offlineInstall()
#checks if the files are already downloaded is.
## WdG: 30 NOV 2013
function offlineInstall ( ) 
{
	if ( file_exists ( 'install' ) )
		return true;
	else
		return false;
}

#function validatedInstall( file(str) )
#checks if the file is a real WDGWV Setupfile!
## WdG: 30 NOV 2013
function validatedInstall ( $filesString )
{
	$checked = array();

	if ( substr ( $filesString, 0, 15 ) == base64_decode ( "V0RHV1YgU2V0dXBGaWxlCg==" ) )
		$checked[] = true;

	if ( substr ( $filesString, 17, 11 ) == base64_decode ( "V0RHV1YgU2V0dXAK" ) )
		$checked[] = true;

	if ( sizeof ( $checked ) >= 2 )
		return true;
	else
		return false;
}

#function setupWrite ( file, contents )
#write contents down to a specified file.
## WdG: 30 NOV 2013
function setupWrite ( $file, $contents )
{
	$handle = @fopen( $file , 'w' );

	if ( $handle )
	{
		if ( is_array ( $contents ) )
		{
			@ob_start ( );
			print_r ( $contents );
			$contents = ob_get_contents ( );
			@ob_end_clean ( );
		}

		@fwrite($handle, $contents);
		@fclose($handle);
		return true;
	}
	else
	{
		return false;
	}
}

#function parseSetupFile ( files(str) )
#handle the install ;)
## WdG: 30 NOV 2013
function parseSetupFiles ( $filesString )
{
	$setupLog = array();

	if ( validatedInstall ( $filesString ) )
	{
		$filesString = preg_replace("#\r#", null, $filesString);
		$explodeAll  = explode("\n", $filesString);

		for ( $i=0; $i<sizeof($explodeAll); $i++ )
		{
			if ( substr ( $explodeAll[$i], 0, 2 ) == "~~" )
			{
				if ( @mkdir ( substr ( $explodeAll[$i], 2 ) ) )
				{
					$setupLog['info'][] = 'Dir "' . substr ( $explodeAll[$i], 0, 1 ) . '" Created';
				}
				else
				{
					$setupLog['error'][] = 'Dir "' . substr ( $explodeAll[$i], 0, 1 ) . '" not Created';
					echo "Setup Failed, see Error log!";
					setupWrite('setup.log', $setupLog);
					break;
				}
			}
			elseif ( substr ( $explodeAll[$i], 0, 1 ) == "~" && substr ( $explodeAll[$i], 0,2 ) != "~~" )
			{
				// PUT TO DB
				#TODO
			}
			else
			{
				$file  = explode("~", $explodeAll[$i]);
				$file1 = setupWrite ( base64_decode ( $file[0] ), 	 		   base64_decode ( $file[2] ) );
				$file2 = setupWrite ( base64_decode ( $file[0] ) . '.version', base64_decode ( $file[1] ) );

				if ( $file1 && $file2 )
				{
					$setupLog['info'][] = 'File "' . $file[0] . '" Created';
				}
				else
				{
					$setupLog['error'][] = 'File "' . $file[0] . '" not Created';
					echo "Setup Failed, see Error log!";
					setupWrite('setup.log', $setupLog);
				}
			}
		}
	}
	else
	{
		echo "The setupfile seems to be corrupted, the setup cannot continue!";
	}
}

#function beginOfflineInstal()
#begins a offline install.
## WdG: 30 NOV 2013
function beginOfflineInstall ( )
{
	if ( is_readable ( 'install' ) )
	{
		parseSetupFiles ( file_get_contents ( 'install' ) );
	}
}

#function beginInstall()
#begins the "online" install.
## WdG: 30 NOV 2013
function beginInstall ( )
{
	#DOWNLOAD ALL THE FILES.
	#TODO
}

?>