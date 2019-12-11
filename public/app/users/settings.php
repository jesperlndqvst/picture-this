<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = sanitizeEmail($_POST['email']);
    $password = hashPassword($_POST['password']);
    $biography = filter_var($_POST['biography'], FILTER_SANITIZE_STRING);
    $id = $_SESSION['user']['id'];

    validateEmail($email, '/settings.php');

    // If email is already taken
    $query = 'SELECT email FROM users WHERE email = :email';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['errors'][] = 'Email is already taken';
        redirect('/settings.php');
    }

    // Updates user data
    $query = 'UPDATE users SET email = :email, password = :password, biography = :biography WHERE id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    if (!$statement) {
        $_SESSION['errors'][] = 'Couldnt update settings!';
    } else {
        $_SESSION['errors'][] = 'Settings updated!';
    }

    redirect('/settings.php');
}

redirect('/');
