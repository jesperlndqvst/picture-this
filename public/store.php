<?php require __DIR__ . '/views/header.php'; ?>
<?php authenticateUser() ?>
<article>
    <h1><?php echo $config['title']; ?></h1>
    <p>Add new post</p>
</article>


<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>


<article>
    <form action="app/posts/store.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="text" name="description">
        <button type="submit" name="submit">Upload</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
