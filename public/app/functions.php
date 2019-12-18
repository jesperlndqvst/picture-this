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

if (!function_exists('authenticateUser')) {
    /**
     * Redirect the user to the login page if the user has not logged in.
     *
     * @return void
     */
    function authenticateUser()
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
if (!function_exists('sanitizeString')) {
    /**
     * Sanitizes string.
     *
     * @param string $string
     *
     * @return string
     */
    function sanitizeString($string)
    {
        return filter_var($string, FILTER_SANITIZE_STRING);
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
     * @param string $path
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

if (!function_exists('displayMessage')) {
    /**
     * Displays an message to the user.
     *
     * @param string $message
     *
     * @return void
     */
    function displayMessage($message)
    {
        $_SESSION['errors'][] = "${message}";
    }
}

if (!function_exists('getUserById')) {
    /**
     * Gets user information from database
     *
     * @param string $id
     *
     * @param PDO $pdo
     *
     * @return array
     */
    function getUserById(string $id, PDO $pdo): array
    {
        $query = 'SELECT * FROM users WHERE id = :id';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user;
        }
        return $user = [];
    }
}
