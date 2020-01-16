<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_GET['id'])) {
    $userId = (int) $_SESSION['user']['id'];
    $followId = (int) filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    if ($userId !== $followId) {

         if (!isFollowed($userId, $followId, $pdo)) {
            // Follow user
            $query = 'INSERT INTO followers (user_id, follow_id)
            VALUES (:userId, :followId)';
            $statement = $pdo->prepare($query);
            $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
            $statement->bindParam(':followId', $followId, PDO::PARAM_INT);
            $statement->execute();
         } else {
            // Unfollow user
            $query = 'DELETE FROM followers
            WHERE user_id = :userId AND follow_id = :followId';
            $statement = $pdo->prepare($query);
            $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
            $statement->bindParam(':followId', $followId, PDO::PARAM_INT);
            $statement->execute();
         }
    }
}

redirect('/../../profile.php?id=' . $_GET['id'] . '&username=' . $_GET['username']);
