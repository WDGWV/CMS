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

function isBlogger ( $theme )
{
	return ( file_exists ( 'themes/' . $theme . '/main.xml' ) ) ? true : false;
}

function bloggerLoop ( $matches )
{
/*
    <b:loop values='data:links' var='link'>
        <b:if cond='data:link.isCurrentPage'>
            <li><a expr:href='data:link.href' class='active'><data:link.title/></a></li>
        <b:else/>
            <li><a expr:href='data:link.href'><data:link.title/></a></li>
        </b:if>
    </b:loop>
*/
	if($matches[1] == 'links')
	{
		$matches[3] = preg_replace(
									"#a expr:href#", 
									"a href",
									$matches[3]
								  );
		$matches[3] = preg_replace(
									"#data:link\.target#", 
									"http://www.wdgwv.com", 
									$matches[3]
								   );
		$matches[3] = preg_replace("#<data:link\.name/>#", 
									"WDGWV",
									$matches[3]
								  );

		return $matches[3];
	}

//    print_r($matches);
}

function bloggerInclude ( $matches )
{

}

function bloggerLoad ( $matches )
{

}

function bloggerParse ( $theme, $name )
{
	$theme = preg_replace_callback(
									"#<b:loop values='data:(.*)' var='(.*)'>(.*?)</b:loop>#",
									"bloggerLoop",
									$theme
								  );

	#$theme = preg_replace_callback(
	#								"#<b:includable id='(.*)' var='(.*)'>(.*)</b:includable>#",
	#								"bloggerInclude",
	#								$theme
	#							  );

	#$theme = preg_replace_callback(
	#								"#<b:include name=\"(.*)\"/>#",
	#								"bloggerLoad",
	#								$theme
	#							  );
	
	$theme = preg_replace(
							"#<data:blog.pageTitle/>#",
							"WDGWV CMS v0.0.1",
							$theme
						 );

	$theme = preg_replace(
							"#<!-- Created by Artisteer v(.*) -->#",
							null,
							$theme
						 );

	$theme = preg_replace(
							"#<b:skin><\!\[CDATA\[(.*)\]\]></b:skin>#si",
							"<style type=\"text/css\">\\1</style>",
							$theme
						 );

	$theme = preg_replace(
							"#data:blog\.homepageUrl#",
							"./",
							$theme
						 );

	$theme = preg_replace(
							"#<b:include name=\"title\"/>#",
							"WDGWV Blog",
							$theme
						 );

	$theme = preg_replace(
							"#<b:include name=\"description\"/>#",
							"WDGWV Products blog",
							$theme
						 );

	$theme = preg_replace(
						 	"#url\('images/(.*)\.(.*)'\)#",
						 	"url('themes/" . $name . "/images/\\1.\\2')",
						 	$theme
						 );
	    
	return $theme;
}

function blogger ( $theme )
{
	$file = file_get_contents('themes/' . $theme . '/main.xml');
	echo bloggerParse($file, $theme);
}


?>