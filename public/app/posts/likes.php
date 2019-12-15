<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $user_id = $_SESSION['user']['id'];

    // Checks if user has already liked
    $query = 'SELECT * FROM likes WHERE post_id = :id AND user_id = :user_id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);

    if($result) {
        // Remove like
        $query = "DELETE FROM likes WHERE post_id = :id AND user_id = :user_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
    } else {
        // Insert like
        $query = "INSERT INTO likes (post_id, user_id) VALUES (:id, :user_id)";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
    }

    // Count likes
    $query = 'SELECT COUNT(post_id) FROM likes
    WHERE post_id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $like = $statement->fetch(PDO::FETCH_ASSOC);
    $likes = $like['COUNT(post_id)'];

    // Updates post table
    $query = "UPDATE posts SET likes = :likes WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':likes', $likes, PDO::PARAM_INT);
    $statement->execute();
}


redirect('/');
