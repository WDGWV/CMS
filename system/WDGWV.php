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

#function WDGWV_getTheme ( ) 
# get the current theme.
## WdG: 01-JAN-2014
function WDGWV_getTheme ( )
{
	return 'corporate';
}

#function WDGWV_getPagename ( ) 
# get the current page name.
## WdG: 01-JAN-2014
function WDGWV_getPagename ( )
{
	return 'Home';
}

#function WDGWV_getVersion ( ) 
# get WDGWV version :)
## WdG: 01-JAN-2014
function WDGWV_getVersion ( )
{
	return file_get_contents('./config/.installed');	
}

#function WDGWV_getTitle ( ) 
# get the current website title.
## WdG: 01-JAN-2014
function WDGWV_getTitle ( )
{
	return 'WDGWV CMS v'.WDGWV_getVersion();	
}

#function WDGWV_getDescription ( ) 
# get the current website description.
## WdG: 01-JAN-2014
function WDGWV_getDescription ( )
{
	return 'testing! the new WDGWV CMS!!!';
}

#function WDGWV_getSlogan ( ) 
# get the current website slogan (if needed).
## WdG: 01-JAN-2014
function WDGWV_getSlogan ( )
{
	return 'This is the page of the new WDGWV cms Version ' . WDGWV_getVersion() . '!';
}

#function WDGWV_getContent ( ) 
# get the current content for the page.
## WdG: 13-JAN-2014
function WDGWV_getContent( )
{
	//WDGWV_Parser
	return '
Here you\'ll find some statics about this project, for now al the pages are static, and not yet changeable.<br />
Come back later ;)<br /><br />
<table><tr><td><script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_factoids_stats.js"></script></td><td>
<script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_cocomo.js"></script></tr></table>
<script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_users.js?style=blue"></script>
';
}

#function WDGWV_getFooter ( ) 
# get the current website footer (userAjustable).
## WdG: 01-JAN-2014
function WDGWV_getFooter ( )
{
	return '<img src=\'http://by.wdgp.nl/logo\' width=\'30px\' height=\'0px\'>&copy; yoursite.';
}

function WDGWV_page_exists ( $page )
{
	if ( /*in database */ false )
		return true;
	else
		return false;
}

function WDGWV_add_page ( $page, $content )
{
	//TODO: ADD TO DATABASE
}

function WDGWV_add_replacer ( $what, $with )
{
	// For mod sys.
	// And handle it while parsing page...
	// TODO: See above...
}

function WDGWV_add_admin ( $page, $content )
{
	//TODO: ADD TO DATABASE W/Prefix
}
?>