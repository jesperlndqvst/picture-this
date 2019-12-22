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
     * Displays message.
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
if (!function_exists('getPosts')) {
    /**
     * Gets posts from database
     *
     * @param PDO $pdo
     *
     * @return array
     */
    function getPosts(PDO $pdo): array
    {
        $id = $_SESSION['user']['id'];
        $query = 'SELECT DISTINCT posts.id, posts.user_id, media, description, date(date), likes, username
        FROM posts
        INNER JOIN users ON posts.user_id = users.id
        INNER JOIN followers ON posts.user_id = followers.follow_id
        WHERE followers.user_id = :id OR posts.user_id = :id ORDER BY posts.id DESC';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
}
if (!function_exists('isLikedByUser')) {
    /**
     * Gets likes from database
     *
     * @param string $postId
     *
     * @param PDO $pdo
     *
     * @return bool
     */
    function isLikedByUser(string $postId, PDO $pdo): bool
    {
        $id = $_SESSION['user']['id'];
        $query = 'SELECT post_id, user_id FROM likes
        WHERE user_id = :id AND post_id = :postId';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':postId', $postId, PDO::PARAM_STR);
        $statement->execute();
        $like = $statement->fetch(PDO::FETCH_ASSOC);
        if ($like) {
            return true;
        } else {
            return false;
        }
    }
}
