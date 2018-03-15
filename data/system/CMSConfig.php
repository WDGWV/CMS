<?php
namespace WDGWV\CMS;

class Config extends \WDGWV\General\WDGWVFramework {
	public function theme() {
		// TO RUN NORMAL MODE
		// return 'portal';
		// TO TEST ADMIN:
		return 'admin';
	}

	public function menu() {
		// Temporary static.
		return array(
			"home" => "/home",
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
	 * DO NOT CHANGE BELOW
	 */
	public function getVersion() {
		return (new \WDGWV\General\WDGWV())->version;
	}
}

?>