<?php
namespace WDGWV\CMS;

class Config extends \WDGWV\General\WDGWVFramework {
	public function title() {
		//.. if...
		return 'WDGWV CMS v' . $this->getVersion();
	}

	public function theme() {
		return 'portal';
	}

	public function menu() {
		// Temporary static.
		return array(
			"home" => "/",
			"blog" => "/blog",
			"extendable cms" => array(
				"." => "/invoice/.",
				".." => "/invoice/..",
				"..." => "/invoice/...",
			),
			"with" => array(
				"." => "/purchaseorder/.",
				".." => "/purchaseorder/..",
				"..." => "/purchaseorder/...",
			),
			"built in" => array(
				"." => "/personell/.",
				".." => "/personell/..",
				"..." => "/personell/...",
			),
			"webshop" => array(
				"." => "/personell/.",
				".." => "/personell/..",
				"..." => "/personell/...",
			),
			"about" => "/about",
		);
	}

	/**
	 * Page Specific
	 */
	public function pagename() {
		return 'Home';
	}
	/**
	 * DO NOT CHANGE BELOW
	 */
	public function getVersion() {
		return file_get_contents('./data/config/installed.version');
	}
}

?>