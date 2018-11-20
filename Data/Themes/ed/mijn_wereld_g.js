/*--- Avanquest WebEasy Document Script ---*/

IE=(navigator.appName.indexOf('Microsoft') >= 0);
NS=(navigator.appName.indexOf('Netscape') >= 0);
SF=(navigator.appName.indexOf('Safari') >= 0);
FF=(navigator.userAgent.indexOf('Firefox') >= 0);
OP=(navigator.userAgent.indexOf('Opera') >= 0);
GK=(navigator.userAgent.indexOf('Gecko') >= 0);
V4=(parseInt(navigator.appVersion) >= 4);
if((V5=navigator.appVersion.indexOf('MSIE '))<0) V5=-5;
V5=(parseInt(navigator.appVersion.charAt(V5+5))>=5);
MAC=(navigator.userAgent.indexOf('Mac')!=-1);


IDP={}; IDP[0]=0;
isOvr=0;

function OnWeOver(snd,txc,txv,img,imv,ref,flag)
{	if(!isOvr) return;
	if(!V4) return;
	if(typeof(IDP.my.location.href)!='string') return;
	if(img && imv)
	{	if(flag)
		{	if(ref)
			{	imv.pos=1;
				if(IDP.my.location.href.lastIndexOf(ref) >= 0) imv.pos=imv.max;
				--imv.pos;
			}
			if(++imv.pos > imv.max) imv.pos=(imv.max)?1:0;
			eval(img+'="'+imv[imv.pos].src+'"');
		}else
		{	eval( img+'="'+imv[0].src+'"' );
		}
	}
	if(txc)
	{	img=txv;
		if(flag)
		{	img=document.vlinkColor;
			if(ref && (IDP.my.location.href.lastIndexOf(ref) < 0)) img=document.linkColor;
		}
		eval(txc+'="'+img+'"');
	}
}


/*--- EndOfFile ---*/
