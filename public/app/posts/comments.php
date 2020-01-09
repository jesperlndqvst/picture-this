<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

authenticateUser();
$user = getUserById(((int)$_SESSION['user']['id']), $pdo);


// Post comment

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

// Delete comment

if (isset($_GET['id'], $_GET['commentId'])) {
    $postId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $commentId = filter_var($_GET['commentId'], FILTER_SANITIZE_NUMBER_INT);
    $query = "DELETE FROM comments WHERE id = :commentId AND post_id = :postId";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();
}

redirect("../../comments.php?id=$postId");
