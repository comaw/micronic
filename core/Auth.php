<?php
/**
 * Created by PhpStorm.
 * User: comaw
 * Date: 05.01.2019
 * Time: 22:04
 */

namespace core;

use app\models\Admin;

/**
 * Class Auth
 *
 * @package core
 */
class Auth
{
    #region [public constants]
    public const AUTH_COOKIE_NAME = '__auth';
    public const AUTH_COOKIE_TIME = 3600;
    #endregion

    #region [protected properties]
    /** @var array $user */
    protected $user;
    #endregion

    #region [public static methods]
    /**
     * @param string $auth
     *
     * @return Auth
     */
    public function setUserAuth(string $auth): Auth
    {
        setcookie(self::AUTH_COOKIE_NAME, $auth, time() + self::AUTH_COOKIE_TIME, "/");
        $_COOKIE[self::AUTH_COOKIE_NAME] = $auth;

        return $this;
    }

    /**
     * @return array|bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getUserAuth()
    {
        if ($this->user) {
            return $this->user;
        }
        if (!isset($_COOKIE[self::AUTH_COOKIE_NAME])) {
            return false;
        }
        $this->user = (new Admin())->getByAuth( $_COOKIE[self::AUTH_COOKIE_NAME]);

        return $this->user;
    }

    /**
     * User logout
     */
    public function logout()
    {
        if (!isset($_COOKIE[self::AUTH_COOKIE_NAME])) {
            unset($_COOKIE[self::AUTH_COOKIE_NAME]);
        }
        setcookie(self::AUTH_COOKIE_NAME, null, time() - self::AUTH_COOKIE_TIME, "/");
    }
    #endregion
}
