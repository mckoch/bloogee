<? 
/** 
* basic wrapper 
* no extended doc for now.
* @version 0.00f public
* @devstate working stable
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore wrapper
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @filesource
*/
/**
* requirements
*/
require_once("BGCONFIG.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Sample BlooGee Wrapper, adopted from scriptaculous page - </title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <script type="text/javascript" src="lib/prototype.js" type="text/javascript"></script>
  <script type="text/javascript"  src="src/scriptaculous.js" type="text/javascript"></script>
  <script type="text/javascript" src="lib/lightbox.js"></script>
  <SCRIPT type="text/javascript" SRC="<?php print $defaultjs ?>"CHARSET="ISO-8859-1"></SCRIPT>
  <STYLE TYPE="text/css" MEDIA="screen">
  <?php include "BGdefault2.css.php";?>
  </STYLE>
  <link rel="stylesheet" href="lib/lightbox.css" type="text/css" media="screen" />

</head>
<body>
<img src="images/pflanzenlinks2.gif" id="topleftimage">

<div id="detailpane"><a href="#" onclick="Effect.toggle('secondlist','appear'); return false;">
<img src="images/info.gif">notepad</a>
 <ul class="sortabledemo" id="secondlist" >
   <li class="green" id="secondlist_secondlist1">
          <span class="handle"><img src="images/info.gif"></span><h3>Marker 1</h3>
   </li>
   <li class="green" id="secondlist_secondlist2">
     <span class="handle"><img src="images/info.gif"></span><h3>Marker 2</h3>
   </li>
   <li class="green" id="secondlist_secondlist3">
     <span class="handle"><img src="images/info.gif"></span><h3>Marker 3</h3>
   </li>
 </ul>
</div>

<div id="interactonme">
	<script type="text/javascript">
	function loadsec() {
		tmp = $('interactonme');
		new Effect.Highlight(tmp);
		var xo = new Ajax.Updater(
	         'interactonme',        // DIV id (XXX: doesnt work?)
	         'user.php?', // URL
	         {                // options
	         method:'get', evalScripts: 'TRUE'
	             });
			}
	loadsec();
	new Draggable('interactonme',{ghosting: false});

	</script>
</div>
<div id="centerpaneswitch">
<div id="servermonitor" style="display:none;">&nbsp;</div>
<!-- Begin Free-Buttons.org -->
<table align=left cellpadding=0 cellspacing=0 border=0><tr>
<td title='show / hide center pane'><a href="#" onclick="Effect.toggle('centerpane','appear'); return false;" onmouseover='wbe("0o");' onmouseout='wbe("0n");' onmousedown='wbe("0c");'><img src="bgmenufullpage.wbimg/imgn0.gif" name=btn0 width=100 height=15 border=0 alt='show / hide center pane'></a></td></tr><tr>
<td title='show / hide notepad'><a href="#" onclick="Effect.toggle('secondlist','appear'); return false;" onmouseover='wbe("1o");' onmouseout='wbe("1n");' onmousedown='wbe("1c");'><img src="bgmenufullpage.wbimg/imgn1.gif" name=btn1 width=100 height=15 border=0 alt='show / hide notepad'></a></td></tr><tr>
<td title='scroll to marker 1'><a href="#"  onclick="new Effect.ScrollTo('secondlist_secondlist1'); return false;"onmouseover='wbe("2o");' onmouseout='wbe("2n");' onmousedown='wbe("2c");'><img src="bgmenufullpage.wbimg/imgn2.gif" name=btn2 width=100 height=15 border=0 alt='scroll to marker 1'></a></td></tr><tr>
<td title='scroll to marker 2'><a href="#" onclick="new Effect.ScrollTo('secondlist_secondlist2'); return false;"onmouseover='wbe("3o");' onmouseout='wbe("3n");' onmousedown='wbe("3c");'><img src="bgmenufullpage.wbimg/imgn3.gif" name=btn3 width=100 height=15 border=0 alt='scroll to marker 2'></a></td></tr><tr>
<td title='scroll to marker 3'><a href="#" onclick="new Effect.ScrollTo('secondlist_secondlist3'); return false;"onmouseover='wbe("4o");' onmouseout='wbe("4n");' onmousedown='wbe("4c");'><img src="bgmenufullpage.wbimg/imgn4.gif" name=btn4 width=100 height=15 border=0 alt='scroll to marker 3'></a></td></tr><tr>
<td title='open BlooGee command window'><a href="#" onclick="feedbackPopUpForm(); return false" onmouseover='wbe("5o");' onmouseout='wbe("5n");' onmousedown='wbe("5c");'><img src="bgmenufullpage.wbimg/imgn5.gif" name=btn5 width=100 height=15 border=0 alt='open BlooGee command window'></a></td></tr><tr>
<td title='show live server requests'><a href="#" onclick="Effect.toggle('servermonitor','appear'); return false;" onmouseover='wbe("6o");' onmouseout='wbe("6n");' onmousedown='wbe("6c");'><img src="bgmenufullpage.wbimg/imgn6.gif" name=btn6 width=100 height=15 border=0 alt='show live server requests'></a></td></tr><tr>
</tr></table><noscript><a href=http://free-buttons.org>Created by Free-Buttons.org</a></noscript>
<script type="text/javascript" language="JavaScript1.1">
function wbpr(im){var i=new Image();i.src='bgmenufullpage.wbimg/img'+im;return i;}
function wbe(id){x=id.substring(0,id.length-1);document['btn'+x].src=eval('btn'+id+'.src');if(id.indexOf('e')!=-1)document['btn'+x+'e'].src=eval('btn'+id+'e.src');}
btn0n=wbpr('n0.gif');btn0o=wbpr('o0.gif');btn0c=wbpr('c0.gif')
btn1n=wbpr('n1.gif');btn1o=wbpr('o1.gif');btn1c=wbpr('c1.gif')
btn2n=wbpr('n2.gif');btn2o=wbpr('o2.gif');btn2c=wbpr('c2.gif')
btn3n=wbpr('n3.gif');btn3o=wbpr('o3.gif');btn3c=wbpr('c3.gif')
btn4n=wbpr('n4.gif');btn4o=wbpr('o4.gif');btn4c=wbpr('c4.gif')
btn5n=wbpr('n5.gif');btn5o=wbpr('o5.gif');btn5c=wbpr('c5.gif')
btn6n=wbpr('n6.gif');btn6o=wbpr('o6.gif');btn6c=wbpr('c6.gif')
</script>
<!-- End Free-Buttons.org -->
<!--<div id="murphy">&nbsp; </div>-->
</div>

<div id = "centerpane"><a href="#" onclick="Effect.toggle('centerlist','appear'); return false;">
<img src="images/info.gif"> centerblog</a>
	<div id = "centerlist" style="display:visible;">
	<?php
	global $mbo,$a;
		require_once($viewports);
		print listformat($mbo -> relatives,"firstlist","collapsed");
	?>
	</div>
</div>

<div id="firstlist_debug" style="visibility:hidden"></div>
<div id="secondlist_debug" style="visibility:hidden"></div>

 <script type="text/javascript">
 // <![CDATA[
   Sortable.create("firstlist",
     {dropOnEmpty:true,containment:["firstlist","secondlist"],constraint:false, hoverclass:'over',
      onChange:function(){$('firstlist_debug').innerHTML = Sortable.serialize('firstlist') }});
   Sortable.create("secondlist",
     {dropOnEmpty:true,containment:["firstlist","secondlist"],constraint:false, hoverclass:'over',
     onChange:function(){$('secondlist_debug').innerHTML = Sortable.serialize('secondlist') }});

  // ]]>
 </script>
 <script type="text/javascript" language="javascript" charset="utf-8">
 //to body onloadcomplete!
// <![CDATA[
	new Draggable('detailpane',{ghosting: false});
	new Draggable('centerpane',{ghosting: false, revert:false});
	new Draggable('centerpaneswitch',{ghosting: false, revert:false});
	//ticker('murphy.plugin.php?print=1','murphy', 30);
	ticker('servermonitor.plugin.php?print=1','servermonitor', 15);
// ]]>
</script>

<script type="text/javascript">
    Position.Window = {
        //extended prototypes position to return
        //the scrolled window deltas
        getDeltas: function() {
            var deltaX =  window.pageXOffset
                || document.documentElement.scrollLeft
                || document.body.scrollLeft
                || 0;
            var deltaY =  window.pageYOffset
                || document.documentElement.scrollTop
                || document.body.scrollTop
                || 0;
            return [deltaX, deltaY];
        },
        //extended prototypes position to
        //return working window's size, 
        //copied this code from the 
        size: function() {
            var winWidth, winHeight, d=document;
            if (typeof window.innerWidth!='undefined') {
                winWidth = window.innerWidth;
                winHeight = window.innerHeight;
            } else {
                if (d.documentElement && typeof d.documentElement.clientWidth!='undefined' && d.documentElement.clientWidth!=0) {
                    winWidth = d.documentElement.clientWidth
                    winHeight = d.documentElement.clientHeight
                } else {
                    if (d.body && typeof d.body.clientWidth!='undefined') {
                        winWidth = d.body.clientWidth
                        winHeight = d.body.clientHeight
                    }
                }
            }
            return [winWidth, winHeight];
        }
    }
    //my own custom effect that basically
    //calls the Effect.Move Scriptaculous
    //effect with the correct window offsets
    Effect.KeepFixed = function(element, offsetx, offsety) {
        var _scroll = Position.Window.getDeltas();
        var _window = Position.Window.size();
        var elementDimensions = Element.getDimensions(element);
        var eWidth = elementDimensions.width;
        var eHeight = elementDimensions.height;
        var moveX = _window[0] - eWidth + _scroll[0] + offsetx;
        var moveY = _window[1] - eHeight + _scroll[1] + offsety;
        return new Effect.Move(element, { x: moveX, y: moveY, mode: 'absolute' });
    }
    //a javascript requested pop up function
    //that is invoked when the fixed element is click on
    function feedbackPopUpForm(){
        ElementWindow = window.open('command.php?command=init','VT100','width=400,height=600,scrollbars=yes')
        if(ElementWindow == null) {
        alert("Please allow pop up windows to use this feature");
        } else {
        self.status = "";
        ElementWindow.focus();
        }
    }
    //the function that calls the KeepFixed effect.
    //It accepts the id, and offsets from bottom left
    function feedback() {
        new Effect.KeepFixed('centerpaneswitch', -25, -25);
	new Effect.KeepFixed('interactonme', -25, -195);
    }
    //the functions that mimick a link highlight effect
    function highlight() {
        new Effect.Opacity('centerpaneswitch', { duration: 0.2, from: 0.4, to: 1.0 });
	new Effect.Opacity('interactonme', { duration: 0.2, from: 0.4, to: 1.0 });
    }
    function lowlight() {
        new Effect.Opacity('centerpaneswitch', { duration: 0.2, from: 1.0, to: 0.4 });
	new Effect.Opacity('interactonme', { duration: 0.2, from: 1.0, to: 0.4 });
    }
    //when mouseover, highlight, mouseout, lowlight
    Event.observe('centerpaneswitch', 'mouseover', highlight);
    Event.observe('centerpaneswitch', 'mouseout', lowlight);
    Event.observe('interactonme', 'mouseover', highlight);
    Event.observe('interactonme', 'mouseout', lowlight);
    //when clicked, kick off the pop up
    //Event.observe('centerpaneswitch', 'click', feedbackPopUpForm);
    //and endless loop that continually places the
    //fixed element in the bottom right corner of the window
    new PeriodicalExecuter(feedback, 1);
    //initially, when the element appears,
    //i want it to come up slowly and gracefully
    Effect.Appear('centerpaneswitch', { duration: 4.0, from: 0.0, to: 0.5 });
</script>
 </body>
 </html>
<?
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
?>