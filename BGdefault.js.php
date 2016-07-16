<?
/** 
* basic client side JavaScript include.
* provides methods for client - > main interface to BlooGee
* no extended doc for now.
* @version 0.00f public
* @devstate unknown
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU  General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage wrapper
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/
?>
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
///////  BlooGee Version 0.00c VERSION2 !!!!
///////  new basic client side JavaScript include
///////  provides methods for client - > main interface to BlooGee
///////  (all rights reserved, copyrights M.C. Koch 2006)
//////////////////////////////////////////////////////////////////////
////////////// all MCO elements behaviours
//////////////////////////////////////////////////////////////////////
function CollapseOverlay(thisOverlay){
	myid = thisOverlay.id;
	mytitle = thisOverlay.title;
	//alert(myid + mytitle);
	thisOverlay.innerHTML = "<a return\=false href\=\"javascript:GetItemFromIdLink(\'" + myid + "\')\">"+ mytitle +"</a>";
}

function GetItemFromIdLink(thisLink) {
	var id = thisLink;
	xo = createXMLHttpRequest();
 	if (xo) {	//	alert("xo exists!");
		xo.open("GET", "http://localhost/index.php?"+id, false); //synchronous!!!!
		xo.send(null);
		var response = xo.responseText;
	    //alert(response);
		insertMessage(response);
	}
}

function insertMessage(msg) {
	var par = document.createElement("div");
	var container = document.getElementById("detailpane");
	var detail = container.appendChild(par);
	detail.innerHTML= msg;
	detail.scrollIntoView();
}
//////////////////////////////////////////
///////////////// searching....

function doSearch() {
	var search = true;
	var key = keyword();
	alert("search.php?SEARCH::"+key+"::descend,title,50");
	xo = new XMLHttpRequest;
	if (xo) {		//alert("xo exists!");
	xo.open("GET", "search.php?SEARCH::"+key+"::descend,title,50");

	xo.send(null);
	updateSearchOverlay(xo.status, xo.responseText);
	}
}
function NdoSearch(){
    var key = keyword();
	var opt = {
	    method: 'get',
	    postBody: 'search.php?SEARCH::'+key+'::descend,title,50',
	    onSuccess: 	updateSearchOverlay(t.status, t.responseText),
	    on404: function(t) {
	        alert('Error 404: location "' + t.statusText + '" was not found.');
	    },
	    onFailure: function(t) {
	        alert('Error ' + t.status + ' -- ' + t.statusText);
	    }
	}
//alert opt;
new Ajax.Request('search.php', opt);
}


function updateSearchOverlay(status, text) {
		var response = text;
		//alert response;
		if (!response) {alert("NO RESPONSE DETECTED!")
		} else {
		insertSearchOverlay(response);}
}
function insertSearchOverlay(response) {
	var par = document.createElement("div");
	var container = $("centerpane");
	var detail = container.appendChild(par);
	detail.innerHTML= response;
}
function keyword() {
 var findthis = $("searchstring");
 var findthis = findthis.value;
	return findthis;
}


////////////////////////////////////////////////////////////////////
////////// XMLHttpRequestObject IE / MOZ
///////////////////////////////
function createXMLHttpRequest() {
	try {
	    xo = new ActiveXObject("MSXML2.XMLHTTP");
	}
	catch (err_MSXML2) {
	    try {
	        xo = new ActiveXObject("Microsoft.XMLHTTP");
	    }
	    catch (err_Microsoft) {
	        if (typeof XMLHTTPRequest != "undefined"){
	        xo = new XMLHttpRequest};
	    }
	}
	return xo;
}
////////////////////////////////
//// helper for getElementById
//// (from prototype)
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


function effects(){
	var commandpane=$('commandpane');
	new Effect.Highlight(commandpane);
	var commandline=$('BGcommandline');
	new Effect.Highlight(commandline);
	}
// update div per link
function loadshell(src, target){
	var target = $(target); //alert(value);
	var result = new Ajax.Updater(target,src, { method:'get',evalScripts: 'FALSE'});
	//new Effect.Highlight(target);
}
//login
function nextstep() {
	new Effect.Highlight(tmp);
 	var findthis = $("nextstepform").value;
	var xo = new Ajax.Updater(
         'interactonme',        // DIV id (XXX: doesnt work?)
         'user.php?userstring='+findthis,        // URL
         {                // options
         method:'get', evalScripts: 'FALSE'
             });
}
function resetpwd() {
	tmp = $('interactonme');
	new Effect.Highlight(tmp);
	var xo = new Ajax.Updater(
         'interactonme',        // DIV id (XXX: doesnt work?)
         'user.php?', // URL
         {                // options
         method:'get',evalScripts: 'TRUE'
             });
}

function ticker(src, target, chng){
	var target = $(target); //alert(value);
	var result = new Ajax.PeriodicalUpdater(target,src, { method:'get',evalScripts: 'FALSE',
	frequency: chng, updateComplete: function(){}});
}
<?
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>