<?php
/** 
* main security 
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
* @todo extend valid commands with shell commands, esp. commandtemplate
*/
class security {
	var $id;
	var $user;
	var $config;
	var $query;
	var $command;
	var $commandparams;
	var $commandoptions;
	var $commandrule;
	var $currentuserrule;
	var $isadmin;
	var $isvalidcommand;
	var $validshellcommands;
	var $validuricommands = array ( // => default behaviours!
	    "SEARCH" => "READ", "LASTN" => "READ",
	    "UPDATE" => "WRITE", "SECURITY" => "WRITE",
	    "ITEMNO"  => "READ", "GETRELATIVES"  => "READ",
	    "INSERT" => "MORE", "SUBMITTED"=>"WRITE", "MOVE"=>"WRITE",
      "SERVERLIST"=>"MORE"
 	);
 	var $validitemcommands = array (
	    "SEARCH", "SECURITY", "ITEMNO", "GETRELATIVES"
 	);
 	function checkquerystring($string) {
	 	if ($_SERVER["QUERY_STRING"]||$string){
	 	    //print $_SERVER["QUERY_STRING"]; //die;
	 	    if ($string == "1") {$string = $_SERVER["QUERY_STRING"];}
		    @list($command, $commandparams, $commandoptions) = explode("::",$string);
		    if (array_key_exists($command, $this -> validuricommands)) {
		 		$this -> query = ereg_replace('[\']', '', $string); //workaround: all apostrophes get lost...
		 		$this -> command = $command;
		 		$this -> commandparams =$commandparams;
		 		$this -> commandoptions = $commandoptions;
		 		///move to function checkrules!
		 		$defaultcommandrule=$this -> validuricommands[$command];
		 		$defaultcommandrule=$this -> rules[$defaultcommandrule];
		 		$this -> commandrule = $defaultcommandrule;
		 		$currentuser= $this -> user;
		 		$currentuserrule = $this -> usergroups[$currentuser];
		 		$currentuserrule = $this -> rules[$currentuserrule];
		 		$this -> currentuserrule = $currentuserrule;
				if ($this -> currentuserrule >= $this -> commandrule){
					$this -> isvalidcommand = TRUE;
					//print " A valid command for user".$this->user;
					return TRUE;
					} else {
				    //print "You have no rights for this request.";
				    $this -> isvalidcommand = FALSE;
				    print "<span class=\"noadmin\"> An invalid command: ".$_SERVER["QUERY_STRING"]." from user ".$this->user."</span>";
				    return FALSE;
				} /// s.a.

			} else {
			    $defaultcommandrule = "READ";
			    $defaultcommandrule=$this -> rules[$defaultcommandrule];
		 		$this -> commandrule = $defaultcommandrule;
		 		$currentuser= $this -> user;
		 		$currentuserrule = $this -> usergroups[$currentuser];
		 		$currentuserrule = $this -> rules[$currentuserrule];
		 		$this -> currentuserrule = $currentuserrule;
			    @$uri = strip_tags($uri);
			    @$uri = ereg_replace('[\,\/\'\%\@\?\$\*\:]', '', $uri);
			    if (ctype_alnum($uri)){
	          	    $this -> query = $uri;
	          	    $this -> isvalidcommand = FALSE;
	          	    return TRUE;
			    } else {
					$this -> query =  $uri . " is shit.";
					$this -> isvalidcommand = FALSE;
					return FALSE;
			    }
			}
		} else { //no querystring
	 		$currentuser=$this->user;
	 		if ($currentuser!=""){
		 		$currentuserrule = $this -> usergroups[$currentuser];
		 		$currentuserrule = $this -> rules[$currentuserrule];
		 		$this -> currentuserrule = $currentuserrule;
		 		return TRUE;
	 		} else {
	 		    global $defaultgroup;
	 		    $currentuser = $defaultgroup;
			}
		}
 	}
	var $rules = array( //defaults for items
	    "PISSOFF"=>"0",
	 	"READ"=>"1",
	 	"WRITE" => "5",
		"REGISTERUSER" => "5", // only new user registration
		"MORE" => "3" //NN
 	);

	var $usergroups = array ( // defaults for user groups
	    "PUBLIC" => "READ",
	    "anonymous" => "READ",
	    "AUTHORS" => "WRITE",
	    "REGISTERED" => "MORE" //NN
	);
	
	function identifyuser() {
	    global $defaultuser, $defaultuserrule, $commandkeyvalid, $loginretry, $usercommandlevel, $defaultgroup, $r;
    	@$user = $_COOKIE["username"]; if ($user==""){$user=$defaultuser;
      if (!$r->request["BGREQUEST"]){
        setcookie("username", $user, time()+$commandkeyvalid);}
      }
/*         @$level = $_COOKIE["usrcommandlevel"]; if ($level!=""){$level=$defaultuserrule;
			setcookie("usrcommandlevel", $usercommandlevel, time()+$commandkeyvalid);}; */
		@$level=$defaultuserrule;
        @$pwdkey = $_COOKIE["userpwd"]; if ($pwdkey==""){$pwdkey=0;
        if (!$r->request["BGREQUEST"]){
          setcookie("userpwd", 0, time()+$commandkeyvalid);};
        }
        @$retry = $_COOKIE["retry"]; if ($retry==""){$retry = 0;
        if (!$r->request["BGREQUEST"]){
          setcookie("retry", $retry, time()+$commandkeyvalid);};
        }
      if ($user!=$defaultuser) {
			$ack = validatekey($user,$pwdkey);
        	if ($ack>0) {

		    	$this->usergroups[$user] = $ack;
		    	$this->rules[$ack] = $ack; $this->user = $user;
		    	$this->currentuserrule = $ack;
          ////////////////////////////////////////////
			    if ($this->user == "mck")	{$this -> isadmin = "ADMIN";} // temp.... array => admins in configfile
          else  {$this -> isadmin = $user;} // dummy: admin
        	} else {
        	    //       	    print "this is ".$ack;
        	    $this->user = $defaultgroup; 
        	    global $defaultcommandlevel;
        	    $this->currentuserrule= $defaultcommandlevel;
          if (!$r->request["BGREQUEST"]){
        	    setcookie("username", $user, time()+$commandkeyvalid);
        	    setcookie("usrcommandlevel", $usercommandlevel, time()+$commandkeyvalid);
        	    setcookie("userpwd", 0, time()+$commandkeyvalid);
            }
        	}
		} else {
		    $this->user = $defaultgroup;
		}
	}

	function getcommand($command) {
		$this-> command = $command;
		return;
	}

	function getvalidshellcommands($shellconfigfile){
	require_once($shellconfigfile);
	    $this->validshellcommands=$validshellcommands;
	    return;
	}


///////// UNASSIGNED /////////////////////


	function UAnewuser($uid,$key, $uname) {
	    $query = "USER::$uid::$key, insert,(unused)";
	    $query .= datasource($query);
	    return $query;
	}
	
	function UAlogonuser($user, $key) {
        $query = "USER::$uid::$key, lookup,(unused)";
         $query .= datasource($query);
	    return $query;
	}
	
	function UAlogoffuser($user, $key) {
	    return "logged off... or not. Don't know yet.";
	}
	
	function UAstoresession() {
		//redirect to client javascript!!!
	}

}

function validatekey($usr, $key) { //still specific for mysql, sysdb!!!
	    global $dbhost, $dbuser, $dbpwd, $database;
        $dbi = mysql_connect($dbhost, $dbuser, $dbpwd);
		if (!$dbi) {die("<h3>connecting...</h3>is nich");
		}
		mysql_select_db($database, $dbi);
		if (mysql_errno()) {die(mysql_errno().mysql_error());}
		$query = "SELECT validid, commandlevel FROM mt_author WHERE author_name
		= \"$usr\" LIMIT 1";
		$dbkey = mysql_query($query, $dbi);
		$row = mysql_fetch_row($dbkey);
		$dbkey = $row[0];
		$commandlevel = $row[1];
		mysql_close($dbi);
		if ($key == $dbkey){/* print $dbkey; */ return $commandlevel;} else return FALSE;
	}
//////////////////////////////////////////
///// init
////
 //   
global $a;
$a = new security;require_once("clientinfo.php");
$a -> identifyuser();
$a -> checkquerystring("1");
$a -> getvalidshellcommands($shellconfig);
//require_once("debug.php");
 //die;
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>
