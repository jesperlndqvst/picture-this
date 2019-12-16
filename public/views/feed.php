<?php

$id = $_SESSION['user']['id'];

$query = 'SELECT DISTINCT posts.id, posts.user_id, media, description, date(date), likes, username
FROM posts
INNER JOIN users ON posts.user_id = users.id
INNER JOIN followers ON posts.user_id = followers.follow_id
WHERE followers.user_id = :id OR posts.user_id = :id ORDER BY posts.id DESC';
$statement = $pdo->prepare($query);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);
?>


<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>


<?php if ($posts) : ?>
    <?php foreach ($posts as $post) : ?>
        <img src="<?= $post['media'] ?>" alt="">
        <p><?= $post['username'] ?></p>
        <p><?= $post['description'] ?></p>
        <p><?= $post['date(date)'] ?></p>

        <?php if ($post['user_id'] === $_SESSION['user']['id']) : ?>
            <a href="#">Edit post</a>
            <form action="/../app/posts/update.php?id=<?= $post['id'] ?>" method="post">
                <label for="description">Description</label>
                <input type="text" name="description" required>
                <button type="submit" name="submit">Submit</button>
            </form>
            <form action="/../app/posts/delete.php?id=<?= $post['id'] ?>" method="post">
                <label for="delete">Delete</label>
                <button type="submit" name="submit">Delete</button>
            </form>
        <?php endif; ?>

        <form action="/../app/posts/likes.php?id=<?= $post['id'] ?>" method="post">
            <label for="likes">Likes: <?= $post['likes']; ?> </label>
            <button type="submit" name="submit">Submit</button>
        </form>

    <?php endforeach; ?>
<?php else : ?>
    <p>No posts to show</p>
<?php endif; ?>
