<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>

<?php authenticateUser() ?>
<?php $user = getUserById($_SESSION['user']['id'], $pdo) ?>

<?php if (isset($_GET['id'], $_GET['username'])) : ?>
    <?php $profile = getProfileById($_GET['id'], $pdo) ?>
    <article class="profile">


        <div class="profile-info">
            <img class="profile-info__img" src="app/uploads/avatars/<?= $profile['avatar'] ?>" alt="profile image">
            
        </div>





        <?php if ($_GET['id'] !== $user['id']) : ?>
            <form action="/app/users/follow.php?id=<?= $_GET['id'] ?>&username=<?= $_GET['username'] ?>" method="post">
                <button class="btn btn--lg" type="submit" name="submit">Follow</button>
            </form>
        <?php endif; ?>



        <a href="settings.php"><button class="btn btn--lg">Profile settings</button></a>


    </article>








<?php endif; ?>


<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php require __DIR__ . '/views/footer.php'; ?>
