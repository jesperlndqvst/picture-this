<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_SESSION['user']['id'];

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

// Change email, usename, biography

if (isset($_POST['email'], $_POST['password'], $_POST['biography'])) {
    $email = sanitizeEmail($_POST['email']);
    $password = hashPassword($_POST['password']);
    $biography = sanitizeString($_POST['biography']);

    validateEmail($email, '/settings.php');

    // If email is already taken
    $query = 'SELECT email FROM users WHERE email = :email';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        displayMessage('Email is already taken');
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
        displayMessage('Couldnt update settings!');
    } else {
        displayMessage('Settings updated!');
    }
    redirect('/settings.php');
}

redirect('/');
