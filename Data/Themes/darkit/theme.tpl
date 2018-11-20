<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{wdg:title}</title>
<link href="{wdg:load}style.css" rel="stylesheet" type="text/css" />
    <!-- setmeta(); -->
      {wdg:meta}
      {wdg:adblock}
    <!-- !sertmeta(); -->
</head>
<body>
	<!-- header -->
    <div id="logo"><a href="{wdg:url}">{wdg:title}</a></div>
    <div id="header">
    	<div id="left_header"></div>
        <div id="right_header"></div>
  </div>
  <div id="menu">
        	<ul>
				{wdg:hide1=begin}<li><a href="{wdg:url=1}"><span>{wdg:link=1}</span></a></li>{wdg:hide1=end}
				{wdg:hide2=begin}<li><a href="{wdg:url=2}"><span>{wdg:link=2}</span></a></li>{wdg:hide2=end}
				{wdg:hide3=begin}<li><a href="{wdg:url=3}"><span>{wdg:link=3}</span></a></li>{wdg:hide3=end}
				{wdg:hide4=begin}<li><a href="{wdg:url=4}"><span>{wdg:link=4}</span></a></li>{wdg:hide4=end}
				{wdg:hide5=begin}<li><a href="{wdg:url=5}"><span>{wdg:link=5}</span></a></li>{wdg:hide5=end}
				{wdg:hide6=begin}<li><a href="{wdg:url=6}"><span>{wdg:link=6}</span></a></li>{wdg:hide6=end}
				{wdg:hide7=begin}<li><a href="{wdg:url=7}"><span>{wdg:link=7}</span></a></li>{wdg:hide7=end}
				{wdg:hide8=begin}<li><a href="{wdg:url=8}"><span>{wdg:link=8}</span></a></li>{wdg:hide8=end}
				{wdg:hide9=begin}<li><a href="{wdg:url=9}"><span>{wdg:link=9}</span></a></li>{wdg:hide9=end}
				{wdg:hide10=begin}<li><a href="{wdg:url=10}"><span>{wdg:link=10}</span></a></li>{wdg:hide10=end}
          </ul>
      </div>
    <!--end header -->
    <!-- main -->
    <div id="ceontent">
    	<div id="Econt_top">
        	<div id="Econt_top_left"></div>
            <div id="Econt_top_right"></div>
        </div>
      <div id="Econt_body">
       	  <div id="sidebar">
            <div id="sidebar_top"></div>
            <div id="sidebar_body">
            <ul>
            {wdg:menu}
            </ul>
              </div>
                <div id="sidebar_bottom"></div>
          </div>
            <div id="ttext">
            <div id="ttext_top">
            	<div id="ttext_top_left"></div>
                <div id="ttext_top_right"></div>
            </div>
            <div id="ttext_body">
              {wdg:content}
            </div>
                <div id="ttext_bottom">
                	<div id="ttext_bottom_left"></div>
                    <div id="ttext_bottom_right"></div>
                </div>
          </div>
 
      </div>
        <div id="Econt_bottom">
        	<div id="Econt_bottom_left"></div>
            <div id="Econt_bottom_right"></div>
        </div>
    </div>
    <!-- end main -->
    <!-- footer -->
    <div id="footer">
    <div id="left_footer">
      {wdg:copyright=1}
    </div>
    <div id="right_footer">
      {wdg:copyright=2}
    </div>
    </div>
    <!-- end footer -->
</body>
</html>
