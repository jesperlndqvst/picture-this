<?php authenticateUser() ?>
<?php $user = getUserById($_SESSION['user']['id'], $pdo) ?>

<nav class="navbar">
    <a class="navbar__heading" href="index.php"><?= $config['title']; ?></a>
    <ul class="navbar__list">
        <li>
            <a href="store.php">
                <img src="/../assets/images/plus.svg" alt="Post image">
            </a>
        </li>
        <li>
            <a href="/profile.php?id=<?= $user['id'] ?>&username=<?= $user['username'] ?>">
                <img src="/../assets/images/profile.svg" alt="Profile page">
            </a>
        </li>
        <li>
            <a href="/search.php">
                <img src="/../assets/images/search.svg" alt="Search">
            </a>
        </li>
    </ul>
</nav>
