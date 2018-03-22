<?php
namespace WDGWV\CMS;

class Config extends \WDGWV\General\WDGWVFramework {
	public function adminURL() {
<<<<<<< HEAD
		return 'HAHAAdmin';
=======
		return 'administration';
>>>>>>> a738cd24bf61e2f485299c35932d37e7fc5079df
	}

	public function theme() {
		// TO RUN NORMAL MODE
		return 'portal';
		// TO TEST ADMIN:
		// return 'admin';
	}

	/**
	 * DO NOT CHANGE BELOW
	 */
	public function getVersion() {
		return (new \WDGWV\General\WDGWV())->version;
	}
}

?>