<?php require __DIR__ . '/views/header.php'; ?>

<?php authenticateUser() ?>
<?php $posts = getPosts($pdo) ?>

<?php if (!$posts) : ?>
    <article>
        <h1><?= $config['title']; ?></h1>
        <p>Welcome, <?= $_SESSION['user']['username']; ?>!</p>
        <a href="store.php">Add a new post</a>
    </article>
<?php endif; ?>

<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php foreach ($posts as $post) : ?>
    <img src="<?= $post['media'] ?>" alt="">
    <p><?= $post['username'] ?></p>
    <p><?= $post['description'] ?></p>
    <p><?= $post['date(date)'] ?></p>

    <?php if ($post['user_id'] === $_SESSION['user']['id']) : ?>
        <a href="#">Edit post</a>
        <form action="/app/posts/update.php?id=<?= $post['id'] ?>" method="post">
            <label for="description">Description</label>
            <input type="text" name="description" required>
            <button type="submit" name="submit">Submit</button>
        </form>
        <form action="/app/posts/delete.php?id=<?= $post['id'] ?>" method="post">
            <label for="delete">Delete</label>
            <button type="submit" name="submit">Delete</button>
        </form>
    <?php endif; ?>

    <form class="form form--likes" action="/app/posts/likes.php" method="post">
        <label for="likes"><?= $post['likes'] ?></label>
        <input type="hidden" name="id" value=" <?= $post['id'] ?>">
        <button type="submit" name="submit">Submit</button>
    </form>

<?php endforeach; ?>



<?php require __DIR__ . '/views/footer.php'; ?>
