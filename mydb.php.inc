<?php
/** 
* main database abstraction layer
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
* @todo fix bug zero response
*/
////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////
//////// Simple Command API for plugins.... //////////////////////
/*  BlooGee Version 0.00d

including ::UPDATE:: command !!!!!

	!!!DO NOT USE ON NETWORKS OR THE WEB!!!!


    wrapper	for MT/Nuke/* style tbl_entries, MySql.
*/
////////////////////////////////////////////////////////////
//requirements moved
///////////////////////////////////////////////////////////////////
/*
provide a translation table and command::parameter::options interface
for plugins -> data: the MCO datasource connector.
 */
////////////////////////////////////////////////////////////////////////////
	 			// ascend, descend = options[0]!!
				// sortfield id,title, text, relatives = options[1]!!
				// myvars = options[2]!!!
			 	//	scheme "COMMAND::param::opt1,opt2,opt3"
////////////////////////////////////////////////////////////////////////////
require_once("mydbconfig.inc.php");
define('ADODB_ASSOC_CASE', 2); 
include("lib/adodb/adodb.inc.php");	 
$t = array(
 	"LASTN"=>"select entry_id, entry_title, entry_text, entry_pinged_urls, entry_created_on
		from mt_entry", //push to $fieldset in configfile
	"FIRSTN"=>"select entry_id, entry_title, entry_text, entry_pinged_urls, entry_created_on
		from mt_entry asc limit 0,", #depr.
	"ITEMNO"=>"select entry_id, entry_title, entry_text, entry_pinged_urls, entry_created_on
		from mt_entry where entry_id  ",
	"SEARCH"=>"select entry_id, entry_title, entry_text, entry_pinged_urls, entry_created_on
		from mt_entry where ",
	"GETRELATIVES"=>"select entry_id, entry_title, entry_text, entry_pinged_urls, entry_created_on
		from mt_entry where ",
	"UPDATE"=>"update mt_entry ",
	"INSERT"=>"insert into bgmessages ",
	"SUBMITTED"=>"select entry_id, entry_title, entry_text, entry_pinged_urls, entry_created_on, 
		entry_created_by, entry_text_more from bgmessages",
	"SERVERLIST"=>"select  entry_title  from bgmessages",
	/*	"SERVERLIST"=>"select entry_title, entry_id, entry_text, entry_pinged_urls, entry_created_on, 
		entry_created_by, entry_text_more from bgmessages", */
	"MOVE"=>"select entry_id, entry_title, entry_text, entry_pinged_urls, entry_created_on, 
		entry_created_by, entry_text_more from bgmessages where ",
	"ascend"=>"asc",
	"descend"=>"desc",
	"id"=>"entry_id",
	"date"=>"entry_created_on",
	"modified"=>"entry_modified_on",
"update"=>"entry_modified_on",
	"title"=>"entry_title",
	"text"=>"entry_text",
	"content"=>"entry_text",
	"relatives"=>"entry_pinged_urls",
	"created"=>"entry_created_on" # addded but not really working yet
);
////////////////////////////////////////////////////////////////////////////
function datasource($query) { 
	global $mbo, $t, $a, $maxresults,$defaultdatasource;
	list($command, $parameter, $options) = explode("::", $query);
	if ($options){list($opt1, $opt2, $opt3) = explode(",",$options);}
	
	switch ($command) {
		case "LASTN":
		/*
	usage: LASTN::(n)::(sort ascend|descend)::(sortfield id|title|text|relatives)
		i.e. "LASTN::7::descend,text,0"
		  */
		  $query = $t["$command"];
			if ($opt1){
				$opt1=$t[$opt1];
			}
			if ($opt2) {
			    $opt2=$t[$opt2];
			}
			//." limit 0,".$parameter
			$query.=" order by $opt2  $opt1"; // limit 0,".$parameter;
			$maxresults=$parameter;
		break;
		case "FIRSTN":
		/* INCOMPLETE NOW!!!!!!!!!
	usage: FIRSTN::(n)::(sort ascend|descend)::(sortfield)
		i.e. "FIRSTN::5::ascend,id,0"
		  TIDY THIS */
		$query = $t[$command].$parameter;
		break;
		case "ITEMNO":
    	/*
	usage: ITEMNO::(n)::(prefetch|expand),0,0
		i.e. "ITEMNO::2345"
		  */ /* pending: expand relatives!!!    */
		    $query = $t[$command]." = '".$parameter."'";// OR entry_title = '$parameter'";
		    $maxresults=1;
		break;
		case "SEARCH":
    	/*
	usage: SEARCH::(searchstring)::(sort ascend|descend),(sortfield),(max num)
		i.e. "SEARCH::weblogs::descend,text,99"
		  *//*  $query = "SEARCH::weblogs::descend,id,".$uri; */
		    if ($opt1){
				$opt1=$t[$opt1];
			}
			if ($opt2) {
				$opt2=$t[$opt2];
			$query = $t[$command]."((entry_title Like '%$parameter%') OR (entry_text Like '%$parameter%')
				OR (entry_pinged_urls  Like '%$parameter%')) order by $opt2 $opt1";// 
				$maxresults=$opt3;
			}
		break;
		case "GETRELATIVES":
        	/*
	usage: GETRELATIVES::(id|string)::(sort ascend|descend),(sortfield),(max num)
		i.e. "GETRELATIVES::weblogs::descend,text,99"
		  *//*  $query = "GETRELATIVES::$id::descend,sortfield,maxnum */
		    if ($opt1){
				$opt1=$t[$opt1];
			}
			if ($opt2) {
				$opt2=$t[$opt2];
			}
			$query = $t[$command]."((entry_title Like '%$parameter%') OR (entry_id Like '%$parameter%')
				OR (entry_keywords Like '%$parameter%')OR (entry_pinged_urls Like '%$parameter%'))
				order by $opt2 $opt1";//.$opt3;
				$maxresults=$opt3;
			/* $queryadd = add items from array own relatives!!! */
		break;
 		case "UPDATE":
    	/*
	usage:  UPDATE::(itemno)::(title|text|relatives),0,0
		i.e. "UPDATE::22341::title,text,99"
		  */
		    if ($opt1){
				$opt1=$t[$opt1];
				$opt2 = addslashes(unescapein($opt2));
  				$query = $t[$command]." SET $opt1='$opt2' WHERE entry_id='$parameter'";
				}
		break;
	 
	 case "INSERT":
	 if ($opt1){
			
			$parameter=$t[$parameter];
			$opt1 = addslashes(unescapein($opt1));
			global $r; $tmp=listarray($r);
			$query = $t[$command]." ($parameter,entry_created_by,entry_created_on, entry_text_more) VALUES('$opt1','$a->user',NOW( ),'$tmp')";
			}
	 break;

	 case "SUBMITTED":
	 $opt1=$t[$opt1]; // sortfield
	 $opt2=$t[$opt2]; //descend, ascend
	 //$parameter is number of entries
	 // i.e. news 15 date ascending or SUBMITTED::10::date,ascend,relatives
	 $query = $t[$command];
	 if(@$opt3){
	 $query.=" WHERE entry_title LIKE '".$opt3."%' ";
	 }
	 $query.=" ORDER BY $opt1 $opt2";// LIMIT 0,$parameter";
	 $maxresults=$parameter;
	 break;
	 
	 case "SERVERLIST":
	 $opt1=$t[$opt1]; // sortfield
	 $opt2=$t[$opt2]; //descend, ascend
	 //$parameter is number of entries
	 // i.e. news 15 date ascending or SUBMITTED::10::date,ascend,relatives
	 $query = $t[$command];
	 $query.=" WHERE entry_title LIKE 'BGSERVERQUERY%' GROUP BY entry_title ";
	 
	 $query.=" ORDER BY $opt1 $opt2";// LIMIT 0,$parameter";
	 $maxresults=$parameter;
	 break;
	 
	 case "MOVE":
		$query = $t[$command]." = '".$parameter."'";
	break;
	}
	
	/////////////////////////////////////////////////////////////
	//print $query; //die;
	///////// the real db thing ///////////////////////////////////
	

	global $mydbtype,$mydbuser,$mydbpwd,$mydbhost,$mydatabase;
	$dsn = $mydbtype."://".$mydbuser.":".$mydbpwd."@".$mydbhost."/".$mydatabase; 
	$db = NewADOConnection($dsn);
	$db->debug = false;
	if (!$db) die("Connection failed");  
	
	if  ($command=="UPDATE"){
		$db->Execute($query);
		 return stripslashes($opt2);
	}
	if  ($command=="INSERT"){
		$db->Execute($query);
		return stripslashes($opt1);
	}
		
	$rs = $db->SelectLimit($query, $maxresults);
	$db->SetFetchMode(ADODB_FETCH_NUM);
	$num = $rs->RecordCount();
	//print $num; die;
	$rs->MoveFirst();
	if (!$rs) {print $db->ErrorMsg();}

	if($command=="SUBMITTED"){
	/*	entry_id, entry_title, entry_text, entry_pinged_urls, 4entry_created_on, 
		5entry_created_by from bgmessages", */
		$tmp="data 4 u: ";
		//print $num; die;
		if ($num < 1){MCOErrorObject($mbo);}
		if ($num >=1) {
		$array = $rs->GetArray();
		$i=0;
		foreach($array as $k => $row) {
		//while ($row = $rs->GetRows()){
			$tmp="&Xi; data 4 u: submitted by  $row[5] on $row[4]. DATA: $row[6]<br>"; 
			$mbo->relatives[$i] = array($row[0],$row[1], $tmp.$row[2], $row[3], $row[4]);
			$i++;
		    }
		}
		return;
	}
	if($command=="SERVERLIST"){
	/*	entry_id, entry_title, entry_text, entry_pinged_urls, 4entry_created_on, 
		5entry_created_by from bgmessages", */
		//print $num; die;
		//if ($num < 1){MCOErrorObject($mbo); return;}
		if ($num >=1) {
		$array = $rs->GetArray();
		$i=0;
		foreach($array as $k => $row) {
			//$tmp="&Xi; data 4 u: submitted by  $row[5] on $row[4].<br>";
			$mbo->relatives[$i] = $row[0];
			$i++;
		    }
		}
		return;
	}
	
	if($command=="MOVE"){
	$array = $rs->GetArray();
	foreach($array as $k => $row) {
		//select entry_id, entry_title, entry_text, entry_pinged_urls, entry_created_on, entry_created_by, entry_text_more from bgmessages
			$tmp="&Xi; data 4 u: submitted by  $row[5] on $row[4]. DATA: $row[6]<br>"; 
			$mbo->relatives[$i] = array($row[0],$row[1], $row[2], $row[3], $row[4], $row[5],$row[6] );
			$dbn = NewADOConnection($dsn);
			$dbn->debug = false;
			if (!$dbn) die("Connection failed");
			$row=$mbo->relatives[0];
			print listarray($row); die;
			$query="INSERT INTO mt_entry (entry_id, entry_title, entry_text, entry_pinged_urls, entry_created_on, entry_created_by, entry_text_more) VALUES ('$row[0]','$row[1]', '$row[2]', '$row[3]', '$row[4]', '$row[5]','$row[6]')";
			$dbn->Execute($query);
			return;
		}
	}
	
	if ($num < 1){MCOErrorObject($mbo);}

	if ($num >= 1) {
	    $i=0;
	    $array = $rs->GetArray();
	    foreach($array as $k => $row) {
		$mbo->relatives[$i] = array($row[0],$row[1], $row[2], $row[3], $row[4]);
		$i++;
	    } 
	}
}

function unescapein($in) {
	$out = eregi_replace("##--##--##",",",$in);
	return $out;
}
/*************************************************
/ BlooGee Version 0.00c                          /
/ all rights reserved, copyrights M.C. Koch 2006 /
*************************************************/
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>