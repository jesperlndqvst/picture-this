<nav>
    <a href="index.php"><?= $config['title']; ?></a>

    <ul>
        <li>
            <a <?= $_SERVER['SCRIPT_NAME'] === '/index.php' ? 'active' : ''; ?>" href="/index.php">Home</a>
        </li>

        <li>
            <a <?= $_SERVER['SCRIPT_NAME'] === '/about.php' ? 'active' : ''; ?>" href="/about.php">About</a>
        </li>

        <li>
            <?php if (isset($_SESSION['user'])) : ?>
                <a href="/app/users/logout.php">Log out</a>
            <?php else : ?>
                <a <?= $_SERVER['SCRIPT_NAME'] === '/login.php' ? 'active' : ''; ?>" href="login.php">Login</a>
            <?php endif; ?>
        </li>

        <li>
            <?php if (!isset($_SESSION['user'])) : ?>
                <a <?= $_SERVER['SCRIPT_NAME'] === '/register.php' ? 'active' : ''; ?>" href="register.php">Register</a>
            <?php else : ?>
                <a <?= $_SERVER['SCRIPT_NAME'] === '/settings.php' ? 'active' : ''; ?>" href="settings.php">Settings</a>
            <?php endif; ?>
        </li>

        <li>
            <?php if ($_SESSION['user']) : ?>
                <form action="/app/users/search.php" method="get">
                    <label for="search">Search</label>
                    <input type="text" name="search" required>
                    <button type="submit">Search</button>
                </form>
            <?php endif; ?>

            <?php if (isset($_SESSION['searchResults'])) : ?>
                <?php $searchResults = $_SESSION['searchResults'] ?>
                <?php foreach ($searchResults as $searchResult) : ?>
                    <a href="#"><?= $searchResult['username'] ?></a>
                <?php endforeach; ?>
                <?php unset($_SESSION['searchResults']); ?>
            <?php endif; ?>
        </li>

        <?php if (isset($_SESSION['errors'])) : ?>
            <?php foreach ($_SESSION['errors'] as $error) : ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

    </ul>
</nav>
