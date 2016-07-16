<?
/** 
* provides object with basic client and request information
* main object is $r with array $request
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
if (connection_aborted()){}
if (headers_sent()){}

class Request {
	var $request;
	function r($r){
		$this->request=$r;
	}
	function makerequestarray(){
	$r = array("REQUEST_METHOD"=>
		$_SERVER['REQUEST_METHOD'],
		"BGREQUEST"=>substr(@$_SERVER['HTTP_BLOOGEEREQUEST'],0,99),
		"BGSERVERLIST"=>@$_SERVER['HTTP_BLOOGEESERVERLIST'],
		"BGDOCOMMAND"=>@$_SERVER['HTTP_BLOOGEEDOCOMMAND'],
		"BGREMOTEPAGE"=>@$_SERVER['HTTP_BLOOGEESERVERPAGE'],
		"QUERY_STRING"=>@$_SERVER['QUERY_STRING'],
		"DOCUMENT_ROOT"=>$_SERVER['DOCUMENT_ROOT'],
		"HTTP_USER_AGENT"=>@$_SERVER['HTTP_USER_AGENT'],
		"REMOTE_ADDR"=>@$_SERVER['REMOTE_ADDR'],
		"HTTP_CONNECTION"=>@$_SERVER['HTTP_CONNECTION'],
		"HTTP_HOST"=>@$_SERVER['HTTP_HOST'],
		"SCRIPT_NAME"=>@$_SERVER['SCRIPT_NAME'],
		"REQUEST_URI"=>@$_SERVER['REQUEST_URI'],
		"PHP_SELF"=>@$_SERVER['PHP_SELF'],
		"REFERER"=>@$_SERVER['HTTP_REFERER'],
		"_REQUEST"=>@$_REQUEST
		);
	$this->request = $r;
	}
}
$r = new Request;
$r->makerequestarray();
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>