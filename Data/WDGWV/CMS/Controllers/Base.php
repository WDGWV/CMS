<?php /* Base Controller */
/**
 * Set namespace
 */
namespace WDGWV\CMS\Controllers;

/**
 * Base controller for database
 */
class Base
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
