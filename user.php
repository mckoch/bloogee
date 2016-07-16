<?php
/** 
* page for user login
* no extended doc for now.
* @version 0.00f public
* @devstate stable
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/
/**
* requirements
*/
require_once("BGCONFIG.php");
require_once("security.php.inc");

$header = "<p>
******************************<br>
 BlooGee Version 0.00c        <br>
 controller for user admission<br>
******************************<br>
</p>
";
$stylesheet = "
<STYLE TYPE=\"text/css\" MEDIA=\"screen\">
#interactonme {
position: relative;
border: solid;
border-width: 5px;
border-right:0px;
border-bottom:0px;
border-color: darkblue;
border-style: ridge;
padding: 15px;
font-family: monospace;
.loggedin{background: lightgreen; padding:5px; width:88;}
.knownuser{background: orange;}
.anonymous{background: yellow;}
}
.nouser {}

</style>
";
$ownjscript = "
<script type=\"text/javascript\">
function nextstep() {
	tmp = $('interactonme');
	new Effect.Highlight(tmp);
 	var findthis = $(\"nextstepform\").value;
	var xo = new Ajax.Updater(
         'interactonme',    
         'user.php?userstring='+findthis,       
         { method:'get', evalScripts: 'TRUE'
             });
}
function resetpwd() {
	tmp = $('interactonme');
	new Effect.Highlight(tmp);
	var xo = new Ajax.Updater(
         'interactonme', 
         'user.php?', 
         {method:'get', evalScripts: 'TRUE'
             });
}
var nextstepform=$('nextstepform');
new Field.activate('nextstepform');
</script>";



$draglet = "<script type=\"text/javascript\">
    //new Draggable('interactonme',{ghosting: false});
    </script>";


function initcookies(){
	global $commandkeyvalid;
    setcookie("username", "anonymous");
	setcookie("retry", "1", time()+$commandkeyvalid);
	setcookie("usrcommandlevel", 1, time()+$commandkeyvalid);
	setcookie("userpwd", 0, time()+$commandkeyvalid);
	return TRUE;
}

function resetcookies(){
	global $commandkeyvalid;
	setcookie("usrcommandlevel", 1, time()+$commandkeyvalid);
	setcookie("userpwd", 0, time()+$commandkeyvalid);
}

/* if (!$_GET){
	initcookies();
} */
if (!$_GET && !$_COOKIE){
/* 	setcookie("username", "anonymous");
	setcookie("retry", "1");
	setcookie("usrcommandlevel", 1, time()+3600); */
	initcookies();
	print $stylesheet;
//	print "<div id=\"interactonme\" class=\"$anonymousclass\">";
	print $header;
	print usernameinput(). "72 STEP 0; anonymous user, no cookie at start";
//	print "</div>".$draglet;
	die;
}

if (($_COOKIE["username"]=="anonymous")&&(!$_GET)) {
	resetcookies(); setcookie("retry", "1");
//	print $stylesheet;
//	print "<div id=\"interactonme\" class=\"$anonymousclass\">";
	print $header;
	print usernameinput()."81 STEP 0a: anonymous user w cookie...";
//	print "</div>".$draglet;
	die;
}

if (($_COOKIE["username"]!="anonymous")&&(!$_GET)) {
	$username= $_COOKIE["username"]; setcookie("retry", "1");
	resetcookies();
//	print ;
//	print "<div id=\"interactonme\" class=\"$knownuserclass\">";
	print $header;
	print userpasswordinput($_COOKIE["username"])."92 type pwd for $username";
//	print "</div>".$draglet;
	die;
}

if (($_COOKIE["username"]=="anonymous")&&($_GET)) {
	$username=$_GET["userstring"];
		setcookie("username", $username);
		resetcookies();
    print userpasswordinput($username)."91pw for $username w cookie";
    die;
}

if (($_COOKIE["username"]!="anonymous")&&($_COOKIE["userpwd"]==0)&&$_GET["userstring"]) {
	if ($_COOKIE["retry"]> $loginretry) {
	    initcookies();
		print usernameinput()."new username please, pw retries exceeded";
		die;
	} 
	

    $q = checkthisuserlogonrequest($_COOKIE["username"],$_GET["userstring"]);
	if ($q!="DBERROR") {
	    ///!!!
	    setcookie("userpwd", $q[3], time()+3600);
	    setcookie("retry", "1");
	   $usrcommandlevel=$q[2];
	   ///!!!
		setcookie("usrcommandlevel", $usrcommandlevel, time()+3600);
	    print youareloggedin($q);//.$header;

		die;
	} else {
	    setcookie("userpwd", 0);
	    $retry = $_COOKIE["retry"];
	    if ($retry < $loginretry){
			$retry++;
			setcookie("retry", "$retry");
		    print /* $header. */userpasswordinput($_COOKIE["username"])." $retry passsword please";
		    die;
		} else {
	    	initcookies();
			print $header.usernameinput()."new username please, pw retries exceeded";
			die;
		}
	}
}
die;
function youareloggedin($a){
	global $loggedinclass;
    $usr = $a[0]; $usremail= $a[1];	$usrhome= $a[2]; $validid=$a[3];
	return "<div  class=\"$loggedinclass\">user $usr: you are logged on. Your key now is \"$a[3]\".
		<a href=\"#\" onclick=\"resetpwd(); return false;\">logout</a></div>";
}

function checkthisuserlogonrequest($usr,$pwd) {
    include "BGCONFIG.php";
 $usr = ereg_replace('[\,\/\'\%\@\?\$\*\:]', '', $usr);
 $pwd = ereg_replace('[\,\/\'\%\@\?\$\*\:]', '', $pwd);
	require_once("mydbconfig.inc.php");
	$db = mysql_connect($dbhost, $dbuser, $dbpwd);
	if (!$db) {
		die("<h3>connecting...</h3>driss ooch ens.");
	}
	mysql_select_db($database);
	if (mysql_errno()) {
		die(mysql_errno().mysql_error());
	}
	$query = "SELECT author_name, author_email,
	commandlevel, author_url, author_id FROM mt_author WHERE author_name
	= \"$usr\" AND author_password = \"$pwd\" LIMIT 1";
	//print $query; //die;
	$result = mysql_query($query);
	if (mysql_errno()) {
		die(mysql_errno().mysql_error());
	}
	$num = mysql_num_rows($result);
	if ($num < 1){return "DBERROR";}
	if ($num == 1) {
	 $q = mysql_fetch_row($result);
	 
	 $validid = uniqid(time().$usr);
	 $query = "UPDATE mt_author SET validid =\"$validid\" WHERE author_name
	= \"$usr\" AND author_password = \"$pwd\" LIMIT 1";
	mysql_select_db($database);
	if (mysql_errno()) {
		die(mysql_errno().mysql_error());
	}
	$result = mysql_query($query);
	if (mysql_errno()) {
		die(mysql_errno().mysql_error());
	}
 //print $validid."::::".$query;
	$q[3] = $validid;
	mysql_close();
	 return $q;//. $validid;
	}
}

function usernameinput(){
	global $header, $submitterimage,$stylesheet,$ownjscript;
	return "
	<form id=\"logonform\" method=\"GET\" action=\"user.php\"	onsubmit=\"nextstep();return false;\" >
	<input id=\"nextstepform\" name=\"userstring\" ></input><span onclick=\"nextstep();\"><img src=\"$submitterimage\"</span></form>
	 username please: <script type=\"text/javascript\">new Field.activate('nextstepform');</script>
";}

function userpasswordinput($username){
    	global $submitterimage,$stylesheet,$ownjscript;
	//require_once("libs.php.inc");
	//require_once("debug.php");
    	return "
	<form id=\"logonform\" method=\"GET\" action=\"user.php\"	onsubmit=\"nextstep();return false;\" >
	<input type=\"password\" name=\"userstring\" id=\"nextstepform\"></input><span onclick=\"nextstep()\"><img src=\"$submitterimage\"</span></form>
		password for $username please: <script type=\"text/javascript\">new Field.activate('nextstepform');</script>";
}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>