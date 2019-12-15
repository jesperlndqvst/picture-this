<?php

$id = $_SESSION['user']['id'];

//Posts

$query = 'SELECT id, media, description, date(date), user_id FROM posts WHERE user_id = :id';
$statement = $pdo->prepare($query);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);

// Likes
$query = 'SELECT * FROM likes';
$statement = $pdo->prepare($query);
$statement->execute();
$likes = $statement->fetchAll(PDO::FETCH_ASSOC);



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
        <p><?= $post['description'] ?></p>
        <p><?= $post['date(date)'] ?></p>
        <a href="#">Edit post</a>


            <form action="/../app/posts/update.php?id=<?= $post['id'] ?>" method="post">
                <label for="description">Description</label>
                <input type="text" name="description"  required>
                <button type="submit" name="submit">Submit</button>
            </form>

            <form action="/../app/posts/likes.php?id=<?= $post['id'] ?>" method="post">
                <label for="likes">Likes: <?= count($likes); ?></label>
                <button type="submit" name="submit">Submit</button>
            </form>


    <?php endforeach; ?>
<?php else : ?>
    <p>No posts to show</p>
<?php endif; ?>
