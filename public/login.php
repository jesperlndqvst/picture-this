<?php require __DIR__ . '/views/header.php'; ?>

<div class="login-container">
    <h1><?= $config['title']; ?></h1>

    <?php if (isset($_SESSION['errors'])) : ?>
        <?php foreach ($_SESSION['errors'] as $error) : ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <form class="form form--login" action="app/users/login.php" method="post">
        <div>
            <label for="email">Email</label>
            <input type="text" name="email" id="email" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <button type="submit">Login</button>
    </form>

    <a href="register.php">Don't have an account? Sign up.</a>
</div>

<?php require __DIR__ . '/views/footer.php'; ?> 
