<?php require __DIR__ . '/views/header.php'; ?>

<?php authenticateUser() ?>



<?php if (isset($_GET['id'], $_GET['username'])) : ?>
    <article>
        <h1>Profile</h1>
        <p><?= $_GET['username'] ?></p>
    </article>

    <form action="/app/users/follow.php?id=<?= $_GET['id'] ?>&username=<?= $_GET['username'] ?>" method="post">
        <label for="follow">Follow</label>
        <button type="submit" name="submit">Follow</button>
    </form>
<?php endif; ?>

<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>


<?php require __DIR__ . '/views/footer.php'; ?>
