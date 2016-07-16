<?
/** 
* HTTP communications between BG servers
* constructs HTTP headers and request
* used as shellcommand
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
*/
/**
* external file class.HttpConnection.inc
*/
require_once("class.HttpConnection.inc");

class askbgserver {
	var $hometext;
	function checkthis($httphost, $httpfile, $bgrequest,$a) {
	global $relatives;
		$headers[] = new HTTP_Header("Accept", "image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*");
		$headers[] = new HTTP_Header("User-Agent", "BlooGee; PHPonLinux;");
		$headers[] = new HTTP_Header("Host", $_SERVER['HTTP_HOST']);
		$headers[] = new HTTP_Header("Referer", $_SERVER['PHP_SELF']);
		$headers[] = new HTTP_Cookie_Header("BlooGeeUser", $a->user);
		$headers[] = new HTTP_Header("BlooGeeRequest", "$bgrequest");
		$headers[] = new HTTP_Header("BlooGeeServerList", "$relatives");
		$headers[] = new HTTP_Header("BlooGeeClientKey", "$bgrequest");
		$headers[] = new HTTP_Header("BlooGeeUserSite", "$bgrequest");
		$req = new HTTP_Request("GET", "$httpfile", "HTTP/1.0", $headers);
		$con = new HTTP_Connection("$httphost");
		$con->Connect(); // open a connection to server
		$con->Request($req); // send request
		$con->Response($res); // creates a response obj read from server
		$con->Close(); // close connection to server
		$hometext = $res->GetEntityBody();// echo entity body from response (file contents)
		return $this->hometext= $hometext;
	}
}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>