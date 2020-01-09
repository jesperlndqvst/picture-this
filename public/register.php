<?php require __DIR__ . '/views/header.php'; ?>

<article class="register">

    <h1 class="heading heading--lg"><?= $config['title']; ?></h1>

    <p class="register__paragraph">Sign up to see photos and videos from your friends.<p>
            <?php if (isset($_SESSION['errors'])) : ?>
                <div class="errors">
                    <?php foreach ($_SESSION['errors'] as $error) : ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['errors']); ?>
                </div>
            <?php endif; ?>

            <form class="form form--register" action="app/users/register.php" method="post">
                <input class="form__input" type="text" name="username" id="username" placeholder="Username" value autocomplete="off" required>
                <input class="form__input" type="email" name="email" id="email" placeholder="Email" value autocomplete="off" required>
                <input class="form__input" type="password" name="password" id="password" placeholder="Password" value autocomplete="off" required>
                <button class="btn btn--lg" type="submit">Register</button>
            </form>

            <a class="register__login-link" href="login.php">Have an account? <span class="text-bold">Log in.</span></a>
</article>

<?php require __DIR__ . '/views/footer.php'; ?> 
