<?php
/** 
* configuration file for mydb.php.inc
* makes use of ADODB abstarction library
* no extended doc for now.
* @version 0.00f public
* @devstate unknown
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @filesource
*/
//////////////////////////////////////////////////////
$mydbtype="mysql";
$mydbuser ="root";
$mydbpwd = "";
$mydbhost = "localhost";
$mydatabase = "bloggern";

//////////////////////////////////////////////////////
//include("lib/adodb/adodb-exceptions.inc.php"); 	
/*	$db = NewADOConnection($dsn);
	$db->debug = false;
	if (!$db) die("Connection failed");   
*/	//testme($db);
//////////////////////////////////////////////////////


function testme($db){
	$maxreturn=5;
$dsn = $dbtype."://".$mydbuser.":".$mydbpwd."@".$mydbhost."/".$mydatabase; 
$query="select * from mt_entry";
	$rs = $db->SelectLimit($query, $maxreturn);
	$db->SetFetchMode(ADODB_FETCH_NUM);
	if (!$rs) {print $db->ErrorMsg();}
	else{
	while (!$rs->EOF) {
		$fld = $rs->FetchField(16);
		$type = $rs->MetaType($fld->type);	
		if ( $type == 'D' || $type == 'T') {print $rs->fields[16].' '.$rs->UserDate($rs->fields[16],'d.m.Y h:m').'<BR>';}
		else {print $rs->fields[0].' '.$rs->fields[1].'<BR>';} 
		$rs->MoveNext();
	}
	dblistarray($rs);
	$rs->Close(); 
	$db->Close();
	}
}
function dblistarray($rs){
	$rs->MoveFirst();	
	print "<pre>";	
	print_r($rs->GetRows());	
	print "</pre>";
	//while (!$rs->EOF) {	var_dump($rs->fields);	print "<br>";$rs->MoveNext();}
	return;
	}

/*

GetRow($sql,$inputarr=false)
Executes the SQL and returns the first row as an array. The recordset and remaining rows are discarded for you automatically. 
If an error occurs, false is returned.

GetAll($sql,$inputarr=false)
Executes the SQL and returns the all the rows as a 2-dimensional array. The recordset is discarded for you automatically. 
If an error occurs, false is returned. GetArray is a synonym for GetAll.

DBDate($date)
Format the $date in the format the database accepts. This is used in INSERT/UPDATE statements; for SELECT statements, use SQLDate. The $date parameter can be a Unix integer timestamp or an ISO format Y-m-d. Uses the fmtDate field, which holds the format to use. If null or false or '' is passed in, it will be converted to an SQL null.
Returns the date as a quoted string.

DBTimeStamp($ts)
Format the timestamp $ts in the format the database accepts; this can be a Unix integer timestamp or an ISO format Y-m-d H:i:s. Uses the fmtTimeStamp field, which holds the format to use. If null or false or '' is passed in, it will be converted to an SQL null.
Returns the timestamp as a quoted string.

qstr($s,[$magic_quotes_enabled=false])
Quotes a string to be sent to the database. The $magic_quotes_enabled parameter may look funny, but the idea is if you are quoting a string extracted from a POST/GET variable, then pass get_magic_quotes_gpc() as the second parameter. This will ensure that the variable is not quoted twice, once by qstr and once by the magic_quotes_gpc.
Eg. $s = $db->qstr(HTTP_GET_VARS['name'],get_magic_quotes_gpc());
Returns the quoted string.

Quote($s)
Quotes the string $s, escaping the database specific quote character as appropriate. Formerly checked magic quotes setting, but this was disabled since 3.31 for compatibility with PEAR DB. 

Affected_Rows( )
Returns the number of rows affected by a update or delete statement. Returns false if function not supported.
Not supported by interbase/firebird currently

FieldCount( )
Returns the number of fields (columns) in the record set.

RecordCount( )
Returns the number of rows in the record set. If the number of records returned cannot be determined from the database driver API, we will buffer all rows and return a count of the rows after all the records have been retrieved. This buffering can be disabled (for performance reasons) by setting the global variable $ADODB_COUNTRECS = false. When disabled, RecordCount( ) will return -1 for certain databases. See the supported databases list above for more details. 
RowCount is a synonym for RecordCount.

PO_RecordCount($table, $where)
Returns the number of rows in the record set. If the database does not support this, it will perform a SELECT COUNT(*) on the table $table, with the given $where condition to return an estimate of the recordset size.
$numrows = $rs->PO_RecordCount("articles_table", "group=$group");

MetaType($nativeDBType[,$field_max_length],[$fieldobj])
Determine what generic meta type a database field type is given its native type $nativeDBType as a string and the length of the field $field_max_length. Note that field_max_length can be -1 if it is not known. The field object returned by FetchField() can be passed in $fieldobj or as the 1st parameter $nativeDBType. This is useful for databases such as mysql which has additional properties in the field object such as primary_key. 
Uses the field blobSize and compares it with $field_max_length to determine whether the character field is actually a blob.
For example, $db->MetaType('char') will return 'C'. 
Returns:
C: Character fields that should be shown in a <input type="text"> tag. 
X: Clob (character large objects), or large text fields that should be shown in a <textarea> 
D: Date field 
T: Timestamp field 
L: Logical field (boolean or bit-field) 
N: Numeric field. Includes decimal, numeric, floating point, and real. 
I:  Integer field. 
R: Counter or Autoincrement field. Must be numeric. 
B: Blob, or binary large objects. 
Since ADOdb 3.0, MetaType accepts $fieldobj as the first parameter, instead of $nativeDBType. 
*/
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>