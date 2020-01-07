<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

// In this file we store/insert new posts in the database.

if (isset($_POST['submit'], $_POST['description'])) {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $description = sanitizeString($_POST['description']);
    $id = $_SESSION['user']['id'];

    $fileExt = explode('.', $fileName);
    $fileActialExt = strtolower(end($fileExt));

    $allowed =  ['jpg', 'jpeg', 'png', 'svg', 'pdf'];

    if (in_array($fileActialExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 300000) {
                $fileNameNew = uniqid('', true) . "." . $fileActialExt;
                $fileDestination = __DIR__ . '/../uploads/posts/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                displayMessage('Your file is uploaded!');
                $media =  $fileNameNew;

                // Updates user data
                $query = "INSERT INTO posts (media, description, date, user_id, likes)
                VALUES (:media, :description, julianday('now'), :id, 0)";
                $statement = $pdo->prepare($query);
                $statement->bindParam(':media', $media, PDO::PARAM_STR);
                $statement->bindParam(':description', $description, PDO::PARAM_STR);
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
    redirect('/store.php');
}

redirect('/');
