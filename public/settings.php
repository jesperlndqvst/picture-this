<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/navigation.php'; ?>

<?php authenticateUser() ?>
<?php $user = getUserById($_SESSION['user']['id'], $pdo) ?>

<article>
    <h1>Settings</h1>
    <p>Change your settings</p>
</article>

<?php if (isset($_SESSION['errors'])) : ?>
    <?php foreach ($_SESSION['errors'] as $error) : ?>
        <p><?= $error ?></p>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<img src="app/uploads/avatars/<?= $user['avatar'] ?>" alt="avatar image">


<form action="app/users/settings.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <button type="submit" name="submit">Upload</button>
</form>

<form action="app/users/settings.php" method="post">
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?= $user['username'] ?>" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?= $user['email'] ?>" required>
    </div>
    <div>
        <label for="biography">Biography</label>
        <input type="text" name="biography" id="biography" value="<?= $user['biography'] ?>" required>
    </div>
    <button type="submit">Submit</button>
</form>

<form action="app/users/settings.php" method="post">
    <div>
        <label for="password">Current password</label>
        <input type="password" name="password" id="password" required>
    </div>
    <div>
        <label for="new-password">New password</label>
        <input type="password" name="new-password" id="new-password" required>
    </div>
    <div>
        <label for="repeat-password">Repeat password</label>
        <input type="password" name="repeat-password" id="repeat-password" required>
    </div>
    <button type="submit">Change password</button>
</form>


<a href="/app/users/logout.php">Log out</a>


<?php require __DIR__ . '/views/footer.php'; ?>
