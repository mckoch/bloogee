<?
/** 
* produce a log from BlooGee system db
* configure to preferred log style
* no extended doc for now.
* @version 0.00f public
* @devstate working
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage plugin
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @todo cleanup
*/
/**
* requirements
*/
include "BGCONFIG.php";
require_once("mbo.class.php");
require_once("libs.php.inc");
require_once("security.php.inc");
require_once($defaultdatasource);
require_once($viewports);
$thisserverlist=4;
//$query="SERVERLIST::$thisserverlist::date,descend,BGQUERY";
//querylistformat serverlistformat
//$query="SERVERLIST::$thisserverlist::date,descend,BGBLACK";
//$query="SERVERLIST::$thisserverlist::date,descend,BGSERVER";
//  $query="SERVERLIST::$thisserverlist::date,descend,BG";
print "<span class=\"loggedin\">latest $thisserverlist server events</span><br>";

//print serverlistformat(datasource($query));
//   print querylistformat(datasource($query));
$query="SUBMITTED::$thisserverlist::date,descend,BG";
print itemformat2(datasource($query),'serverlist', 'collapsed')
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>