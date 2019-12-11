<?php

declare(strict_types=1);


require __DIR__ . '/../autoload.php';

if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var(strtolower(trim($_POST['email'])), FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $id = $_SESSION['user']['id'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'][] = 'Not a valid email!';
        redirect('/settings.php');
    }

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
    $query = 'UPDATE users SET email = :email, password = :password WHERE id = :id;';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
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
