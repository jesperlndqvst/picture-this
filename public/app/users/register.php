<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
    $username = sanitizeUsername($_POST['username']);
    $email = sanitizeEmail($_POST['email']);
    $password = hashPassword($_POST['password']);
    $biography = 'No bigraphy set';
    $avatar = 'undefined.svg';

    validateEmail($email, '/register.php');

    $query = 'SELECT username, email FROM users WHERE username = :username OR email = :email';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    // If username or email is taken display error
    if ($users) {
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                displayMessage('Username is already in use');
            }
            if ($user['email'] === $email) {
                displayMessage('Email is already in use');
            }
        }
        redirect('/register.php');
    }

    // Insert user into database
    $query = 'INSERT INTO users (username, email, password, biography, avatar)
    VALUES (:username, :email, :password, :biography, :avatar)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
    $statement->bindParam(':avatar', $avatar, PDO::PARAM_STR);
    $statement->execute();

    // Gets user by email
    $query = 'SELECT * FROM users WHERE email = :email';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION['user']['id'] = $user['id'];

    // Insert user into followers table
    $id = $user['id'];
    $query = 'INSERT INTO followers (user_id, follow_id)
    VALUES (:id, :id)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
}

redirect('/');
