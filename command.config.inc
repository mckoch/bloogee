<?
/** 
* configuration file for command.php
* no extended doc for now.
* @version 0.00f public
* @devstate stable
* @author M. C. Koch <mckoch@kulturserver-nrw.de>
* @copyright copyleft M.C. Koch 2006
* @license GNU General Public License http://www.fsf.org 
* @package BlooGee
* @subpackage bgcore
* {@}link http://bloggen.de BlooGee home}
* {@}link http://sourceforge.net BlooGee Home on Sourceforge}
*/

$validshellcommands= array(
	"thiscommand"=>array(1,0,"commandtemplate.php"),
	"test"=>array(1,"ADMIN","bonus.php"),
  "murphy"=>array(1,0,"murphy.command.php"),
   "destill"=>array(1,0,"destiller.command.php"),
   "destillext"=>array(3,"ADMIN","destillerext.command.php"),
   "getid3"=>array(3,0,"id3.command.php"),
   "getexternal"=>array(3,"ADMIN","getexternal.command.php"),
   "bugs"=>array(3,0,"bugtracker.command.php"),
   "new"=>array(3,0,"new.command.php"),
   "news"=>array(3,"ADMIN","news.command.php"),
    "move"=>array(3,"ADMIN","movethenews.command.php")
	);
//////////////////////////////////////////////////////////
#
#This library is free software; you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation; eitherversion 2.1 of the License, or (at your option) any later version. This library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License at http://www.fsf.org for more details. Not for governmental or military use. You should have received a copy of the GNU Lesser General Public License along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
#Please see also http://fsf.org/licensing/essays/free-software-for-freedom.html
#
/* NO EMPTY LINES BELOW HERE!! */
?>