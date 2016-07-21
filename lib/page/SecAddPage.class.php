<?php
namespace dns\page;
use dns\system\helper\IDatabase;
use dns\system\helper\TDatabase;
use dns\system\DNS;
use dns\system\User;

/**
 * @author      Jan Altensen (Stricted)
 * @license     GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @copyright   2014-2016 Jan Altensen (Stricted)
 */
class SecAddPage extends AbstractPage implements IDatabase {
	use TDatabase;
	
	public function prepare() {
		if (!isset($_GET['id']) || empty($_GET['id']) || !ENABLE_DNSSEC) {
			throw new \Exception('The link you are trying to reach is no longer available or invalid.', 404);
		}
		print_r($_REQUEST);
		$soaIDs = User::getAccessibleDomains();
		if (!in_array($_GET['id'], $soaIDs)) {
			throw new \Exception('Access denied. You\'re not authorized to view this page.', 403);
		}
		
		$sql = "SELECT * FROM dns_soa WHERE id = ?";
		$res = $this->db->query($sql, array($_GET['id']));
		$soa = $this->db->fetch_array($res);
		
		$this->tpl->assign(array("soa" => $soa));
	}
}
