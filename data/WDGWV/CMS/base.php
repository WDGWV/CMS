<?php
namespace WDGWV\CMS;

class base extends \WDGWV\General\WDGWVFramework {
	private $config;
	private $emulation;

	function __construct($customConfiguration = false) {
		$this->emulation = array(
			'Blogger' => new \WDGWV\CMS\emulation\Blogger(),
			'WordPress' => new \WDGWV\CMS\emulation\WordPress(),
		);

		if ($customConfiguration != false) {
			$this->config = $customConfiguration;
		} else {
			$this->config = new \WDGWV\CMS\Config();
		}

		\WDGWV\CMS\hooks::sharedInstance()->loopHooks(array('get', 'post', 'url'));
	}

	public function database() {
		// ...
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
		return 'WDGWV CMS'; // Wordpress....
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
		return sprintf(
			'%s&#32;&#169;&#32;%s&#32;%s&#32;%s&#32;<a href=\'https://www.wdgwv.com/products/cms\' target=\'_blank\'>&#87;&#68;&#71;&#87;&#86;&#32;&#67;&#77;&#83;</a>,&#32;%s&#46;',
			$this->h(function_exists('__') ? \__('Copyright') : ('Copyright')),
			$this->h(@date('Y')),
			$this->h($this->getTitle()),
			$this->h(function_exists('__') ? \__('Powered by') : ('Powered by')),
			$this->h(function_exists('__') ? \__('All rights reserved') : ('All rights reserved'))
		);
	}

	public function serve() {
		global $database;
		if ($this->emulation['Blogger']->isBlogger($this->getTheme())) {
			$this->emulation['Blogger']->blogger(
				$this->getTheme()
			);
		} elseif ($this->emulation['WordPress']->isWordpress($this->getTheme())) {
			$this->emulation['WordPress']->wordpress(
				$this->getTheme()
			);
		} else {
			$parser = new \WDGWV\General\templateParser(
				$this->config->debug,
				null,
				CMS_TEMPLATE_DIR
			);

			$pageController = new \WDGWV\CMS\controllers\page(
				$parser,
				$this,
				$database
			);

			$parser->setParameter(
				'{ITEM:',
				'}'
			);

			$parser->setTemplate(
				$this->getTheme(),
				'html',
				'/data/themes/' . $this->getTheme() . '/'
			);

			$parser->bindParameter('year', @date('Y'));

			$parser->bindParameter('SITE_TITLE', $this->getTitle());

			$parser->bindParameter('copyright',
				$this->getFooter()
			);

			$parser->setMenuContents($database->loadMenu());

			$pageController->displayPage();

			$parser->display();

			if ($parser->didDisplay()) {
				echo "THEME " . $this->getTheme() . " Does not exists!";
			}
		}
	}

	private function h($s) {
		$out = '';
		for ($i = 0;isset($s[$i]); $i++) {
			$x = ord($s[$i]);
			$out .= '&#' . $x . ';';
		}
		return $out;
	}
}
?>