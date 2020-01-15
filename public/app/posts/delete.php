<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';
authenticateUser($pdo);

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];

    // Delete file
    $query = 'SELECT media FROM posts WHERE id = :id AND user_id = :userId';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();
    $post = $statement->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        unlink('../uploads/posts/' . $post['media']);
    }

    // Delete post
    $query = 'DELETE FROM posts WHERE id = :id AND user_id = :userId';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();

    if (!$statement) {
        displayMessage("Couldn't delete post. Try again.");
    } else {
        displayMessage('Post deleted.');
    }
}

redirect('/');
