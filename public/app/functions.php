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
if (!function_exists('getAllPosts')) {
    /**
     * Gets all posts from database
     *
     * @param PDO $pdo
     *
     * @return array
     */
    function getAllPosts(PDO $pdo): array
    {
        $id = $_SESSION['user']['id'];
        $query = 'SELECT DISTINCT posts.id, posts.user_id, media, description, date(date), likes, username, avatar
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
if (!function_exists('getUserPosts')) {
    /**
     * Gets user posts from database
     *
     * @param string $username
     *
     * @param PDO $pdo
     *
     * @return array
     */
    function getUserPosts(string $username, PDO $pdo): array
    {
        $username = sanitizeUsername($_GET['username']);
        $query = 'SELECT posts.id, posts.user_id, media, description, date(date), likes, username, avatar FROM posts
        INNER JOIN users ON posts.user_id = users.id WHERE username = :username
        ORDER BY posts.id DESC';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        if(!$posts) {
            $posts = getAllPosts($pdo);
        }
        return $posts;
    }
}
if (!function_exists('isLikedByUser')) {
    /**
     * Gets likes from database
     *
     * @param int $postId
     *
     * @param PDO $pdo
     *
     * @return bool
     */
    function isLikedByUser(int $postId, PDO $pdo): bool
    {
        $id = $_SESSION['user']['id'];
        $query = 'SELECT post_id, user_id FROM likes
        WHERE user_id = :id AND post_id = :postId';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
        $statement->execute();
        $like = $statement->fetch(PDO::FETCH_ASSOC);
        return $like ? true : false;
    }
}
if (!function_exists('getComments')) {
    /**
     * Gets comments from database
     *
     * @param int $postId
     *
     * @param PDO $pdo
     *
     * @return array
     */
    function getComments(int $postId, PDO $pdo): array
    {
        $query = 'SELECT username, comment, avatar, date(date) AS date
        FROM comments INNER JOIN users ON comments.user_id = users.id
        WHERE post_id = :postId';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
        $statement->execute();
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $comments;
    }
}
if (!function_exists('getProfileById')) {
    /**
     * Gets profile information from database
     *
     * @param int $profileId
     *
     * @param PDO $pdo
     *
     * @return array
     */
    function getProfileById(int $profileId, PDO $pdo): array
    {
        $query = 'SELECT username, biography, avatar FROM users
        WHERE users.id = :profileId';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $statement->execute();
        $profile = $statement->fetch(PDO::FETCH_ASSOC);
        return $profile;
    }
}
if (!function_exists('getPostsCountById')) {
    /**
     * Gets post count information from database
     *
     * @param int $profileId
     *
     * @param PDO $pdo
     *
     * @return string
     */
    function getPostsCountById(int $profileId, PDO $pdo): string
    {
        $query = 'SELECT count(id) AS posts FROM posts
        WHERE user_id = :profileId';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $statement->execute();
        $postsCount = $statement->fetch(PDO::FETCH_ASSOC);
        return $postsCount['posts'];
    }
}
if (!function_exists('getFollowersCountById')) {
    /**
     *
     * Gets followers count information from database
     *
     * @param int $profileId
     *
     * @param PDO $pdo
     *
     * @return string
     */
    function getFollowersCountById(int $profileId, PDO $pdo): string
    {
        $query = 'SELECT count(user_id) -1 AS followers FROM followers
        WHERE follow_id = :profileId;';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $statement->execute();
        $followCount = $statement->fetch(PDO::FETCH_ASSOC);
        return $followCount['followers'];
    }
}
if (!function_exists('getFollowingCountById')) {
    /**
     *Gets following count information from database
     *
     * @param int $profileId
     *
     * @param PDO $pdo
     *
     * @return string
     */
    function getFollowingCountById(int $profileId, PDO $pdo): string
    {
        $query = 'SELECT count(follow_id) -1 AS following FROM followers
        WHERE user_id = :profileId;';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $statement->execute();
        $followingCount = $statement->fetch(PDO::FETCH_ASSOC);
        return $followingCount['following'];
    }
}

if (!function_exists('getProfilePostsById')) {
    /**
     * Gets profile images from database
     *
     * @param int $profileId
     *
     * @param PDO $pdo
     *
     * @return array
     */
    function getProfilePostsById(int $profileId, PDO $pdo): array
    {
        $query = 'SELECT media FROM posts
        WHERE user_id = :profileId ORDER BY date DESC';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $statement->execute();
        $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
}
if (!function_exists('getSearchResult')) {
    /**
     * Gets profile images from database
     *
     * @param string $search
     *
     * @param PDO $pdo
     *
     * @return array
     */
    function getSearchResult(string $search, PDO $pdo): array
    {
        $search = filter_var($_GET['search'], FILTER_SANITIZE_STRING);
        $statement = $pdo->prepare('SELECT username, id, avatar FROM users WHERE username LIKE :search');
        if (!$statement) {
            die(var_dump($pdo->errorInfo()));
        }
        $search = '%' . $search . '%';
        $statement->bindParam(':search', $search, PDO::PARAM_STR);
        $statement->execute();
        $searchResults = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!$searchResults) {
            displayMessage('No users found');
        }
        return $searchResults;
    }
}
if (!function_exists('isFollowed')) {
    /**
     * Checks if user is followed
     *
     * @param userId $userId
     *
     * @param profileId $profileId
     *
     * @param PDO $pdo
     *
     * @return bool
     */
    function isFollowed(int $userId, int $profileId, PDO $pdo): bool
    {
        $query = 'SELECT * FROM followers
        WHERE user_id = :userId AND follow_id = :profileId';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':profileId', $profileId, PDO::PARAM_INT);
        $statement->execute();
        $isFollowed = $statement->fetch(PDO::FETCH_ASSOC);
        if($isFollowed) {
            return true;
        }
        return false;
    }
}
