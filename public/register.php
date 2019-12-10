<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1>Register</h1>

    <form action="app/users/register.php" method="post">

        <div>
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
            <small>Please provide the your username.</small>
            <?php if (isset($_SESSION['username_error'])) : ?>
                <p><?php echo $_SESSION['username_error']; ?>!</p>
                <?php unset($_SESSION['username_error']); ?>
            <?php endif; ?>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>
            <small>Please provide the your email address.</small>
            <?php if (isset($_SESSION['email_error'])) : ?>
                <p><?php echo $_SESSION['email_error']; ?>!</p>
                <?php unset($_SESSION['email_error']); ?>
            <?php endif; ?>
        </div>

        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <small>Please provide the your password (passphrase).</small>
        </div>

        <button type="submit">Register</button>
    </form>
</article>

<?php require __DIR__ . '/views/footer.php'; ?> 
