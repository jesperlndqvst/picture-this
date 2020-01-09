<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$user = getUserById((int)$_SESSION['user']['id'], $pdo);
$id = $user['id'];

// Change password
if (isset($_POST['password'], $_POST['new-password'], $_POST['repeat-password'])) {
    $password = $_POST['password'];
    $newPassword = $_POST['new-password'];
    $repeatPassword = $_POST['repeat-password'];

    // If passwords doesn't match
    if ($newPassword !== $repeatPassword) {
        displayMessage("Passwords doesn't match!");
        redirect('/settings.php');
    }

    if (password_verify($password, $user['password'])) {

        // Update password
        $newPassword = hashPassword($_POST['new-password']);
        $query = 'UPDATE users SET password = :newPassword WHERE id = :id';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        displayMessage("Password updated");
        redirect('/settings.php');
    } else {
        displayMessage("Wrong password!");
        redirect('/settings.php');
    }

    redirect('/settings.php');
}

redirect('/');
