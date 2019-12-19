<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_GET['id'])) {
    $userId = $_SESSION['user']['id'];
    $followId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Checks if user is in the followers table
    $query = 'SELECT user_id FROM followers
    WHERE user_id = :userId AND follow_id = :followId AND user_id != follow_id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':followId', $followId, PDO::PARAM_INT);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Unfollow user
    if ($user) {
        displayMessage('User Unfollowed');
        $query = 'DELETE FROM followers
        WHERE user_id = :userId AND follow_id = :followId';
        $statement = $pdo->prepare($query);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':followId', $followId, PDO::PARAM_INT);
        $statement->execute();
        redirect('/../../profile.php?id=' . $_GET['id'] . '&username=' . $_GET['username']);
    }

    // Follow user
    $query = 'INSERT INTO followers (user_id, follow_id)
    VALUES (:userId, :followId)';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':followId', $followId, PDO::PARAM_INT);
    $statement->execute();
}

redirect('/../../profile.php?id='.$_GET['id'].'&username='.$_GET['username']);
