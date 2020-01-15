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
        displayMessage("There was an error with your email/password combination. Please try again.");
        redirect('/login.php');
    }
    if (password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user']['id'] = $user['id'];
    } else {
        displayMessage("There was an error with your email/password combination. Please try again.");
    }
}

redirect('/');
