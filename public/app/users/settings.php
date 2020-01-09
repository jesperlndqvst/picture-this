<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$user = getUserById((int)$_SESSION['user']['id'], $pdo);
$id = $user['id'];

// Change username, email and biography

if (isset($_POST['username'], $_POST['email'], $_POST['biography'])) {
    $username = sanitizeUsername($_POST['username']);
    $email = sanitizeEmail($_POST['email']);
    $biography = sanitizeString($_POST['biography']);
    $currentUsername = $user['username'];
    $currentEmail = $user['email'];

    validateEmail($email, '/settings.php');

    // If username is already taken
    $query = 'SELECT username FROM users
    WHERE username = :username AND username != :currentUsername';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':currentUsername', $currentUsername, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        displayMessage('Username is already taken');
        redirect('/settings.php');
    }
    // If email is already taken
    $query = 'SELECT email FROM users
    WHERE email = :email AND email != :currentEmail';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':currentEmail', $currentEmail, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        displayMessage('Email is already taken');
        redirect('/settings.php');
    }

    // Updates user data
    $query = 'UPDATE users SET username = :username, email = :email, biography = :biography WHERE id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    if (!$statement) {
        displayMessage('Couldnt update settings!');
    } else {
        displayMessage('Settings updated!');
    }
    redirect('/settings.php');
}

redirect('/');
