<?php
namespace WDGWV\CMS;

class base extends \WDGWV\General\WDGWVFramework {
	private $config;

	function __construct($customConfiguration = false) {
		if ($customConfiguration != false) {
			$this->config = $customConfiguration;
		} else {
			$this->config = new \WDGWV\CMS\Config();
		}
	}

	public function menu() {
		return $this->config->menu();
	}

	public function getTheme() {
		return $this->config->theme();
	}

	public function getPageName() {
		return $this->config->pagename();
	}

	public function getTitle() {
		return $this->config->title();
	}

	public function maintenanceMode() {
		return false;
	}

	public function singlePage() {
		return false;
	}

	public function getDescription() {
		return 'testing! the new WDGWV CMS!!!';
	}

	public function getSlogan() {
		return 'This is the page of the new WDGWV cms Version ' . WDGWV_getVersion() . '!';
	}

	public function getContent() {
		//WDGWV_Parser
		return 'Here you\'ll find some statics about this project, for now al the pages are static, and not yet changeable.<br />
Come back later ;)<br /><br />
<table><tr><td><script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_factoids_stats.js"></script></td><td>
<script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_cocomo.js"></script></tr></table>
<script type="text/javascript" src="http://www.ohloh.net/p/642938/widgets/project_users.js?style=blue"></script>
<br /><br />
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- ONDERAAN -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-5555094756467155"
     data-ad-slot="1975252506"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';
	}

	public function getFooter() {
		return '<img src=\'http://by.wdgp.nl/logo\' width=\'30px\' height=\'0px\'>&copy; yoursite.';
	}

	public function page_exists($page) {
		if ( /* in database */false) {
			return true;
		} else {
			return false;
		}

	}
}
?>