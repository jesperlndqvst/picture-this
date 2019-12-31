<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>

<?php authenticateUser() ?>
<?php $user = getUserById($_SESSION['user']['id'], $pdo) ?>
<?php $posts = getPosts($pdo) ?>

<?php if (!$posts) : ?>
    <article>
        <h1><?= $config['title']; ?></h1>
        <p>Welcome, <?= $user['username'] ?>!</p>
        <a href="store.php">Add a new post</a>
    </article>
<?php endif; ?>

<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<article class="posts">
    <?php foreach ($posts as $post) : ?>
        <div class="post">

            <div class="post__user-info">
                <div>
                    <img src="app/uploads/avatars/<?= $post['avatar'] ?>" alt="avatar image">
                    <p><?= $post['username'] ?></p>
                </div>
                <?php if ($post['user_id'] === $user['id']) : ?>
                    <a class="user-info__edit"><img src="assets/images/edit.svg" alt="edit post"></a>
                <?php endif; ?>
            </div>

            <img class="post__img" src="app/uploads/posts/<?= $post['media'] ?>" alt="post image">

            <div class="post__post-info">
                <form class="form form--likes" action="/app/posts/likes.php" method="post">
                    <label for="likes"><?= $post['likes'] ?></label>
                    <input type="hidden" name="id" value=" <?= $post['id'] ?>">
                    <button type="submit" name="submit">
                        <i class="<?= isLikedByUser((int) $post['id'], $pdo) ? "fas fa-heart" : "far fa-heart"  ?>"></i>
                    </button>
                </form>

                <p><?= $post['description'] ?></p>
                <p><?= $post['date(date)'] ?></p>

                <?php if ($post['user_id'] === $user['id']) : ?>
                    <div class="post-info__edit hidden">
                        <form class="form form--update" action="/app/posts/update.php?id=<?= $post['id'] ?>" method="post">
                            <label for="description">New description</label>
                            <input type="text" name="description" required>
                            <button type="submit" name="submit">Submit</button>
                        </form>
                        <form class="form form--delete" action="/app/posts/delete.php?id=<?= $post['id'] ?>" method="post">
                            <label for="delete">Delete</label>
                            <button type="submit" name="submit">Delete</button>
                        </form>
                    </div>
                <?php endif; ?>


                <a href="comments.php?id=<?= $post['id'] ?>">Comment...</a>
            </div>


        </div>
</article>
<?php endforeach; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
