<?php
namespace WDGWV\CMS\Controllers;

class API extends \WDGWV\CMS\Controllers\base
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
