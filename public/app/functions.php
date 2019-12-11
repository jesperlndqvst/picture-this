<?php

declare(strict_types=1);

if (!function_exists('redirect')) {
    /**
     * Redirect the user to given path.
     *
     * @param string $path
     *
     * @return void
     */
    function redirect(string $path)
    {
        header("Location: ${path}");
        exit;
    }
}
if (!function_exists('isLoggedIn')) {
    /**
     * Redirect the user to the login page if the user has not logged in.
     *
     * @return void
     */
    function isLoggedIn()
    {
        if (!isset($_SESSION['user'])) {
            redirect('/login.php');
        }
    }
}
