<?php
/** 
* in-place edit page for single elements of items only!!!
* no extended doc for now.
* @version 0.00f public
* @devstate stable
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage helper
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @filesource
*/
/**
*/
include "BGCONFIG.php";
require_once("mbo.class.php");
require_once("security.php.inc");
//require_once("libs.php.inc");
$id = $_POST['id'];
$element =$_POST['element'];
$updatestring =escapein($_POST['updatestring']);
/**
* makes submitted string suitable for db 
* @todo replace by better & more secure filter
*/
function escapein($in) {
	$out = eregi_replace(",","##--##--##",$in);
	//$out = htmlentities($in);
	return $out;
}
global $a;
/**
* @todo require better security so users may use this ;-)
*/
if ($a->isadmin == "ADMIN"){
	$a->getcommand("UPDATE"); require_once("mydb.php.inc");
	$query = "UPDATE::$id::$element,$updatestring,0";
	$query=datasource($query);
	print "<span class=\"loggedin\">changed by ".$a->user.": </span>".$query;
}
else { print "<span class=\"noadmin\">no admin, no edit. unchanged: </span>".$_POST['updatestring'];
	//require_once("debug.php");
	}
die;
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>