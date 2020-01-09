<?php require __DIR__ . '/views/header.php'; ?>

<article class="login">
    <h1 class="heading heading--lg"><?= $config['title']; ?></h1>

    <?php if (isset($_SESSION['errors'])) : ?>
        <div class="errors">
            <?php foreach ($_SESSION['errors'] as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        </div>
    <?php endif; ?>

    <form class="form form--login" action="app/users/login.php" method="post">
        <input class="form__input" type="email" name="email" id="email" placeholder="Email" value autocomplete="off" required>
        <input class="form__input" type="password" name="password" id="password" placeholder="Password" value autocomplete="off" required>
        <button class="btn btn--lg" type="submit">Log in</button>
    </form>

    <a class="login__signup-link" href="register.php">Don't have an account yet? <span class="text-bold">Sign up.</span></a>
</article>

<?php require __DIR__ . '/views/footer.php'; ?>
