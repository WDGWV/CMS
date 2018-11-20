/*--- Avanquest WebEasy Motion Script ---*/


function OnWeLoad()
{

	Img4={max:1,pos:0};
	Img4[0]=new Image();Img4[0].src='mijn_wereld004001.gif';
	Img4[1]=new Image();Img4[1].src='mijn_wereld004002.gif';
	Img6={max:1,pos:0};
	Img6[0]=new Image();Img6[0].src='mijn_wereld004003.gif';
	Img6[1]=new Image();Img6[1].src='mijn_wereld004004.gif';
	Img7={max:1,pos:0};
	Img7[0]=new Image();Img7[0].src='mijn_wereld004005.gif';
	Img7[1]=new Image();Img7[1].src='mijn_wereld004006.gif';	IDP.my=(window.parent.frames.length && parent.MyFrm)?parent.MyFrm:window;
	IDP[1]=(V5)?'document.getElementById(\'e4\').src':(IE)?'e4.src':'document.e4.src';
	IDP[2]=(V5)?'document.getElementById(\'e6\').src':(IE)?'e6.src':'document.e6.src';
	IDP[3]=(V5)?'document.getElementById(\'e7\').src':(IE)?'e7.src':'document.e7.src';
	isOvr=1;
}


/*--- EndOfFile ---*/
