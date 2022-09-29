<?php

namespace Csrf;


class Csrf
{

    /**
     * @param string $name
     * @param int $expiry default 600 = 10mins
     * @return \stdClass
     */
    public static function newToken(string $name, int $expiry = 600): \stdClass
    {
        $token = new \stdClass();
        $token->name = $name;
        $token->expiry = time() + $expiry;
        $token->value = md5(uniqid(mt_rand(), true));
        return $_SESSION['tokens'][$name] = $token;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public static function getToken(string $name): mixed
    {
        return $_SESSION['tokens'][$name] ?? null;
    }

    public static function isSessionStarted(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE ? true : false;
    }

    /**
     * @param string $name
     * @param int $expiry default 600 = 10mins
     * @return string
     */
    public static function createInput(string $name, int $expiry = 600): string
    {
        if (!self::isSessionStarted())
            return false;
        if (self::IsNullOrEmptyString($name))
            return false;
        $token = self::getToken($name) ?? self::newToken($name, $expiry);
        if (empty($token) || time() > $token->expiry)
            $token = self::newToken($name, $expiry);
        return '<input type="hidden" id="token" name="token" value="' . $token->value . '">';
    }

    /**
     * @param string $name
     * @param $unsetToken
     * @param $sentToken
     * @return bool
     */
    public static function verify(string $name, $unsetToken = false, $sentToken = null): bool
    {
        if (!self::isSessionStarted())
            return false;
        if (self::IsNullOrEmptyString($name))
            return false;
        $sentToken = $sentToken ?? $_POST['token'] ?? null;
        if (empty($sentToken))
            return false;
        $token = self::getToken($name);
        if (empty($token))
            return false;
        if (time() > $token->expiry) {
            self::unsetToken($name);
            return false;
        }

        if ($unsetToken)
            self::unsetToken($name);
        return $token->value === $sentToken ? true : false;
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function unsetToken(string $name): bool
    {
        if (!self::isSessionStarted())
            return false;
        if (self::IsNullOrEmptyString($name))
            return false;
        unset($_SESSION['tokens'][$name]);
        return true;
    }

    public static function IsNullOrEmptyString($str): bool
    {
        return (is_null($str) || empty(trim($str)));
    }
}