<?php

namespace MVCore;

class Session
{

    public function __construct()
    {
        session_start();
    }

    public function setFlash($key, $value)
    {
        $_SESSION['flash'][$key] = $value;
    }

    public function getFlash($key)
    {
        if (isset($_SESSION['flash'][$key])) {
            $value = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
        }

        return $value ?? null;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public function delete($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

}