<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActialExt = strtolower(end($fileExt));

    $allowed =  ['jpg', 'jpeg', 'png', 'svg', 'pdf'];

    if (in_array($fileActialExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 300000) {
                $fileNameNew = uniqid('', true).".".$fileActialExt;
                $fileDestination = __DIR__ . '/../uploads/avatars'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                redirect('/settings.php?uploadsucess');
            } else {
                $_SESSION['errors'][] = 'Your file is too big!';
                redirect('/settings.php');
            }
        } else {
            $_SESSION['errors'][] = 'There was an error uploading your file!';
            redirect('/settings.php');
        }
    } else {
        $_SESSION['errors'][] = 'You cannot upload files of this type!';
        redirect('/settings.php');
    }
}

redirect('/');
