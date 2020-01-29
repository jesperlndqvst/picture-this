<?php

declare(strict_types=1);
require __DIR__ . '/../autoload.php';

//TODO remove files aswell


if (isset($_POST['id'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    //get all users posts
    $query = 'SELECT * FROM posts WHERE user_id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    //get avatar image
    $avatar = getUserById($id, $pdo)['avatar'];

    //delete avatar image
    unlink('../uploads/avatars/' . $avatar);

    if ($posts) {
        //delete posts images
        foreach ($posts as $post) {
            unlink('../uploads/posts/' . $post['media']);
        }
        //delete all likes from posts by user
        foreach ($posts as $post) {
            $query = 'DELETE FROM likes WHERE post_id = :postId';
            $statement = $pdo->prepare($query);
            $statement->bindParam(':postId', $post['id'], PDO::PARAM_INT);
            $statement->execute();
        }
        //coments on all posts by user
        foreach ($posts as $post) {
            $query = 'DELETE FROM comments WHERE post_id = :postId';
            $statement = $pdo->prepare($query);
            $statement->bindParam(':postId', $post['id'], PDO::PARAM_INT);
            $statement->execute();
        }
    }

    //delete from posts
    $query = 'DELETE FROM posts WHERE user_id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    //delete from likes
    $query = 'DELETE FROM likes WHERE user_id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    //delete from followers
    $query = 'DELETE FROM followers WHERE user_id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $query = 'DELETE FROM followers WHERE follow_id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    //delete from comments
    $query = 'DELETE FROM comments WHERE user_id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    //delete from users
    $query = 'DELETE FROM users WHERE id = :id';
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    displayMessage('Your account is deleted');
    redirect('/login.php');
}
