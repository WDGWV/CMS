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

// AJAX.JS
// This Code is (c) WDG.P ; Free To use if opensource; non comerical;
// and useable by WDG.P => and all the projects of it.

function ajaxback() {

  var hash=document.location.hash.split("#");
  var hash=hash[1]; // means pagename
  var hash=hash.split("#");
  var hash=hash[1]; // means prev.

  if (typeof(hash) == "undefined") { var hash='wiki'; }

  //LoadAjaxPage("wiki","");
}

function debug(logerror) { 
        if (typeof console != "undefined") { 
            console.log(logerror); 
        } 
} 

function createRequest() {
  try {
    request = new XMLHttpRequest();
  } catch (tryMS) {
    try {
      request = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (otherMS) {
      try {
        request = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (failed) {
        request = null;
      }
    }
  }
  return request;
}


function processAjax(url,target,title) {
  request = createRequest();
  if(request == null) {
    alert("Unable to Create Request");
    return;
  }
  var nocache = new Date();
  // Add the nocache to the url to make sure it gets updated page...
  url = url + '&stopIEcache='+nocache;
  debug(url);
  request.open("GET",url,true);
  request.onreadystatechange = function() {stateChanged(target,title)};
  request.send(null);
}


function stateChanged(field,title) {
  if(request.readyState == 4) {
    if(request.status == 200) {
      detailDiv = document.getElementById(field);
      debug("Page:" + request.responseText);
      detailDiv.innerHTML = request.responseText;
      //document.getElementById('PageName').innerHTML=translate(title);
	  //window.location.hash=title;
    }
  }
}


function LoadAPage(page,main) {
 return LoadAjaxPage(page,main);
}

function LoadAjaxPage(page,main) {
 if ( page.match(main) )
 {
  var page = page.split("/");
  var leng = page.length-1;
  var page = page[leng];

  var pagz = page.split("&");
  var pagz = pagz[0];

  window.location.hash=page;
  
  //document.getElementById('PageName').innerHTML = '<img src=\'data/img/loading.gif\'>' + translate('Loading') + ' ' + translate('Page') + ' "' + translate(pagz) + '" ' + translate('Please') + ' ' + translate('Wait') + '...';
  
  processAjax ( "" + "ajax.php?load=" + page, 'pageInnerContent', pagz);
  
  return false;
 }
 else
 {
   return true; // is an external page
 }
}

function ajaxpage(page)
{
  return LoadAjaxPage('' + page, '');
}

/*
//AJAX PAGE HASH HANDLER?
var hash=document.location.hash.split("#");
var hash=hash[1]; // means pagename
if (typeof(hash) == "undefined") { var hash='home'; }
setTimeout("LoadAjaxPage('"+hash+"','');", 500)
*/