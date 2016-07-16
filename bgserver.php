<?
/** 
* the procedural switch file for the server communications.
* included by server protocoll page. Will be joined / replaced by commandswitch.php
* @version 0.00f public
* @devstate pre-beta
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgserver
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/
/**
* requirements....
*/
global $defaultdatasource,$viewports;
require_once("BGCONFIG.php");
require_once($defaultdatasource);
require_once($viewports);

$bgserverversion="V0.00a";
global $a, $defaultdatasource, $viewports,$var, $maxserverlist;
///////////////
header("BlooGeeLocation: http://".$_SERVER['HTTP_HOST'] 
                    .dirname($_SERVER['PHP_SELF']));
header("BlooGeeRequest: ACK $bgserverversion");

//if (requestheader

///////serverlist
$query="SERVERLIST::$maxserverlist::date,descend,0";
$outserverlist= serverlistformat(datasource($query));
header("BlooGeeServerList:". $outserverlist);
/////////////////
$cmd=explode("::", $var);
$var=explode(",",$cmd[2]);
//print_r($cmd);
//	require_once("commandswitch.php");
switch ($cmd[0]){
	case "ITEMNO":
	$content= "&Xi; $cmd[0] was item. ";
	$query = "ITEMNO::".@$cmd[1]."::0,0,0";
				//print $query;
										
				if (@$cmd[1]=='?'||!@$cmd[1]){print "				
					usage: ITEMNO::(n)::0,0,0<br>
					i.e. \"ITEMNO::2345\"<br>";
					break;
				}
				$a->checkquerystring($query);
				if ($a->isvalidcommand == TRUE){
					// print $query; //die;
					require_once($defaultdatasource);
					require_once($viewports);
					$content.= itemformat(datasource($query),".$cmd[1].","expanded");
				} else {$content.= noa();} 
	break;
	case "SEARCH":
	$content= "&Xi; $cmd[0] was search. ";
	if (@$cmd[1]=='?'||@!$cmd[1]){print "
					usage: SEARCH::(searchstring)::(sort ascend|descend),(sortfield),(max num)<br>
					i.e. \"SEARCH::weblogs::descend,text,99\"<br>";
					break;
		}
		$parm=explode(",", $cmd[2]);
		if ($parm[2]>$maxresults){$parm[2]=$maxresults;}
		$query = "SEARCH::".@$cmd[1]."::$parm[0],$parm[1],$parm[2];";
		$a->checkquerystring($query);
		if ($a->isvalidcommand == TRUE){
			require_once($defaultdatasource);
			require_once($viewports);
			$content= itemformat(datasource($query),"now()","expanded");
		}
	break;
	case "RELATIVES":
	$content= "&Xi;  $cmd[0] was relatives and is not working yet. ";
	break;
	case "DESTILL":
	$content= "&Xi;  $cmd[0] was destiller. ";
	require_once("destiller.plugin.php");
	$content.= "hello. this is $destillerversion with maxnr $maxresults "; 
				$query = "SEARCH::".$cmd[1]."::ascend,title,$maxresults";
				$a->checkquerystring($query);
				$content.= " based on query $query. Results:<br>";
				if ($a->isvalidcommand){
					require_once($defaultdatasource);
					require_once($viewports);
					require_once("libs.php.inc");
					datasource($query);
					$query= listarrayrecurse($mbo);
					$query=destillermain($query);
					$content.= $query;
				} 
	break;
}
/////save the query and source
require_once($defaultdatasource);
$query = "INSERT::title::BGSERVERQUERY*".$r->request['REMOTE_ADDR'].$r->request['REFERER']."*".@$cmd[0]."*".@$cmd[1]."*".@$var[0]."*".@$var[1]."*".@$var[2].",0,0";
datasource($query);
/////////////save all received serverlist
$inserverlist=explode(" ",$r->request['BGSERVERLIST']);
foreach($inserverlist as $row) {
	$query = "INSERT::title::BGSERVERLIST*".$row."*".$r->request['REMOTE_ADDR'].$r->request['REFERER'].",0,0";
	datasource($query);
}
/////////////the response object 

$response="<div class=\"id\">".$r->request['REMOTE_ADDR'].$r->request['REFERER']."</div><div class=\"title\">"
.@$cmd[0]."*".@$cmd[1]."*".@$var[0]."*".@$var[1]."*".@$var[2]."</div>
<div class=\"content\">$content</div><div class=\"relatives\"></div>";
header("BlooGeeState: DATA");
print $response;
//print listarray($r);
////// END MAIN ///////////
/** 
* helper function for $a
*/
function noa(){global $a; if (!$a){return " no or invalid security. ";}}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>