<?php
namespace WDGWV\CMS\Controllers;

class Shop extends \WDGWV\CMS\Controllers\Base
{
    private static $databaseConnection = '';

    public function __construct($databaseConnection)
    {
        static::$databaseConnection = $databaseConnection;
    }

    public function getUserById($userID)
    {
        return;
    }
}
