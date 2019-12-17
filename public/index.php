<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1><?= $config['title']; ?></h1>
    <p>This is the home page.</p>

    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?= $_SESSION['user']['username']; ?>!</p>
        <a href="store.php">Add a new post</a>
    <?php endif; ?>
</article>

<article class="posts">
<?php if (isset($_SESSION['user'])) : ?>
    <?php require __DIR__ . '/views/feed.php'; ?>
<?php endif; ?>
</article>


<?php require __DIR__ . '/views/footer.php'; ?>
