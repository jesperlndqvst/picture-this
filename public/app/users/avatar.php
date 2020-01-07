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

redirect('/');
