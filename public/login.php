<?php require __DIR__ . '/views/header.php'; ?>

<div class="container container--login">
    <h1><?= $config['title']; ?></h1>

    <?php if (isset($_SESSION['errors'])) : ?>
        <?php foreach ($_SESSION['errors'] as $error) : ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <form class="form form--login" action="app/users/login.php" method="post">
        <input class="input input--login" type="email" name="email" id="email" placeholder="Email" value autocomplete="off" required>
        <input class="input input--login" type="text" name="password" id="password" placeholder="Password" value autocomplete="off" required>
        <button class="btn btn--login" type="submit">Log in</button>
    </form>

    <a href="register.php">Don't have an account? Sign up.</a>
</div>

<?php require __DIR__ . '/views/footer.php'; ?>
