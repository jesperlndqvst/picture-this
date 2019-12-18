<?php $user = getUserById($_SESSION['user']['id'], $pdo) ?>

<nav>
    <a href="index.php"><?= $config['title']; ?></a>
    <ul>
        <li>
            <a href="/profile.php?id=<?= $user['id'] ?>&username=<?= $user['username'] ?>">Profile</a>
        </li>
        <li>
            <a href="/search.php">Search</a>
        </li>
    </ul>
</nav>
