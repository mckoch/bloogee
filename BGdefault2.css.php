<?php
/** 
* Standard block for bg documentation.
* This fileheader is dummy (short desc).
* no extended doc for now.
* @version 0.00f public
* @devstate unknown
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage wrapper
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/
?>
body {
     background: #302732;
     font: 14px Verdana, Helvetica, sans-serif;
	margin: 0 auto;
	line-height: 1.4em;
}
	A 			{ color: #CCCC66; text-decoration: none; }
	A:link		{ color: #CCCC66; text-decoration: none; }
	A:visited	{ color: #CCCC66; text-decoration: none; }
	A:active	{ color: #FFFF99; }
	A:hover		{ color: #FFFF99; }
	
li {
    list-style-image:url(images/expand.gif);
    margin-top:5px;
    margin:0px;
    padding:0px;
  }
  img {
    border: 0px;
  }
#topleftimage{
	position: absolute; top:356px; left:0px;}

h1 {font-size: normal;}

span.handle {
    background-color: #27302f;
    color:white;
    cursor: move;
  }

#menupane {
	position: absolute;
	background: url(images/spinnennetz.jpg) top left;
	top: 36px;
	left: 10px;
	width:200px;
	height:500px;
	z-index: 12;
	margin: 18px;
	padding: 20px;
	overflow: auto;
	border: 5px;
	border-style: ridge;
	border-right: 0px;
	border-bottom:0px;
	border-color: red;
}
#menupanecontainer {
      position:absolute;
      	top: 36px;
	left: 10px;

}

#centerpaneswitch {
	position:absolute; 
	width: 250px;
	border:1px solid #f90; 
	background-color: #27272f;
	top:0px; 
	left:0px; 
	padding:12px; 
	z-index: 5000;
}
#detailpane {
	position: absolute;
	top: 10px;
	right: 10px;

	background: url(images/sleegers_vorhang_blau.gif) top right;
	z-index: 120;
	margin: 18px;
		padding: 20px;
	     	border-style: ridge;
	border-right: 0px;
	border-bottom:0px;
	border-color: red;
}
.singleimage {
	width: 200px;
	border: 0px;
}
.inplaceeditor-saving {
	background: url(images/loading.gif) top left no-repeat; }

#overlay {
}
#centerpane {
	position: absolute;
	left:45px;
	width: 50%;
	margin: 36px 36px 36px 36px;
	     	border-style: ridge;
	border-right: 0px;
	border-bottom:0px;
	border-color: red;
	padding: 20px;
	}
#rightpane {
}
#servermonitor{font-size:xx-small; width: 350px; color:#66cc99; overflow: none; height: 100px;}
#servermonitor a{font-size:xx-small;}
#showsearchlist {
    	padding: 20px;
	overflow: none;
	     	border-style: ridge;
	border-right: 0px;
	border-bottom:0px;
	border-color: red;
	}

#searchpanel {
	position: absolute;
	overflow:auto;
	bottom: 36px;
	right: 0px;
	z-index:100;
}
#relatives {
}
#BlooGee {
}
#menubuttons{
width: 150px;
position: absolute;
}
#footer {padding: 5px;}
#murphy{
position: relative;
	width:200px;
	font-size: x-small;
	color: #66cc99;
	z-index:1;
}
.item {
	color: green;
}

.title {
	color: red;
}
.content {
	background: #27302f;
	color: #8faeae;
}
.relatives {
}



.teaser {
	font-size:small;

}
.teaser a {
	font-weight: 100 ;
	font-size: normal;
	margin-top: 20px;
	}

#interactonme {
	position: absolute;
	left:15px;
	top: 10px;
	width: 220px;
	border: solid;
	border-width: 5px;
	border-right:0px;
	border-bottom:0px;
	border-color: darkblue;
		border-style: ridge;
	padding: 15px;
	font-family: monospace;
	color: green;
	//background: url(images/logongreen.gif) top left  no-repeat;
	background-color: #27272f;
	z-index:2000;
}
#interactonme loggedin {font-size: small;}

#interactonme input {background: blue; 	border-style: ridge;}
.nouser {}
.loggedin{background: lightgreen; padding:0px 8px 0px 8px; font-size: x-small;}
.noadmin{color: black; background: red; padding:0px 8px 0px 8px; font-size: x-small;}
.knownuser{background: orange;padding: 0px 8px 0px 8px;}
.anonymous{background: yellow;padding: 0px 8px 0px 8px;}
.blogdate{background: url(images/edit2.gif) top left  no-repeat;
	background-color:#27272f; padding: 0px 8px 0px 17px;font-size:x-small;}
.miniature{width: 50px;}
<?
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>