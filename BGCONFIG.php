<?php
/** 
* main configuration file for BlooGee.
* configures BlooGee's default behaviours
* @version 0.00f public
* @devstate pre-beta
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @deprec user admission BG only, main datasource in mydbconfig.inc.php!!
* note: not used in this version; db config will be found in mydb.config.inc
* since BG uses only ONE db for data and system!!
* @todo clean up vars, clean up db usage.
* @filesource
*/

$configfile=$_SERVER["PHP_SELF"];
$shellconfig="command.config.inc";
/**
*@return dbuser
*/
$dbuser ="root";
$dbpwd = "";
$dbhost = "localhost";
$database = "bloggern";
$usertable = "bguser";
$maxresults=99;
$maxserverlist=25;
$sysdb="bgsysdb.php.inc";
//
$defaultuser ="anonymous";
$defaultgroup = "PUBLIC";
$defaultuserrule = "READ";
$defaultcommandlevel = 0; //if '0' no access for anonymous!
$defaultcommandrule = "MORE";
//
$defaulturl ="http://laurel.home.mck/"; 
$defaultlanguage = "en"; //NN
$defaultwrapper = "sortable.wrapper.inc.php";
$defaultdatasource = "mydb.php.inc";
$defaultplugin = "BGdefault_plugin.inc.php";
$defaultjs="BGdefault.js.php";
//
$viewports = "BGdefault_viewports.inc.php"; //NN
$defaultviewport ="listformat"; //NN, into commandparameter[new]
//
$editpage="edit.php";
$searchpage="search.php";
$loginpage="user.php";
$jsincpath=""; //NN for prototype etc -> JS//set absolute url!
$plugindir="";//NN, for shell.
/**
*  23 starts debug pane, other values don't mean a thing for now.
*/
$debuglevel="21"; 
//(E_ERROR | E_WARNING | E_PARSE | E_NOTICE | E_ALL,0);
error_reporting(E_ALL);
$loginretry="2";
$commandkeyvalid="3600";
$usercommandlevel="1"; //for cookies only
$submitterimage="images/save.gif";
$loggedinclass = "loggedin";
$knownuserclass = "knownuser";
$anonymousclass = "anonymous";
$loggedinclass = "loggedin";
//
$bgversion = "0.00f public";
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>