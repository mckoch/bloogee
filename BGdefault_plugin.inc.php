<?php
/** 
* Default plugin to produce blog style init page
* @version 0.00f public
* @devstate stable
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU  General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage plugin
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @filesource
*/
/**
* ascend, descend = options[0]!!
* sortfield id,title, text, relatives = options[1]!!
* maxnumber = options[2]!!!
* working COMMANDS: LASTN, ITEMNO, SEARCH, GETRELATIVES
* general usage: command::parameter::op0, op1, op2  (ALL options must be passed!)
*	usage: LASTN::(n)::(sort ascend|descend)::(sortfield id|title|text|relatives|date)
*		i.e. "LASTN::3::descend,text,0"
*
*	usage: ITEMNO::(n)::0,0,0
*		i.e. "ITEMNO::2345"
*
*	usage: SEARCH::(searchstring)::(sort ascend|descend),(sortfield),(max num)
*		i.e. "SEARCH::weblogs::descend,text,99"
*		  $query = "SEARCH::weblogs::descend,id,".$uri; 
*
*	usage: GETRELATIVES::(id|string)::(sort ascend|descend),(sortfield),(max num)
*		i.e. "GETRELATIVES::223::descend,text,99"
*		$query = "GETRELATIVES::$id::descend,id,".$uri;
*/
if ($a->isvalidcommand == FALSE){
	if ($a->currentuserrule >= $a->commandrule){
		require_once("mydb.php.inc");
		datasource("LASTN::22::descend,created,0");
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