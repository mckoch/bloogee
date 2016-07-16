<?php
/** 
* command shell
* no extended doc for now.
* @version 0.00f public
* @devstate working
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/
define("COMMANDLINEENABLED",TRUE);

$destillermax=250;
$blogmax=50;
$terminalinfo=0;
$defaultcommandlinevalue="blog 5";
	// basic command conttroller for BlooGee V0.01 #e
	require_once("BGCONFIG.php");
	require_once("murphy.plugin.php");
	/*print makemurphy();*/
	$murphy=makemurphy(); $murphynumber=$_COOKIE['murphycookie'];
	require_once "mbo.class.php";
	require_once("security.php.inc");
	require_once("libs.php.inc");
	//require_once("debug.php");
	$vt100version = "0.00b public";
	$header = "<span class=\"terminalheader\"><p>
	******************************<br>
	 &Xi; BlooGee Version $bgversion        <br>
	 &Xi; vt-100  text shell $vt100version<br>
	******************************<br>
	</p></span>
	";	
	$help = "<br /><span class=\"help\">";
		$help.= $a->user;
		$help.= "> bloogee version $bgversion, vt-100 version $vt100version.<br>
		&Xi; Usage '[cmd blog, item, search, relatives, destill] [var searchterm,?] [opt diags, -request]' 
		<br>&Xi; Try: 'diags', 'validate', 'sysrules', 'commands', 'online' , 'new', 'news' , 'mykey', 'item'
		('info', 'cls', 'logon', 'logoff'). 
		Try also: 'bonus', 'version', 'now', 'who', 'mykey', 'files', 'direct', 'clientinfo', '* -request'.<br />
		&Xi; Logon with user/pwd 'guest'. </p>
		
		</span>
		";
	$welcomemessage="welcome to &Xi; $a->user\@$defaulturl's command interface. 
	Play around and have some fun.";
	

	
$directcommandhelp ="//////////////////<br>
// ascend, descend = options[0]!!<br>
// sortfield id,title, text, relatives = options[1]!!<br>
// maxnumber = options[2]!!!<br>
// working COMMANDS: LASTN, ITEMNO, SEARCH, GETRELATIVES, UPDATE, INSERT<br>
// general usage: command::parameter::op0, op1, op2  (ALL options must be passed!)<br>
	usage: LASTN::(n)::(sort ascend|descend)::(sortfield id|title|text|relatives|date)<br>
		i.e. 'LASTN::3::descend,text,0'<br>
	usage: ITEMNO::(n)::0,0,0<br>
		i.e. 'ITEMNO::2345'<br>
	usage: SEARCH::(searchstring)::(sort ascend|descend),(sortfield),(max num)<br>
		i.e. 'SEARCH::weblogs::descend,text,99'<br>
	usage: GETRELATIVES::(id|string)::(sort ascend|descend),(sortfield),(max num)<br>
		i.e. 'GETRELATIVES::223::descend,text,99'<br>
//////////////////////<br>
";
	if (!COMMANDLINEENABLED==TRUE){ 
		print "$header no rights. But: $murphy";
		die;
	}
$stylecontainer="<div id=\"stylecontainer\"><STYLE TYPE=\"text/css\" MEDIA=\"screen\">
	 #BGcommandline,  #commandpane {font-family:monospace; size:12pt;padding:0px; margin: 0px;}
	 .terminalheader {color: lightgreen;font-family:monospace;padding:0px 8px 0px 8px;}
	.noadmin{color: black; background: red; font-size: small;margin: 5px;padding:0px 8px 0px 8px;}
	.knownuser,	.isuser {background: orange;margin: 5px;padding:0px 8px 0px 8px;}
	.anonymous{background: yellow;margin: 5px;padding:0px 8px 0px 8px;}
	.sysmessage{color: black; background: lightgreen;margin: 5px;padding:0px 8px 0px 8px;}
	.isadmin{color: red; background: lightblue;margin: 5px;padding:0px 8px 0px 8px;}
	#interactonme{background: lightgreen;padding: 8px; margin:5px;}
	.singleimage {height: 120px;border: 0px;}
	.inplaceeditor-saving {background: url(images/loading.gif) top left no-repeat; }
	.loggedin{background: lightgreen; padding:0px 8px 0px 8px; font-size: small;}
	hr {color: lightgreen; visibility: hidden;}
	#commandline{font-family: monospace; border-style: inset; border-width:0px 0px 1px 0px; border-color: lightgreen;}
	</STYLE></div>
";
	function bonus(){require_once("images_sleegersfotos_ticker.php");print " &Xi; bonus!<hr>";}
	///// main ////
	$var=@$_GET['command'];
	///
	if ($var=="init"){$initcommand="initialize";}
	if(@$initcommand=="initialize"){
		print $stylecontainer; 
		print "<div id=\"commandpane\" class =\"commandpane\">";
		print $header; print $welcomemessage."<br>";;
		//print $header."<br>".$welcomemessage;
	}	
	///
	print "<hr>".$a->user."@".$defaulturl.">".@$var."<br>";
	if ($a->commandrule > $a->currentuserrule) {
		print "$murphy <span class=\noadmin\">insufficient command power, try 'validate'.";
	}

if (@!$_GET['command']){print $header; print $welcomemessage; print " &Xi; nothing done so far.";}
	else {
		$cmd=explode("::", $var);
		$var=explode(" ",$var);
		////////////////////////////////////////////
		require_once("commandswitch.php");
		////////////////////////diagnostics, only admins -> shows app passwords!!!!  /////////////////////////////
		if (@$var[0]=="diags"||@$var[1]=="diags"||@$var[2]=="diags"||@$var[3]=="diags"){
			if (@$a->isadmin =="ADMIN"){
			$debuglevel=23;
				require_once("debug.php");
			} else {
				print "<span class=\"noadmin\">".$a->user." is no admin.</span>Try 'validate'.";
			}
		}
	 }



$defaultcommandlinevalue =@$var[0]." ".@$var[1];;//." ".$a[1];	 
		function userinput(){
		global $header, $submitterimage,$a, $defaulturl, $defaultcommandlinevalue;
		$input ="<form id=\"commandform\" method=\"GET\" action=\"command.php\"
		onsubmit=\"docommand();return false;\" >&Xi; ".$a->user."@".$defaulturl.">
			<input id=\"commandline\" value=\"$defaultcommandlinevalue\"  type=\"text\"  name=\"command\" size=\"24\" onclick=\"$(this).value='';\"></input>
			<span >
			<img onclick=\"docommand()\"src=\"$submitterimage\"></span></form>";

		
		return $input;
	}

	// if($initcommand=TRUE){print "<div id=\"commandpane\" class =\"commandpane\">";}	
	
	// print "<div id=\"interactonme\">test</div>";
	print "<div id=\"BGcommandline\" class=\"BGcommandline\">".userinput()."</div>";
	
	if (@$_GET){
	$u=$a->user;
	$a=$a->isadmin;

	print "<div class=\"sysmessages\"><span class=\"sysmessage\" onclick=\"docommand()\"><img src=\"$submitterimage\"></span><span class=\"sysmessage\">ready</span>";
	print "<span class=\"isuser\">&Xi; <a href=\"user.php\" onclick=\"loadshell('user.php', 'interactonme'); return false;\">$u</a> </span>";
	if ($a=="ADMIN"){print "<span class=\"isadmin\">&Xi;  $a </span>"; print $murphynumber;} 
		//die;
	} else {print "<span class=\"isuser\" onclick=\"docommand()\"><img src=\"$submitterimage\"</span><span class=\"sysmessage\">initialized. </span>";
		print "<span class=\"isuser\">&Xi; <a href=\"user.php\" onclick=\"loadshell('user.php', 'interactonme'); return false;\">".@$u."</a> </span>";
	if ($a=="ADMIN"){print "<span class=\"isadmin\">&Xi;  $a </span>";print $murphynumber;} 
	}
	print "</div>";
	print "<div id=\"interactonme\">&Xi; $vt100version 2006	</div>";


	if (@$initcommand=="initialize"){
		print "</div>"; // close commandpane only
		require_once("terminalheader.command.php");
	}
	?>
	<?
	function commandhelp($thiscommand){
		//$thishelp=$thiscommand->version;
		// $thishelp.=$thiscommand->description;
		$thishelp=$thiscommand->help;
		$thisparams=array_keys($thiscommand->params);
		$thisoptions=array_keys($thiscommand->options);
		$opts=""; $parms="";
		foreach($thisparams as $parm){$parms.=$parm.",";}
		foreach($thisoptions as $opt){$opts.=$opt.",";}
		$thisusage="<br> &Xi; usage with param[$parms] opt[$opts];<br>";
		return($thishelp.$thisusage);
	}
	function commandinfo($thiscommand) {
		$thisinfo="<p>Version: ";
		$thisinfo.=$thiscommand->version;
		$thisinfo.="<br />&Xi; ";
		$thisinfo.=$thiscommand->description;
		$thisinfo.="</p>";
		return $thisinfo;
	}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>