<?php
namespace WDGWV\CMS;

class Config extends \WDGWV\General\WDGWVFramework {
	public function adminURL() {
		return 'administration';
	}

	public function database() {
		return 'plainText';
	}

	public function theme() {
		return \WDGWV\CMS\controllers\databases\controller::sharedInstance()->getTheme();

	}

	/**
	 * DO NOT CHANGE BELOW
	 */
	public function getVersion() {
		return (new \WDGWV\General\WDGWV())->version;
	}
}

?>