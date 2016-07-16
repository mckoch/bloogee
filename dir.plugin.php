<?
/** 
* mini plugin to browse files from command line
* restrict to admin use!
* no extended doc for now.
* @version 0.00f public
* @devstate DANGEROUS - may unveil your whole filesystem
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
* @filesource
*/
$d = dir("/etc"); 
echo "Handle: ".$d->handle."<br>\n"; 
echo "Path: ".$d->path."<br>\n"; 
while (false !== ($entry = $d->read())) { 
   echo $entry."<br>\n"; 
} 
$d->close(); 
?>
