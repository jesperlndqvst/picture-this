<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>

<?php authenticateUser() ?>
<?php $user = getUserById($_SESSION['user']['id'], $pdo) ?>


<?php if (isset($_GET['id'], $_GET['username'])) : ?>
    <?php $profile = getProfileById($_GET['id'], $pdo) ?>
    <?php $postsCount = getPostsCountById($_GET['id'], $pdo) ?>
    <?php $followsCount = getFollowCountById($_GET['id'], $pdo) ?>
    <?php $posts = getProfilePostsById($_GET['id'], $pdo) ?>


    <article class="profile">

        <div class="profile-info">
            <img class="profile-info__img" src="app/uploads/avatars/<?= $profile['avatar'] ?>" alt="profile image">
            <div class="profile-info__posts">
                <p><?= $postsCount['posts'] ?></p>
                <p>Posts</p>
            </div>
            <div class="profile-info__followers">
                <p><?= $followsCount['followers'] ?></p>
                <p>Followers</p>
            </div>
            <div class="profile-info__following">
                <p><?= $followsCount['following'] ?></p>
                <p>Following</p>
            </div>
        </div>

        <div class="profile-description">
            <p class="text-bold"><?= $profile['username'] ?></p>
            <p><?= $profile['biography'] ?></p>
        </div>


        <?php if ($_GET['id'] !== $user['id']) : ?>
            <form action="/app/users/follow.php?id=<?= $_GET['id'] ?>&username=<?= $_GET['username'] ?>" method="post">
                <button class="btn btn--lg" type="submit" name="submit">
                    <?= isFollowed($user['id'], $_GET['id'], $pdo) ? 'Unfollow' : 'Follow' ; ?>
                </button>
            </form>
        <?php endif; ?>

        <a href="settings.php"><button class="btn btn--lg">Profile settings</button></a>

        <div class="profile-posts">
            <?php foreach ($posts as $post) : ?>
                <img class="profile-posts__img" src="app/uploads/posts/<?= $post['media'] ?>" alt="post image">
            <?php endforeach; ?>
        </div>

    </article>








<?php endif; ?>


<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
