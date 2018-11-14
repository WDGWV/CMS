<?php
namespace WDGWV\CMS\Controllers;

class User extends \WDGWV\CMS\Controllers\Base
{
    private $database;

    /**
     * Call the debugger
     * @since Version 1.0
     */
    public static function shared()
    {
        /**
         * Shared Instance
         * @var class
         */
        static $inst = null;

        /**
         * If not have a instance, create one.
         */
        if ($inst === null) {
            /**
             * Initialisize Shared Instance
             * @var class
             */
            $inst = new \WDGWV\CMS\Controllers\User();
        }

        /**
         * Return Shared Instance
         */
        return $inst;
    }

    public function __construct()
    {
        $this->database = \WDGWV\CMS\Controllers\Databases\Controller::shared();
    }

    /**
     * @param $userID
     * @return null
     */
    public function getUserById($userID)
    {
        return false;
    }

    public function exists($userNameOrEmail)
    {
        return false;
    }

    public function login($userNameOrEmail, $userPassword)
    {
        return false;
    }

    public function register($userName, $userPassword, $userRealname, $userLastname, $userExtra)
    {
        return false;
    }

    public function activate($userID, $activationToken)
    {
        return false;
    }

    public function deactivate($userID)
    {
        return false;
    }

    public function delete($userID)
    {
        return false;
    }
}
