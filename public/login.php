<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1>Login</h1>

    <?php if (isset($_SESSION['errors'])) : ?>
        <?php foreach ($_SESSION['errors'] as $error) : ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <form action="app/users/login.php" method="post">
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" required>
            <small>Please provide the your email address.</small>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <small>Please provide the your password (passphrase).</small>
        </div>

        <button type="submit">Login</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?> 
