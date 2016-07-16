<?
/** 
* construct HTTP request headers and make request
* no extended doc for now.
* @version 0.00f public
* @devstate  working 
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage plugin
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/
error_reporting(0);
require_once("class.HttpConnection.inc");

function makeheaders($httphost, $httpfile, $bgrequest,$debug) {
global $bgversion,$a,$defaulturl, $serverlistout;
	$headers[] = new HTTP_Header("Accept", "image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*");
	$headers[] = new HTTP_Header("User-Agent", "BlooGee $bgversion; PHPonLinux;");
	$headers[] = new HTTP_Header("Host", $_SERVER['HTTP_HOST']);
	$headers[] = new HTTP_Header("Referer", $_SERVER['PHP_SELF']);
	$headers[] = new HTTP_Header("BlooGeeRequest", "$bgrequest");
	$headers[] = new HTTP_Header("BlooGeeServerList", "$serverlistout");
	$headers[] = new HTTP_Header("BlooGeeClientKey", $a->user);
	$headers[] = new HTTP_Header("BlooGeeUserSite", "$defaulturl");
	$req = new HTTP_Request("GET", "$httpfile", "HTTP/1.0", $headers);
	$con = new HTTP_Connection("$httphost");
	$con->m_debug = $debug;
	$con->Connect(); // open a connection to server
	$con->Request($req); // send request
	$con->Response($res); // creates a response obj read from server
	$con->Close(); // close connection to server
	$hometext = $res->GetEntityBody();// echo entity body from response (file contents)
	return $hometext;
}
////////////////////
/* $httphost="laurel02.home.mck";
$httpfile="/index.php";
$bgrequest="QUERYLIST::233::0,0,0";
$debug="TRUE";*/
////////////////////
require_once($defaultdatasource);
require_once($viewports);
$query="SERVERLIST::$maxserverlist::date,descend,0";
$serverlistout= serverlistformat(datasource($query));
////////////////////
if ($var[4]=="TRUE"){print htmlentities(makeheaders($var[1], $var[2], $var[3], $var[4]));}
else {print makeheaders($var[1], $var[2], $var[3], $var[4]);}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>