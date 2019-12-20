<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$user = getUserById($_SESSION['user']['id'], $pdo);
$id = $user['id'];

// Change avatar image

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $fileExt = explode('.', $fileName);
    $fileActialExt = strtolower(end($fileExt));

    $allowed =  ['jpg', 'jpeg', 'png', 'svg', 'pdf'];

    if (in_array($fileActialExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 300000) {

                // Delete old file
                $standardAvatar = 'undefined.svg';
                $query = 'SELECT avatar FROM users WHERE id = :id AND avatar != :standardAvatar';
                $statement = $pdo->prepare($query);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->bindParam(':standardAvatar', $standardAvatar, PDO::PARAM_STR);
                $statement->execute();
                $user = $statement->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    unlink('../uploads/avatars/' . $user['avatar']);
                }

                // Uploads new file
                $fileNameNew = uniqid('', true) . "." . $fileActialExt;
                $fileDestination = __DIR__ . '/../uploads/avatars/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                displayMessage('Your image is uploaded!');
                $avatar = $fileNameNew;

                // Updates user data
                $query = 'UPDATE users SET avatar = :avatar WHERE id = :id';
                $statement = $pdo->prepare($query);
                $statement->bindParam(':avatar', $avatar, PDO::PARAM_STR);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->execute();
            } else {
                displayMessage('Your file is too big!');
            }
        } else {
            displayMessage('There was an error uploading your file!');
        }
    } else {
        displayMessage('You cannot upload files of this type!');
    }
    redirect('/settings.php');
}

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
        // Updates password
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
