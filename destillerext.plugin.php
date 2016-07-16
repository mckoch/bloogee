<?php
/** 
* Text & Link Destiller V0.3 for BlooGee command shell
* Seperates text and links from a given URL, records queries and
* computes a score for relative density of information :-). With a nice
* high score list; display by host for registred members, one-click-delete
* from database for admins. 
* stand-alone version for BlooGee
* @version 0.00f public
* @devstate unknown
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage plugin
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/
$version="0.00c";
$destillerextheader="<span class=\"terminalheader\"><p>
	******************************<br>
	 &Xi; destillerext V. $version        <br>
	 &Xi; @$defaulturl<br>
	******************************<br>
	</p></span>

";


$destillerexthelp="returns links contained in external websites 
and produces a nice entropic factor (see destiller). <br>
usage: 'destillerext www.somethite.org /somepath/page.html'.<br>
notice: input no preceeding http. make sure to seperate host fom path with blank.";


require_once("class.HttpConnection.inc");
error_reporting(0);
//$httphost=$_GET['url'];
// usage: 'print destillermain("www.localhost.ak","/index.php")';

// language
define ("_DEST_TEXTFOUND", "gefundener Text");
define ("_DEST_LINKSFOUND", "gefundene Links");
define ("_DEST_LINKSFOUNDTEXT01"," Links gefunden. Von ");
define ("_DESTLINKSFOUNDTEXT02"," Zeichen Quelltext blieben ");
define ("_DESTLINKSFOUND03"," Zeichen lesbarer Text übrig. Die berechnete <b>relative Informationsdichte</b> (Score) für die untersuchte Seite ");
define ("_DEST_LINKSFOUND04"," beträgt ");
define ("_DEST_LINKSFOUND05",".");

function unhtmlentities($string) {
	$trans_tbl = get_html_translation_table (HTML_ENTITIES);
	$trans_tbl = array_flip ($trans_tbl);
	return strtr ($string, $trans_tbl);
}

# GET URL FROM REMOTE HOST (from doc of class package)
function checkthis($httphost, $httpfile) {
			$headers[] = new HTTP_Header("Accept", "image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, */*");
			$headers[] = new HTTP_Header("User-Agent", "Destiller/0.2b (compatible; http://bloggern.de/destiller.php; PHPonLinux;)");
			$headers[] = new HTTP_Header("Host", "$httphost");
			$headers[] = new HTTP_Header("Referer", "http://localhost/test");
			$req = new HTTP_Request("GET", "$httpfile", "HTTP/1.0", $headers);
			$con = new HTTP_Connection("$httphost");
			$con->Connect(); // open a connection to server
			$con->Request($req); // send request
			$con->Response($res); // creates a response obj read from server
			$con->Close(); // close connection to server
			$hometext = $res->GetEntityBody();// echo entity body from response (file contents)
	   return $hometext;
}

# function extractlinks() by http://nola.info/?view=SNIP&item=98 #
function extractlinks( $data ) {
   unset($location);
   $links = array();
   $links[] = array(); // the contents of the anchors (highlighted text // the URLs corresponding to each element of $links
   $pos = 0;
   $i = 0;
   while (!(($pos = strpos($data,"<",$pos)) === false)) {
      $pos++;
      $endpos = strpos($data,">",$pos);
      $tag = substr($data,$pos,$endpos-$pos);
      $tag = trim($tag);
      if (isset($location)) {  // look for a </A>
         if (!strcasecmp(strtok($tag," "),"/A")) {
            $link = substr($data,$linkpos,$pos-1-$linkpos);
            $links[][0] = strip_tags($link);
            $links[sizeof($links)-1][1] = $location;
            unset($location);
         }
         $pos = $endpos+1;
      } else {  // look for a <A ...>
         if (!strcasecmp(strtok($tag," "),"A")) {
            if (eregi("HREF[ \t\n\r\v]*=[ \t\n\r\v]*\"([^\"]*)\"",$tag,$regs));
            else if (eregi("HREF[ \t\n\r\v]*=[ \t\n\r\v]*([^ \t\n\r\v]*)",$tag,$regs));
            else $regs[1] = "";
            if ($regs[1]) {  // Only use it if it seems to be reasonable
               $location = $regs[1];
            }
            $pos = $endpos+1;
            $linkpos = $pos;
         } else {
            $pos = $endpos+1;
         }
      }
      $i++;
   }
   return $links;
}
#MAIN FUNCTION
function destillermain($httphost, $httpfile) {
	if ($httphost){
		$hometext = checkthis($httphost, $httpfile);
	}
	$links=extractlinks($hometext);
	$n1=strlen($hometext);
		if(strcmp('4.3', phpversion()) > 0) {
    	    /* PHP Ver. < 4.3.0 */
	    	    $hometext = unhtmlentities($hometext);
		        $hometext= htmlspecialchars(strip_tags($hometext));
    		} else {
			/* PHP Ver. >= 4.3.0 */
    			$hometext=htmlspecialchars(strip_tags(html_entity_decode($hometext)));
	}
	#$hometext=htmlspecialchars(strip_tags(html_entity_decode($hometext)));
	$n2=strlen($hometext);
	if (isset($links)) {
	$response ="";
		$response.= "<table cellspacing=\"25\"><tr>";
			//<td width=\"50%\" valign=\"top\"><h3>"._DEST_TEXTFOUND."</h3>$hometext</td>";
		$response.= "<td width=\"50%\" valign=\"top\"><h3>"._DEST_LINKSFOUND."</h3>";
		$i=0;
		foreach($links as $val) {
			if ($val[0]!==""){
				$response.= "<a href=\"".$baseurl;
				$response.= rtrim(($val[1]), "\\");
				#print_r($val[1]);
				$response.= "\">";
				$response.=($val[0]);
				$response.= "</a> $i| ";
				$i++;
			}
		}
		if ($i<1) {$i=1;}
		$rid=$n2/$n1*$i;
		//if (isset($httphost)){
		//	sql_query("INSERT INTO ".$prefix."_destiller VALUES ('$httphost','$httpfile','$i','$n1','$n2','$rid', NULL)", $dbi);
		//}
	}
		$response.="</td></tr></table>";
	if (isset($links)) {
		$response.= $i._DEST_LINKSFOUNDTEXT01.$n1._DESTLINKSFOUNDTEXT02.$n2._DESTLINKSFOUND03;
		if(!($httphost=="")){
			$response.= " <a href=\"http://$httphost/$httpfile\">http://$httphost$httpfile</a>";
		}
		$response.= _DEST_LINKSFOUND04.$rid._DEST_LINKSFOUND05;
		//averagescore();
	}
	return $response;
}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>