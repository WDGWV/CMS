/*--- Avanquest WebEasy Motion Script ---*/


function OnWeLoad()
{

	Img4={max:1,pos:0};
	Img4[0]=new Image();Img4[0].src='mijn_wereld003002.gif';
	Img4[1]=new Image();Img4[1].src='mijn_wereld003003.gif';
	Img5={max:1,pos:0};
	Img5[0]=new Image();Img5[0].src='mijn_wereld003004.gif';
	Img5[1]=new Image();Img5[1].src='mijn_wereld003005.gif';
	Img6={max:1,pos:0};
	Img6[0]=new Image();Img6[0].src='mijn_wereld003006.gif';
	Img6[1]=new Image();Img6[1].src='mijn_wereld003007.gif';	IDP.my=(window.parent.frames.length && parent.MyFrm)?parent.MyFrm:window;
	IDP[1]=(V5)?'document.getElementById(\'e4\').src':(IE)?'e4.src':'document.e4.src';
	IDP[2]=(V5)?'document.getElementById(\'e5\').src':(IE)?'e5.src':'document.e5.src';
	IDP[3]=(V5)?'document.getElementById(\'e6\').src':(IE)?'e6.src':'document.e6.src';
	isOvr=1;
}


/*--- EndOfFile ---*/
