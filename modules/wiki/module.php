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
define('wiki_user', 'auto');

#function check_wiki_tags ( text )
# Check wiki tags/links
## WdG: 10 JAN 2013
function check_wiki_tags ( $texts )
{

}

#function edit_wiki_page ( page, content, user )
# Edit wiki Page
## WdG: 10 JAN 2013
function edit_wiki_page ( $page, $content, $user )
{

}

#function new_wiki_page ( page, content, user, hidden )
# New wiki page
## WdG: 10 JAN 2013
function new_wiki_page ( $page, $content, $user, $hidden = false )
{

}

#function del_wiki_page ( page )
# Delete wiki oage
## WdG: 10 JAN 2013
function del_wiki_page ( $page )
{
	backup_wiki_page ( $page ) ;
}

#function backup_wiki_page ( page )
# Backup current revision.
## WdG: 10 JAN 2013
function backup_wiki_page ( $page )
{
	$now = date("/dmY-His");
	$pag = read_wiki_page ( $page );
	new_wiki_page($page.$now, $pag, wiki_user, true);
}

#function clear_wiki_backups ( )
# Clear all the backups
## WdG: 10 JAN 2013
function clear_wiki_backups ( )
{

}

#function read_wiki_page ( page )
# Get wiki page contents.
## WdG: 10 JAN 2013
function read_wiki_page ( $page )
{
	//123
}
?>