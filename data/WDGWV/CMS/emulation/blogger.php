<?php
namespace WDGWV\CMS\emulation;

class Blogger {
	function isBlogger($theme) {
		return (file_exists(CMS_TEMPLATE_DIR . $theme . '/main.xml')) ? true : false;
	}

	function bloggerLoop($matches) {
		if ($matches[1] == 'links') {
			$matches[3] = preg_replace(
				"#a expr:href#",
				"a href",
				$matches[3]
			);
			$matches[3] = preg_replace(
				"#data:link\.target#",
				"http://www.wdgwv.com",
				$matches[3]
			);
			$matches[3] = preg_replace("#<data:link\.name/>#",
				"WDGWV",
				$matches[3]
			);

			return $matches[3];
		}

//    print_r($matches);
	}

	function bloggerInclude($matches) {

	}

	function bloggerLoad($matches) {

	}

	function bloggerParse($theme, $name) {
		$theme = preg_replace_callback(
			"#<b:loop values='data:(.*)' var='(.*)'>(.*?)</b:loop>#i",
			"bloggerLoop",
			$theme
		);

		$theme = preg_replace(
			"#<data:blog.pageTitle/>#",
			"WDGWV CMS v0.0.1",
			$theme
		);

		$theme = preg_replace(
			"#<!-- Created by Artisteer v(.*) -->#",
			null,
			$theme
		);

		$theme = preg_replace(
			"#<b:skin><\!\[CDATA\[(.*)\]\]></b:skin>#si",
			"<style type=\"text/css\">\\1</style>",
			$theme
		);

		$theme = preg_replace(
			"#data:blog\.homepageUrl#",
			"./",
			$theme
		);

		$theme = preg_replace(
			"#<b:include name=\"title\"/>#",
			"WDGWV Blog",
			$theme
		);

		$theme = preg_replace(
			"#<b:include name=\"description\"/>#",
			"WDGWV Products blog",
			$theme
		);

		$theme = preg_replace(
			"#url\('images/(.*)\.(.*)'\)#",
			"url('themes/" . $name . "/images/\\1.\\2')",
			$theme
		);

		$theme = preg_replace(
			"#<b:else/>
            <b:if cond='data:post.url'>
                <a expr:href='data:post.url'><data:post.title/></a>
            <b:else/>
                <data:post.title/>
            </b:if>
        </b:if>#",
			null,
			$theme
		);

		$theme = preg_replace(
			"#<data:post.title/>#",
			"PAGE TITLE",
			$theme
		);

		return $theme;
	}

	function blogger($theme) {
		$file = file_get_contents('themes/' . $theme . '/main.xml');
		echo bloggerParse($file, $theme);
	}
}
?>