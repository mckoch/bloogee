<?php
/** 
* basic formatters for viewable output
* extend to own needs
* no extended doc for now.
* @version 0.00f public
* @devstate working
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU  General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/
function itemformat2($values,$dummy, $collapsed) {
	global $a, $mbo, $defaulturl, $editpage;
	$requestkey=uniqid($a->user);
	$content="";
	//print listarray($a);
	$values = $mbo->relatives;
	foreach ($values as $property => $value) {
		
        $content .= "<div class=\"item\" name=\"$value[0]\" id=\"$requestkey$value[0]\"";
		$content .= "><div class=\"serverquery\" >$value[1]</div>";
	 	//$content .= "<div class=\"content\"  id=\"itemformat$requestkey"."content$value[0]\">$value[2]</div>";
		//$content .= "<div class=\"relatives\" id=\"itemformat$requestkey"."relatives$value[0]\">";
		//$content .= $value[3]."</div>";
	    $content .= "</div>";
	}
	return $content;
}

function itemformat($values,$dummy, $collapsed) {
	global $a, $mbo, $defaulturl, $editpage;
	$requestkey=uniqid($a->user);
	$content="";
	//print listarray($a);
	$values = $mbo->relatives;
	foreach ($values as $property => $value) {
		$content .= "<div class=\"$requestkey$value[0]'\"><span class=\"itemid\"> $value[0] </span>
		<a href=\"#\" onclick=\"Effect.toggle('$requestkey$value[0]','appear'); return false;\">$value[1]></a>
		".substr(strip_tags($value[2]),0,45)."...</div>";
        $content .= "<div class=\"item\" name=\"$value[0]\" id=\"$requestkey$value[0]\"";
        if ($collapsed=="collapsed"){$content.= " style=\"display:none; \"";}
		$content .= "><div class=\"title\" id=\"itemformat$requestkey"."title$value[0]\">$value[1]</div>";
	 	$content .= "<div class=\"content\"  id=\"itemformat$requestkey"."content$value[0]\">$value[2]</div>";
		$content .= "<div class=\"relatives\" id=\"itemformat$requestkey"."relatives$value[0]\">";
		$content .= $value[3]."</div>";
	    $content .= "</div>";
	    
	   
	if ($a->isadmin=="ADMIN"){
			$content.= "
				<script type=\"text/javascript\">new Ajax.InPlaceEditor('itemformat$requestkey"."title$value[0]', '$defaulturl$editpage?',{rows:2,callback: function(form, value) {return 'id=$value[0]&element=title&updatestring=' + value}});</script>
				<script type=\"text/javascript\">new Ajax.InPlaceEditor('itemformat$requestkey"."content$value[0]', '$defaulturl$editpage?',{rows:6,callback: function(form, value) {return 'id=$value[0]&element=content&updatestring=' + value}});</script>
				<script type=\"text/javascript\">new Ajax.InPlaceEditor('itemformat$requestkey"."relatives$value[0]', '$defaulturl$editpage?',{rows:2, callback: function(form, value) {return 'id=$value[0]&element=relatives&updatestring=' + value}});</script>
			";
		} else { //demo mode
		    $content.= "
		    		<script type=\"text/javascript\">new Ajax.InPlaceEditor('itemformat$requestkey"."title$value[0]', '$defaulturl$editpage?',{rows:2,callback: function(form, value) {return 'id=$value[0]&element=title&updatestring=' + value}});</script>
			";
		}

	    
	}
	return $content;
}

function teaserformat($values) {
	global $mbo;
	$content="";
		$values = $mbo->relatives;
	foreach ($values as $property => $value) {
        $content .= "<div class=\"item\" name=\"$value[0]\" id=\"$value[0]\">";
		$content .= "<div class=\"title\">$value[1]</div>";
	 	$content .= "<div class=\"teaser\">".substr(strip_tags($value[2]),0,45)."... mehr:</div>";
		// $content .= "<div class=\"relatives\">$value[3]</div>";
	    $content .= "</div>";
	}
	return $content;
}

function serverlistformat($values) {
	global $mbo;
	$content="";
		$values = $mbo->relatives;
	foreach ($values as $property => $value) {
	$line=explode("*",$value);
	$content.=$line[1]." ";
	//$content.=$value." ";
        /* $content .= "<div class=\"item\" name=\"$value[0]\" id=\"$value[0]\">";
		$content .= "<div class=\"title\">$value[1]</div>";
	 	
	    $content .= "</div>";*/
	}
	return $content;
}
function querylistformat($values) {
	global $mbo;
	$content="";
		$values = $mbo->relatives;
	foreach ($values as $property => $value) {
	$line=explode("*",$value);
	$content.=$line[0]."*".$line[2]."::".$line[3]."::".$line[4].",".$line[5].",".$line[6]."; ";
	//$content.=$value." ";
        /* $content .= "<div class=\"item\" name=\"$value[0]\" id=\"$value[0]\">";
		$content .= "<div class=\"title\">$value[1]</div>";
	 	
	    $content .= "</div>";*/
	}
	return $content;
}

function listformat($values, $list, $collapsed) {
	global $a, $mbo, $defaulturl, $editpage;
	$values = $mbo->relatives;	
	$isadmin = $a -> isadmin;
	$content = "<ul class=\"sortabledemo\" id=\"$list\" style=\"height:150px;\">";
	foreach ($values as $property => $value) {
	    $content .= "<li class=\"orange\" id=\"$list$value[0]\"><span class=\"handle\">$value[0]</span>
		<a href=\"#\" onclick=\"Effect.toggle('$value[0]','appear'); return false;\">$value[1]<img src=\"images\edit.gif\"></a>";
        $content .= "<div class=\"item\" ";
        if ($collapsed=="collapsed"){$content.= " style=\"display:none; \"";}
		$content .= " name=\"$value[0]\" id=\"$value[0]\"  title=\"$value[1]\">";
		$content .= "<div class=\"title\" id=\"title$value[0]\" >$value[1]</div>";
	 	$content .= "<div class=\"content\" id=\"content$value[0]\" >";
		 if($value[4]){
		 	$content .= "<span class=\"blogdate\">".$value[4]."</span> ";
			 };
		$content .= $value[2]."</div>";
		$content .= "<div class=\"relatives\" id=\"relatives$value[0]\">$content[3]</div>";
		if ($isadmin=="ADMIN"){
			$content.= "
				<script type=\"text/javascript\">new Ajax.InPlaceEditor('title$value[0]', '$defaulturl$editpage?',{rows:2,callback: function(form, value) {return 'id=$value[0]&element=title&updatestring=' + value}});</script>
				<script type=\"text/javascript\">new Ajax.InPlaceEditor('content$value[0]', '$defaulturl$editpage?',{rows:6,callback: function(form, value) {return 'id=$value[0]&element=content&updatestring=' + value}});</script>
				<script type=\"text/javascript\">new Ajax.InPlaceEditor('relatives$value[0]', '$defaulturl$editpage?',{rows:2, callback: function(form, value) {return 'id=$value[0]&element=relatives&updatestring=' + value}});</script>
			";
		} else { //demo mode
		    $content.= "
		    				<script type=\"text/javascript\">new Ajax.InPlaceEditor('title$value[0]', '$defaulturl$editpage?',{rows:2,callback: function(form, value) {return 'id=$value[0]&element=title&updatestring=' + value}});</script>
			";
		}
   		$content .= "</div>";
		$content .= "</li>";
	}
	$content .= "</ul>";
	return $content;
}

function listitemformat($values, $list, $collapsed) {
	$content = "";
	$values = $mbo->relatives;
	foreach ($values as $property => $value) {
	    $content .= "<li class=\"orange\" id=\"$list$value[0]\"><span class=\"searchresult\">$value[0]</span>
		<a href=\"#\" onclick=\"Effect.toggle('$value[0]','appear'); return false;\">$value[1]<img src=\"images\edit.gif\"></a>";
        $content .= "<div class=\"item\" ";
        if ($collapsed=="collapsed"){$content.= " style=\"display:none; \"";}
		$content .= " name=\"$value[0]\" id=\"$value[0]\"  title=\"$value[1]\">";
		$content .= "<div class=\"title\">$value[1]</div>";
	 	$content .= "<div class=\"content\">$value[2]</div>";
		$content .= "<div class=\"relatives\">$value[3]</div></div>";
			$content .= "</li>";
	}
	return $content;
}
 function HTMLheader(){
	 
}
 function HTMLfooter(){
 
}
 function RSSitemformat(){}
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>