<?php

declare(strict_types=1);

require __DIR__.'/../autoload.php';

if (isset($_POST['description'], $_GET['id'])) {
    $description = sanitizeString($_POST['description']);
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = $_SESSION['user']['id'];

    $query = 'UPDATE posts SET description = :description WHERE id = :id AND user_id = :user_id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();

    if (!$statement) {
        displayMessage('Couldnt update settings!');
    } else {
        displayMessage('Settings updated!');
    }
}

redirect('/');
