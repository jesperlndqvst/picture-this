<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>

<?php authenticateUser() ?>
<?php $user = getUserById($_SESSION['user']['id'], $pdo) ?>

<article class="settings">

    <div class="avatar-settings">
        <img class="avatar-settings__img" src="app/uploads/avatars/<?= $user['avatar'] ?>" alt="avatar image">

        <form class="avatar-settings__form" action="app/users/avatar.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <button class="btn btn--lg" type="submit" name="submit">Change avatar</button>
        </form>

    </div>

    <div class="profile-settings">
        <form action="app/users/settings.php" method="post">
            <div>
                <label for="username">Username</label>
                <input class="form__input " type="text" name="username" id="username" value="<?= $user['username'] ?>" required>
            </div>
            <div>
                <label for="email">Email</label>
                <input class="form__input " type="text" name="email" id="email" value="<?= $user['email'] ?>" required>
            </div>
            <div>
                <label for="biography">Biography</label>
                <input class="form__input " type="text" name="biography" id="biography" value="<?= $user['biography'] ?>" required>
            </div>
            <button class="btn btn--lg" type="submit">Save information</button>
        </form>
    </div>

    <div class="password-settings">
        <form action="app/users/password.php" method="post">
            <div>
                <label for="password">Current password</label>
                <input class="form__input " type="password" name="password" id="password" required>
            </div>
            <div>
                <label for="new-password">New password</label>
                <input class="form__input " type="password" name="new-password" id="new-password" required>
            </div>
            <div>
                <label for="repeat-password">Repeat password</label>
                <input class="form__input " type="password" name="repeat-password" id="repeat-password" required>
            </div>
            <button class="btn btn--lg" type="submit">Change password</button>
        </form>
    </div>

    <a href="/app/users/logout.php"><button class="btn btn--lg">Log out</button></a>

</article>

<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>






<?php require __DIR__ . '/views/footer.php'; ?>
