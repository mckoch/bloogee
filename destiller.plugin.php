<?php
/** 
* Text & Link Destiller.
* seperates text and links if given an url, produces nice factor for "relative density of information"
* test with your site...
* based on standalone version.
* no extended doc for now.
* @version 0.00f public
* @devstate stable but has to be reworked
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage plugins
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* todo clean up constants, translate, create mco instead of table
*/
define ("_DESTILLER", "Text und Link Destiller V 0.3e");
define ("_DEST_EXPLAIN", "Befreit Seiten vom Layout und lässt nur Fliesstext und eine Liste der enthaltenen Links übrig.	Dazu wird ein <b>Koeffizient der relativen Informationsdichte als Score</b> berechnet. Viel Spass! ");
define ("_DEST_FOOTER","<small><center>Alle Rechte an Texten bei deren jeweiligen Urhebern. Nur für Testzwecke zu ausschliesslich
privatem Gebrauch und Erheiterung. Mit den Resultaten ist keine wie auch immer geartete (Be)Wertung verbunden.Benutzung auf eigene Gefahr.<br>
<a href=\"http://reinesfreiland.de\">c. 2003</a> <a href=\"http://kulturserver-nrw.de/home/phpnuke/modules.php?name=Downloads&d_op=viewdownloadeditorial&lid=10&ttitle=Website_Text_and_Link_Destiller\">OSS</a></center></small><br>
<center><a href=\"destiller-xml.php\"><img border=\"0\" src=\"http://bloggern.de/images/valid-rss.png\"></a></center>");
define ("_DEST_AVGSCORE"," Seiten wurden bislang untersucht, der durchschnittliche Score liegt derzeit bei ");
define ("_DEST_HOMETEXT","<!-- <small>Bitte einen formatierten HTML-Text eingeben, z.B. Quelltext einer Google-Ergebnisseite. -->
		Dieses Skript extrahiert bzw. trennt Links und Textinformationen aus Listen, Tabellen etc. und wandelt HTML-codierte Sonderzeichen in Text.
		Zusätzlich wird eine Liste der enthaltenen Links ausgegeben.</small><br><br>");
define ("_DEST_INFOTEXT","<!-- <li>Kopieren Sie den zu untersuchenden Quelltext in das Texteingabefeld auf dieser Seite. <li>Klicken Sie auf \"Destiller\".</li>
		<h3>oder</h3> --><li> Bitte geben Sie einen Hostnamen (z.B. www.einhost.de) ein: <br><input type=\"text\" name=\"httphost\" size=\"20\"> <li>und
		eine Seite (z.B. /index.html, mindestens jedoch \"/\") an: <br><input type=\"text\" name=\"httpfile\" size=\"20\" value=\"/\">. <li>Klicken Sie auf \"Destiller\".");
define ("_DEST_INFOTEXTURL","Die Linkliste zeigt Links wie im Quelltext gefunden - also u. U. nur relativ zur untersuchten Seite.");
define ("_DEST_TEXTFOUND", "gefundener Text");
define ("_DEST_LINKSFOUND", "gefundene Links");
define ("_DEST_LINKSFOUNDTEXT01"," Links gefunden. Von ");
define ("_DESTLINKSFOUNDTEXT02"," Zeichen Quelltext blieben ");
define ("_DESTLINKSFOUND03"," Zeichen lesbarer Text übrig. Die berechnete <b>relative Informationsdichte</b> (Score) für die untersuchte Seite ");
define ("_DEST_LINKSFOUND04"," beträgt ");
define ("_DEST_LINKSFOUND05",".");
define ("_DEST_NEWQUERY01","neue Abfrage");
$destillerversion=" text&link destiller cmd plugin 0.0a";
$destillerhelp ="** $destillerversion **<br>searches a result for links and produces a nice entropic factor for your keyword on this source.<br>
usage: destiller (string)<br>i.e. \"destiller blog\".<br>Also try 'destiller [var keyword] relatives' or 'destiller [var item] item'. ";

/**
* backwards compatibility
*/

function unhtmlentities($string) {
	$trans_tbl = get_html_translation_table (HTML_ENTITIES);
	$trans_tbl = array_flip ($trans_tbl);
	return strtr ($string, $trans_tbl);
}

/**
* function extractlinks() by http://nola.info/?view=SNIP&item=98 #
*/
function extractlinks( $data ) {
   unset($location);
   $links = array();
   $links[] = array(); // the URLs corresponding to each element of $links
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

/**
* main function
*/
function destillermain($hometext) {
global $defaulthost;
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
		$output=  "<table cellspacing=\"25\"><tr>";
		$output.=  "<td colspan=\"2\" valign=\"top\"><h3>"._DEST_LINKSFOUND."</h3>";
		$i=0;
		foreach($links as $val) {
			if (@$val[0]!==""){
				$output.=  "<a href=\"";
				$output.=  rtrim(@($val[1]), "\\");
				//$output.=rtrim(@$val[0]);
				$output.=  "\">";
				$output.=  rtrim(@$val[0]);
				$output.=  "</a> $i| ";
				$i++;
			}
		}
		if ($i<1) {$i=1;}
		$rid=$n2/$n1*$i;

	}
		$output.= "</td></tr></table>";
	if (isset($links)) {
		$output.=  $i._DEST_LINKSFOUNDTEXT01.$n1._DESTLINKSFOUNDTEXT02.$n2._DESTLINKSFOUND03;
		if(!($defaulthost=="")){
		global $defaulthost;
			$output.=  " <a href=\"http://$defaulthost\">http://$defaulthost</a>";
		}
		$output.=  _DEST_LINKSFOUND04.$rid._DEST_LINKSFOUND05;
		//averagescore();
	}
	return $output;
}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>