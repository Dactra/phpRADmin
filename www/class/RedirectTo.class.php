<?
/** 
Oreon is developped with GPL Licence 2.0 :
http://www.gnu.org/licenses/gpl.txt
Developped by : Julien Mathis - Romain Le Merlus
 
The Software is provided to you AS IS and WITH ALL FAULTS.
OREON makes no representation and gives no warranty whatsoever,
whether express or implied, and without limitation, with regard to the quality,
safety, contents, performance, merchantability, non-infringement or suitability for
any particular or intended purpose of the Software found on the OREON web site.
In no event will OREON be liable for any direct, indirect, punitive, special,
incidental or consequential damages however they may arise and even if OREON has
been previously advised of the possibility of such damages.

For information : contact@oreon.org
*/

class RedirectTo{
			
	var $id;
	var $nb;
	var $pages;
	var $right;
	
	function RedirectTo($data)
	{
		$this->nb	= $data["id"];
		$this->id	= $data["id_pages"];
		$this->pages = $data["pages"];
		$this->right = $data["appright"];	
	}
	
	function get_id(){
		return $this->id;	
	}
		
	function get_pages(){
		return $this->pages;	
	}

	function get_right(){
		return $this->right;	
	}
		
}
