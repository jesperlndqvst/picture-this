<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

authenticateUser();

if(isset($_GET['id'], $_POST['comment'])) {
    $postId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];
    $comment = sanitizeString($_POST['comment']);

    $query = "INSERT INTO comments (post_id, user_id, comment, date) VALUES (:postId, :userId, :comment, julianday('now'))";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
    $statement->execute();
}

redirect("../../comments.php?id=$postId");
