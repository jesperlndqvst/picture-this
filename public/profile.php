<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>

<?php authenticateUser($pdo) ?>
<?php $user = getUserById($_SESSION['user']['id'], $pdo) ?>


<?php if (isset($_GET['id'], $_GET['username'])) : ?>
    <?php $profile = getProfileById($_GET['id'], $pdo) ?>
    <?php $posts = getProfilePostsById($_GET['id'], $pdo) ?>

    <article class="profile">

        <div class="profile-info">
            <img class="profile-info__img" src="app/uploads/avatars/<?= $profile['avatar'] ?>" alt="profile image">
            <div class="profile-info__posts">
                <p><?= getPostsCountById($_GET['id'], $pdo)  ?></p>
                <p>Posts</p>
            </div>
            <div class="profile-info__followers">
                <p><?= getFollowersCountById($_GET['id'], $pdo) ?></p>
                <p>Followers</p>
            </div>
            <div class="profile-info__following">
                <p><?= getFollowingCountById($_GET['id'], $pdo) ?></p>
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
                    <?= isFollowed($user['id'], $_GET['id'], $pdo) ? 'Unfollow' : 'Follow'; ?>
                </button>
            </form>
        <?php else : ?>
            <a href="settings.php"><button class="btn btn--lg">Profile settings</button></a>
        <?php endif; ?>

        <div class="profile-posts">
            <?php foreach ($posts as $post) : ?>
                <div class="profile-posts__img">
                    <a href="/?username=<?= $profile['username'] ?>#<?= $post['id'] ?>">
                        <img src="app/uploads/posts/<?= $post['media'] ?>" alt="post image">
                    </a>
                </div>

            <?php endforeach; ?>
        </div>

    </article>

<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
