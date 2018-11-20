/*--- Avanquest WebEasy Motion Script ---*/


function OnWeLoad()
{

	Img3={max:1,pos:0};
	Img3[0]=new Image();Img3[0].src='mijn_wereld002002.gif';
	Img3[1]=new Image();Img3[1].src='mijn_wereld002003.gif';
	Img4={max:1,pos:0};
	Img4[0]=new Image();Img4[0].src='mijn_wereld002004.gif';
	Img4[1]=new Image();Img4[1].src='mijn_wereld002005.gif';
	Img6={max:1,pos:0};
	Img6[0]=new Image();Img6[0].src='mijn_wereld002006.gif';
	Img6[1]=new Image();Img6[1].src='mijn_wereld002007.gif';	IDP.my=(window.parent.frames.length && parent.MyFrm)?parent.MyFrm:window;
	IDP[1]=(V5)?'document.getElementById(\'e3\').src':(IE)?'e3.src':'document.e3.src';
	IDP[2]=(V5)?'document.getElementById(\'e4\').src':(IE)?'e4.src':'document.e4.src';
	IDP[3]=(V5)?'document.getElementById(\'e6\').src':(IE)?'e6.src':'document.e6.src';
	isOvr=1;
}


/*--- EndOfFile ---*/
