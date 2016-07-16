<?
/** 
* procedural file for command.php
* extend to won needs
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
/**
* main switch($var[0]) for commands
*/

		switch ($var[0]) {
		case "license":
			require_once("LICENSE");
			break;
			case "exit":
				bonus();
				print " &Xi; ok. current shell terminated.<br>".$murphy; die;
				break;
			/// for all the kids.... ///////////////
			case "bonus": bonus();break;
			case "dir": bonus(); print "<blink><span class=\"noadmin\">&Xi; GURU MEDITATION AT ADRESS ::".mktime(now).":: </span>";die;
			case "ls": bonus(); print "&Xi; <blink><span class=\"noadmin\">GURU MEDITATION AT &Xi; ADRESS ::".mktime(now)."::</span>";die;
			case "format": bonus(); print "<blink><span class=\"noadmin\">&Xi; GURU MEDITATION AT ADRESS ::".mktime(now)."::</span>";die;
			case "cd": print "ok, just tell me where to go. &Xi;";
				if(@$var[1]){print "no valid location or parameters. try again. &Xi;";}
			break;
			//////////////////////////////////
			case $var[0]=="?"||$var[0]=="help"||$var[0]=="shit"||$var[0]=="fuck":
			print $header;
				print $help;
				break;
			case $var[0]=="cls"||@$var[1]=="cls"||@$var[2]=="cls":
					print "$murphy &Xi; not implemenetd clearscreen; please retry:clsie for MSstuff, 
					clsmoz for others. May finally mess up your screen.";
				break;
			case $var[0]=="version"||$var[0]=="ver":
				print "current version &Xi; $vt100version";
				break;
			case "sysrules":
					print listarray($a->usergroups);
					print listarray($a->validuricommands);
					if ($a->isadmin=="ADMIN"){
						print listarray($a->rules);
						print listarray($a->validshellcommands);
					}
					break;
			case "info":
					print $header.$welcomemessage; 
					if (@!$terminalinfo){print " No further information on $defaulturl available yet, sorry.";} else {print $terminalinfo;}
				break;
			case @$var[1]=="-request"||@$var[2]=="-request"||
				@$var[3]=="-request"||@$var[4]=="-request":
				print listarrayrecurse($r);
				//nobreak!!!;
			case "thiscommand":
				require_once("commandtemplate.php");
				//$thiscommand=new thiscommand;
				//print listarray($thiscommand);
				//print commandhelp($thiscommand);
				 $thiscommand->init();
				 print $thiscommand->output;
				break;
			case "clsie":
				print "$murphy <script type=\"text/javascript\">newcommandpane();</script>";
				break;
			case "clsmoz":
				print "$murphy <a href=\"\" onclick=\"newcommmandpane(); return false;\">clear history</a>";
				print "<script type=\"text/javascript\">loadshell('user.php');</script>";
				break;
			case "now":
				$today = getdate(mktime(now));
				print listarray($today);
				break;
			case "who":
				print "You are user ".$a->user.".";
				break;
			case "commands":
				print "&Xi; core: ".listarray($a->validuricommands);
				print "&Xi; extensions: ".listarray(array_keys($a->validshellcommands));
				//print listarray($a->validshellcommands);
				break;
			case "mykey":
					//$mykey=$_COOKIE;//['userpwd'];
					//print "php session: ".listarrayrecurse(session_get_cookie_params());
					print "<br>&Xi; bloogee key: ".@$_COOKIE['userpwd'];
					print "<br>current min. commandlevel on $defaulturl is ".$a->commandrule.".<br>current rule for ".
						$a->user." is ".$a->currentuserrule.". ";
				break;
			case "online": // fake.
				print listarray($a->usergroups);
				break;
			case "files":
				$d = dir(@$var[1]); 
				if(!@$d){print " &Xi; noop.";break;}
				else{echo "Handle: ".$d->handle."<br>\n"; 
				echo "Path: ".$d->path."<br>\n"; 
				while (false !== ($entry = $d->read())) { 
				   echo $entry."<br>\n";
					}
				} 
				$d->close(); 
				break;
			case "direct":
				if (@$var[1]=='?'||@!$var[1]){print $directcommandhelp;	break;}
				$query=@$var[1];
				if ($a->isadmin!="ADMIN"){print "$murphy security breach. check aborted."; break;}
				$a->checkquerystring($query);
				if ($a->isvalidcommand == TRUE){
				print "command $query is valid. ";
				require_once($defaultdatasource);
				if (@$var[2]=="direct"){print listarrayrecurse(datasource($query));break;}
				if (@$var[2]=="mbo"){print listarrayrecurse($mbo);break;}
				if (@$var[2]=="all"){print listarrayrecurse(datasource($query));print listarrayrecurse($mbo);break;}
				if (@!$var[2]){		print "oops. try direct, mbo, all";}
		
				} else {print "command $query seems to be invalid. $murphy";}
				break;
			case @$var[0]=="validate"||@$var[0]=="val":
			print $header;
				if ($a->isvalidcommand==TRUE){ // MORE!!!!!!!!!!!
					print "a valid command for \$a, my dear. ";
				} else {
					if ($a->isadmin =="ADMIN"){
						print "declared \$a: ".listarrayrecurse($a);
						require_once("debug.php");
					} 
				print "<span class=\"isuser\">".$a->user." is ".$a->isadmin.".</span> Some basic data:<br>";
				print "This is BlooGee@".$defaulturl;
				print " with <br>defaultuser:".$defaultuser.", <br>defaultgroup: ".$defaultgroup.
					", <br>defaultuserrule: ".$defaultuserrule.", <br>defaultcommandlevel: ".$defaultcommandlevel.
					", <br>defaultcommandrule: ".$defaultcommandrule.".<br>";
					print "Array \$_REQUEST: ".listarrayrecurse($_REQUEST);
					print "Array \$_COOKIE: ".listarrayrecurse($_COOKIE);
				//print "declared \$_GET: ".listarrayrecurse($_GET);
				}
				break;
			case "search":
				if (@$var[1]=='?'||@!$var[1]){print "
					usage: SEARCH::(searchstring)::(sort ascend|descend),(sortfield),(max num)<br>
					i.e. \"SEARCH::weblogs::descend,text,99\"<br>";
					break;
					}
				$query = "SEARCH::".@$var[1]."::ascend,text,5";
				//print $query;
				$a->checkquerystring($query);
				require_once("search.php");
				
				break;
			case "new":
				if (@$var[1]=='?'||@!$var[1]){
					print	"// i.e. 'new title jhgfjgfjs' or 'new relatives ::http://somwehere.what/bg.php'. <br>
						seperate textline by '::'.";
					break;
					}
					function escapein($in) { //move to libs -> from edit.php
						$out = eregi_replace(",","##--##--##",$in);
						//$out = htmlentities($in);
						return $out;
					}
			  //syntax: ::INSERT::text|title::textvartexttextetxtxttxttx
				$query = "INSERT::".@$var[1]."::".escapein($cmd[1]).",0,0";	
				print $query;
				$a->checkquerystring($query);
				if ($a->isvalidcommand == TRUE){
					require_once($defaultdatasource);
					print listarray(datasource($query));
					break;
				}
				break;
			case "news":
				if (@$var[1]=='?'||@!$var[1]|@!$var[2]|@!$var[3]){print "
					// i.e. 'news 15 date ascend' or 'SUBMITTED::10::date,ascend,relatives'<br>";
					} else { 
					$query = "SUBMITTED::$var[1]::$var[2],$var[3],0";
					if ($var[4]){$query = "SUBMITTED::$var[1]::$var[2],$var[3],$var[4]";}
					$a->checkquerystring($query);
					if ($a->isvalidcommand == TRUE){
						print "ok.";
						require_once($defaultdatasource);
						require_once($viewports);
						//$query=datasource($query);
						//print listarrayrecurse($mbo);
						print itemformat(datasource($query),".@$var[1].","collapsed");
						break;
					}
					break;
				}
				break;
			case "clientinfo":
				print listarray($r->request);
				break;
			case "item":
				$query = "ITEMNO::".@$var[1]."::0,0,0";
				//print $query;
										
				if (@$var[1]=='?'||!@$var[1]){print "				
					usage: ITEMNO::(n)::0,0,0<br>
					i.e. \"ITEMNO::2345\"<br>";
					break;
				}
				$a->checkquerystring($query);
				if ($a->isvalidcommand == TRUE){
					
					require_once($defaultdatasource);
					require_once($viewports);
					print itemformat(datasource($query),".@$var[1].","expanded");
					break;
				}
				
			case "blog":
				$query = "LASTN::".@$var[1]."::descend,created,0";
				if (@$var[1]=='?'||@!$var[1]){print "				
					usage: LASTN::(n)::(sort ascend|descend)::(sortfield id|title|text|relatives|date)<br>
					i.e. \"LASTN::3::descend,text,0\"<br>";
					break;
				}
				//print $query;
				if(@$var[1]>$blogmax){$var[1]=$blogmax;}
				$a->checkquerystring($query);
				require_once($defaultdatasource);
				require_once($viewports);
				print itemformat(datasource($query),".@$var[1].","collapsed");
				
				//require_once("debug.php");
				break;
			case "relatives":
				$query = "GETRELATIVES::".@$var[1]."::ascend,text,5";
				if (@$var[1]=='?'||@!$var[1]){print "				
					usage: GETRELATIVES::(id|string)::(sort ascend|descend),(sortfield),(max num)<br>
					i.e. \"GETRELATIVES::223::descend,text,99\"<br>";
					break;
				}
				$a->checkquerystring($query);
				require_once($defaultdatasource);
				require_once($viewports);
				print itemformat(datasource($query),".@$var[1].","collapsed");
				print $query;
				break;
			case "update":
				//if
				if (@$var[1]=='?'||@!$var[1]){print "				
					usage:  UPDATE::(itemno)::(title|text|relatives),(value),0<br>
					i.e. \"UPDATE::22341::title,text,0\"<br>";
					break;
				}
				if (@$var[1]&&@$var[2]&&@$var[3]){
					$query = "UPDATE::$var[1]::$var[2],$var[3],0";
					
					$a->checkquerystring($query);
					$query = "UPDATE::".$a->commandparams."::".$a->commandoptions;
					//print $query;
					
					if ($a->isvalidcommand == TRUE) {
						//require_once($defaultdatasource);
						//print datasource($query);
						print "not implemented yet.";
						listarray($a); listarray($var);
					}
				}
				print "too dangerous now.";
				//print $a->commandoptions;
				//print $a->commandparams;
				//require_once($editpage);
				
				break;
			
			case $var[0]=="logoff"||$var[0]=="logout"||$var[0]=="bye"||$var[0]=="login"||$var[0]=="logon":
				print $a->user."@".$defaulturl."><br><span class=\"sysmessage\">";
				print "click <a href=\"\" onclick=\"loadshell('user.php', 'interactonme'); return false;\">new user dialog</a><span>";
				print " or use the login from ".$defaulturl.". &Xi; login link below commandline.
				<script type =\"text/javascript\">var interactonme=$('interactonme');loadshell('user.php', interactonme); return false;</script>
				";
				break;


			/////////////////////////// extensions below here
			// bg HTTP header constructor
			case "bghttp":
			if (@$var[1]=='?'||@!$var[1]||@!$var[2]){print "
					usage: bghttp (host) (/file) (BGCOMMAND) [(TRUE|FALSE)(serverlist|querylist|blacklist get|request)]<br>
					i.e. \"bghttp testhost.org /index.php ITEMNO::2323::0,0,0 -debug \"<br>";
					break;
					}else {
					require_once("serverinfo.plugin.php");
					print " &Xi; done. ";
					}
			break;
			// destiller plugin
			case $var[0]=="destiller"&&$var[2]=="relatives":
				$query = "GETRELATIVES::".@$var[1]."::ascend,text,5";
				$a->checkquerystring($query);
				require_once($defaultdatasource);
				datasource($query);
				require_once("destiller.plugin.php");
				print destillermain(listarrayrecurse($mbo));
			break;
			case $var[0]=="destiller"&&$var[2]=="item":
				$query = "ITEMNO::".@$var[1]."::0,0,0";
				$a->checkquerystring($query);
				require_once($defaultdatasource);
				datasource($query);
				require_once("destiller.plugin.php");
				print destillermain(listarrayrecurse($mbo));
			break;
			case $var[0]=="destiller":
			require_once("destiller.plugin.php");
			if (@$var[1]=='?'||@!$var[1])
				{print $$destillerhelp;
				} else {
					print "hello. this is $destillerversion with maxnr $destillermax "; 
					$query = "SEARCH::".$var[1]."::ascend,title,$destillermax";
					$a->checkquerystring($query);
					print " based on query $query. Results:<br>";
					if ($a->isvalidcommand){
						require_once($defaultdatasource);
						require_once($viewports);
						datasource($query);
						$query= listarrayrecurse($mbo);
						$query=destillermain($query);
						print $query;
					} 
						
				}
				break;
			case "destillext":
			require_once"destillerext.plugin.php";
			if (@$var[1]=='?'||@!$var[1]||@!$var[2])
					{print $destillerextheader.$destillerexthelp;}
				else { if ($a->isadmin=="ADMIN"){
					if(@$var[2]){print ( destillermain($var[1],$var[2]));}
					} else {print $destillerextheader."&Xi; noop. no public usage.";}
				}
				break;
				
			////////// murphy plugin
			case "murphy":
				print $murphy;
					break;
					
			case @!$var[1]:
				if (ctype_alnum($var[0])==TRUE){

					print "$murphy<br> <span class=\"sysmessage\">#$vt100version: 
					&Xi;<br>For help try '?' (or maybe '$var[0] ?)'.</span>";
				break;
				} else {
				// default;
				}
			default:
				//print $header;
				bonus();
				print "$murphy &Xi; noop. your command, master: ";
				print $var[0];
				print " with opts " .@$var[1]." did not match at all. Try '?'";
				//print "<script type=\"text/javascript\">new Effect.Highlight('commandline'); alert('fsdgd');</script>";
			 break;
		 }
		 
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>