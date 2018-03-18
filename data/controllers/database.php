<?php
namespace WDGWV\CMS\controllers\databases;

class base {
	//
	protected function createMenuDB() {
		return array(
			array(
				'name' => 'Home',
				'icon' => 'home',
				'url' => '/home',
				'userlevel' => '*',
				'submenu' => null,
			),
			array(
				'name' => 'Blog',
				'icon' => 'pencil',
				'url' => '/blog',
				'userlevel' => '*',
				'submenu' => array(
					array('name' => 'Blog', 'url' => '/blog', 'icon' => 'pencil'),
					array('name' => 'Last post', 'url' => '/blog/last', 'icon' => 'rss'),
				),
			),
			array(
				'name' => 'Administration',
				'url' => '#',
				'icon' => 'cogs',
				'userlevel' => 'moderator',
				'submenu' => array(), //.. later
			),
			array(
				'name' => 'About',
				'url' => '/about',
				'icon' => 'address-card-o',
			),
		);
	}

}
?>