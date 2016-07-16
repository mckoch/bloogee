<?  
/** 
* template for commands
* strucrure for secure shell commands
* no extended doc for now.
* @version 0.00f public
* @devstate alpha
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/

class thiscommand{
	var $header="<span class=\"terminalheader\"><p>
	******************************<br>
	 &Xi; commandtemplate V <br>
	  &Xi; text shell V br>
	 &Xi; bg  v <br>
	******************************<br>
	</p></span>";
	var $help=" &Xi; this is a friendly help text for a friendly template. ";
	var $description="&Xi; basic template for shell plugins bg";
	var $version=" 0.00a ";
	var $params=array("-info"=>"info","-?"=>"help");
	var $options=array("v1"=>"v1","val6"=>"val6");
	// $config to read from array $a->validshellcommands!!!
	var $config=array("commandrule"=>"1","isadmin"=>"FALSE","myconf"=>"myconfig",
		"commonerror"=>" &Xi; an error occured. ", "success"=>" &Xi; command succeeded. ",
		"standalone"=>"FALSE");
	var $output;
	var $request;
	var $validated="FALSE";
	function inittest(){
		global $a;
		///print $this->listarray($a);
		if(!$a){$this->validated=="FALSE"; return "no a=$a.".$this->validated;}
		if ($a->currentuserrule>=$this->config["commandrule"]){print " &Xi; ok. ";
			return $this->validated="TRUE";} else {return $this->validated=FALSE;}
		}
	function init($param){
		//require_once("security.php"); // TESTING ONLY OR STANDALONE
		$myconfig=$this->inittest();
					
		if ($this->validated=="TRUE"){$this->request=$param; return $this->main();}
		else {return $this->bye(" &Xi; aborted. ");}
	}
	function bye($command){
		global $a;
		if ($a->commandrule<=$this->config["commandrule"]){
			
			$this->output = $command.$a->user.$this->config["success"];
			
		} else {
			return $this->header.$this->config["commonerror"];
		}
		// require_once("debug.php");
	}
	function main(){
	global $a, $mbo, $r, $var;
		if ($this->validated=="TRUE"){
			if (!$var[1]){$var[1]="-?";}
			$params=$this->params[$var[1]];
				switch ($params){
					case "help": $command=" i'll help you if i can. "; 
					$command.=$this->listarray($a->validshellcommands[$var[0]]);
					$command .= commandhelp($this); break;
					case "info":
					$command=commandinfo($this);
					break;
					default: $command=" Nothing to do. Try help. ";break;
				}
	
				/////// da code ///////
				// $command = $this->listarray($this->request); //.....
				//$command .=$this->listarray($a);
				//////end ////////////
				return $this->bye($command);
		
		}
	}
	function listarray($array) {
	    $content = "<ul>"; foreach ($array as $property => $value){
		$content .= "<li>".$property.": ".$value."</li>";
		foreach ($value as $tempkey => $value2) {
	 	$content .= "<ul><li>".$tempkey.": ".$value2."</li></ul>";}
		}
		$content .= "</ul>"; return $content;
	}
}


///// testing & init
$thiscommand=new thiscommand;
if ($thiscommand->config["standalone"]=="TRUE")
{require_once("BGCONFIG.php"); require_once("security.php.inc");}
/*
$userinput = array("info","j23kljl","e");
//////////////////////main...
$result = $thiscommand->init($userinput);
print $result;
require_once("debug.php"); */

//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>