<?php
/** 
* main file for generating the MicroContentObject
* no extended doc for now.
* @version 0.00f public
* @devstate stable, conceptual
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @todo define methods, include config-array
*/

/**
* BlooGee Version 0.00c                          /
* the main Micro Content Object                  /
* @devstate: basic
*/
class MCO {
	var $id;
	var $config; #NN
	var $description;
	var $content;
	var $overlay;#NN
	var $canvas;#NN
	var $relatives;
/** not really in use.
* @devstate dummy
* @todo connect to server commuications
*/
	function receive_message($id) {
	    global $id;
	    //$this -> id = $id;
	}
/** not really in use.
*@devstate dummy
* @todo connect to server commuications
*/
	function send_message() {
	    global $id;
	    //$relatives = $this -> relatives;
	}
	/////////////////////// not really in use.....
}
/*
*creates a basic error 
* @todo: replace by derived class (extend class MCO)
*/
function MCOErrorObject($mbo) {
	global $content, $mbo, $a;
	$mbo->id = "error";
	$mbo->description = "BlooGee::ErrorObject:: an error occured:";
	$mbo->content = $a-> query;
	$mbo->relatives = array("BlooGee system error",0,0,0);
}
/*************************************************
/ BlooGee Version 0.00c                          /
/ all rights reserved, copyrights M.C. Koch 2006 /
*************************************************/
?>
