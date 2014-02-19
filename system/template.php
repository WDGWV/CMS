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
  
class template
{

 	private $config;
 	private $parameters;
 	private $uniid;

   	public function __construct( ) 
   	{
		$this->uniid = uniqid();
   	}

 	public function __destruct( ) 
 	{

 	}

 	public function setTemplate($templateFile='default')
 	{
  		$this->config=array();
 		$this->parameters=array();

 		if(file_exists("./template/" . $templateFile . "/theme.html"))
 			$this->config['theme'] = $templateFile;
 	}

 	public function setParameterStart($s1="\{WDGWV:", $s2="\}")
 	{
 		$this->config['parameter'] = array($s1, $s2);
 	}

 	public function setParameter($parameter, $replaceWith)
	{
		$this->parameters[]=array($parameter, $replaceWith);
 	}

 	private function _parse()
 	{
		if(!isset($this->config['theme']))
			$this->config['theme'] = 'default';

 		$template = file_get_contents("./template/" . $this->config['theme'] . "/theme.html");

 		$template = preg_replace(
 									"/\{if (.*)\}/", 
 								 	"<?php if (\\1) { ?>",
 								 	$template
 								);

 		$template = preg_replace(
 									"/\{\else\}/",
 									"<?php }else{ ?>",
 									$template
 								);

 		$template = preg_replace(
 									"/\{\/if\}/",
 									"<?php } ?>",
 									$template
 								);

 		$template = preg_replace(
 									"/\{elseif (.*)\}/", 
 								 	"<?php elseif (\\1) { ?>",
 								 	$template
 								);


 		$template = preg_replace(
 									"/\{#(.*?)#\}/",
 									"<?php if(function_exists('translate')) { echo translate('\\1'); }else{ echo '\\1'; } ?>",
 									$template
 								);

 		$p0=$this->config['parameter'][0];
 		$p1=$this->config['parameter'][1];

 		for ($i=0; $i<sizeof($this->parameters); $i++)
 		{

	 		$template = preg_replace(
	 								 "/" . 
	 								 	   $p0 .
	 									   $this->parameters[$i][0] . 
	 									   $p1 .
	 							     "/", 

	 							     		$this->parameters[$i][1],

	 							     $template
	 							    );

	 	}

 		$fh = @fopen(".tmp_" . $this->uniid . ".bin",'w');
 		@fwrite($fh, $template);
 		@fclose($fh);

 		if ( !file_exists("_tmp_" . $this->uniid . ".bin") )
 			die('Need read/write actions.');

 		include ".tmp_" . $this->uniid . ".bin";

 		unlink(".tmp_" . $this->uniid . ".bin");
 	}

 	public function display($what='site')
 	{
 		if(!isset($this->config['parameter']))
 			$this->setParameterStart();

 		$this->_parse();
 	}
}
?>