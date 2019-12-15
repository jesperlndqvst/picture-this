<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


// Change post description

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = $_SESSION['user']['id'];

    $query = "INSERT INTO likes (post_id, user_id) VALUES (:id, :user_id)";
    $statement = $pdo->prepare($query);
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
