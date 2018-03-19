<?php
#function mod_getConfig ( mod )
# Fetch the config and return it as array
# Example usage:
/*
$myConfig = mod_getConfig('MyAwesomeModule');
if ( !is_array ( $myConfig ) )
die('Unable to load the config file!');
 */
## WdG: 16-JAN-2014
function mod_getConfig($mod) {
	$file1 = sprintf("modules/%s/settings.php", $mod);// Only some settings
	$file2 = sprintf("modules/%s/settings.cnf", $mod);// Only Settings file (ini file)

	if (file_exists($file1)) {
		//Parse the ini and return the config as a array.
		$config = load_config_from_ini($file1);
	} elseif (file_exists($file2)) {
		$config = parse_config_file($file2);
	} else {
		$config = "Unable to see config file, Database support is not yet included";
		#LATER-TODO: Add Database support for later.
	}
}

// print_r(load_config_from_ini("test.ini"));

function load_config_from_ini($file) {
	// This array we will fill, and return
	$configuration = array();

	// Here we store the active session's name
	$activeSection = null;

	// if the file exists
	if (file_exists($file)) {
		// ... and is readable
		if (is_readable($file)) {
			$file = file_get_contents($file);
			$file = explode("\n", $file);

			for ($i = 0; $i < sizeof($file); $i++) {
				if (substr($file[$i], 0, 1) == ";") {
					// Skipping comments
				} else if (substr($file[$i], 0, 1) == "[") {
					if (substr($file[$i], -1, 1) == "]") {
						// Entering a new Section
						// We'll skip the last ]
						$activeSection = substr($file[$i], 1, -1);

						// We'll create a new array for this section
						$configuration[$activeSection] = array();
					} else {
						// This ini file is corrupted, since the section tag [ never closes, missing ']'.
						trigger_error('Ini file is corrupted!');

						// return false
						return false;
					}
				} else if (preg_match("/=/", $file[$i])) {
					// Entering a new configuration item
					if ($activeSection != null) {
						// And we have a section
						$explodeData = explode("=", $file[$i]);

						if (substr($explodeData[0], -1) != "]") {
							$configuration[$activeSection][$explodeData[0]] = $explodeData[1];
						} else {
							if (substr($explodeData[0], -2) != "[]") {
								// Array with keys...
								$explodeX = explode("[", $explodeData[0]);

								if (!isset($configuration[$activeSection][$explodeX[0]])) {
									$configuration[$activeSection][$explodeX[0]] = array();
								}

								$configuration[$activeSection][$explodeX[0]][substr($explodeX[1], 0, -1)] = $explodeData[1];
							} else {
								if (!isset($configuration[$activeSection][substr($explodeData[0], 0, -2)])) {
									$configuration[$activeSection][substr($explodeData[0], 0, -2)] = array();
								}

								$configuration[$activeSection][substr($explodeData[0], 0, -2)][] = $explodeData[1];
							}
						}
					} else {
						trigger_error('Got data but no section, stopping parse');
						return;
					}
				} else {
					// Just ignore, this is overhead data.
				}
			}

			// return the configuration array
			return $configuration;
		}
	}
}

#function mod_admin ( mod )
# Load the administration/settings file for the module
## WdG: 16-JAN-2014
function mod_admin($mod) {
	$file1 = sprintf("modules/%s/admin.php", $mod);// Standard Admin
	$file2 = sprintf("modules/%s/administration.php", $mod);// Standard Admin
	$file3 = sprintf("modules/%s/settings.php", $mod);// Only some settings
	$file4 = sprintf("modules/%s/settings.cnf", $mod);// Only Settings file (ini file)

	if (file_exists($file4))// Only a ini file
	{
		// Parse the ini file,
		// and make a edit settings page
		mod_writeAdmin($mod, $file4);
	} elseif (file_exists($file3))// Settings file... see example
	{
		// Only Some settings, On/Off Toggle...
		/* Example:
		setting1=true
		setting2=This can be a really long string, but dont use enters in it! (use instead [ENT] )
		headline=This is a Multiline Test...[ENT]and it works well!
		footer=hello, this is the footer
		licencekey=X123W-WDGYD-WDGWV-WPOEN-WODBT-20394-QAZWS
		 */
		mod_seeSettings($mod, $file3);
	} elseif (file_exists($file2))// include the config file.
	{
		// it's a self written config, so load it...

		//mod_admin_header();
		include $file2;
		//mod_admin_footer();
	} elseif (file_exists($file1))// include the config file
	{
		// i'ts a self written config, so load it....

		//mod_admin_header();
		include $file1;
		//mod_admin_footer();
	} else {
		// No settings are found.
		{
			// No settings are found.
			mod_Error('No settings...');
		}
	}
}

?>