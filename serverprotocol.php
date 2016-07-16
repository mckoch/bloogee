<?
/** 
* protocoll for communication between BG servers.
* no extended doc for now
* @version 0.00f public
* @devstate alpha
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgserver
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @todo rewrite and integrate with security.php.inc
*/
/**
* requirements
*/
require_once("BGCONFIG.php");
require_once($defaultdatasource);
require_once($viewports);

$bgserverpage="/index.php";
$bgserverprotocollversion="0.00testing";

$validheadercommands = array( //to $a->validheadercommands
	"HELLO"=>"PUBLIC",
	"VERSION"=>"PUBLIC",
	"SERVERLIST"=>"PUBLIC",
	"QUERYLIST"=>"MORE",
	"BLACKLIST"=>"AUTHOR",
	"NEEDKEY"=>"PUBLIC",
	"USETHISKEY"=>"PUBLIC",
	"ACKKEY"=>"MORE",
	"KEYFORMEPLEASE"=>"PUBLIC",
	"ERROR"=>"PUBLIC",
	"DOCOMMAND"=>"PUBLIC");
///////////////////////////////////////////////////////////////////
if (blacklist($httphost)==TRUE){die("&Xi; blacklisted.");}
else {require_once("class.HttpConnection.inc");
	$request=$r->request['BGREQUEST'];
	//$request=$_REQUEST['bgrequest'];
//	print $request;
//	$a->validatecommand($request);
//	if ($a->isvalidcommand="1"){
		$headers=bgprotocoll($request);
		$httphost=$r->request['REMOTE_ADDR'];
		//$httphost=$_SERVER['HTTP_HOST'];
		
		$httpfile=$r->request['BGREMOTEPAGE'];
		print (dohttprequest($headers, $httphost, $httpfile));
//	}else {bgprotocoll("NEEDKEY");
//		dohttprequest($headers, $httphost, $httpfile);
//	}
}
die;
///////////////////////////////////////////////////////////////////
/**
* contains the main switch for internal server commands.
* note: expandable by bgserver.php
* @devstate unstable
*/
function bgprotocoll($request){
global $a, $r,$bgserverprotocollversion,$bgserverpage, $maxserverlist;
	switch($request){
		case "TEST":
			$headers[] = new HTTP_Header("BlooGeeRequest","VERSION");
		break;
		case "HELLO":
			$headers[] = new HTTP_Header("BlooGeeRequest","Hello. &Xi; waiting...");
		break;
		case "VERSION";
			$headers[] = new HTTP_Header("BlooGeeRequest","MYVERSION $bgserverprotocollversion");
		break;
		case "SERVERLIST":
			$query="SERVERLIST::$maxserverlist::date,descend,BGSERVER";
			$outquerylist= serverlistformat(datasource($query));
			$headers[] = new HTTP_Header("BlooGeeServerList",$outquerylist);
		break;
		case "QUERYLIST":
			$query="SERVERLIST::$maxserverlist::date,descend,BGQUERY";
			$outquerylist= querylistformat(datasource($query));
			$headers[] = new HTTP_Header("BlooGeeQueryList",$outquerylist);
		break;
		case "BLACKLIST":
			$query="SERVERLIST::$maxserverlist::date,descend,BGBLACK";
			$outquerylist= querylistformat(datasource($query));
			$headers[] = new HTTP_Header("BlooGeeBlackList",$outquerylist);
		break;
		case "NEEDKEY":
			//requested user & key
			//blockcommand: if user & key for remote site exist in calling sysdb
			$headers[] = new HTTP_Header("BlooGeeRequest","USETHISKEY");
			$headers[] = new HTTP_Header("BlooGeeKey",$bguserkey);
			
			// if not exist $bguserkey:
			// $bguserkey = generateserverkey($defaulturl);
			//$headers[] = new HTTP_Header("BlooGeeRequest:KEYFORMEPLEASE");
			//$headers[] = new HTTP_Header("BlooGeeKey:$bguserkey");
		break;
		case "USETHISKEY":
			//$keytocheck= $r->request['BlooGeeKey'];
			//check key form http header BlooGeeKey in sysdb
			//
			//if not true
			//$headers[] = new HTTP_Header("BlooGeeRequest:ERROR");
			print "nokeyhere!!";
		break;
		case "KEYFORMEPLEASE":
			
			$ackthiskey="BGSERVERKEYREQUEST*$defaulturl*$ackthiskey";
			$headers[] = new HTTP_Header("BlooGeeRequest","USETHISKEY");
			//store $ackthiskey to sysdb as news
			//blockcommand
		break;
		case "ACKKEY":
			//store  key sent by remote host based on request "KEYFORMEPLEASE".
			//should be 'auto||manual' action from shell
		break;
		case "DOCOMMAND":
			//if $a->isvalidcommand do the query; else return header NEEDKEY
			// $query=
			$var=$r->request['BGDOCOMMAND'];
			print "<hr>$var<hr>";
			$headers[] = new HTTP_Header("BlooGeeRequest","ACK");
			require_once("bgserver.php");
		break;
		case "ERROR":
			//write to sysdb
			die (" &Xi; invalid request header.");
		break;
		default: 
			$headers[] = new HTTP_Header("BlooGeeRequest","ERROR");
		break;
	}
	$headers[] = new HTTP_Header("BlooGeeServerPage",$bgserverpage);
	return $headers;
}
/**
* constructs the main HTTP object from classfile class.HttpConnection.inc.
* used by bgeserver to respond to bg requests from other servers.
* @purpose communication between BGs by HTTP headers.
* @devstate stable
*/
function dohttprequest($headers, $httphost, $httpfile){
	$req = new HTTP_Request("GET", "$httpfile", "HTTP/1.0", $headers);
	$con = new HTTP_Connection("$httphost");
	$con->m_debug = "TRUE";
	$con->Connect(); 
	$con->Request($req);
	$con->Response($res);
	$con->Close(); 
	$hometext = $res->GetEntityBody();
	return $hometext;
}

/**
* return TRUE if calling SERVER is in blacklist; FALSE if not.
* @purpose communication between BGs by HTTP headers.
* @devstate dummy
*/
function blacklist($httphost){
	//check if remote $defaulturl or parts of it are in blacklist
	//if "TRUE" 
	//return TRUE; //is in blacklist
	//if FALSE
	return FALSE; //not in blacklist
}
/**
* return TRUE if SERVER key is valid FALSE if not.
* @purpose communication between BGs by HTTP headers.
* @devstate dummy
*/
function checkserverkey($defaulturl, $keytocheck){
	//from sysdb
	//if ok 
	return TRUE;
	//else return FALSE;
}
/**
* generate a new key for the calling SERVER
* @purpose communication between BGs by HTTP headers.
* @devstate dummy
*/
function generateserverkey($url){
	//generate new key
	//write to db
	return $newkey;
}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>