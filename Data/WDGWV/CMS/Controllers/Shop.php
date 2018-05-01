<?php
namespace WDGWV\CMS\Controllers;

class Shop extends \WDGWV\CMS\Controllers\Base
{
    /**
     * @var string
     */
    private static $databaseConnection = '';

    /**
     * @param $databaseConnection
     */
    public function __construct($databaseConnection)
    {
        static::$databaseConnection = $databaseConnection;
    }

    /**
     * @param $userID
     * @return null
     */
    public function getUserById($userID)
    {
        return;
    }
}
