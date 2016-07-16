<?php
/** 
* JavaScript for command.php
* has to be loaded/initialized once with 'command.php?command=init'
* if not loaded, command.php will act like a normal form page
* @version 0.00f public
* @devstate still testing, subject to change
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/
?>
<div class="scriptcontainer" style="visibility:hidden;">
Scriptcontainer-->
<script type="text/javascript" src="lib/prototype.js" type="text/javascript"></script>
<script type="text/javascript"  src="src/scriptaculous.js" type="text/javascript"></script>
  <script type="text/javascript" src="lib/lightbox.js"></script><link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
 <link rel="stylesheet" href="lib/lightbox.css" type="text/css" media="screen" />
<script type="text/javascript">
function $() {
	  var elements = new Array();
	  for (var i = 0; i < arguments.length; i++) {
	    var element = arguments[i];
	    if (typeof element == 'string')
	      element = document.getElementById(element);
	    if (arguments.length == 1)
	      return element;
	    elements.push(element);
	  }
  return elements;
}

function docommand(){
	var lastcommandline=$('commandline');
	var value = lastcommandline.value;
	xo = createXMLHttpRequest();
 	if (xo) {xo.open('GET', 'command.php?command='+value, false); 
		xo.send(null);
		if(xo.ReadyState!=""){
			var commandpane=$('BGcommandline');
			var par=commandpane.parentNode;
			par.removeChild(commandpane);
			var interactonme=$('interactonme');
			var par=interactonme.parentNode;
			par.removeChild(interactonme);
			if (xo.readyState==4){		
				var response = xo.responseText;
				//alert(response);
				insertMessage(response);
				return;
			}
		}
	}
}	

function createXMLHttpRequest() {
	try {
	    xo = new ActiveXObject("MSXML2.XMLHTTP");
	}
	catch (err_MSXML2) {
	    try {
	        xo = new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    catch (err_Microsoft) {
	    //alert('no ms!');
	        if (typeof XMLHTTPRequest){
	        xo = new XMLHttpRequest};
	    }
	}
	return xo;
}

function insertMessage(msg) {
	var par = document.createElement('div');
	var container = document.getElementById('commandpane');
	var detail = container.appendChild(par);
	detail.innerHTML= msg;
	new Effect.Highlight(detail, {startcolor:'#123456'});
	new Effect.ScrollTo('commandform');	
	new Field.activate('commandline');
	//detail.scrollIntoView();

}

function loadshell(src, target){
	var target = $(target); //alert(value);
	var result = new Ajax.Updater(target,src, {method:'get',evalScripts: 'TRUE'});
	new Effect.Highlight(target);
	new Effect.ScrollTo('commandform');
	//target.scrollIntoView(true);
	//var t=$('nextstepform');
	//new Field.activate(t);
}
function nextstep() {
	tmp = $('interactonme');
	new Effect.Highlight(tmp, {startcolor:'#123456'});
 	var findthis = $('nextstepform').value;
	var xo = new Ajax.Updater('interactonme', 'user.php?userstring='+findthis,{method:'get', evalScripts: 'TRUE'});
	
}
new Field.activate('commandline');
new Effect.Highlight('commandpane',{startcolor:'#123456'});
</script>
</div>
<?
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
?>