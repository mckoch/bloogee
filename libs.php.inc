<?php
/** 
* PHP library used in many BG pages
* methods and helpers for basic controllers      
* no extended doc for now.
* @version 0.00f public
* @devstate working
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @todo cleanup library
*/

function bginit(){
  global $r;
  if (!$r->request["BGREQUEST"]){
    global $commandkeyvalid;
    if (!$_COOKIE){
        setcookie("username", "anonymous");
      setcookie("retry", "1", time()+$commandkeyvalid);
      setcookie("usrcommandlevel", 1, time()+$commandkeyvalid);
      setcookie("userpwd", 0, time()+$commandkeyvalid);
    }
  }    
    ob_start();
    global $mbo;
	$mbo = new MCO;
}
function bgexit(){
    $page = ob_get_contents();
	ob_end_clean();
	echo $page;
	die;
}

function dosearchrelatives($query) {
	$values = datasource($query);
	$content = itemformat($values);
	return $content;
}
function dofullsearch($query) {
	$values = datasource($query);
	$content = itemformat($values);
	return $content;
}
function securitydebug(){
	global $a;
	$content = listarray($a);
	$class_methods = get_class_methods(get_class($a));
		foreach ($class_methods as $method_name) {
   $content .=  "$method_name\n";
}

return $content;
}

function listarray($array) {
    $content = "<ul>";
    	foreach ($array as $property => $value){
		$content .= "<li>".$property.": ".$value."</li>";
	 	foreach ($value as $tempkey => $value2) {
	 	    $content .= "<ul><li>".$tempkey.": ".$value2."</li></ul>";
		}
	}
	$content .= "</ul>";
	return $content;
}

function listarray2($array) {
    	$content = "<ul>";
	 	foreach ($array as $key => $val) {
				if (is_array($val)||is_object($val)){
				    $tmpid=uniqid(time());
				    $content .= "<a href=\"#\" onclick=\"Effect.toggle('$tmpid','appear'); return false;\">$key: $val</a>
					<div id=\"$tmpid\" style=\"display:none;\" ><li>";
		 	        $content .= "<ul>";
		 	        foreach ($val as $key2 => $val2) {
                    	 if (is_array($val2)||is_object($val2)){
		 	            	$content .= "<li><ul>";
			 	        		foreach ($val2 as $key3 => $val3) {
			 	            		$content .= "<li>".$key3.": ".$val3."</li>";
					 			}
	 	            		$content .= "</ul></li>";
						} else {
							$content.="<li>".$key2.": ".$val2."</li>";
						}
		 	        }
					$content.= "</ul></div>";
	 			} else $content.="<li>".$key.": ".$val."</li>";
	 	}
	 	$content.="</ul>";
	return $content;
}



function listarrayrecurse($array) {
    $content = "<ul>";
	foreach ($array as $key => $val) {
    	if (is_array($val)||is_object($val)){
			$tmpid=uniqid(time());
		    $content .= "<li>";// .$key.": ".$val."::";
    	    $content .= "<a href=\"#\" onclick=\"Effect.toggle('$tmpid','appear');
			return false;\">$key</a><div id=\"$tmpid\" style=\"display:none;\" >";
			$content .= listarrayrecurse2($val);
    		$content .= "</div></li>";
		} else {
			$content.="<li>".$key.": ".$val."</li>";
		}
	}
	$content.="</ul>";
	return $content;
}

function listarrayrecurse2($array) {
    $content = "<ul>";
	foreach ($array as $key => $val) {
    	if (is_array($val)||is_object($val)){
			$tmpid=uniqid(time());
		    $content .= "<li>";// .$key.": ".$val."::";
    	    $content .= "<a href=\"#\" onclick=\"Effect.toggle('$tmpid','appear');
			return false;\">$key</a><div id=\"$tmpid\" style=\"display:none;\" >";
			$content .= listarrayrecurse($val);
    		$content .= "</div></li>";
		} else {
			$content.="<li>".$key.": ".$val."</li>";
		}
	}
	$content.="</ul>";
	return $content;
}
///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////

/*************************************************
/ BlooGee Version 0.00c                          /
/ all rights reserved, copyrights M.C. Koch 2006 /
*************************************************/
?>
