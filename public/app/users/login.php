<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = sanitizeEmail($_POST['email']);

    validateEmail($email, '/login.php');

    $query = 'SELECT * FROM users WHERE email = :email';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        redirect('/login.php');
    }
    if (password_verify($_POST['password'], $user['password'])) {
        unset($user['password']);
        $_SESSION['user'] = $user;


        // Checks if user is in the followers table
        $id = $user['id'];
        $query = 'SELECT user_id FROM followers WHERE user_id = :id AND follow_id = :id';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // Insert user into followers table
            $query = 'INSERT INTO followers (user_id, follow_id)
            VALUES (:id, :id)';
            $statement = $pdo->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        }
    }
}

redirect('/');
