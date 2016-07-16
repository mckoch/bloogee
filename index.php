<?php
/**
* main file to keep things together ;-).
* may be renamed or copied under different filenames.
* @version 0.00f public
* @devstate stable
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright M.C. Koch 2006
* @license GNU General Public License  http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @filesource
*/
/**
* requirements to start BlooGee core
*/
include "BGCONFIG.php";
include "mbo.class.php";
include "security.php.inc";
include "libs.php.inc";
/**
* main procedure       
*/
//////////////////////////////////////////////////////////
bginit();
global $a, $defaultplugin;
if (@$_SERVER['HTTP_BLOOGEEREQUEST']){
	$var=$_SERVER['HTTP_BLOOGEEREQUEST'];
	require_once("serverprotocol.php");
	die;
}
if ($a-> isvalidcommand){
	require_once($defaultdatasource);
	datasource($a-> query);
	include $defaultwrapper;
} else {
	include $defaultplugin;
	include $defaultwrapper;
}
bgexit();
die;
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
?>