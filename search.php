<?php
/** 
* controller for full text search  .
* usage: SEARCH::(searchstring)::(sort ascend|descend),(sortfield),(max num)
* i.e. "SEARCH::weblogs::descend,created,99"
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
* requirements
*/
include "BGCONFIG.php";
require_once("mbo.class.php");
require_once("libs.php.inc");
require_once("security.php.inc");

global $a;
if ($a->isvalidcommand){
	if ($a->command == "SEARCH"){ require_once("mydb.php.inc");
		$query = "SEARCH::".$a->commandparams."::".$a-> commandoptions;
		require_once($viewports);
		print itemformat(datasource($query),"thirdlist","collapsed");
	}
} else {print "sorry... no valid command in ".$_SERVER['QUERY_STRING']."!";}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>