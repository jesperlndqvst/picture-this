<?php
require __DIR__ . '/views/header.php';
require __DIR__ . '/views/navigation.php';
authenticateUser();
?>

<article class="store">

    <h2 class="heading-l">New post</h2>

    <?php if (isset($_SESSION['errors'])) : ?>
        <div class="errors">
            <?php foreach ($_SESSION['errors'] as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <form class="form form--store" action="app/posts/store.php" method="POST" enctype="multipart/form-data">
        <div class="form--store__img"></div>
        <input class="form--store__input" type="file" name="file">
        <textarea class="form__input" rows="4" cols="50" name="description" placeholder="Write a image description..."></textarea>
        <button class="btn btn--lg" type="submit" name="submit">Upload</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
