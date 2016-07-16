<?php
/** 
* helper file to display objeczs etc. regarding the current request.
* include in page if required, set errorlevel to >23 (in BGCOFIG.php).
* no extended doc for now. needs scriptaculous; or remove style=\"display:none;\"
* @version 0.00f public
* @devstate unknown
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bghelper
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/
/**
* $debuglevel=23 starts debug output and sets error_warning(E_ALL)
*/
if ($debuglevel > 22) {
    error_reporting(E_ALL); # Set error reporting to highest level
	$errorid = uniqid(time());

print "<hr>DEBUG<hr>";
print "<a href=\"#\" onclick=\"Effect.toggle('debugpane','appear'); return false;\">APPLICATION</a>
<div id=\"debugpane\" style=\"display:none;\" >";
print "required files: ".listarrayrecurse(get_required_files());
$array = get_declared_classes();
global $cm;
foreach ($array as $key => $val) {
		$cm[$val]['methods: '] =get_class_methods($val);//.get_class_vars($val);
		$cm[$val]['variables'] =get_class_vars($val);
}
print "objects and classes: ";
print listarray2($cm);
print "declared variables: ".listarrayrecurse(get_defined_vars());
print "cookies: ".listarrayrecurse(session_get_cookie_params());
print "</div>";
print "<a href=\"#\" onclick=\"Effect.toggle('debugpaneserver','appear'); return false;\">SERVER</a>
<div id=\"debugpaneserver\" style=\"display:none;\" >";
print "Array \$_SERVER: ".listarrayrecurse($_SERVER);
print "Array \$_REQUEST: ".listarrayrecurse($_REQUEST);
print "Array \$_COOKIE: ".listarrayrecurse($_COOKIE);
print "</div>";
} else {
    error_reporting(0);

}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>
