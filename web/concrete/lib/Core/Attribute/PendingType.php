<?
namespace Concrete\Core\Attribute;
use \Concrete\Core\Foundation\Object;
use Loader;
class PendingType extends Type {

	public static function getList() {
		$db = Loader::db();
		$atHandles = $db->GetCol("select atHandle from AttributeTypes");
		
		$dh = Loader::helper('file');
		$available = array();
		if (is_dir(DIR_MODELS . '/' . DIRNAME_ATTRIBUTES . '/' .  DIRNAME_ATTRIBUTE_TYPES)) {
			$contents = $dh->getDirectoryContents(DIR_MODELS . '/' . DIRNAME_ATTRIBUTES . '/' .  DIRNAME_ATTRIBUTE_TYPES);
			foreach($contents as $atHandle) {
				if (!in_array($atHandle, $atHandles)) {
					$available[] = PendingAttributeType::getByHandle($atHandle);
				}
			}
		}
		return $available;
	}

	public static function getByHandle($atHandle) {
		$th = Loader::helper('text');
		if (file_exists(DIR_MODELS . '/' . DIRNAME_ATTRIBUTES . '/' .  DIRNAME_ATTRIBUTE_TYPES . '/' . $atHandle)) {
			$at = new PendingAttributeType();
			$at->atID = 0;
			$at->atHandle = $atHandle;
			$at->atName = $th->unhandle($atHandle);
			return $at;
		}
	}
	
	public function install() {
		$at = parent::add($this->atHandle, $this->atName);
	}

}