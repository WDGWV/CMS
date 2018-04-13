<?php
namespace WDGWV\CMS;

class Config extends \WDGWV\General\WDGWVFramework
{
    public function adminURL()
    {
        return 'administration';
    }

    public function database()
    {
        return 'plainText';
    }

    public function theme()
    {
        return \WDGWV\CMS\controllers\databases\controller::sharedInstance()->getTheme();
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
