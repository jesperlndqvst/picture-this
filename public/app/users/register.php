<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $email = filter_var(strtolower(trim($_POST['email'])), FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $biography = 'No bigraphy set';

    // Checks if email is valid
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['errors'][] = 'Not a valid email!';
        redirect('/register.php');
   }

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
                $_SESSION['errors'][] = 'Username is already taken';
            }
            if ($user['email'] === $email) {
                $_SESSION['errors'][] = 'Email is already taken';
            }
        }
        redirect('/register.php');
    }

    // Insert user into database
    $query = 'INSERT INTO users (username, email, password, biography)
    VALUES (:username, :email, :password, :biography)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':username', $username, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
    $statement->execute();
    redirect('/login.php');
}
redirect('/login.php');
