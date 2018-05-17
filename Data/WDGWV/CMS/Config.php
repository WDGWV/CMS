<?php
namespace WDGWV\CMS;

class Config extends \WDGWV\General\WDGWV
{
    /**
     * administration url
     * @return string administration url
     */
    public function adminURL()
    {
        return 'Administration';
    }

    /**
     * Database type
     * @return string database type
     */
    public function database()
    {
        return 'SQLite';
        // return 'PlainText';
    }

    /**
     * get current theme
     * @return string current theme
     */
    public function theme()
    {
        return \WDGWV\CMS\Controllers\Databases\Controller::sharedInstance()->themeGet();
    }

    /**
     * generateSalts
     *
     * @param $length
     */
    public function generateSalts($length = 50)
    {
        return preg_replace(
            '/=/',
            null,
            base64_encode(
                random_bytes($length)
            )
        );
    }

    /**
     * DO NOT CHANGE BELOW
     */
    public function getVersion()
    {
        return (new \WDGWV\General\WDGWV())->version;
    }

    public function __construct()
    {
        if (!\defined('ADMIN_URL')) {
            \define('ADMIN_URL', $this->adminURL());
        }
    }
}
