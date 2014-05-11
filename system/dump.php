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

function dump($orgvar = NULL, $depth = 0, $firstcall = true, $objdepth = 0)
{
   // first check if the variable has already been parsed
    $keyvar = 'the_elegant_dump_recursion_protection_scheme';
	
	//Anti recursie
    if (is_array($orgvar) && isset($orgvar[$keyvar])) 
    {
        // the passed variable is already being parsed!
        $real_var=&$orgvar[$keyvar];
        $type=gettype($real_var);
		$recursed = 'Recursion!';
    }
    else
    {
      if($objdepth > 3)
      {
        $recursed = 'Copy of Object printed 3 times.';
      }
      else
      {
        $recursed = false;
      }
    }
		
	
	$var=array($keyvar=>$orgvar);
	$var=$var[$keyvar];
	
	
	// we will insert an elegant parser-stopper
		
	$type = gettype($var);
	
	$c['bg'] = 		  ini_get('highlight.bg');
	$c['comment'] = ini_get('highlight.comment');
	$c['default'] = ini_get('highlight.default');
	$c['html'] = 	  ini_get('highlight.html');
	$c['keyword'] = ini_get('highlight.keyword');
	$c['string'] = 	ini_get('highlight.string');
	
	$sp = @implode('', warray_fill(0, $depth, '&nbsp;&nbsp;&nbsp;&nbsp;'));
	
	if(is_resource($var) || $type == 'resource') 
	{
		if(get_resource_type($var) == 'stream') 
		{
			$streamData = stream_get_meta_data($var);
			$ret = '<span style="color: '.$c['keyword'].';">Recource: </span><strong style="color: '.$c['html'].';">Stream</strong> '.dump($streamData, $depth+1, false);
		}
		else
		{
			$ret = '<span style="color: '.$c['keyword'].';">Recource: </span><strong style="color: '.$c['html'].';">' . ucfirst(get_resource_type($var)).'</strong>';
	  }
	}
	elseif (is_array($var) || $type == 'array')
	{
		$depth++;
		$i = count($var);
		
		$uniqueId = rand();
				
		if($i && !$recursed) 
		{
		
			if(!$firstcall && $i > 2) 
			{
				$default_state = 'none';
				$dots = '...';
			}
			else 
			{
				$default_state = 'inline';
				$dots = '';
			}
				
			$ret = '<a href="#" style="color: '.$c['default'].'; text-decoration: none;" onclick="arr = document.getElementById(\'arr_'.$uniqueId.'\'); dots = document.getElementById(\'dots_'.$uniqueId.'\'); if(arr.style.display == \'none\') {arr.style.display = \'inline\'; dots.innerHTML = \'\'} else {arr.style.display = \'none\'; dots.innerHTML = \'...\'} this.blur(); return false;">array</a> <span style="color: '.$c['html'].';">(</span>';
			$ret .= '<code style="display: '.$default_state.';" id="arr_'.$uniqueId.'"><br>';
			$sp = $sp . '&nbsp;&nbsp;&nbsp;&nbsp;';
			
			
			foreach($var as $k => &$v) 
			{
				$ret .= $sp . '<span style="color: '.$c['default'].';">[</span>'.dump($k, false, false).'<span style="color: '.$c['default'].';">] => </span>' . dump($v, $depth, false);
				$ret .= ($i-- > 1 ? '<span style="color: '.$c['html'].';">,</span>' : '').'<br>';			
			}
			$depth--;
			$sp = @implode('', warray_fill(0, $depth, '&nbsp;&nbsp;&nbsp;&nbsp;'));
	
			$ret .= $sp . '</code><span style="color: '.$c['html'].';" id="dots_'.$uniqueId.'" >'.$dots.'</span><span style="color: '.$c['html'].';">)</span>';
		}
		else
		{
		$ret = '<span style="color: '.$c['default'].';">array </span> <span style="color: '.$c['html'].';">( '.($recursed ? '<strong style="color: red;">'.$recursed.'</strong>' : '' ).' )</span>';
		}
	}
	elseif (is_bool($var) || $type == 'bool') 
	{
		$ret = '<span style="color: '.$c['keyword'].';">' . ($var ? 'true' : 'false') . '</span>';
	}
	elseif (is_float($var) || is_int($var) || is_numeric($var) || $type == 'double' || $type == 'integer') 
	{
		$ret = '<span style="color: '.$c['string'].';">' . $var . '</span>';
	}
	elseif (is_object($var) || $type == 'object') 
	{
	
		$vars = get_object_vars($var);
		$methods = get_class_methods($var);
		
		// Bouw stamboom op
		$tmp = $var;
		$parents = array();
		while($tmp = get_parent_class($tmp)) 
		{
			$parents[] = $tmp;
		}
		
		$tree = implode(' -> ', array_merge($parents, array(get_class($var))));

		$depth++;
		$i = count($vars) + count($methods);
		
		$uniqueId = rand();
		
		if($i && !$recursed) 
		{
			$ret = '<a href="#" style="color: '.$c['keyword'].'; text-decoration: none;" onclick="obj = document.getElementById(\'obj_'.$uniqueId.'\'); dots = document.getElementById(\'dots_'.$uniqueId.'\'); if(obj.style.display == \'none\') {obj.style.display = \'inline\'; dots.innerHTML = \'\'} else {obj.style.display = \'none\'; dots.innerHTML = \'...\'} this.blur(); return false;">Object: <span style="color: '.$c['default'].';">'. $tree . '</span></a> <span style="color: '.$c['html'].';">{</span>';
				
			if(!$firstcall && $i > 2) 
			{
				$default_state = 'none';
				$dots = '...';
			}
			else
			{
				$default_state = 'inline';
				$dots = '';
			}
			
			$ret .= '<code style="display: '.$default_state.';" id="obj_'.$uniqueId.'"><br>';
			$sp = $sp . '&nbsp;&nbsp;&nbsp;&nbsp;';
			
			$objdepth++;
			
			foreach($vars as $k => &$v)
			{
				$ret .= $sp . '<span style="color: '.$c['default'].';">[</span>'.dump($k, false, false).'<span style="color: '.$c['default'].';">] => </span>' . dump($v, $depth, false, $objdepth);
				$ret .= ($i-- > 1 ? '<span style="color: '.$c['html'].';">,</span>' : '').'<br>';	
			}
			
			foreach($methods as $k => $v)
			{
				$ret .= $sp . '<span style="color: '.$c['default'].';">function</span> <span style="color: '.$c['html'].';">' . $v .'()</span>';
				$ret .= ($i-- > 1 ? '<span style="color: '.$c['html'].';">,</span>' : '').'<br>';			
			}
			$depth--;
			$sp = @implode('', warray_fill(0, $depth, '&nbsp;&nbsp;&nbsp;&nbsp;'));
	
			$ret .= $sp . '</code><span id="dots_'.$uniqueId.'" style="color: '.$c['html'].'">'.$dots.'</span><span style="color: '.$c['html'].';">}</span>';
		}
		else
		{
			$ret = '<span style="color: '.$c['keyword'].';">Object: </span><span style="color: '.$c['default'].';">'. $tree . '</span> <span style="color: '.$c['html'].';">{ '.($recursed ? '<strong style="color: red;">'.$recursed.'</strong>' : '' ).' }</span>';
		}
	

	}
	elseif (is_string($var) || $type == 'string')
	{
		$ret = '<span style="color: '.$c['string'].';">\'' . $var . '\'</span>';
	}
	elseif (is_null($var) || $type == 'NULL') 
	{
		$ret = '<span style="color: '.$c['keyword'].';">NULL</span>';
	}
	else
	{
		$ret = '<strong style="color: red;">Unknown: </strong><span style="color: '.$c['html'].';">' . gettype($var) . '</span>';
	}
	
	if($firstcall) 
	{
		return '<code style="display: block; background-color: '.$c['bg'].'; border: 1px solid black; padding: 5px; margin: 5px;">'.$ret.'</code>';
	}
	else
	{
		return $ret;
  }
}

function warray_fill($iStart, $iLen, $vValue) 
{
    $aResult = array();
    for ($iCount = $iStart; $iCount < $iLen + $iStart; $iCount++) 
    {
        $aResult[$iCount] = $vValue;
    }
    return $aResult;
}
?>