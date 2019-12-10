<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Checks if email or username is taken
    $statement = $pdo->prepare('SELECT username, email FROM users');
    $statement->execute();
    $users = $statement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        if ($user['username'] === $username || $user['email'] === $email) {
            if ($user['username'] === $username) {
                $_SESSION['username_error'] = 'Username is already taken';
            }
            if ($user['email'] === $email) {
                $_SESSION['email_error'] = 'Email is already taken';
            }
            redirect('/register.php');
        }
    }

    // Inserts user data to database
    $query = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->execute();
}

redirect('/login.php');
