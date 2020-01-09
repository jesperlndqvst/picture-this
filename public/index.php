<?php

require __DIR__ . '/views/header.php';
require __DIR__ . '/views/navigation.php';

authenticateUser();
$user = getUserById($_SESSION['user']['id'], $pdo);
if (isset($_GET['username'])) {
    $posts = getUserPosts($_GET['username'], $pdo);
} else {
    $posts = getAllPosts($pdo);
}

?>

<?php if (!$posts) : ?>
    <div class="welcome">
        <p>Welcome, <?= $user['username'] ?>!</p>
        <a href="store.php">Add new post</a>
    </div>
<?php endif; ?>


<article class="posts">

    <?php if (isset($_SESSION['errors'])) : ?>
        <div class="errors">
            <?php foreach ($_SESSION['errors'] as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <?php foreach ($posts as $post) : ?>
        <div class="post" id="<?= $post['id'] ?>">

            <div class="post__user-info">
                <div>
                    <img src="app/uploads/avatars/<?= $post['avatar'] ?>" alt="avatar image">
                    <a href="/profile.php?id=<?= $post['user_id'] ?>&username=<?= $post['username'] ?>">
                        <p><?= $post['username'] ?></p>
                    </a>
                </div>
                <?php if ($post['user_id'] === $user['id']) : ?>
                    <a class="user-info__edit"><img src="assets/images/edit.svg" alt="edit post"></a>
                <?php endif; ?>
            </div>

            <img class="post__img" src="app/uploads/posts/<?= $post['media'] ?>" alt="post image">

            <div class="post__post-info">
                <form class="form form--likes" action="/app/posts/likes.php" method="post">
                    <input type="hidden" name="id" value=" <?= $post['id'] ?>">
                    <button type="submit" name="submit">
                        <i class="<?= isLikedByUser((int) $post['id'], $pdo) ? "fas fa-heart" : "far fa-heart"  ?>"></i>
                    </button>
                    <p><?= $post['likes'] ?></p>
                </form>

                <p><?= $post['description'] ?></p>
                <p><?= $post['date(date)'] ?></p>

                <?php if ($post['user_id'] === $user['id']) : ?>
                    <div class="post-edit hidden">

                        <div class="post-edit-container">
                            <h2 class="heading-l">Edit post</h2>
                            <div class="post-edit__exit">
                                <a><img src="assets/images/close.svg" alt="close"></a>
                            </div>
                            <img class="post-edit__img" src="app/uploads/posts/<?= $post['media'] ?>" alt="post image">
                            <div class="post-edit__forms">
                                <form class="form form--update" action="/app/posts/update.php?id=<?= $post['id'] ?>" method="post">
                                    <textarea class="form__input" rows="4" cols="50" name="description" required><?= $post['description'] ?></textarea>
                                    <button class="btn btn--lg" type="submit" name="submit">Edit description</button>
                                </form>
                                <form class="form form--delete" action="/app/posts/delete.php?id=<?= $post['id'] ?>" method="post">
                                    <button class="btn btn--lg" type="submit" name="submit">Delete post</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <a href="comments.php?id=<?= $post['id'] ?>"><i class="far fa-comment"></i> Comment</a>
            </div>

        </div>

    <?php endforeach; ?>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
