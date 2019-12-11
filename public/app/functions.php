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

if (!function_exists('sanitizeUsername')) {
    /**
     * Sanitizes username.
     *
     * @param string $username
     *
     * @return string
     */
    function sanitizeUsername($username)
    {
        return filter_var(trim($username), FILTER_SANITIZE_STRING);
    }
}

if (!function_exists('sanitizeEmail')) {
    /**
     * Sanitizes email.
     *
     * @param string $email
     *
     * @return string
     */
    function sanitizeEmail($email)
    {
        return filter_var(strtolower(trim($email)), FILTER_SANITIZE_EMAIL);
    }
}

if (!function_exists('hashPassword')) {
    /**
     * Hash encrypts password.
     *
     * @param string $password
     *
     * @return string
     */
    function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}


if (!function_exists('validateEmail')) {
    /**
     * Validates email and redirects user to given path if email is not valid.
     *
     * @param string $email
     *
     * @return void
     */
    function validateEmail($email, $path)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errors'][] = 'Not a valid email!';
            redirect("${path}");
        }
    }
}
