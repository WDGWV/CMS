<?php
namespace WDGWV\CMS\Controllers;

class Base
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
