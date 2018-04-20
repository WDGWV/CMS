<?php
namespace WDGWV\CMS;

class Config extends \WDGWV\General\WDGWV
{
    public function adminURL()
    {
        return 'Administration';
    }

    public function database()
    {
        return 'PlainText';
    }

    public function theme()
    {
        return \WDGWV\CMS\Controllers\Databases\Controller::sharedInstance()->getTheme();
    }

    //first time generation of keys -> random_bytes
    // echo preg_replace('/=/', null, base64_encode(random_bytes(25)));

    /**
     * DO NOT CHANGE BELOW
     */
    public function getVersion()
    {
        return (new \WDGWV\General\WDGWV())->version;
    }
}
