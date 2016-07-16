<?php
/** 
* plugin for bloogee vt100 etc.
* produces one of 49 "wisdoms" or anything filled in it's db table. based on old version for PHP/Postnuke.
* counts reloads & requests; sets cookie.
* no extended doc for now.
* @version 0.00f public
* @devstate stable but dirty
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage plugins
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @todo rewrite to work with ADODB & sytem config!
*/

######## START MAIN ############################################################

error_reporting(0);
$murphyversion="0.0c";
$murphydescription="murphy plugin";
$maxmurphy=49; # max Sätze definieren;
$isplugin = TRUE; //NN!
$iscontroller=FALSE; // NN full...
$murphyblock=@$_GET['print'];
#$murphyblock=FALSE;  # to config!
$murphycookievalid=time()+3600000; # Gültigkeit Cookie 1000h.
$murphytable="bgmurphy_en";
if ($murphyblock==TRUE){
	require_once("BGCONFIG.php");
	require_once("libs.php.inc");
	handlemurphycookie();
    print makemurphy();
}
######## END MAIN ############### no need to change below this! ################

function makemurphy(){
	$murphyvar=handlemurphycookie();
	return murphyslaw($murphyvar);
}

function handlemurphycookie() {
    global $maxmurphy, $murphyvar;
    if (!isset($_COOKIE["murphycookie"])){
           $murphyvar=1;
           murphycookie($murphyvar);
       }
        else {
            if (($_COOKIE["murphycookie"])>=$maxmurphy) {
                $murphyvar=1;
                murphycookie($murphyvar);
            }
            else {
                $i=($_COOKIE["murphycookie"]);
                $murphyvar=$i+1;
                murphycookie($murphyvar);
            }
	    return $murphyvar;
	}
}

function murphyslaw($murphyvar) {
       global $dbhost, $database, $dbuser, $dbpwd, $murphyblock, $prefix, 
	       $murphytable,$murphydescription, $murphyversion;
    $mlink = mysql_connect($dbhost, $dbuser, $dbpwd);
    mysql_select_db($database, $mlink);
    $mresult = mysql_query("SELECT * FROM $murphytable where ID=".$murphyvar, $mlink);
    $mrow = mysql_fetch_object($mresult);
    $mlaw=$mrow->law;
    $mlaw= "<span class=\"murphy\">".$mlaw."</span><span class=\"murphysystem\">
		 [$murphydescription $murphyversion]</span>";
    mysql_free_result($mresult);
    return $mlaw;
}

function murphycookie($murphyvar) {
         global $murphycookievalid;
         setcookie("murphycookie", $murphyvar, $murphycookievalid);
}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>